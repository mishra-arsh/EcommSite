<?php
    require "../db.php";
    session_start();
    if(isset($_SESSION['userId'])){
        if ($_SESSION['Role'] == 'admin'){
            // echo "Welcome admin";
            if (isset($_GET['del'])) {
                $prodNoToDelete = mysqli_real_escape_string($conn, $_GET['del']);
                $deleteSql = "DELETE FROM `products` WHERE `prodNo` = '$prodNoToDelete'";
                mysqli_query($conn, $deleteSql);
                header("Location: view_products.php");
                exit;
            }
        
            $sql = "SELECT * FROM `products`";
            $result = mysqli_query($conn, $sql);
        
        


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Manage</title>
    <style>
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        tr, th {
            border-bottom: 2px solid #333;
            color: #fff;
            padding: 0.5rem;
            text-align: center;
            box-shadow: 5px 5px 10px -5px #333, 5px 5px 10px -5px #333;
            border-radius: 10px;
            background: linear-gradient(to right,rgb(54, 54, 54), rgb(193, 0, 0));
        }
        td {
            padding: 0.5rem;
            text-align: center;
            /* background-color: silver; */
            border: none;
            box-shadow: 5px 5px 10px -5px #333, 5px 5px 10px -5px #333;
            border-radius: 10px;
            background: linear-gradient(to right,rgb(54, 54, 54), rgb(193, 0, 0));   
        }
        img {
            width: 80px;
            height: auto;
        }
        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .navbar {
            position: fixed;
            top: 0;
            background: linear-gradient(to right,rgb(54, 54, 54), rgb(193, 0, 0));
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1000;
            }

            .logo {
            font-size: 1.8rem;
            font-weight: bold;
            letter-spacing: 1px;
            }

            .nav-links {
            list-style: none;
            display: flex;
            gap: 1.5rem;
            }

            .nav-links li a {
            text-decoration: none;
            color: white;
            font-weight: 500;
            transition: color 0.3s ease;
            }

            .nav-links li a:hover {
            color: #ffd54f;
            }

            /* Hamburger Icon */
            .hamburger {
            display: none;
            font-size: 1.8rem;
            cursor: pointer;
            }
            @media (max-width: 768px) {
                .nav-links {
                    position: absolute;
                    top: 70px;
                    right: 0;
                    background: #00acc1;
                    width: 100%;
                    flex-direction: column;
                    align-items: center;
                    gap: 1.2rem;
                    padding: 1rem 0;
                    display: none;
                }

                .nav-links.show {
                    display: flex;
                }

                .hamburger {
                    display: block;
                }
        }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="logo">sHOPI sTORE</div>
    <ul class="nav-links" id="navLinks">
        <li><a href="../index.php">HOME</a></li>
        <li><a href="view_products.php">VIEW PRODUCTS</a></li>
        <li><a href="add_products.php">ADD PRODUCTS</a></li>
        <li><a href="users.php">TOTAL CUSTOMERS</a></li>
        <li><a href="transaction.php">PRODUCTS HISTORY</a></li>
        <li><a href="../logout.php">LOGOUT</a></li>
    </ul>
    <div class="hamburger" id="hamburger">&#9776;</div>
    </nav>
    <table class="table-data">
        <thead>
            <tr>
                <th>PRODUCT NAME</th>
                <th>CATEGORY</th>
                <th>PRICE</th>
                <th>IMAGE</th>
                <th>QUANTITY</th>
                <th>COUPON CODE</th>
                <th>PRODUCT NO.</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
                while($row = mysqli_fetch_assoc($result)){
    
            ?>
            <tr>
                <td> <?php echo "{$row['name']}";?>  </td>
                   
                
                <td><?php echo "{$row['category']}";?> </td>
                <td><?php echo "{$row['price']}";?> </td>
                <td> <img src="../images/<?php echo "{$row['image']}";?>"></td>
                <td><?php echo "{$row['quantity']}";?> </td>
                <td><?php echo "{$row['couponCode']}";?> </td>
                <td><?php echo "{$row['prodNo']}";?> </td>
                <td>
            <button class="delete-btn" onclick="confirmDelete('<?php echo $row['prodNo']; ?>')">Delete</button>
          </td>
               
            </tr>
                    
            <?php }
            } 

        

                else {
                    header('Location: ../userDash.php');
                }
            }

            else {
                header('Location: ../loginPage.php');
            } 
        
            ?>
        </tbody>
    </table>
    <script>
    function confirmDelete(proddNo) {
        if (confirm("Are you sure you want to delete this product?")) {
            window.location.href = "view_products.php?del=" + proddNo;
        }
    }
  </script>
</body>
</html>

