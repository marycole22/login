<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loginpage</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif&family=Poltawski+Nowy&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <div class="head">
        <h2>LOGIN PAGE</h2>
        </div>
        <div class="login">

        <?php 
        
        
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
        
            $errors = array();
        
            if (empty($email) OR empty($password)) {
                array_push($errors, "All fields are required");
            }
        
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>{$error}</div>";
                }
            } else {
                require_once "conn.php";
        
                $sql = "SELECT * FROM createme WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        
                if ($user) {
                    if (password_verify($password, $user['password'])) {
                        header("Location: welcome.php");
                        die();
                    } else {
                        echo "<div class='alert alert-danger'>Password does not match</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Email does not match</div>";
                }
            }
        }
        
        
        
        ?>
        
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label>EMAIL</label><br>
                <input type="email" placeholder="@GMAIL.COM" name="email" ><i class="fa-solid fa-envelope"></i><br><br>

                <label>PASSWORD</label><br>
                <input type="password" name="password" placeholder="PASSWORD" ><i class="fa-solid fa-lock"></i><br><br>
                <a href="#">Forget Password?</a><br>

                <button name="login">LOGIN</button><br>

                <p>If you don't have an account <a href="create.php">CREATE ACCOUNT</a></p>
                


            </form>
        </div>
    </div>
</body>
</html>