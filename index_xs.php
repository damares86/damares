<?php

session_start();

spl_autoload_register('autoloader');

function autoloader($class){
    include("admin/class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

// recall of all the classes
$files=glob("admin/class/*.php", GLOB_BRACE);
rsort($files); 

// creation of the file with all the initialization of the classes
if(!is_file('admin/inc/class_initialize.php')){
    $file_handle = fopen('inc/class_initialize.php', 'w');
    fwrite($file_handle, '<?php');
    fwrite($file_handle, "\n");
    foreach ($files as $filename) {
        $nomefile = pathinfo($filename);
    $file=$nomefile['filename'];
    if($file!="PhpXlsxGenerator")
    {
        $file_var = strtolower($file);
        fwrite($file_handle, '$'.$file_var.' = new '.$file.'($db);');
        fwrite($file_handle, "\n");
    }
}
if($prefix){
    fwrite($file_handle,'$common->prx = "'.$prefix.'_";') ;
    fwrite($file_handle, "\n");
}
fwrite($file_handle,"?>");
chmod('admin/inc/class_initialize.php',0777);
}

include "admin/inc/class_initialize.php";

$setting->name = "debug" ;
$dbg = $setting->showAllWhere('id',['name']);
$row_debug = $dbg->fetch(PDO::FETCH_ASSOC);
extract($row_debug);

if($row_debug['value']==1){
	require 'admin/vendor/autoload.php';		// If installed via composer
	$debug = new \bdk\Debug(array(
		'collect' => true,
		'output' => true,
	));
}

$setting->name="lang" ;
$stmt = $setting->showByName();
$lang = $stmt['value'];

foreach (glob("locale/$lang/*.php") as $row){
    require "$row";
}

// echo "Err";
// exit;	
if (!isset($_SESSION['customer_loggedin'])) 
{
//   require 'admin/inc/customer_check_cookie.php';
  header('Location: login.php?err=noLogin');
  exit;
}
// else if (isset($_COOKIE['damares-customer-login']))
// {

//     $pieces = explode(",", $_COOKIE['damares-customer-login']);
//     $customer->id = $pieces[0];
//     $id = $pieces[0];
//     $customer->auth_token = $pieces[1];
//     if (!$customer->checkCookie() > 0) {
//       header("Location: login.php?err=noLogin");
//       exit;
//     }
    
//       // redirect tofix
//       // $plugin->pluginname = "role_redirect";

//       // if ($plugin->itemExists('pluginname') && $plugin->isActive() == 1) {
//       //   $stmt = $role->showAllWhere('id', ['id']);
//       //   foreach ($stmt as $row) {
//       //     if ($row['redirect'] != "none") {
//       //       header("Location: " . $row['redirect'] . "");
//       //       exit;
//       //     }
//       //   }
//       // }

//       // header("Location: index_xs.php");
//       // exit;
   
//   }


?>

<!DOCTYPE html>
	<html dir="ltr" lang="en-US">
	<head>
		<meta name="robots" content="noindex, nofollow">

		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="author" content="SemiColonWeb" />

		<!-- Stylesheets
			============================================= -->
			<meta http-equiv="content-type" content="text/html; charset=utf-8" />
			<meta name="author" content="davidemasera" />
			<!-- <link rel="icon" href="../assets/img/Xstream_Logo_Picto_Circ_Small.png" type="image/png"/> -->
			<link rel="icon" href="assets/img/Xstream_Logo_Picto_Circ_Small.png" type="image/png"/>

			<!-- Stylesheets
			============================================= -->
			<link href="https://fonts.googleapis.com/css?family=Cairo:300,400,400i,700|Cairo:300,400,500,600,700|PT+Serif:400,400i&display=swap" rel="stylesheet" type="text/css" />
			<!-- <link rel="stylesheet" href="../assets/css/bootstrap.css" type="text/css" />
			<link rel="stylesheet" href="../assets/style.css" type="text/css" />
			<link rel="stylesheet" href="../assets/css/swiper.css" type="text/css" />
			<link rel="stylesheet" href="../assets/css/dark.css" type="text/css" />
			<link rel="stylesheet" href="../assets/css/font-icons.css" type="text/css" />
			<link rel="stylesheet" href="../assets/css/animate.css" type="text/css" />
			<link rel="stylesheet" href="../assets/css/magnific-popup.css" type="text/css" />
			<link rel="stylesheet" href="../assets/css/custom.css" type="text/css" /> -->
            <link rel="stylesheet" href="assets/css/bootstrap.css" type="text/css" />
			<link rel="stylesheet" href="assets/style.css" type="text/css" />
			<link rel="stylesheet" href="assets/css/swiper.css" type="text/css" />
			<link rel="stylesheet" href="assets/css/dark.css" type="text/css" />
			<link rel="stylesheet" href="assets/css/font-icons.css" type="text/css" />
			<link rel="stylesheet" href="assets/css/animate.css" type="text/css" />
			<link rel="stylesheet" href="assets/css/magnific-popup.css" type="text/css" />
			<link rel="stylesheet" href="assets/css/custom.css" type="text/css" />
			<meta name="viewport" content="width=device-width, initial-scale=1" />


		<!-- Document Title
			============================================= -->
			<title><?=$cust_title?> - Xstream-Labs</title>

		</head>

		<body class="stretched">
<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<!-- Header
		============================================= -->
		<header id="header" class="header-size-md" data-sticky-shrink="false">
			<div id="header-wrap">
				<div class="container">
					<div class="header-row justify-content-between">

						<!-- Logo
						============================================= -->
						<div id="logo" class="me-lg-0">
                        <!-- <a href="../index.php" class="standard-logo"><img src="../assets/img/XStream_logo_horizontal.png" alt="Canvas Logo"></a>
							<a href="../index.php" class="retina-logo"><img src="../assets/img/XStream_logo_horizontal.png" alt="Canvas Logo"></a> -->
                            <a href="../index.php" class="standard-logo"><img src="assets/img/XStream_logo_horizontal.png" alt="Canvas Logo"></a>
							<a href="../index.php" class="retina-logo"><img src="assets/img/XStream_logo_horizontal.png" alt="Canvas Logo"></a>
						</div><!-- #logo end -->

						<div id="primary-menu-trigger">
							<svg class="svg-trigger" viewBox="0 0 100 100"><path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path><path d="m 30,50 h 40"></path><path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path></svg>
						</div>

						<!-- Primary Navigation
						============================================= -->
					

<nav class="primary-menu with-arrows">

<ul class="menu-container">
	<li class="menu-item">
			<?php
			$lang_folder="";
			if($lang!="it"){
				$lang_folder="$lang/";
			}
			?>
			<a href="../<?=$lang_folder?>index.php" class="button button-xlarge button-circle button-border button-xstream">
				<i class="icon-arrow-left2"></i><?=$cust_back?>
			</a>
	</li>

	<li class="menu-item">
		<a class="button button-xlarge button-circle button-border button-xstream" data-bs-toggle="modal" data-bs-target="#myModal">
		<b><i class="icon-line-log-out"></i></b>Logout
	</a>

	</li>

		


</ul>

</nav><!-- #primary-menu end -->


</div>
				</div>
			</div>
			<div class="header-wrap-clone"></div>
		</header><!-- #header end -->
	


		<section>
			<div class="content-wrap noPadding" id="azienda">
				<div class="container clearfix login">
							<img src="assets/img/XStream_Login_Cover.png" class="desktopVisual">	
							<img src="assets/img/XStream_Login_Cover.png" class="mobileVisual">
                            <!-- <img src="../assets/img/XStream_Login_Cover.png" class="desktopVisual">	
							<img src="../assets/img/XStream_Login_Cover.png" class="mobileVisual"> -->
			<div class="clear"></div>
				</div>
			</div>
		</section>				<!-- #header end -->
				<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myModalLabel"><?=$cust_modal_title?></h4>
											<button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
										</div>
										<div class="modal-body">
											
											<p><?=$cust_modal_text?></p>


										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$cust_modal_canc?></button>
											<button type="button" class="btn btn-primary"><a href="admin/core/customer_logout.php?lang=<?=$lang?>" class="modalOk">Ok</a></button>
										</div>
									</div>
								</div>
							</div>
			<!-- Content
				============================================= -->
		<section id="content" class="mb-5">
			<div class="container login clearfix p-5">
				<h1 class="text-center">Area Riservata Clienti</h1>
				<p class="my-5 text-center">
                    Benvenuto <strong> nome utente</strong><br>
                    Qui puoi scaricare aggiornamenti e documentazione dei tuoi prodotti.
                </p>

				<div class="row px-5 mb-3">
					<div class="col-12 text-center">
						<h1>Prodotti</h1>
					</div>
				</div>
				
					<div class="row mb-5 align-items-center px-5">
						<div class="col-12 border-bottom ">
							<div class="row py-3">
						
								<div class="col-12 col-md-3">
									<img src="assets/img/products/XStream_cStream_Box.png">
									<!-- <img src="../assets/img/products/XStream_<?=$prod->product?>_Box.png"> -->
								</div>
								<div class="col-12 col-md-9 ">

                                    <!-- TAB -->

									<div class="tabs side-tabs tabs-bordered clearfix" id="tab-8">

										<ul class="tab-nav clearfix">
											
											
											<li><a href="#cStream-1">OVA</i></a></li>

											
											<li><a href="#cStream-2">Fatpack</a></li>

											
										</ul>

                                        <!-- SCHEDE -->
										<div class="tab-container p-5">

										    <div class="tab-content clearfix" id="cStream-1">
												<b>OVA</b><br><br>

										
												<a href="file/download.php?user=<?=$name?>&type=ova&product=<?=$prod->product?>" class="button button-xlarge button-circle button-border button-xstream">
													<i class="icon-arrow-down2"></i>Download
												</a>
												<br>
													<br>
													<!-- <p>
														
														sha1: 
														<?php
														// $ova= "file/$prodFolder/ova/$file";
														// $sha1file=sha1_file($ova);
														// echo "<b>$sha1file</b>";
														?>
													</p> -->
													
											</div>
											
											<div class="tab-content clearfix" id="cStream-2">
												<b>Fatpack</b><br><br>

												<table class="table table-bordered w-100">
													<thead class="thead-light">
														<th>File</th>
														<th>Download</th>
													</thead>
													<tbody>
													
													<tr>
														<td>file name</td>
														<td>
															<a href="file/download.php?user=<?=$name?>&type=jar&product=<?=$prod->product?>&filename=<?=$nomefile['basename']?>" class="button button-small button-circle button-border button-xstream">
																<i class="icon-arrow-down2"></i>Download
															</a>
														</td>
													</tr>		

													</tbody>
												</table>												
											</div>

										

										</div>

									</div>


								</div>
	
								</div>
							</div>
							</div>

							<br>
		</div>
	</div>
	</div>
	
		</section>
	<!-- Footer
		============================================= -->
		<footer id="footer" class="grafite" data-scrollto-settings="{&quot;offset&quot;:100,&quot;speed&quot;:1250,&quot;easing&quot;:&quot;easeOutQuad&quot;}">
			<!-- Copyrights
			============================================= -->
			<div id="copyrights">
				<div class="container">
				<div class="row">
						<div class="col-12 col-md-6 mb-3">
							<div class="col-12 col-lg-auto text-center text-lg-left order-last order-lg-first">
								<!-- <img src="../assets/img/XStream_logo_horizontal.png" alt="XStream Labs Logo" class="mb-2"><br> -->
								<img src="assets/img/XStream_logo_horizontal.png" alt="XStream Labs Logo" class="mb-2"><br>
								Copyright 2018 - <?php echo date('Y');?> © XStream Labs
							</div>
						</div>

						<div class="col-6 col-md-3">
							<div>
								<address>
									<strong>Indirizzo</strong><br>
									XStream S.r.l.<br>
									Corso Svizzera, 185<br>
									10149 Torino<br>
								</address>
								<div class="pointer" data-toggle="modal" data-target=".bs-privacy-modal-scrollable">Privacy Policy</div>
							</div>
						</div>

						<div class="col-6 col-md-3">
							<strong>Telefono</strong>
							+39 011 0168800<br>
							<strong>Email</strong>
							company@xstream-labs.com<br>
							<strong>VAT</strong>
							11975670016
							<div class="widget clearfix">
								<a href="https://it.linkedin.com/company/xstream-labs" target="_blank" class="social-icon si-small si-rounded si-linkedin">
									<i class="icon-linkedin"></i>
									<i class="icon-linkedin"></i>
								</a>
								&nbsp; &nbsp;
								<a href="https://twitter.com/Xstream_Labs" target="_blank" class="social-icon si-small si-rounded si-twitter">
									<i class="icon-twitter"></i>
									<i class="icon-twitter"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div><!-- #copyrights end -->
		</footer>

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- JavaScripts
	============================================= -->
    <script src="js/jquery.js"></script>
	<script src="js/plugins.min.js"></script>
	<script src="js/cookiealert.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/TypewriterJS/2.18.0/core.min.js"></script>
	<script src="js/typewriter.js"></script>
	<!-- <script src="../js/jquery.js"></script>
	<script src="../js/plugins.min.js"></script>
	<script src="../js/cookiealert.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/TypewriterJS/2.18.0/core.min.js"></script>
	<script src="../js/typewriter.js"></script> -->

	<!-- Footer Scripts
	============================================= -->
	<script src="js/functions.js"></script>
	<!-- <script src="../js/functions.js"></script> -->


</body>
</html>
