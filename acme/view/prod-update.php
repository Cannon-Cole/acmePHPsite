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
    } elseif (isset($prodInfo['categoryId'])) {
        if ($increment == $prodInfo['categoryId']) {
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
        <title><?php
            if (isset($prodInfo['invName'])) {
                echo "Modify $prodInfo[invName] ";
            } elseif (isset($invName)) {
                echo $invName;
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
                    if (isset($prodInfo['invName'])) {
                        echo "Modify $prodInfo[invName] ";
                    } elseif (isset($invName)) {
                        echo $invName;
                    }
                    ?></h1>
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
                        } elseif (isset($prodInfo['invName'])) {
                            echo "value='$prodInfo[invName]'";
                        }
                        ?>>
                        Description
                        <input type="text" name="invDescription" id="invDescription" placeholder="Description" required <?php
                        if (isset($invDescription)) {
                            echo "value = '$invDescription'";
                        } elseif (isset($prodInfo['invDescription'])) {
                            echo "value='$prodInfo[invDescription]'";
                        }
                        ?>>
                        Image path
                        <input type="text" name="invImage" id="invImage" placeholder="Image path" required <?php
                        if (isset($invImage)) {
                            echo "value = '$invImage'";
                        } elseif (isset($prodInfo['invImage'])) {
                            echo "value='$prodInfo[invImage]'";
                        }
                        ?>>
                        Thumbnail path
                        <input type="text" name="invThumbnail" id="invThumbnail" placeholder="Thumbnail path" required <?php
                        if (isset($invThumbnail)) {
                            echo "value = '$invThumbnail'";
                        } elseif (isset($prodInfo['invThumbnail'])) {
                            echo "value='$prodInfo[invThumbnail]'";
                        }
                        ?>>
                        Price
                        <input type="number" name="invPrice" step="0.01" id="invPrice" placeholder="Price" required <?php
                        if (isset($invPrice)) {
                            echo "value = '$invPrice'";
                        } elseif (isset($prodInfo['invPrice'])) {
                            echo "value='$prodInfo[invPrice]'";
                        }
                        ?>>
                        Stock
                        <input type="number" name="invStock" id="invStock" placeholder="Stock" required <?php
                        if (isset($invStock)) {
                            echo "value = '$invStock'";
                        } elseif (isset($prodInfo['invStock'])) {
                            echo "value='$prodInfo[invStock]'";
                        }
                        ?>>
                        Size
                        <input type="number" name="invSize" id="invSize" placeholder="Size" required <?php
                        if (isset($invSize)) {
                            echo "value = '$invSize'";
                        } elseif (isset($prodInfo['invSize'])) {
                            echo "value='$prodInfo[invSize]'";
                        }
                        ?>>
                        Weight
                        <input type="number" name="invWeight" id="invWeight" placeholder="Weight" required <?php
                        if (isset($invWeight)) {
                            echo "value = '$invWeight'";
                        } elseif (isset($prodInfo['invWeight'])) {
                            echo "value='$prodInfo[invWeight]'";
                        }
                        ?>>
                        Location
                        <input type="text" name="invLocation" id="invLocation" placeholder="Location" required <?php
                        if (isset($invLocation)) {
                            echo "value = '$invLocation'";
                        } elseif (isset($prodInfo['invLocation'])) {
                            echo "value='$prodInfo[invLocation]'";
                        }
                        ?>>
                        Vendor
                        <input type="text" name="invVendor" id="invVendor" placeholder="Vendor" required <?php
                        if (isset($invVendor)) {
                            echo "value = '$invVendor'";
                        } elseif (isset($prodInfo['invVendor'])) {
                            echo "value='$prodInfo[invVendor]'";
                        }
                        ?>>
                        Style
                        <input type="text" name="invStyle" id="invStyle" placeholder="Style" required <?php
                               if (isset($invStyle)) {
                                   echo "value = '$invStyle'";
                               } elseif (isset($prodInfo['invStyle'])) {
                                   echo "value='$prodInfo[invStyle]'";
                               }
                               ?>>                      
                        <input type="submit" name="submit" value="Update Product">
                        <!-- Add the action name - value pair -->
                        <input type="hidden" name="action" value="updateProd">
                        <!-- Primary key -->
                        <input type="hidden" name="invId" value="<?php
                        if (isset($prodInfo['invId'])) {
                            echo $prodInfo['invId'];
                        } elseif (isset($invId)) {
                            echo $invId;
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