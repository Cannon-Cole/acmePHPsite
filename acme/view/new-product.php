<?php
if (!isset($_SESSION) || $_SESSION['loggedin'] == false) {
    header('Location: /');
} else {
    if ($_SESSION["clientData"]['clientLevel'] < 2) {
        header('Location: /');
        exit;
    }
}
$catList = '<select name="categoryId" form="new-product">';
$catList .= '<option value="0">Choose a Category</option>';
$increment = 1;
foreach (getCategories() as $category) {
    $catList .= "<option value='$increment'";
    if (isset($catType)) {
        if ($increment == $catType) {
            $catList .= ' selected=';
        }
    }
    $catList .= ">$category[categoryName]</option>";
    $increment++;
}
$catList .= '</select>';
?>
<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width = device-width, initial-scale = 1">
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
                    Category<br>
                    <?php echo $catList; ?><br>    
                    <form method="post" id="new-product" action="/acme/products/index.php">
                        Name
                        <input type="text" name="invName" id="invName" placeholder="Name" required <?php
                        if (isset($invName)) {
                            echo "value = '$invName'";
                        }
                        ?>>
                        Description
                        <input type="text" name="invDescription" id="invDescription" placeholder="Description" required <?php
                        if (isset($invDescription)) {
                            echo "value = '$invDescription'";
                        }
                        ?>>
                        Image path
                        <input type="text" name="invImage" id="invImage" value="/acme/images/products/no-image.png" placeholder="Image path" required <?php
                        if (isset($invImage)) {
                            echo "value = '$invImage'";
                        }
                        ?>>
                        Thumbnail path
                        <input type="text" name="invThumbnail" id="invThumbnail" value="/acme/images/products/no-image.png" placeholder="Thumbnail path" required <?php
                        if (isset($invThumbnail)) {
                            echo "value = '$invThumbnail'";
                        }
                        ?>>
                        Price
                        <input type="number" name="invPrice" step="0.01" id="invPrice" placeholder="Price" required <?php
                        if (isset($invPrice)) {
                            echo "value = '$invPrice'";
                        }
                        ?>>
                        Stock
                        <input type="number" name="invStock" id="invStock" placeholder="Stock" required <?php
                        if (isset($invStock)) {
                            echo "value = '$invStock'";
                        }
                        ?>>
                        Size
                        <input type="number" name="invSize" id="invSize" placeholder="Size" required <?php
                        if (isset($invSize)) {
                            echo "value = '$invSize'";
                        }
                        ?>>
                        Weight
                        <input type="number" name="invWeight" id="invWeight" placeholder="Weight" required <?php
                        if (isset($invWeight)) {
                            echo "value = '$invWeight'";
                        }
                        ?>>
                        Location
                        <input type="text" name="invLocation" id="invLocation" placeholder="Location" required <?php
                        if (isset($invLocation)) {
                            echo "value = '$invLocation'";
                        }
                        ?>>
                        Vendor
                        <input type="text" name="invVendor" id="invVendor" placeholder="Vendor" required <?php
                        if (isset($invVendor)) {
                            echo "value = '$invVendor'";
                        }
                        ?>>
                        Style
                        <input type="text" name="invStyle" id="invStyle" placeholder="Style" required <?php
                               if (isset($invStyle)) {
                                   echo "value = '$invStyle'";
                               }
                               ?>>                      
                        <input type="submit" name="submit" value="Add Product">
                        <!-- Add the action name - value pair -->
                        <input type="hidden" name="action" value="insertProduct">
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