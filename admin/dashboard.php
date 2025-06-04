<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <style>
        body {
            background: url(adminGIF.gif);
            background-size: cover;
            background-repeat: no-repeat;
            object-fit: content;
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
        <li><a href="dashboard.php">DASHBOARD</a></li>
        <li><a href="view_products.php">VIEW PRODUCTS</a></li>
        <li><a href="add_products.php">ADD PRODUCTS</a></li>
        <li><a href="users.php">TOTAL CUSTOMERS</a></li>
        <li><a href="transaction.php">PRODUCTS HISTORY</a></li>
        <li><a href="../logout.php">LOGOUT</a></li>
    </ul>
    <div class="hamburger" id="hamburger">&#9776;</div>
</nav>
    <h1 style="color: rgb(122, 28, 28); text-align: center;">Hey Admin!</h1>
    
</body>
</html>