<?php
if (!isset($_SESSION) || $_SESSION['loggedin'] == false) {
    header('Location: /');
} else {
    if ($_SESSION["clientData"]['clientLevel'] < 2) {
        header('Location: /');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width = device-width, initial-scale = 1">
        <title><?php
            if (isset($prodInfo['invName'])) {
                echo "Delete $prodInfo[invName] ";
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
                        echo "Delete $prodInfo[invName] ";
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
                    <form method="post" id="new-product" action="/acme/products/index.php">
                        Name
                        <input type="text" name="invName" id="invName" placeholder="Name" readonly required <?php
                        if (isset($invName)) {
                            echo "value = '$invName'";
                        } elseif (isset($prodInfo['invName'])) {
                            echo "value='$prodInfo[invName]'";
                        }
                        ?>>
                        Description
                        <input type="text" name="invDescription" id="invDescription" placeholder="Description" readonly required <?php
                        if (isset($invDescription)) {
                            echo "value = '$invDescription'";
                        } elseif (isset($prodInfo['invDescription'])) {
                            echo "value='$prodInfo[invDescription]'";
                        }
                        ?>>                                           
                        <input type="submit" name="submit" value="Delete Product - !This is permanent!">
                        <!-- Add the action name - value pair -->
                        <input type="hidden" name="action" value="deleteProd">
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