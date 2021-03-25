<?php
if (!isset($_SESSION) || $_SESSION['loggedin'] == false) {
    header('Location: /');
} else {
    if ($_SESSION["clientData"]['clientLevel'] < 2) {
        header('Location: /');
        exit;
    }
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
                    <h2>Acme Product Management</h2>
                    <a class="register" href="/acme/products/?action=addCategory" title="Add Category">Add category</a>
                    <a class="register" href="/acme/products/?action=addProduct" title="Add Product">Add product</a>
                </div>
                 <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                    ?>
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