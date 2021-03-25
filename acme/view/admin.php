<?php
if (!isset($_SESSION) || $_SESSION['loggedin'] == false) {
    header("../index.php");
}
?>
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
                <h1><?php
                    echo $_SESSION["clientData"]['clientFirstname'];
                    echo ' ';
                    echo $_SESSION["clientData"]['clientLastname'];
                    ?></h1>
                <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                    ?>
                <ul>
                    <li><?php echo 'First Name: ' . $_SESSION["clientData"]['clientFirstname']; ?></li>
                    <li><?php echo 'Last Name: ' . $_SESSION["clientData"]['clientLastname']; ?></li>
                    <li><?php echo 'Email: ' . $_SESSION["clientData"]['clientEmail']; ?></li>
                </ul>
                <a class="register" href="/acme/accounts?action=client-update" title="My Account">Update Account Information</a>
                <?php if ($_SESSION["clientData"]['clientLevel'] > 1){ echo '<br><br><h4>Edit Products</h4><p>You can manage your products here</p><a class="register" href="/acme/products" title="My Account">Manage Products</a>';} ?>
            </main>
            <br><br>
            <footer>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
                <p>Last Updated&#58; 24 September&#44; 2018</p>
            </footer>
        </div>
    </body>
</html>