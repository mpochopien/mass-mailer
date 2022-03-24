<?php
    include "functions.php";
    try {
        Start();
    } catch (JsonException $e) {
        header('Location: index.php?error');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <title>Mass mailer</title>
</head>
    <body>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert">
                Mass mailing started!
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
                Error while sending emails!
            </div>
        <?php endif; ?>
    
        <div class="container mt-3">
            <div class="card">
                <div class="card-header">
                    <h3>Mass mailer</h3>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Topic" name="topic" required>
                            <label for="topic">Topic</label>
                        </div>

                        <h5>From:</h5>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Name</span>
                            <input type="text" class="form-control" placeholder="Name" aria-label="Name" name="mailFromName" required>
                            <span class="input-group-text">Mail</span>
                            <input type="text" class="form-control" placeholder="Mail" aria-label="Mail" name="mailFrom" required>
                        </div>

                        <h5>Reply to:</h5>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Name</span>
                            <input type="text" class="form-control" placeholder="Name" aria-label="Name" name="replyToName" required>
                            <span class="input-group-text">Mail</span>
                            <input type="text" class="form-control" placeholder="Mail" aria-label="Mail" name="replyTo" required>
                        </div>
    
                        <div class="form-floating mb-3">
                            <textarea rows="10" style="height: 100%;" class="form-control" placeholder="Message" name="message" required></textarea>
                            <label for="message">Message</label>
                        </div>
    
                        <div class="mb-3">
                            <input class="form-control" type="file" placeholder="The list of recipients" accept="text/plain, .csv" name="list" required>
                            <label class="form-label" for="list">The list of recipients</label>
                        </div>
    
                        <button class="btn btn-primary" type="submit">Send</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="container mt-3 mb-3">
            <div class="card">
                <div class="card-header">
                    <h3>Infos</h3>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        List of recipients should be text file with listed mails. Each mail in separate line e.g.:
                        <pre><code>
some@mail.com
other@mail.com
mail@server.com</code>
                        </pre>
                    </li>
                    <li class="list-group-item">
                        Message can contain HTML. Just copy whole HTML codes to 'Message' field. Recommended to use generator like this one: <a href="https://beefree.io/">https://beefree.io/</a>, to avoid cross-client problems with compatibility.
                    </li>
                </ul>
            </div>
        </div>
    </body>
</html>
