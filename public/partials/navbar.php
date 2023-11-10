<link rel="stylesheet" href="assets/css/style.css">
<nav>
    <div class="logo">
        <img src="assets/images/logo.jpg" alt="FilmMarket Logo">
    </div>
    <ul class="menu">
        <li><a href="#">Home</a></li>
        <li><a href="#about-us">About Us</a></li>
        <li><a href="#films-section">Films</a></li>
        <li><a href="#collections">Collections</a></li>
        <li><a href="#contact">Contact</a></li>
    </ul>
    <div class="user-info">
        <button class="cart-icon">
            Cart (<span id="cart-count">0</span>)
        </button>
        <a href="authentication/login.php" class="logout"><button class="logout">Logout</button></a>
        <a href="account.php" class="user-profile"><button class="user-profile" onclick="toggleProfileUpdate()">Profile</button></a>
    </div>
</nav>