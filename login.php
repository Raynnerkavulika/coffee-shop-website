<?php 
include('config.php');

session_start();

if(isset($_POST['submit'])){
    
    $email = $_POST['email'];
    $email = filter_var($email,FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $password = filter_var($password,FILTER_SANITIZE_STRING);

    $select = $conn->prepare("SELECT * FROM users WHERE email=? AND password=?");
    $select->execute([$email,$password]);
    $row = $select->fetch(PDO::FETCH_ASSOC);

    if($select->rowCount()>0){

       if($row['user_type'] == 'admin'){

        $_SESSION['admin_id'] = $row['id'];
        header('location:admin_page.php');

       }elseif($row['user_type'] == 'user'){

        $_SESSION['user_id'] = $row['id'];
        header('location:home.php');

       }else{
        $message[] = "no user found";
       }
}else{
  $message[] = "wrong email or password";
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php  
   if(isset($message)){
    foreach($message as $message){
        echo'
        <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times"></i>
        </div>
        ';
    }
   }

?>
<section class="form-container">
    <form action="" method="post" enctype="multipart/form-data">
        <h3>login now</h3>
        <input type= "email" name= "email" placeholder="enter your email" required class="box">
        <input type="password" name="password" placeholder="enter your password" required class="box">
        <input type="submit" name="submit" value="login now" required class="btn">
        <p>don't have an account? <a href="register.php">register now</a></p>
    </form>

</section>
</body>
</html>