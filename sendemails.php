<?php
include "config.php";

require(__DIR__ . '/vendor/autoload.php');

/**
 * @throws \PHPMailer\PHPMailer\Exception|JsonException
 */
function prepareForSending($configFile){
    $configFile = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . $configFile);
    $config = json_decode($configFile, true, 512, JSON_THROW_ON_ERROR);
    
    $seconds = interval / 1000;
    $list = file(__DIR__ . DIRECTORY_SEPARATOR . $config['listFile']);
    $message = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . $config['messageFile']);
    
    foreach ($list as $index => $mail) {
        sendMail($mail, $message, $config);
        
        if(($index+1) % amount === 0){
            sleep($seconds);
        }
    }
    
    displayLog("Finished! All mails sent.");
}

/**
 * @throws \PHPMailer\PHPMailer\Exception
 */
function sendMail($mail, $message, $config) {
    if(!empty($mail)){
        $phpMailer = new PHPMailer\PHPMailer\PHPMailer();
    
        $phpMailer->IsSMTP();
        $phpMailer->SMTPDebug = 1;
        $phpMailer->SMTPAuth = true;
        $phpMailer->SMTPSecure = 'tls';
        $phpMailer->Host = mailServerHost;
        $phpMailer->Port = mailServerPort;
        $phpMailer->Username = $config['accountMail'];
        $phpMailer->Password = $config['accountPassword'];
    
        if (!$phpMailer->SmtpConnect()) {
            displayLog("Error! Wrong credentials");
            exit;
        }
        
        $phpMailer->setFrom($config['accountMail'], $config['mailFrom']);
        $phpMailer->addReplyTo($config['replyTo'], $config['replyToName']);
        $phpMailer->Encoding = 'base64';
        $phpMailer->CharSet = 'UTF-8';
        $phpMailer->addAddress($mail);
        $phpMailer->Subject = $config['topic'] ?? '';
        $phpMailer->isHTML(true);
        $phpMailer->Body = $message;

        if (!$phpMailer->send()) {
            displayLog("Error! Mail didn't send to: {$mail}");
        }
    }
}

function displayLog($message)
{
    $date = date("Y-m-d H:i:s");
    echo "[{$date}] {$message}";
}

$options = getopt("c:");
if (!empty($options['c'])) {
    try {
        prepareForSending($options['c']);
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        displayLog("Error! PHPMailer exception");
    } catch (JsonException $e) {
        displayLog("Error! Config parse exception");
    }
} else {
    print_r($options);
    displayLog("Error! Undefined config argument");
}
