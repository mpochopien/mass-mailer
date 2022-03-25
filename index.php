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
    <script src="https://cdn.tiny.cloud/1/<?= tinyMCEKey ?>/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
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
                    <h4><?= mailServerHost ?></h4>
                    <h4>Interval: <?= interval / 1000 ?> seconds. Amount sent every interval: <?= amount ?>.</h4>
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
                            <span class="input-group-text">Account mail</span>
                            <input type="text" class="form-control" placeholder="Account mail" aria-label="Account mail" name="accountMail" required>
                            <span class="input-group-text">Account password</span>
                            <input type="text" class="form-control" placeholder="Account password" aria-label="Account password" name="accountPassword" required>
                        </div>

                        <h5>Reply to:</h5>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Name</span>
                            <input type="text" class="form-control" placeholder="Name" aria-label="Name" name="replyToName" required>
                            <span class="input-group-text">Mail</span>
                            <input type="text" class="form-control" placeholder="Mail" aria-label="Mail" name="replyTo" required>
                        </div>
    
                        <div class="form-floating mb-3">
                            <textarea id="message" name="message" rows="15" placeholder="Message"></textarea>
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

<script>
        tinymce.init({
            selector: '#message',
            menubar: 'file edit view insert format tools table help',
            removed_menuitems: 'newdocument',
            plugins: 'print preview autolink lists media table autoresize wordcount fullscreen hr insertdatetime help searchreplace charmap image paste link',
            toolbar: 'undo redo | bold italic | forecolor backcolor | code table | alignleft aligncenter alignright alignjustify | bullist numlist | link',
            toolbar_mode: 'sliding',
            contextmenu: false,
            browser_spellcheck: true,
            toolbar_sticky: true,
            paste_data_images: true,
            forced_root_block: false,
            entity_encoding: 'raw',
            mobile: {
                menubar: 'file edit view insert format tools table help',
                toolbar_mode: 'scrolling'
            }
        });
</script>