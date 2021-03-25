<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home | Acme, Inc.</title>
        <link rel="stylesheet" media="screen" href="../css/style.css">
    </head>
    <body>
        <div class="wrapper">
            <header>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/header.php'; ?>
            </header>
            <main>
                <div class="content-wrapper">
                    <p>All fields required</p>
                    <?php
                    if (isset($message)) {
                        echo $message;
                    }
                    ?>
                    <form method="post" action="/acme/accounts/index.php">
                        First name:
                        <input type="text" name="clientFirstname" required id="clientFirstname" placeholder="First name" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";}  ?>>
                        Last name:
                        <input type="text" name="clientLastname" required id="clientLastname" placeholder="Last name" <?php if(isset($clientLastname)){echo "value='$clientLastname'";}  ?>>
                        Email:
                        <input type="email" name="clientEmail" required id="clientEmail" placeholder="Email" <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?>>
                        Password: <span class="password-requirements">8 characters and has at least 1 uppercase character, 1 number and 1 special character</span>
                        <input type="password" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" id="clientPassword" placeholder="Password">
                        <input type="submit" name="submit" value="Register">
                        <!-- Add the action name - value pair -->
                        <input type="hidden" name="action" value="register">
                    </form>
                </div>
            </main>
            <footer>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
                <p>Last Updated&#58; 24 September&#44; 2018</p>
            </footer>
        </div>
    </body>
</html>