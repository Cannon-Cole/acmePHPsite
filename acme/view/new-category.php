<?php
if (!isset($_SESSION) || $_SESSION['loggedin'] == false) {
    header('Location: /');
}
else{
    if($_SESSION["clientData"]['clientLevel'] < 2){
        header('Location: /');
        exit;
    }
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
                <div class="content-wrapper">
                    <p>All fields required</p>
                    <?php
                    if (isset($message)) {
                        echo $message;
                    }
                    ?>
                    <form method="post" action="/acme/products/index.php">
                        Category
                        <input type="text" name="categoryName" id="categoryName" placeholder="Category" required>                   
                        <input type="submit" name="submit" value="Add Category">
                        <!-- Add the action name - value pair -->
                        <input type="hidden" name="action" value="insertCategory">
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