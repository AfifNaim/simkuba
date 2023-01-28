<!DOCTYPE html>
<html lang="en">
<head>
	<title>SIMKUBA</title>
	<meta charset="UTF-8">
	<meta name="description" content="Cryptocurrency Landing Page Template">
	<meta name="keywords" content="cryptocurrency, unica, creative, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Favicon -->
	<link href="crypto/img/favicon.ico" rel="shortcut icon"/>

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

	<!-- Stylesheets -->
    <link rel="stylesheet" href="crypto/css/bootstrap.min.css">
    <link rel="stylesheet" href="crypto/css/font-awesome.min.css">
    <link rel="stylesheet" href="crypto/ss/themify-icons.css">
    <link rel="stylesheet" href="crypto/css/animate.css">
    <link rel="stylesheet" href="crypto/css/owl.carousel.css">
    <link rel="stylesheet" href="crypto/css/style.css">



	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


</head>
<body>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>

	<!-- Header section --> 
	<header class="header-section clearfix">
		<div class="container-fluid">
			<a href="" class="site-logo">
				<img src="{{ asset('assets/logo/logoOnly.png') }}" width="100">
			</a>
			<div class="responsive-bar"><i class="fa fa-bars"></i></div>
			<a href="" class="user"><i class="fa fa-user"></i></a>
			<a class="site-btn" href="{{ route('register') }}">Sign Up</a>
			<a class="site-btn" href="{{ route('login') }}">Login</a>
		</div>
	</header>
	<!-- Header section end -->


	<!-- Hero section -->
	<section class="hero-section">
		<div class="container">
			<div class="row">
				<div class="col-md-6 hero-text">
					<h2>Rekap <span>Keuangan</span> <br>SIMKUBA</h2>
					<h4>Cara mudah untuk melakukan pencatatan keuangan UMKM anda</h4>
					<form class="hero-subscribe-from">
						<a class="site-btn sb-gradients" href="{{ route('register') }}">Get Started</a>
					</form>
				</div>
				<div class="col-md-6">
					<img src="{{ asset('logo/web.png') }}" width="1000"">
				</div>
			</div>
		</div>
	</section>
	<!-- Hero section end -->


	<!-- About section -->
	<section class="about-section spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 offset-lg-6 about-text">
					<h2>Apa itu SIMKUBA</h2>
					<h5>SIMKUBA adalah sistem informasi keuangan yang membantu anda dalam pencatatan keuangan UMKM anda</h5>
					<p>UMKM Batik di Masaran Sragen merupakan salah satu sentral industi batik lokal yang berdomisili diwilayah surakarta, selama ini dalam pengelolaan keuangan UMKM masih mencatat transaksi keuangan dengan secara manual, untuk itulah SIMKUBA dibutuhkan!.</p>
				</div>
			</div>
			<div class="about-img">
				<img src="crypto/img/about-img.png" alt="">
			</div>
		</div>
	</section>
	<!-- About section end -->


	<!-- Features section -->
	<section class="features-section spad gradient-bg">
		<div class="container text-white">
			<div class="section-title text-center">
				<h2>Fitur Aplikasi</h2>
				<p>SIMKUBA adalah Sistem Informasi Keuangan yang anda butuhkan.</p>
			</div>
			<div class="row">
				<!-- feature -->
				<div class="col-md-6 col-lg-4 feature">
					<i class="ti-mobile"></i>
					<div class="feature-content">
						<h4>Manajemen UMKM</h4>
						<p>Menampilkan data UMKM anda, membuat seolah sistem ini milik anda sendiri.</p>
					</div>
				</div>
				<div class="col-md-6 col-lg-4 feature">
					<i class="ti-mobile"></i>
					<div class="feature-content">
						<h4>Manajemen Kategori</h4>
						<p>Membantu anda dalam melakukan filter transaksi keuangan anda.</p>
					</div>
				</div>
				<div class="col-md-6 col-lg-4 feature">
					<i class="ti-mobile"></i>
					<div class="feature-content">
						<h4>Manajemen Transaksi</h4>
						<p>Membantu anda dalam mencatat keuangan anda, dilengkapi dengan foto serta dekripsi bila anda melewatkan detai dalam mencatat keuangan anda.</p>
					</div>
				</div>
				<div class="col-md-6 col-lg-4 feature">
					<i class="ti-mobile"></i>
					<div class="feature-content">
						<h4>Manajemen Users</h4>
						<p>Anda merasa kelelahan dalam mencatat keuangan? Anda bisa menambahkan user baru untuk membantu anda!.</p>
					</div>
				</div>
				<div class="col-md-6 col-lg-4 feature">
					<i class="ti-mobile"></i>
					<div class="feature-content">
						<h4>Cetak Laporan</h4>
						<p>Anda dapat mencetak laporan keuangan anda dengan sangat mudah dan cepat tanpa harus melakukan rekap kembali</p>
					</div>
				</div>
				<div class="col-md-6 col-lg-4 feature">
					<i class="ti-mobile"></i>
					<div class="feature-content">
						<h4>Grafik Keuangan</h4>
						<p>Anda dapat melihat grafik keuangan umkm anda dengan sangat mudah, jadi makin jeli dalam melakukan transaksi</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Features section end -->


	<!-- Process section -->
	<section class="process-section spad">
		<div class="container">
			<div class="section-title text-center">
				<h2>Mulai Registrasi Dengan SIMKUBA</h2>
				<p>Mulai belajar tentang SIMKUBA dengan tutorial mudah! </p>
			</div>
			<div class="row">
				<div class="col-md-4 process">
					<div class="process-step">
						<figure class="process-icon">
							<i class="fa-regular fa-file-user"></i>
						</figure>
						<h4>Buat Akun Anda</h4>
						<p>Lakukan registrasi pada SIMKUBA dengan mengisi biodata anda. </p>
					</div>
				</div>
				<div class="col-md-4 process">
					<div class="process-step">
						<figure class="process-icon">
							<i class="fa-regular fa-file-invoice-dollar"></i>
						</figure>
						<h4>Lakukan Verifikasi</h4>
						<p>Sistem terintregasi dengan email anda tanpa ribet </p>
					</div>
				</div>
				<div class="col-md-4 process">
					<div class="process-step">
						<figure class="process-icon">
							<i class="fa-regular fa-file-invoice-dollar"></i>
						</figure>
						<h4>Mulai Mencatat Transaksi</h4>
						<p>Sangat mudah melakukan pencatatan keuangan dengan SIMKUBA</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Process section end -->

	<!-- Footer section -->
	<footer class="footer-section">
		<div class="container">
			<div class="row spad">
				
			</div>
		</div>
	</footer>


	<!--====== Javascripts & Jquery ======-->
    <script src="crypto/js/jquery-3.2.1.min.js"></script>
    <script src="crypto/js/owl.carousel.min.js"></script>
    <script src="crypto/js/main.js"></script>
</body>
</html>
