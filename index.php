<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THE AL AQSA SCHOOL</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="img/logo.jpg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/0ca0bd90fd.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <a href="#" class="logo"><img src="img/logo3.png" alt=""></a>
        <ul>
            <li><a href="#">HOME</a></li>
            <li><a href="#">NEWS</a></li>
            <li><a href="#">ABOUT</a></li>
            <li><a href="#">CONTACT</a></li>
            <li><a href="#">STAFFS</a></li>
        </ul>
        <div class="navbar-menu-toggle">
            <i class="fa-solid fa-bars"></i>
        </div>
        <div class="side-navbar">
            <p class="close-btn" style="text-align: right;">
                <i class="fa-solid fa-xmark"></i>
            </p>
            <ul class="side-nav-link">
                <li><a href="#">HOME</a></li>
                <li><a href="#">NEWS</a></li>
                <li><a href="#">ABOUT</a></li>
                <li><a href="#">STAFFS</a></li>
                <li><a href="#">STUDENTS</a></li>
            </ul>
        </div>
    </header>
    <section class="banner">
        <p>Welcome to Al Aqsa School</p>
    </section>
    <div class="about">
        <br><br>
        <h2>A Legacy of Excellence and Innovation</h2><br>
        <p>At Al Aqsha School, we believe in every student's potential and are dedicated to helping you succeed. We provide the tools, inspiration, and guidance you need to achieve your goals. Our resources and advice will help you excel academically and personally. Join our community, explore our platform, and let us support you on your journey to a bright and successful future. Together, we can achieve great things!</p>
        <a href="#">Discover Life at Reid Avenue</a>
        <div class="principal">
            <img src="img/principal.png" alt="">
            <h3>Principal Message</h3>
            <p>At Al Aqsha School, we believe in every student's potential and are dedicated to helping you succeed. We provide the tools, inspiration, and guidance you need to achieve your goals. Our resources and advice will help you excel academically and personally. Join our community, explore our platform, and let us support you on your journey to a bright and successful future. Together, we can achieve great things!
            </p>
        </div>
    </div>

    <div class="flogo"><img src="img/logo3.png" alt=""></div>
    <footer>
        <div class="social">
            <a href="#"><img src="img/fb.png" alt="Facebook"></a>
            <a href="#"><img src="img/ig.png" alt="Instagram"></a>
            <a href="#"><img src="img/yt.png" alt="YouTube"></a>
        </div>
        <div class="links">
            <ul>
                <li><a href="#">HOME</a></li>
                <li><a href="#">NEWS</a></li>
                <li><a href="#">ABOUT</a></li>
                <li><a href="#">CONTACT</a></li>
                <li><a href="#">GALLERY</a></li>
            </ul>
        </div>
        <div class="credits">
            <p>© 2024 Al Aqsha</p>
            <a href="#">PROJECT 25</a>
        </div>
    </footer>    
    <script type="text/javascript">
        window.addEventListener("scroll", function () {
            var header = document.querySelector("header");
            header.classList.toggle("sticky", window.scrollY > 0)
        })
    
        document.querySelector('.navbar-menu-toggle').addEventListener('click', function () {
            document.querySelector('.side-navbar').classList.toggle('active');
        });
    
        document.querySelector('.side-navbar .close-btn').addEventListener('click', function () {
            document.querySelector('.side-navbar').classList.remove('active');
        });
    </script>
    
</body>

</html>
