<?php
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}
?>
<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Image Management</title>
        <link rel="stylesheet" media="screen" href="../css/style.css">
    </head>
    <body>
        <div class="wrapper">
            <header>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/header.php'; ?>
            </header>
            <main>
                <h1>Image Management</h1>
                <h2>Add New Product Image</h2>
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
                <form action="/acme/uploads/" method="post" enctype="multipart/form-data">
                    <label for="invItem">Product</label><br>
                    <?php echo $prodSelect; ?><br><br>
                    <label>Upload Image:</label><br>
                    <input type="file" name="file1"><br>
                    <input type="submit" class="regbtn" value="Upload">
                    <input type="hidden" name="action" value="upload">
                </form>
                <h2>Existing Images</h2>
                <p class="notice">If deleting an image, delete the thumbnail too and vice versa.</p>
                <?php
                if (isset($imageDisplay)) {
                    echo $imageDisplay;
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