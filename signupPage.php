<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
<header class="hero-heading"><h1>sHOPI sTORE</h1>
<br>
</header>
<img src="index-gif.gif" alt="">
    <div class="container">
        <form action="signupPage.php" method="post" class="form-details">
            <div class="inForm">
            <label for="fullname" >FullName</label>
            <input type="text" name="fullname" class="form-input" id="fullname">

            <label for="email">Email</label>
            <input type="email" name="email" class="form-input" id="email">
            
            <label for="password">Password</label>
            <input type="password" name="password" class="form-input" id="password">
            
            
            <label for="cpassword">Confirm Password</label>
            <input type="password" name="cpassword" class="form-input" id="cpassword">
            <select name="Role" id="role">
                <option value="admin">Admin</option>
                <option value="user">Customer</option>
            </select>
           
            <!-- <select name="year-select" id="clg-year">
                <option value="none" >Year</option>
                <option value="apple">1 <sup>st</sup>Year </option>
                <option value="first">2<sub>nd</sub>Year</option>
                <option value="second">3 <sup>rd</sup>Year </option>
                <option value="third">4 <sup>th</sup>Year </option>
            </select> -->
            </div>
            
            
            <button class="submit-btn" type="submit">Register</button>
            <p>Already Registered?  <a href="loginPage.php">Login Here</a></p>
           
        </form>
    </div>
    

    <?php
    require "db.php";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (
            isset($_POST['fullname'], $_POST['email'], $_POST['password'], $_POST['cpassword'], $_POST['Role']) &&
            $_POST['password'] === $_POST['cpassword']
        ) {
            $fullName = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['Role'];
    
            $query = $conn->prepare("INSERT INTO `Users` (`name`, `email`, `Password`, `Role`) VALUES (?, ?, ?, ?)");
            $query->bind_param("ssss", $fullName, $email, $password, $role);
            $query->execute();
    
            echo "<div class='echoo'>Success! Your profile is now active.</div>";
            header('Location: loginPage.php');
    
            $query->close();
        }
    }
    
?>
<script>
 document.querySelector('.form-details').addEventListener('submit', function (e) {
    const fname = document.getElementById('fullname').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const cpassword = document.getElementById('cpassword').value;

  
    const oldError = document.getElementById('errorMsg');
    if (oldError) oldError.remove();

    if (fname === '' || email === '' || password === '' || cpassword === '') {
        e.preventDefault();
        showError('All fields are required.');
        return;
    }

    if (password !== cpassword) {
        e.preventDefault();
        showError('Passwords do not match.');
        return;
    }

    
});

function showError(message) {
    const errorDiv = document.createElement('div');
    errorDiv.id = 'errorMsg';
    errorDiv.textContent = message;
    errorDiv.style.color = 'red';
    errorDiv.style.textAlign = 'center';
    errorDiv.style.marginTop = '1rem';
    document.querySelector('.form-details').appendChild(errorDiv);

    setTimeout(() => {
        errorDiv.remove();
    }, 4000);
}
</script>
</body>
</html>
