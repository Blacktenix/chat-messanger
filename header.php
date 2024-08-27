<header class="header">
    <div class="container">
        <div class="user">
            <img class="user-logo" src="">
            <div class="user-login">
                <p class="name">FirstName LastName</p>
                <p class="login"><?php echo $_SESSION["login"] ?></p>
            </div>
        </div>
        <?php
        if ($_SESSION["login"] != NULL) {
            echo "<a href=\"logout.php\" class=\"header-button\">Log Out<a/>";
        }
        else{
            echo "<a href=\"register.php\" class=\"header-button\">Log In<a/>";
        }
        ?>


    </div>
</header>