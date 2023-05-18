<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CREATE ACCOUNT</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif&family=Poltawski+Nowy&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="container">
    <div class="head">
    <h2>CREATE ACOOUNT</h2>
    </div>
    <div class="create">

    <?php 

  if(isset($_POST['create'])){
     
    $fullname = $_POST['fullname'];
    $mobile = $_POST['mobile'];
    $date = $_POST['date'];
    $email =$_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    $passwordhash = password_hash($password, PASSWORD_DEFAULT);

     $errors = array();

     if(empty($fullname) OR empty($mobile) OR empty($date) OR empty($email) OR empty($password) OR empty($confirm) ) {
        array_push($errors, "All field must be fill");
     }

     if (!preg_match("/^[a-zA-Z-' ]*$/",$fullname)) {
        array_push($errors, "Must be letters only");
     }

     if (!preg_match('/^[0-9]*$/', $mobile)) {
        array_push($errors, "Must be number");
     }

     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Must be a valid email");
     }

     if (strlen($password) < 7) {
        array_push($errors, "Password must be at least 7 long");
     }

     if ($password !== $confirm) {
        array_push($errors, "Password must be match");
     }

     require_once "conn.php";
     $sql = "SELECT * FROM createme  WHERE email = '$email'";
     $result = mysqli_query($conn, $sql);
     $rowcount = mysqli_num_rows($result);

     if ($rowcount>0) {
       array_push($errors, "Email already exist");
     }

     if (count($errors) > 0) {
        foreach($errors as $error) {
            echo "<div class= 'alert alert-danger'>{$error}</div>";
           
        }
     }

    else{
      
        $sql ="INSERT INTO `createme` (`id`, `fullname`, `mobile`, `date`, `email`, `password`) VALUES (NULL, ?, ?, ?, ?, ? )";
        $stmt = mysqli_stmt_init($conn);
        $prepare = mysqli_stmt_prepare($stmt, $sql);
        if ($prepare) {
            mysqli_stmt_bind_param( $stmt, "sssss", $fullname, $mobile, $date, $email, $passwordhash,);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);

            header("Location: index.php");
            exit;
        }else{
            die("something went wrong");
        }
    
    }


  }

  ?>

    
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"" method="post">
            <label >FULL NAME</label><br>
            <input type="text" name="fullname" placeholder="FULLNAME"  class="form-control"><i class="fa-solid fa-user-secret"></i><br><br>

            <label for="">MOBILE NO</label><br>
            <input type="tel" name="mobile" placeholder="123456789" class="form-control" ><i class="fa-solid fa-mobile"></i><br><br>

            <label for="">DATE OF CHOICE</label><br>
            <input type="date" name="date"  ><i class="fa-solid fa-calendar-days" class="form-control"></i><br><br>

            <label for="">EMAIL</label><br>
            <input type="email" name="email"  placeholder="@GMAIL.COM" class="form-control"><i class="fa-solid fa-envelope"></i><br><br>

            <label for="">PASSWORD</label><br>
            <input type="password" name="password"  placeholder="PASSWORD" class="form-control" ><i class="fa-solid fa-lock"></i><br><br>

            <label for="">CONFIRM PASSWORD</label><br>
            <input type="password" name="confirm" placeholder="CONFIRM PASSWORD" class="form-control"><i class="fa-solid fa-unlock"></i><br><br>

            <button name="create">SUBMIT</button>
            <p>If you have account <a href="index.php">LOGIN!!!</a></p>
        </form>
    </div>
</div>
    
</body>
</html>