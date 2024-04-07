<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Todo app</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">

        <h1 class="logo me-auto">
            <a href="index.html" class="logo me-auto"><img src="assets/img/main-logo-black-transparent-removebg-preview.png" alt="" class="img-fluid" style="width: 160px;"></a>
        </h1>

        @if (Route::has('login'))
            <nav id="navbar" class="navbar">
                <ul>
                    @auth
                        <li><a class="nav-link scrollto active" href="{{ url('/index') }}">Dashboard</a></li>
                    @else
                        <li><a class="getstarted scrollto" href="{{ route('login') }}">Login</a></li>
                        @if (Route::has('register'))
                            <li><a class="getstarted scrollto" href="{{ route('register') }}">Register</a></li>
                        @endif
                    @endauth
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
        @endif

    </div>
</header>

<section id="hero" class="d-flex align-items-center">

    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                <h1>Better Solutions For Your Life</h1>
                <h2>Every activity of your life should be planned clearly.</h2>
                <div class="d-flex justify-content-center justify-content-lg-start">
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                <img src="assets/img/home-image.png" class="img-fluid animated" alt="">
            </div>
        </div>
    </div>
</section>

<footer class="text-center mt-5">
    <p>&copy; {{ date('Y') }} Your Todo. All rights reserved.</p>
</footer>

<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

</body>

</html>
