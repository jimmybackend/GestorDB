<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Tienda en línea</title>
</head>
<body>
    <!-- === HEADER === -->
    <header class="l-header">
        <nav class="nav bg-grid">
            <div>
                <a href="#" class="nav-logo">Tienda</a>
            </div>
            <div class="nav-menu" id="nav-menu">
                <ul class="nav-list">
                    <li class="nav-item"><a href="#home" class="nav-link active">Inicio</a></li>
                    <li class="nav-item"><a href="#featured" class="nav-link">Destacados</a></li>
                    <li class="nav-item"><a href="#new" class="nav-link">Nuevos</a></li>
                    <li class="nav-item"><a href="#subscribed" class="nav-link">Suscríbase</a></li>
                </ul>
            </div>
            <div>
                <i class="fas fa-shopping-cart nav-cart"></i>
                <i class="fas fa-th-list nav-toggle" id="nav-toggle"></i>

            </div>
        </nav>
    </header>
    <!-- === MAIN PAGE === -->
    <main class="l-main">
        <!-- === HOME === -->
        <section id="home" class="home">
            <div class="home-container bg-grid">
                <div class="home-data"><br><br><br>
                   <?php include 'usersadd.php'; ?>
                   <br><br><br>
                </div>
                
            </div>
        </section>


        <!-- === FOOTER === -->
        <section class="section footer">
            <div class="footer-container bg-grid">
                <div class="footer-box">
                        <h3 class="footer-title">Tienda</h3>
                        <p class="footer-decs">products store</p>
                        <a href="#" class="footer-store"><img src="assets/images/footerstore1.png" alt="store"></a>
                        <a href="#" class="footer-store"><img src="assets/images/footerstore2.png" alt="store"></a>
                    
                </div>
                <div class="footer-box">
                    <h3 class="footer-title">Explore</h3>
                    <ul>
                        <li><a href="#home" class="footer-link">Home</a></li>
                        <li><a href="#featured" class="footer-link">Featured</a></li>
                        <li><a href="#new" class="footer-link">New</a></li>
                        <li><a href="#subscribe" class="footer-link">Subscribe</a></li>
                    </ul>
                </div>
                <div class="footer-box">
                    <h3 class="footer-title">Our Services</h3>
                    <ul>
                        <li><a href="#home" class="footer-link">pricing</a></li>
                        <li><a href="#featured" class="footer-link">free shipping</a></li>
                        <li><a href="#new" class="footer-link">gift card</a></li>
                    </ul>
                </div>
                <div class="footer-box">
                    <h3 class="footer-title">Explore</h3>
                    <ul class="social-icons">
                        <li><a href="#" class="footer-link "><i class="fab fa-facebook-square"></i></a></li>
                        <li><a href="#" class="footer-link"><i class="fab fa-instagram-square"></i></a></li>
                        <li><a href="#" class="footer-link"><i class="fab fa-twitter-square "></i></a></li>

                    </ul>
                </div>
            </div>
            <p class="footer-copy">&#169; 2020 Copyright all right reserved</p>
        </section>
    </main>
    <script src="assets/js/main.js"></script>
</body>
</html>