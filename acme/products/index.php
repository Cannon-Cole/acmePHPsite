<!--Products Controller-->
<?php
// Create or access a Session
session_start();

//products controller
require_once '../library/connections.php';
// Get the acme model for use as needed
require_once '../model/acme-model.php';
// Get the products model
require_once '../model/products-model.php';
// Get the functions library
require_once '../library/functions.php';
// Get the uploads model
require_once '../model/uploads-model.php';

$navList = buildNav(getCategories());

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'addCategory':
        include '../view/new-category.php';
        break;
    case 'addProduct':
        include '../view/new-product.php';
        break;
    case 'insertCategory':
        // Filter and store the data
        $categoryName = filter_input(INPUT_POST, 'categoryName', FILTER_SANITIZE_STRING);

        if (empty($categoryName)) {
            $_SESSION['message'] = '<p>Please provide a category to add.</p>';
            include '../view/new-category.php';
            exit;
        }

        // Send the data to the model
        $regOutcome = addNewCategory($categoryName);

        // Check and report the result
        if ($regOutcome === 1) {
            include '../view/new-category.php';
            exit;
        } else {
            $_SESSION['message'] = "<p>Category add failed</p>";
            include '../view/new-category.php';
            exit;
        }
        break;
    case 'insertProduct':
        //invName, invDescription, invImage, invThumbnail, invPrice, invStock, invSize, invWeight, 
        //invLocation, categoryId, invVendor, invStyle
        //Filter and store the data
        $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invSize = filter_input(INPUT_POST, 'invSize', FILTER_SANITIZE_NUMBER_INT);
        $invWeight = filter_input(INPUT_POST, 'invWeight', FILTER_SANITIZE_STRING);
        $invLocation = filter_input(INPUT_POST, 'invLocation', FILTER_SANITIZE_STRING);
        $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);
        $invVendor = filter_input(INPUT_POST, 'invVendor', FILTER_SANITIZE_STRING);
        $invStyle = filter_input(INPUT_POST, 'invStyle', FILTER_SANITIZE_STRING);
        $catType = $categoryId;

        if (empty($invName) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invSize) || empty($invWeight) || empty($invLocation) || empty($categoryId) || empty($invVendor) || empty($invStyle)) {
            if (isset($categoryId)) {
                if ($categoryId == 0) {
                    $_SESSION['message'] = '<p>Please make a category is selected.</p>';
                } else {
                    $_SESSION['message'] = '<p>Please make sure all fields have a value.</p>';
                }
            }

            include '../view/new-product.php';
            exit;
        }

        if ($categoryId == 0) {
            $_SESSION['message'] = '<p>Please make the category is selected.</p>';
            include '../view/new-product.php';
            exit;
        }

        // Send the data to the model
        $regOutcome = addNewProduct($invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $categoryId, $invVendor, $invStyle);
        // Check and report the result
        if ($regOutcome === 1) {
            $_SESSION['message'] = "<p>Product added.</p>";
            include '../view/new-product.php';
            exit;
        } else {
            $_SESSION['message'] = "<p>Product add failed</p>";
            include '../view/new-product.php';
            exit;
        }
        break;

    case 'mod':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $prodInfo = getProductInfo($invId);
        if (count($prodInfo) < 1) {
            $_SESSION['message'] = 'Sorry, no product information could be found.';
        }
        include '../view/prod-update.php';
        exit;
        break;

    case 'del':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $prodInfo = getProductInfo($invId);
        if (count($prodInfo) < 1) {
            $_SESSION['message'] = 'Sorry, no product information could be found.';
        }
        include '../view/prod-delete.php';
        exit;
        break;

    case 'fea':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        $_SESSION['message'] = '<div class="featured-message"><p>Previously featured product was ' . getFeatured()['invName'] . "</p>";
        $notUsed = setFeatured($invId);
        $_SESSION['message'] .= '<p>Currently featured product is ' . getFeatured()['invName'] . "</p></div>";

        header("location: /acme/products");

        exit;
        break;

    case'updateProd':
        $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invSize = filter_input(INPUT_POST, 'invSize', FILTER_SANITIZE_NUMBER_INT);
        $invWeight = filter_input(INPUT_POST, 'invWeight', FILTER_SANITIZE_STRING);
        $invLocation = filter_input(INPUT_POST, 'invLocation', FILTER_SANITIZE_STRING);
        $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);
        $catType = $categoryId;
        $invVendor = filter_input(INPUT_POST, 'invVendor', FILTER_SANITIZE_STRING);
        $invStyle = filter_input(INPUT_POST, 'invStyle', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        if (empty($invName) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invSize) || empty($invWeight) || empty($invLocation) || empty($categoryId) || empty($invVendor) || empty($invStyle)) {
            if (isset($categoryId)) {
                if ($categoryId == 0) {
                    $_SESSION['message'] = '<p>Please make a category is selected.</p>';
                } else {
                    $_SESSION['message'] = '<p>Please complete all information for the item!</p>';
                }
            }

            include '../view/prod-update.php';
            exit;
        }

        if ($categoryId == 0) {
            $_SESSION['message'] = '<p>Please make the category is selected.</p>';
            include '../view/prod-update.php';
            exit;
        }

        //check if anything has changed
        $prodInfo = getProductInfo($invId);

        if ($prodInfo['invName'] == $invName && $prodInfo['invDescription'] == $invDescription && $prodInfo['invImage'] == $invImage &&
                $prodInfo['invThumbnail'] == $invThumbnail && $prodInfo['invPrice'] == $invPrice && $prodInfo['invStock'] == $invStock &&
                $prodInfo['invSize'] == $invSize && $prodInfo['invWeight'] == $invWeight && $prodInfo['invLocation'] == $invLocation &&
                $prodInfo['categoryId'] == $categoryId && $prodInfo['invVendor'] == $invVendor && $prodInfo['invStyle'] == $invStyle) {
            $_SESSION['message'] = "<p class='notice'>Error. $invName was not updated, because nothing was changed.</p>";
            include '../view/prod-update.php';
            exit;
        } else {
            // Send the data to the model
            $updateResult = updateProduct($invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $categoryId, $invVendor, $invStyle, $invId);
        }
        // Check and report the result
        if ($updateResult) {
            $_SESSION['message'] = "<p class='notify'>Congratulations, $invName was successfully updated.</p>";
            header('location: /acme/products/');
            exit;
        } else {
            $_SESSION['message'] = "<p class='notice'>Error. $invName was not updated.</p>";
            include '../view/prod-update.php';
            exit;
        }
        break;

    case 'deleteProd':

        $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        $deleteResult = deleteProduct($invId);

        // Check and report the result
        if ($deleteResult) {
            $_SESSION['message'] = "<p class='notify'>Congratulations, $invName was successfully deleted.</p>";
            header('location: /acme/products/');
            exit;
        } else {
            $_SESSION['message'] = "<p class='notice'>Error. $invName was not deleted.</p>";
            header('location: /acme/products/');
            exit;
        }
        break;

    case 'category':
        $categoryName = filter_input(INPUT_GET, 'categoryName', FILTER_SANITIZE_STRING);
        $products = getProductsByCategory($categoryName);
        if (!count($products)) {
            $message = "<p class='notice'>Sorry, no $categoryName products could be found.</p>";
        } else {
            $prodDisplay = buildProductsDisplay($products);
        }
        include '../view/category.php';
        exit;
        break;

    case 'product-details':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_STRING);

        $productDetailResult = getProductDetails($invId);

        $thumbnails = getThumbnails($invId);
        $thumbnailList = buildThumbnailList($thumbnails);

        // Check and report the result
        if (count($productDetailResult) > 0) {
            $prodDetailDisplay = buildProductDetail($productDetailResult);
            $productDetailName = $productDetailResult['invName'];
            include '../view/product-detail.php';
            exit;
        } else {
            $_SESSION['message'] = "<p class='notice'>Error. No product found</p>";
            header('location: /acme/products?action=category');
            exit;
        }
        include '../view/product-details.php';

        break;

    default:
        $products = getProductBasics();

        if (count($products) > 0) {
            $prodList = '<table class="product-list">';
            $prodList .= '<thead>';
            $prodList .= '<tr><th>Product Name</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
            $prodList .= '</thead>';
            $prodList .= '<tbody>';
            foreach ($products as $product) {
                $prodList .= "<tr><td>$product[invName]</td>";
                $prodList .= "<td><a href='/acme/products?action=mod&id=$product[invId]' title='Click to modify'>Modify</a></td>";
                $prodList .= "<td><a href='/acme/products?action=del&id=$product[invId]' title='Click to delete'>Delete</a></td>";
                $prodList .= "<td><a href='/acme/products?action=fea&id=$product[invId]' title='Click to feature'>Feature</a></td></tr>";
            }
            $prodList .= '</tbody></table>';
        } else {
            $_SESSION['message'] = '<p class="notify">Sorry, no products were returned.</p>';
        }

        include '../view/product-management.php';
}