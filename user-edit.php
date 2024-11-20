<?php
session_start();
include("pdo.php");
if (!isset($user)) {
    header("Location:/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat | Profile</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include("header.php");
    ?>
    <form action="update_profile.php" method="POST" enctype="multipart/form-data">
        <div class="profile-form">
            <div>
                <label for="profilePic">Profile Picture:</label>
                <input type="file" name="profilePic" id="profilePic">
            </div>

            <div>
                <label for="firstName"><strong>First Name: </strong></label>
                <input type="text" name="firstName" id="firstName" value="<?php echo htmlspecialchars($user["firstName"]) ?>" required>
            </div>

            <div>
                <label for="lastName"><strong>Last Name: </strong></label>
                <input type="text" name="lastName" id="lastName" value="<?php echo htmlspecialchars($user["lastName"]) ?>" required>
            </div>

            <div>
                <label for="dateOfBirth"><strong>Date of Birth: </strong></label>
                <input type="date" name="dateOfBirth" id="dateOfBirth" value="<?php echo htmlspecialchars($user["dateOfBirth"]) ?>" required>
            </div>

            <div>
                <button type="submit">Update Profile</button>
            </div>
        </div>
    </form>
</body>

</html>