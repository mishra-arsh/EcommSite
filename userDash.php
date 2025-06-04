<?php 
    require "db.php";
    session_start();
    if(isset($_SESSION['Role'])){
        if ($_SESSION['Role'] == "user"){
        $userId = $_SESSION['userId'];
        $role = $_SESSION['Role'];

    $search = '';
    if (isset($_GET['search'])) {
        $search = mysqli_real_escape_string($conn, $_GET['search']);
        $sql = "SELECT * FROM `products` WHERE 
                `name` LIKE '%$search%' OR 
                `category` LIKE '%$search%' OR 
                `couponCode` LIKE '%$search%'";
    }
    else {
        
        $sql = "SELECT * FROM `products`";
    }
    $result = mysqli_query($conn, $sql);
    if ($result) {
         
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="userDash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
    <nav class="navbar">
    <div class="logo">sHOPI sTORE</div>
    <ul class="nav-links" id="navLinks">
        
        <li><a href="index.php">HOME</a></li>
        <li><a href=""><i class="fas fa-cart-plus"></i></a>
        <span id="cartCount">0</span>
        </li>
        <li><a href="status.php">STATUS</a></li>
        <li><a href="logout.php">LOGOUT</a></li>
    </ul>
    <div class="hamburger" id="hamburger">&#9776;</div>
    </nav>

    <div style="text-align:center; margin-top: 2rem;">
    <form action="" method="get" class="form-input">
        <input type="text" name="search" placeholder="Search by Name, Category, or Coupon Code" value="<?php echo htmlspecialchars($search); ?>" style="padding: 0.5rem; width: 300px; border-radius: 5px; border: 1px solid #fff; background: linear-gradient(to right, #232526, #414345; color: white;);
">
        <button type="submit" style="padding: 0.5rem 1rem; border: none; background-color:rgb(139, 52, 52); color: white; border-radius: 5px;">Search</button>
        
    </form>
    <button id="openFilterModal" style="margin-top: 1rem; padding: 0.5rem 1rem; background-color:rgb(139, 52, 52); color:white; border:none; border-radius:5px;">Open Filter</button>
    </div>
    
   


    <section class="intro-section">
    <h1>Welcome to sHOPI sTORE</h1>
    <p>Your one-stop destination for top-quality products at unbeatable prices. From daily essentials to exclusive deals, explore our wide range and enjoy seamless shopping. Fast delivery, secure checkout, and amazing offers await you!</p>
    </section>

    <div class="category-section" style="text-align:center; margin: 2rem auto;">
    <h2 style="color: white;">Browse by Category</h2>
    <div id="categoryButtons" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1rem; margin-top: 1rem;">
        <button class="category-btn" data-category="Electronics">Electronics</button>
        <button class="category-btn" data-category="Fashion">Fashion</button>
        <button class="category-btn" data-category="Games & Toys">Games & Toys</button>
        <!-- <button class="category-btn" data-category="Home">Home</button> -->
        <button class="category-btn" data-category="Kitchen & Foods">Kitchen</button>
        <button class="category-btn" data-category="All">Show All</button>
    </div>
    </div>


    <div id="cartModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Your Cart</h2>
        <div id="cartItemsContainer"></div>

        <div id="cartItemsContainer"></div>
        <button id="checkoutBtn" class="cart-btn" style="margin-top:10px;">Proceed to Checkout</button>
    </div>
    </div>

    <div id="checkoutModal" class="modal">
    <div class="modal-content">
        <span class="close-checkout-btn">&times;</span>
        <h2>Checkout Form</h2>
        <form id="checkoutForm">

            <label for="coupon">Coupon Code:</label><br>
            <input type="text" id="coupon" name="coupon"><br><br>

            <label for="fullName">Full Name:</label><br>
            <input type="text" id="fullName" name="fullName" required><br><br>

            <label for="address">Shipping Address:</label><br>
            <textarea id="address" name="address" required></textarea><br><br>

            <label for="contact">Contact Number:</label><br>
            <input type="text" id="contact" name="contact" required><br><br>

            <p><strong>Total: Rs <span id="totalPrice">0</span></strong></p>
            <p id="discountMessage" style="color:green;"></p>


            <button type="submit" class="cart-btn">Submit Order</button>
        </form>
    </div>
    </div>


    
    <div id="filterModal" class="modal">
        <div class="modal-content">
            <span class="close-filter-btn"><b> &times; </b></span>
            <h2>Filter Products</h2>
            <form id="filterForm">
                <label for="filterName">Name</label><br>
                <input type="text" id="filterName" name="filterName"><br><br>

                <label for="filterCategory">Category</label><br>
                <input type="text" id="filterCategory" name="filterCategory"><br><br>

                <label for="filterPrice">Max Price</label><br>
                <input type="number" id="filterPrice" name="filterPrice"><br><br>

                <label for="priceRange">Max Price: <span id="priceValue">500</span></label><br>
                <input type="range" id="priceRange" name="priceRange" min="0" max="1000" step="50" value="500" style="width: 100%;">

                <button type="submit" class="cart-btn">Apply Filter</button>
            </form>
        </div>
    </div>


    <div class="details">
    <div class="prod-row">
    <?php  
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <div class="prod-card">
        
            <div class="favorite-icon"><i class="fas fa-heart"></i></div>
            <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="Product Image">

            <h2><?php echo htmlspecialchars($row['name']); ?></h2>
            <h3><?php echo htmlspecialchars($row['category']); ?></h3>
            <p>Rs <?php echo htmlspecialchars($row['price']); ?></p>
            <p>Quantity: <?php echo htmlspecialchars($row['quantity']); ?></p>
            <a href='#'
                class="add-to-cart-btn" 
                data-image="images/<?php echo $row['image']; ?>"
                data-name="<?php echo htmlspecialchars($row['name']); ?>" 
                data-category="<?php echo htmlspecialchars($row['category']); ?>" 
                data-price="<?php echo htmlspecialchars($row['price']); ?>">
                <button class="cart-btn" type="button">ADD TO CART</button>
            </a>
            <a href="borrow.php?prodNo=<?php echo $row['prodNo'];?>"><button class='cart-btn'>BUY NOW</button></a>

        </div>
        
    <?php 
    }
   
    ?>
    </div>
</div>
<?php
        }
        else {
            echo "<div> Failed to connect! </div>";
        }
    }else {
        header('Location: admin/dashboard');
    }
    }
        else {
            header('Location: loginPage.php');
            exit();
        }

    
    ?>
<script>
    function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem("cartItems")) || [];
    cartCount.textContent = cart.length;
}
    const modal = document.getElementById("cartModal");
    const cartIcon = document.querySelector(".fa-cart-plus");
    const closeBtn = document.querySelector(".close-btn");
    const cartItemsContainer = document.getElementById("cartItemsContainer");

    // --- Load Cart from localStorage on Page Load ---
    window.addEventListener("load", () => {
        const savedCart = JSON.parse(localStorage.getItem("cartItems")) || [];
        savedCart.forEach(item => addItemToCart(item, false));
        updateEmptyCartMessage();
        updateCartCount();
    });

    
    cartIcon.addEventListener("click", function(event) {
        event.preventDefault();
        modal.style.display = "block";
    });

    
    closeBtn.addEventListener("click", () => modal.style.display = "none");
    window.addEventListener("click", (event) => {
        if (event.target === modal) modal.style.display = "none";
    });

   
    document.querySelectorAll(".add-to-cart-btn").forEach(button => {
        button.addEventListener("click", function(event) {
            event.preventDefault();
            const item = {
                name: this.getAttribute("data-name"),
                category: this.getAttribute("data-category"),
                price: this.getAttribute("data-price"),
                image: this.getAttribute("data-image")
            };
            addItemToCart(item, true);
        });
    });

    
    function addItemToCart(item, saveToStorage = true) {
    const itemId = `${item.name}-${item.category}-${item.price}`;

  
    if (document.getElementById(itemId)) return;

    const cartItem = document.createElement("div");
    cartItem.classList.add("cart-item");
    cartItem.id = itemId;
    cartItem.innerHTML = `
        <img src="${item.image}" alt="${item.name}" style="width: 60px; height: 60px; object-fit: cover; margin-right: 10px;">
        <strong>${item.name}</strong><br>
        Category: ${item.category}<br>
        Price: Rs ${item.price}<br>
        <button class="delete-btn" data-id="${itemId}" style="margin-top:5px;">Delete</button>
        <hr>
    `;
    cartItemsContainer.appendChild(cartItem);

    if (saveToStorage) {
        const cart = JSON.parse(localStorage.getItem("cartItems")) || [];
        cart.push(item);
        localStorage.setItem("cartItems", JSON.stringify(cart));
    }

    updateEmptyCartMessage();
    updateCartCount();
}


document.querySelectorAll(".add-to-cart-btn").forEach(button => {
    button.addEventListener("click", function(event) {
        event.preventDefault();
        const item = {
            name: this.getAttribute("data-name"),
            category: this.getAttribute("data-category"),
            price: this.getAttribute("data-price"),
            image: this.getAttribute("data-image")
        };
        addItemToCart(item, true);
    });
});


    
    cartItemsContainer.addEventListener("click", function(e) {
        if (e.target.classList.contains("delete-btn")) {
            const itemId = e.target.getAttribute("data-id");
            document.getElementById(itemId)?.remove();

            let cart = JSON.parse(localStorage.getItem("cartItems")) || [];
            cart = cart.filter(item => `${item.name}-${item.category}-${item.price}` !== itemId);
            localStorage.setItem("cartItems", JSON.stringify(cart));

            updateEmptyCartMessage();
        }
    });

    
    function updateEmptyCartMessage() {
        if (!cartItemsContainer.hasChildNodes()) {
            cartItemsContainer.innerHTML = "<p>Your cart is currently empty.</p>";
        }
    }


    const filterModal = document.getElementById("filterModal");

const openFilterBtn = document.getElementById("openFilterModal");
const closeFilterBtn = document.querySelector(".close-filter-btn");

openFilterBtn.addEventListener("click", () => {
    filterModal.style.display = "block";
});

closeFilterBtn.addEventListener("click", () => {
    filterModal.style.display = "none";
});

window.addEventListener("click", (event) => {
    if (event.target === filterModal) {
        filterModal.style.display = "none";
    }
});


document.getElementById("filterForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const name = document.getElementById("filterName").value.toLowerCase();
    const category = document.getElementById("filterCategory").value.toLowerCase();
    const price = parseFloat(document.getElementById("filterPrice").value);

    document.querySelectorAll(".prod-card").forEach(card => {
        const cardName = card.querySelector("h2").textContent.toLowerCase();
        const cardCategory = card.querySelector("h3").textContent.toLowerCase();
        const cardPrice = parseFloat(card.querySelector("p").textContent.replace("Rs", "").trim());

        const matchesName = name === "" || cardName.includes(name);
        const matchesCategory = category === "" || cardCategory.includes(category);
        const matchesPrice = isNaN(price) || cardPrice <= price;

        if (matchesName && matchesCategory && matchesPrice) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
    document.getElementById("filterForm").reset();

    filterModal.style.display = "none";
});

// const priceRange = document.getElementById("priceRange");
// const priceValue = document.getElementById("priceValue");

// priceRange.addEventListener("input", function () {
//     priceValue.textContent = this.value;

//     // Auto-filter as the range changes (optional)
//     filterByPrice(this.value);
// });

// function filterByPrice(maxPrice) {
//     maxPrice = parseFloat(maxPrice);
//     document.querySelectorAll(".prod-card").forEach(card => {
//         const priceText = card.querySelector("p").textContent.replace("Rs", "").trim();
//         const productPrice = parseFloat(priceText);

//         if (!isNaN(productPrice) && productPrice <= maxPrice) {
//             card.style.display = "block";
//         } else {
//             card.style.display = "none";
//         }
//     });
// }
const checkoutModal = document.getElementById("checkoutModal");
const checkoutBtn = document.getElementById("checkoutBtn");
const closeCheckoutBtn = document.querySelector(".close-checkout-btn");

checkoutBtn.addEventListener("click", () => {
    checkoutModal.style.display = "block";
});

closeCheckoutBtn.addEventListener("click", () => {
    checkoutModal.style.display = "none";
});

window.addEventListener("click", (e) => {
    if (e.target === checkoutModal) checkoutModal.style.display = "none";
});

const totalPriceEl = document.getElementById("totalPrice");
const couponInput = document.getElementById("coupon");
const discountMessage = document.getElementById("discountMessage");

function calculateCartTotal() {
    const cart = JSON.parse(localStorage.getItem("cartItems")) || [];
    let total = 0;

    cart.forEach(item => {
        total += parseFloat(item.price);
    });

    return total;
}

function updateTotalDisplay(discount = 0) {
    let total = calculateCartTotal();
    if (discount > 0) {
        total -= (total * discount / 100);
        discountMessage.textContent = `Coupon applied! ${discount}% discount.`;
    } else {
        discountMessage.textContent = "";
    }

    totalPriceEl.textContent = total.toFixed(2);
}

checkoutBtn.addEventListener("click", () => {
    updateTotalDisplay(); 
    checkoutModal.style.display = "block";
});


document.getElementById("checkoutForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const coupon = couponInput.value.trim().toUpperCase();
    let discount = 0;

    if (coupon === "SAVE10") {
        discount = 10;
    } else if (coupon === "WELCOME20") {
        discount = 20;

    } else if (coupon === "SALE15") {
        discount = 15;
    }
    else if (coupon !== "") {
        alert("Invalid coupon code!");
        return;
    }

    const totalBefore = calculateCartTotal();
    const finalTotal = totalBefore - (totalBefore * discount / 100);

    alert(`Order submitted! Final amount: Rs ${finalTotal.toFixed(2)}.`)
    // alert("Order submitted! (This is a placeholder. You can now handle the data.)");


    // Optional: Clear cart
    localStorage.removeItem("cartItems");
    cartItemsContainer.innerHTML = "";
    updateCartCount();
    checkoutModal.style.display = "none";
    modal.style.display = "none";
});

document.querySelectorAll(".category-btn").forEach(btn => {
    btn.addEventListener("click", function () {
        const selectedCategory = this.getAttribute("data-category").toLowerCase().trim();

        document.querySelectorAll(".prod-card").forEach(card => {
            const cardCategory = card.querySelector("h3").textContent.toLowerCase().trim();

            if (selectedCategory === "all" || cardCategory === selectedCategory) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    });
});

document.querySelectorAll('.favorite-icon').forEach(icon => {
    icon.addEventListener('click', function () {
        this.classList.toggle('active');
    });
});


</script>


    
</body>
</html>