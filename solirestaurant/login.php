<?php 

require "config.php";
if(isset($_POST["submit"])){
    $tel = $_POST["tel"];
    $rusult=tel_existe($tel);
    if(empty($rusult)){
        header("Location:register.php");
    }else{
        $_SESSION["client"]=$rusult;
        header("Location:index.php");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <section>
        <div>
            <img src="image/logo.png" alt="logo">
            <h2>INGREDIENTS AND LOTS OF LOVE</h2>

            <form method="POST">
                <label for="tel">Enter your phone number:</label>
                <input type="tel" id="tel" name="tel" required>
                <button type="submit" name="submit">Log in</button>
            </form>
        </div>
    </section>
</body>
</html>
