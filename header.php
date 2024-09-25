<?php
if (isset($_SESSION["id"])) {
    $user = get_user($_SESSION["id"]);
}
?>
<header class="header">
    <div class="container">

        <?php if (isset($user)) : ?>

            <div class="user">
                <img class="user-logo" src="user.png">
                <div class="user-login">
                    <p class="name">
                        <?php echo $user["firstName"] . " " . $user["lastName"] ?>
                    </p>
                    <p class="login">
                        <?php echo $user["login"] ?>
                    </p>
                </div>
                <nav>
                    <a href="index.php">Chats</a>
                    <span>|</span>
                    <a href="user.php">Profile</a>
                </nav>
            </div>
            <a href="logout.php" class="header-button">Log Out</a>

        <?php else : ?>

            <h2>Chat Application</h2>
            <div>
                <a href="login.php" class="header-button">Log In</a>
                <a href="register.php" class="header-button">Register</a>
            </div>

        <?php endif ?>
    </div>
</header>