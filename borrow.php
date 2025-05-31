<?php 
    require "db.php";
    session_start();
   
    $prodNo =$_GET['prodNo'];
   
    if (isset($_GET['prodNo']) && is_numeric($_GET['prodNo'])) {
         
       
    
   
    if (isset($_SESSION['userId'])) {
        
        $userId = $_SESSION['userId'];

      
        if ($_SESSION['Role'] == 'user'){
           
            $checkQtyQuery = "SELECT `quantity` FROM `products` WHERE `prodNo` = '$prodNo'";
            $qtyResult = mysqli_query($conn, $checkQtyQuery);
            if ($qtyResult && mysqli_num_rows($qtyResult) > 0) {
                $row = mysqli_fetch_assoc($qtyResult);
                $quantity = $row['quantity'];

                if ($quantity > 0) {        
            
                    $sql = "INSERT INTO `transaction`(`user_id`, `product_id`, `purch_date`, `status`) VALUES('$userId', '$prodNo', CURDATE(), 'purcahsed') ";
                    $result = mysqli_query($conn, $sql);
                    
                    if ($result) {

                        $sqlQuery = "UPDATE `products` SET `quantity` = (`quantity` - 1) WHERE  `prodNo` = '$prodNo'";
                        $res = mysqli_query($conn, $sqlQuery);
                        echo "<div class ='req-msg'> <img src='orderSuccess.gif' > <br> <a href='userDash.php' class ='home-btn'> FINAL CHECKOUT </a>";

                        
            }
        
            else {
                echo "Failed";
            }
        }
        else {
            echo "<div style='width: 100%; background-color: green; color: white; padding: 1.5rem; text-align: center; font-weight: bold;'>Item ran OUT OF STOCK.<div/>";
        }
    }
        }
    
        else {
            header('Location: admin/dashboard.php');
        }
    }
    else {
        header('Location: loginPage.php');
    }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        .req-msg {
            width: 50%;
            height: 70%;
            position: absolute;
            top: 10%;
            left: 22%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: linear-gradient(to right,rgb(54, 54, 54), rgb(193, 0, 0));
            color: #fff;
        }
        a {
            padding: 2px;
            margin-top: 5rem;
            background-color: lightblue;
            text-decoration: none;
        }
    </style>
</head>
<body>
    
</body>
</html>