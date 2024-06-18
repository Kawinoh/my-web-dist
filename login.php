<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/connect.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: contact.html");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management system</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body style="background-color: gold; font-family: Arial;">
    <div id="login-container">
        <h1>Login</h1>

        <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>

        <form id="login-form" method="post">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" style="font-family: Georgia" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="password" style="font-family: Georgia" required >
            <button type="submit" style="background-color: blue;color: white;">Login</button>
            <a href="forgot-password.php" id="forgot-password">Forgot Password?</a>
        </form>
    </div>


</body>
</html>