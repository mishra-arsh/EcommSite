<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="loginPage.css">
</head>
<body>
<header class="hero-heading"><h1>sHOPI sTORE</h1>
<br>
</header>
<div class="container">
        <form action="loginPage.php" method="post" class="form-details">
            <label for="email">Email</label>
            <input type="text" name="email" class="form-input" id="email" required>
            <label for="password">Password</label>
            <input type="password" name="password" class="form-input" id="password" required>
            <a href="loginPage.php">Forgot Password</a>
            
            <button class="submit-btn" type="submit" name="login" >Login</button>
            <p>New user?</p>
            <a href="signupPage.php" >Register Now</a>
        </form>
    </div>
    <?php
        require "db.php";
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            if (isset($_POST["login"])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                 $search = $conn->prepare("SELECT * FROM `Users` WHERE `email` = ?");
                 $search->bind_param("s", $email);
                 $search->execute();
                 $res = $search->get_result(); 
                 $rowNum = mysqli_num_rows($res);
                // echo var_dump($rowNum);
                 if ($rowNum > 0) {
                    $row = mysqli_fetch_assoc($res);
                    if ($row['Password'] == $password){
    
                        
                        $_SESSION['userId'] = $row['id'];
                        $_SESSION['Role'] = $row['Role'];
                        if ($row['Role'] == "user"){
                            header('Location: userDash.php');
                        }
                        else {
                            echo "hii";
                            header('Location: admin/dashboard.php');
                        }
                        
                    }
                    else {
                        echo "<div class='error-popup'>Invalid email or password.</div>";
                        // header('Location: loginPage.php');
                       
                        
                    }
                    // $search->close();
                    
                 }
                 else {
                    header('Location: loginPage.php');
                    echo "<div id='errorMsg'> Login Failed. </div>";
                 }
            }
    }
    ?>
    <script>
        document.querySelector('.form-details').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();

            if (email === '' || password === '') {
                e.preventDefault();
                alert("Please fill in both fields.");
            }
        });
    </script>


</body>
</html>

<?php

?>