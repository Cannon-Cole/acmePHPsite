<?php
if (!isset($_SESSION) || $_SESSION['loggedin'] == false) {
    header('Location: /');
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}
?>
<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home | Acme, Inc.</title>
        <link rel="stylesheet" media="screen" href="/acme/css/style.css">
    </head>
    <body>
        <div class="wrapper">
            <header>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/header.php'; ?>
            </header>
            <main>
                <div class="content-wrapper">
                    <h2>Account Management</h2>
                    <?php
                    $updateAccountLink = '/acme/accounts/?action=update-account-page&clientId=' . $_SESSION['clientData']['clientId'];
                    $updatePasswordLink = '/acme/accounts/?action=update-password-page&clientId=' . $_SESSION['clientData']['clientId'];
                    ?>
                    <a class="register" href="<?php echo $updateAccountLink ?>" title="Update Account">Update Account</a>
                    <a class="register" href="<?php echo $updatePasswordLink ?>" title="Change Password">Change Password</a>
                </div>
                <?php
                if (isset($prodList)) {
                    echo $prodList;
                }
                ?>
            </main>
            <footer>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
                <p>Last Updated&#58; 24 September&#44; 2018</p>
            </footer>
        </div>
    </body>
</html>
<?php unset($_SESSION['message']); ?> 