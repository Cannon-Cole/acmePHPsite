<!--accounts controller-->

<?php
// Create or access a Session
session_start();

require_once '../library/connections.php';
// Get the acme model for use as needed
require_once '../model/acme-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the functions library
require_once '../library/functions.php';

$navList = buildNav(getCategories());

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'login':
        include '../view/login.php';
        break;


    case 'registration':
        include '../view/register.php';
        break;


    case 'register':
        //Filter and store the data
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        $existingEmail = checkExistingEmail($clientEmail);

        // Check for existing email address in the table
        if ($existingEmail) {
            $_SESSION['message'] = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
            include '../view/login.php';
            exit;
        }

        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
            $_SESSION['message'] = '<p>Please provide information for all empty form fields.</p>';
            header('../view/register.php');
            exit;
        }
        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
        // Send the data to the model
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

        // Check and report the result
        if ($regOutcome === 1) {
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            $_SESSION['message'] = "<p>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
            include '../view/login.php';
            exit;
        } else {
            $_SESSION['message'] = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include '../view/registration.php';
            exit;
        }
        break;


    case 'login-signin':
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientEmail = checkEmail($clientEmail);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
        $passwordCheck = checkPassword($clientPassword);

        // Run basic checks, return if errors
        if (empty($clientEmail) || empty($passwordCheck)) {
            $_SESSION['message'] = '<p class="notice">Please provide a valid email address and password.</p>';
            include '../view/login.php';
            exit;
        }

        // A valid password exists, proceed with the login process
        // Query the client data based on the email address
        $clientData = getClient($clientEmail);
        // Compare the password just submitted against
        // the hashed password for the matching client
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        // If the hashes don't match create an error
        // and return to the login view
        if (!$hashCheck) {
            $_SESSION['message'] = '<p class="notice">Please check your password and try again.</p>';
            include '../view/login.php';
            exit;
        }
        // A valid user exists, log them in

        $_SESSION['loggedin'] = true;
        // Remove the password from the array
        // the array_pop function removes the last
        // element from an array
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;

        $_SESSION['message'] = "You are logged in";

        $_SESSION['welcome'] = true;

        setcookie('firstname', "", strtotime('-1 year'), '/');

        // Send them to the admin view        
        include '../view/admin.php';
        //$_SESSION['message'] = "";
        exit;
        break;

    case 'logout':
        session_destroy();
        header('Location: /');
        exit;
        break;

    case 'client-update':
        include '../view/client-update.php';
        exit;
        break;

    case 'update-account-page':
        $clientId = filter_input(INPUT_GET, 'clientId', FILTER_VALIDATE_INT);
        $accInfo = getAccountBasics($clientId);
        if (count($accInfo) < 1) {
            $_SESSION['message'] = 'Sorry, no account information could be found.';
        }
        include '../view/acc-update.php';
        exit;
        break;

    case 'update-password-page':
        $clientId = filter_input(INPUT_GET, 'clientId', FILTER_VALIDATE_INT);
        $accInfo = getAccountBasics($clientId);
        if (count($accInfo) < 1) {
            $_SESSION['message'] = 'Sorry, no account information could be found.';
        }
        include '../view/pass-update.php';
        exit;
        break;

    case 'update-user-account':
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_STRING);

        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)) {
            $_SESSION['message'] = '<p>Please fill in all the fields!</p>';
            include '../view/acc-update.php';
            exit;
        }

        //check if anything has changed
        $accInfo = getAccountBasics($clientId);

        if ($accInfo['clientFirstname'] == $clientFirstname && $accInfo['clientLastname'] == $clientLastname && $accInfo['clientEmail'] == $clientEmail) {
            $_SESSION['message'] = "<p class='notice'>Error. $clientFirstname your account was not updated, because nothing was changed.</p>";
            include '../view/acc-update.php';
            exit;
        } else {
            // Send the data to the model
            $updateAccountResult = updateAccount($clientId, $clientFirstname, $clientLastname, $clientEmail);
        }
        // Check and report the result
        if ($updateAccountResult) {
            $_SESSION['message'] = "<p class='notify'>Congratulations, $clientFirstname's account was successfully updated.</p>";
            $clientData = getClient($clientEmail);
            array_pop($clientData);
            // Store the array into the session
            $_SESSION['clientData'] = $clientData;
            header('location: /acme/accounts/');
            exit;
        } else {
            $_SESSION['message'] = "<p class='notice'>Error. $clientFirstname's account was not updated.</p>";
            include '../view/acc-update.php';
            exit;
        }
        break;

    case 'update-user-password':
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

        if (empty($clientPassword)) {
            $_SESSION['message'] = '<p>Please fill in all the fields!</p>';
            include '../view/pass-update.php';
            exit;
        }

        //check if anything has changed
        $accInfo = getAccountBasics($clientId);

        // Send the data to the model
        $updatePasswordResult = updatePassword($clientId, password_hash($clientPassword, PASSWORD_DEFAULT));

        // Check and report the result
        if ($updatePasswordResult) {
            $_SESSION['message'] = "<p class='notify'>Congratulations, password was successfully changed.</p>";
            header('location: /acme/accounts/');
            exit;
        } else {
            $_SESSION['message'] = "<p class='notice'>Error. $clientFirstname's password was not updated.</p>";
            include '../view/pass-update.php';
            exit;
        }
        break;

    default :
        include '../view/admin.php';
}