<section class="headerTop">
    <h6 class="invisible">HeaderTop</h6>
    <img class="logoImg" src="/acme/images/site/logo.gif" alt="The ACME Logo">
    <div class="side-by-side">
        <?php
        if (isset($_SESSION['welcome'])) {
            echo "<p class='hover-button'><a href='/acme/accounts/'>Welcome ";
            echo $_SESSION['clientData']['clientFirstname'];
            echo "</a></p><p>&nbsp|&nbsp</p>";
        }

        if (isset($_COOKIE['firstname'])) {
            echo "<p>Welcome ";
            echo $_COOKIE['firstname'];
            echo "</p>";
        }

        if (isset($_SESSION['loggedin'])) {
            if ($_SESSION['loggedin'] == true) {
                echo "<p class='hover-button'><a href='/acme/accounts/?action=logout'>Logout</a></p>";
            } else {
                echo
                '<p>       
        <img class="accountImg" src="/acme/images/site/account.gif" alt="An image of a red folder">
        <a href="/acme/accounts/?action=login" title="My Account">My Account</a> 
        </p>';
            }
        } else {
            echo
            '<p>       
        <img class="accountImg" src="/acme/images/site/account.gif" alt="An image of a red folder">
        <a href="/acme/accounts/?action=login" title="My Account">My Account</a> 
        </p>';
        }
        ?>
    </div>
</section>
<nav>
    <?php echo $navList; ?> 
</nav>