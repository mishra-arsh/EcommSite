<?php 
require "../db.php";
session_start();

if (!isset($_SESSION['userId']) || $_SESSION['Role'] !== 'admin') {
    header('Location: ../loginPage.php');
    exit();
}

// Handle deletion
if (isset($_GET['id'])) {
    $deleteId = intval($_GET['id']);
    $delete = $conn->prepare("DELETE FROM `transaction` WHERE `id` = ?");
    $delete->bind_param("i", $deleteId);
    $delete->execute();

    // Prevent repeated deletion on refresh
    header("Location: transaction.php");
    exit();
}

// Fetch transaction data
$sql = $conn->prepare('SELECT * FROM `transaction`');
$sql->execute();
$result = $sql->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            /* margin: 0; */
            font-family: Arial, sans-serif;
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

        .table-data {
            width: 90%;
            margin: 100px auto 50px;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: none;
            background: linear-gradient(to right, rgb(54, 54, 54), rgb(193, 0, 0));
            color: white;
            box-shadow: 5px 5px 10px -5px #333;
            border-radius: 8px;
        }

        th {
            font-weight: bold;
        }

        .delete-btn {
            background-color: #c62828;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
            text-decoration: none;
        }

        .delete-btn:hover {
            background-color: #b71c1c;
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
            <th>CUSTOMER ID</th>
            <th>PRODUCT ID</th>
            <th>DATE OF PURCHASE</th>
            <th>STATUS</th>
            <th>ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
            <td><?php echo htmlspecialchars($row['product_id']); ?></td>
            <td><?php echo htmlspecialchars($row['purch_date']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td>
                <a 
                    href="transaction.php?id=<?php echo $row['id']; ?>" 
                    class="delete-btn" 
                    onclick="return confirm('Do you want to delete this transaction?');">
                    DELETE
                </a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    // Mobile toggle for nav
    const hamburger = document.getElementById('hamburger');
    const navLinks = document.getElementById('navLinks');

    hamburger?.addEventListener('click', () => {
        navLinks.classList.toggle('show');
    });
</script>

</body>
</html>
