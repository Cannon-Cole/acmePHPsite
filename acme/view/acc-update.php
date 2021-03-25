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
                echo "Update $accInfo[clientFirstname]'s account";
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
                echo "Update "; 
                    if (isset($accInfo['clientFirstname'])) {
                        echo "$accInfo[clientFirstname]'s";
                    } elseif (isset($clientFirstname)) {
                        echo $clientFirstname;
                        echo "'s";
                    }
                    echo " account";
                    ?></h1>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>       
                <div class="content-wrapper">
                    <form method="post" id="new-product" action="/acme/accounts/index.php">
                        First Name
                        <input type="text" name="clientFirstname" id="clientFirstname" placeholder="First Name" required <?php
                        if (isset($clientFirstname)) {
                            echo "value = '$clientFirstname'";
                        } elseif (isset($accInfo['clientFirstname'])) {
                            echo "value='$accInfo[clientFirstname]'";
                        }
                        ?>>
                        Last Name
                        <input type="text" name="clientLastname" id="clientLastname" placeholder="Last Name" required <?php
                        if (isset($clientLastname)) {
                            echo "value = '$clientLastname'";
                        } elseif (isset($accInfo['clientLastname'])) {
                            echo "value='$accInfo[clientLastname]'";
                        }
                        ?>>
                        Email
                        <input type="email" name="clientEmail" id="clientEmail" placeholder="Email" required <?php
                               if (isset($clientEmail)) {
                                   echo "value = '$clientEmail'";
                               } elseif (isset($accInfo['clientEmail'])) {
                                   echo "value='$accInfo[clientEmail]'";
                               }
                               ?>>
                        <input type="submit" name="submit" value="Update Account">
                        <!-- Add the action name - value pair -->
                        <input type="hidden" name="action" value="update-user-account">
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