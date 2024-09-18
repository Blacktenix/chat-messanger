<?php
 $user = get_user($_SESSION["id"])
?>
<header class="header">
    <div class="container">
        <div class="user">
            <img class="user-logo" src="">
            <div class="user-login">
                <p class="name"> 
                    <?php 
                    if ($user != NULL) {
                        echo $user["firstName"] . $user["lastName"];
                    }
                    ?>
                 </p>
                <p class="login"><?php echo $_SESSION["login"] ?></p>
            </div>
        </div>
        <?php
        if ($user != NULL) {
            echo "<a href=\"logout.php\" class=\"header-button\">Log Out<a/>";
        }
        else{
            echo "<a href=\"login.php\" class=\"header-button\">Log In<a/>";
        }
        ?>


    </div>
</header>