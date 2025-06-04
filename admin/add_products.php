<?php
    require "../db.php";
    session_start();
    if($_SERVER["REQUEST_METHOD"] === 'POST'){
        
        
        if(isset($_SESSION['userId'])) {
            if ($_SESSION['Role'] === "admin") {
                $title = $_POST['title'];   
                $category = $_POST['category'];
                $price = $_POST['price'];
                $quantity = $_POST['quantity'];
                $coupon = $_POST['coupon'];
                $prodNo = $_POST['prodNo'];
                $image = $_FILES['image']['name'];

                $sql = $conn->prepare("INSERT INTO `products`(`name`, `price`, `category`, `quantity`, `couponCode`, `image`, `prodNo`) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $sql->bind_param("sisissi", $title, $price, $category, $quantity, $coupon, $image, $prodNo);
                if ($sql->execute()) {
                    $imageLocation = $_FILES['image']['tmp_name'];
                    $uploadLoc = "/opt/lampp/htdocs/EcommSite/images/";
                    move_uploaded_file( $imageLocation, $uploadLoc.$image);
                    echo "<div class ='submit-prod'> Product Uploaded Successfully</div>";
                }
                else {
                    echo "<div> Failed to Insert the Product!";
                }
            }
            else {
                header('Location: ../userDash.php');
            }
        }
        else {
                header('Location: ../loginPage.php');
            }
        }
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Products</title>
    <style>
        body{
            background: linear-gradient(to right, #e3f2fd, #ffffff);
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


            .form-data {
                background: linear-gradient(to right,rgb(54, 54, 54), rgb(193, 0, 0));
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 10px 10px 20px 10px rgba(0, 0, 0, 0.58);
            width: 100%;
            max-width: 500px;
            position: absolute;
            top: 30%;
            left: 10%;
            }

            .form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            }

            .form input[type="text"],
            .form input[type="file"] {
            padding: 0.75rem 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            }

            .form input:focus {
            border-color: #26c6da;
            outline: none;
            }

            input[type="file"] {
            padding: 0.6rem;
            border: 1px dashed #bbb;
            background-color: #fafafa;
            }

            .submit-btn {
            background-color: #26c6da;
            color: white;
            padding: 0.9rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            }

            .submit-btn:hover {
            background-color: #00acc1;
            }

            .error {
            color: red;
            font-size: 0.9rem;
            text-align: center;
            margin-top: 0.5rem;
            }

            img {
                width: 40%;
                height: 70%;
                position: absolute;
                top: 5%;
                left: 40%;
            }

            /* Responsive Design */
            @media (max-width: 600px) {
            .form-data {
                padding: 1.5rem;
            }

            .form input,
            .submit-btn {
                font-size: 0.95rem;
            }
            }


            .submit-prod {
                background: linear-gradient(to right, #4caf50, #81c784); 
                color: white;
                padding: 1rem 1.5rem;
                margin: 1rem auto;
                border-radius: 8px;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                font-size: 1.1rem;
                text-align: center;
                width: fit-content;
                max-width: 90%;
                animation: popFadeIn 0.6s ease-out;
                z-index: 9999;
            }


            @keyframes popFadeIn {
                0% {
                    transform: scale(0.8);
                    opacity: 0;
                }
                100% {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            /* Responsive */
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
            @media (min-width: 300px) and (max-width: 1024px){
                img {
                    width: 20%;
                    height: 40%;
                    position: absolute;
                    top: 65%;
                    left: 39%;
                }
            }
    </style>
</head>
<body>
<nav class="navbar">
  <div class="logo">sHOPI sTORE</div>
  <ul class="nav-links" id="navLinks">
  <li><a href="../index.php">HOME</a></li>
  <li><a href="dashboard.php">DASHBOARD</a></li>
        <li><a href="view_products.php">VIEW PRODUCTS</a></li>
        <li><a href="add_products.php">ADD PRODUCTS</a></li>
        <li><a href="users.php">TOTAL CUSTOMERS</a></li>
        <li><a href="transaction.php">PRODUCTS HISTORY</a></li>
        <li><a href="../logout.php">LOGOUT</a></li>
  </ul>
  <div class="hamburger" id="hamburger">&#9776;</div>
</nav>
    <form action="add_products.php" method="post" id="prodForm" enctype="multipart/form-data" class="form-data">
        <div class="form">
            <input type="text" name="title" placeholder="NAME" id="title">
            <input type="text" name="category" placeholder="CATEGORY" id="category" >
            <input type="text" name="price" placeholder="AMOUNT" id="price">
            <input type="file" name="image" class="file-data" id="image" >
            <input type="text" name="quantity" placeholder="QUANTITY" id="quantity">
            <input type="text" name="coupon" placeholder="COUPON CODE" id="coupon">
            <input type="text" name="prodNo" placeholder="Product Number" id="prodNo">
            <button type="submit" class="submit-btn">ADD</button>
            <div class="error" id="errorMsg"></div>
        </div>
    </form>

    <img src="shopping-cart-shopping.gif" alt="gif">


<script>
  const hamburger = document.getElementById('hamburger');
  const navLinks = document.getElementById('navLinks');

  hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('show');
  });


            const form = document.getElementById('prodForm');
            const errorMsg = document.getElementById('errorMsg');

            form.addEventListener('submit', (event) => {
                const title = document.getElementById('title').value.trim();
                const category = document.getElementById('category').value.trim();
                const price = document.getElementById('price').value.trim();
                const image = document.getElementById('image').value.trim();
                const quantity = document.getElementById('quantity').value.trim();
                const coupon = document.getElementById('coupon').value.trim();

                if (!title || !category || !price || !image || !quantity || !coupon) {
                    event.preventDefault();
                    errorMsg.textContent = "All fields are required!";
                    setTimeout(() => {
                        errorMsg.textContent = "";
                    }, 4000);
                }
            });

            const submitProd = document.querySelector('.submit-prod');
            if (submitProd) {
                setTimeout(() => {
                    submitProd.style.display = 'none';
                }, 4000);
            }
        
</script>
</body>
</html>