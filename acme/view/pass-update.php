<?php
if (!isset($_SESSION) || $_SESSION['loggedin'] == false) {
    header('Location: /');
}
?>
<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width = device-width, initial-scale = 1">
        <title><?php
            if (isset($accInfo['invName'])) {
                echo "Update $accInfo[clientFirstname]'s password ";
            } elseif (isset($clientFirstname)) {
                echo $clientFirstname;
            }
            ?>  | Acme, Inc.</title>
        <link rel="stylesheet" media="screen" href="../css/style.css">
    </head>
    <body>
        <div class="wrapper">
            <header>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/header.php'; ?>
            </header>
            <main>
                <h1><?php
                    if (isset($accInfo['clientFirstname'])) {
                        echo "Update $accInfo[clientFirstname]'s password";
                    } elseif (isset($clientFirstname)) {
                        echo $clientFirstname;
                    }
                    ?></h1>
                <div class="content-wrapper">
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                    ?> 
                    <form method="post" id="new-product" action="/acme/accounts/index.php">
                        Password: <span class="password-requirements">8 characters and has at least 1 uppercase character, 1 number and 1 special character</span>
                        <input type="password" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Password">                     
                        <input type="submit" name="submit" value="Update Password">
                        <!-- Add the action name - value pair -->
                        <input type="hidden" name="action" value="update-user-password">
                        <!-- Primary key -->
                        <input type="hidden" name="clientId" value="<?php
                        if (isset($accInfo['clientId'])) {
                            echo $accInfo['clientId'];
                        } elseif (isset($clientId)) {
                            echo $clientId;
                        }
                        ?>"> 
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