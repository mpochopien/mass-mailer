<?php
include "config.php";

/**
 * @throws JsonException
 */
function Start() {
    if(isset(
        $_POST["topic"],
        $_POST["message"],
        $_POST['accountMail'],
        $_POST['accountPassword'],
        $_POST['mailFromName'],
        $_POST['replyTo'],
        $_POST['replyToName'],
        $_FILES["list"]
    )){
        $date = date("jnYHis");
 
        $info = pathinfo($_FILES["list"]["name"]);
        $ext = $info['extension'];
        $listFilePath = "TemporaryFiles" . DIRECTORY_SEPARATOR . "List_$date.".$ext;
        move_uploaded_file($_FILES["list"]["tmp_name"], $listFilePath);
        
        $messageFilePath = "TemporaryFiles" . DIRECTORY_SEPARATOR . "Mail_$date.txt";
        $messageFile = fopen($messageFilePath, 'ab');
        fwrite($messageFile, $_POST["message"]);
        fclose($messageFile);
        
        $mailerConfig = [
            'messageFile' => $messageFilePath,
            'listFile' => $listFilePath,
            'topic' => $_POST["topic"] ?? '',
            'mailFrom' => $_POST['mailFromName'] ?? '',
            'accountMail' => $_POST['accountMail'] ?? '',
            'accountPassword' => $_POST['accountPassword'] ?? '',
            'replyTo' => $_POST['replyTo'] ?? '',
            'replyToName' => $_POST['replyToName'] ?? '',
        ];
        $mailerConfig = json_encode($mailerConfig, JSON_THROW_ON_ERROR);
    
        $configFilePath = "TemporaryFiles" . DIRECTORY_SEPARATOR . "Config_$date.json";
        $configFile = fopen($configFilePath, 'ab');
        fwrite($configFile, $mailerConfig);
        fclose($configFile);
        
        $cmd = "php sendemails.php -c{$configFilePath} > Logs" . DIRECTORY_SEPARATOR . "log{$date}.log";
        if (str_starts_with(php_uname(), "Windows")){
            pclose(popen("start /B ". $cmd, "r"));
        } else {
            exec($cmd . " > /dev/null &");
        }
        header('Location: index.php?success');
    }
}
