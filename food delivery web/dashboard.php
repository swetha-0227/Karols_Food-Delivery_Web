<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin";
$port = "33066";

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch seller details
$sql = "SELECT * FROM seller";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Add your existing CSS here (no changes needed) */
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">Karols</div>
        <ul id="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="#">Order Food</a></li>
            <li><a href="login.html">Admin Login</a></li>
            <li><a href="logout.php" class="btn">Logout</a></li> <!-- Corrected logout link -->
            <li><a href="sellerreg.php" class="btn">Sell</a></li>
        </ul>
        <div class="menu-toggle" id="menu-toggle">☰</div>
        <div class="user-info">
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        </div>
    </nav>

    <section class="fill">
        <h1>"Order Delicious Food...!!"</h1>
        <h1>Anytime! Anywhere!!</h1>
        <p>Explore the top restaurants and get food delivered at your doorstep.</p>
        <div class="search-bar">
            <input type="text" placeholder="Search for restaurants, cuisines, or dishes...">
            <button>Search</button>
        </div>
    </section>

    <section class="categories">
        <h2>Popular Categories</h2>
        <div class="carousel">
            <button class="carousel-arrow left">&#8249;</button>
            <div class="slider-container">
                <div class="slider">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="slide">
                                    <div class="seller-box">
                                        <h3>' . $row["product_name"] . '</h3>
                                        <img src="' . $row["product_image"] . '" alt="Product Image">
                                        <p>Seller: ' . $row["name"] . '</p>
                                        <p>Price: $' . number_format($row["product_price"], 2) . '</p>
                                    </div>
                                  </div>';
                        }
                    } else {
                        echo "<p>No products found.</p>";
                    }
                    ?>
                </div>
            </div>
            <button class="carousel-arrow right">&#8250;</button>
        </div>
    </section>

    <section class="localities">
        <h2>Popular Localities</h2>
        <div class="grid">
            <div class="locality"><h3>Chennai</h3></div>
            <div class="locality"><h3>Bengaluru</h3></div>
            <div class="locality"><h3>Coimbatore</h3></div>
            <div class="locality"><h3>Hyderabad</h3></div>
            <div class="locality"><h3>Delhi</h3></div>
        </div>
    </section>

    <div class="footer">
        &copy; <?php echo date("Y"); ?> @Karols. All Rights Reserved.
    </div>

    <script>
        // JavaScript for toggle menu in mobile view
        const menuToggle = document.getElementById('menu-toggle');
        const navLinks = document.getElementById('nav-links');

        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        // Slider logic
        const slider = document.querySelector('.slider');
        const slides = document.querySelectorAll('.slide');
        const leftArrow = document.querySelector('.carousel-arrow.left');
        const rightArrow = document.querySelector('.carousel-arrow.right');

        let currentIndex = 0;

        // Dynamically calculate slide width (including gap)
        const slideWidth = slides[0].getBoundingClientRect().width + 24; // 24px gap (1.5rem)

        // Total slides minus visible slides (3 visible)
        const maxIndex = slides.length - 3;

        // Move to the next slide
        function nextSlide() {
            currentIndex = currentIndex < maxIndex ? currentIndex + 1 : 0; // Reset to 0 after the last slide
            updateSliderPosition();
        }

        // Move to the previous slide
        function prevSlide() {
            currentIndex = currentIndex > 0 ? currentIndex - 1 : maxIndex; // Loop back to the last slide
            updateSliderPosition();
        }

        // Update the slider's position
        function updateSliderPosition() {
            slider.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
        }

        // Event listeners for navigation
        rightArrow.addEventListener('click', nextSlide);
        leftArrow.addEventListener('click', prevSlide);
        setInterval(nextSlide, 5000);
    </script>
</body>
</html>

<?php
$conn->close(); // Close database connection at the end
?>
