<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Beadandó</title>
<meta name="description" content="">
<meta name="author" content="">

<!-- Favicons
    ================================================== -->
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
<link rel="apple-touch-icon" href="img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">

<!-- Bootstrap -->
<link rel="stylesheet" type="text/css"  href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">

<!-- Stylesheet
    ================================================== -->
<link rel="stylesheet" type="text/css"  href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/nivo-lightbox/nivo-lightbox.css">
<link rel="stylesheet" type="text/css" href="css/nivo-lightbox/default.css">
<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Dancing+Script:400,700" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<!-- Navigation
    ==========================================-->
<nav id="menu" class="navbar navbar-default navbar-fixed-top">
  <div class="container"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand page-scroll" href="#page-top">Touché</a> </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#about" class="page-scroll">Bemutatkozás</a></li>
        <li><a href="#restaurant-menu" class="page-scroll">Menü</a></li>
        <li><a href="#portfolio" class="page-scroll">Galléria</a></li>
        <li><a href="#team" class="page-scroll">Séfeink</a></li>
        <li><a href="#call-reservation" class="page-scroll">Kapcsolat</a></li>
		<li><a href="#reservation" class="page-scroll">Foglalás</a></li>	
      </ul>
    </div>
    <!-- /.navbar-collapse --> 
  </div>
</nav>
<?php

require_once("vbeni_functions.php");
session_start();
$connect=dbconnect();

if(!isset($_COOKIE['visitor']))
{
	$sql='SELECT * FROM visitors' ;
	$query=pg_query($connect,$sql);
	if(pg_numrows($query) !=0)
	{
		$sql='SELECT max(id) FROM visitors';
		$query=pg_query($connect,$sql);
		$new=pg_fetch_all($query);
		$snum=$new[0]["max"]+1;
		setcookie('visitor', 'visitor_'.$snum, time() + (86400*14));
	}
	else
	{
		$new=1;
		setcookie('visitor', 'visitor_'.$new, time() + (86400*14));
	}
	
}
else
{
	$sql='SELECT * FROM visitors WHERE name=\''.$_COOKIE['visitor'].'\'';
	$query=pg_query($connect,$sql);
	if(pg_numrows($query)===0)
	{
		$sql='INSERT INTO visitors (name, visited) values(\''.$_COOKIE['visitor'].'\',\'1\')';
		pg_query($connect,$sql);
	}
	else
	{
		$sql='UPDATE visitors SET visited=visited+1 WHERE name=\''.$_COOKIE["visitor"].'\'';
		pg_query($connect,$sql);
	}
}


?>
<!-- Header -->
<header id="header">
  <div class="intro">
    <div class="overlay">
      <div class="container">
        <div class="row">
          <div class="intro-text">
            <h1>Touché</h1>
            <p>Restaurant / Coffee / Pub</p>
            <a href="#about" class="btn btn-custom btn-lg page-scroll">Rólunk</a> </div>
        </div>
      </div>
    </div>
  </div>
</header>
<!-- About Section -->
<div id="about">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-6 ">
        <div class="about-img"><img src="img/about.jpg" class="img-responsive" alt=""></div>
      </div>
      <div class="col-xs-12 col-md-6">
        <div class="about-text">
          <h2>Éttermünkről</h2>
          <hr>
          <p>Éttermünk 1992 óta biztosít minőségi, és kielégítő éttermi szolgáltatást minden hozzánk látogató vendégünk számára. Nálunk minden étel különös odafigyeléssel, és precízióval készül.</p>
          <h3>Díjnyertes Séfeink</h3>
          <p>FŐszakácsunk, Laci pályafutása alatt számos díjat nyert, többek között a 13. országos szakácsversenyen nyerte el első helyezést, és több gasztrónómiai lap szerint is egyedi ízvilágot tud varázsolni a legátlagosabb ételekhez is.</p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Restaurant Menu Section -->
<div id="restaurant-menu">
  <div class="section-title text-center center">
    <div class="overlay">
      <h2>Menü</h2>
      <hr>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <h2 class="menu-section-title">Heti menü</h2> 
	  <?php
	 
		require_once("vbeni_functions.php");
		$connect=dbconnect();
		//mai menü
		$sql='SELECT * FROM menu WHERE current_date=date';
		$query=pg_query($connect,$sql);
		$result=pg_fetch_all($query);		
		if ($result!==false)
		{
			foreach ($result as $record)
			{
				
				print'
				<div class="menu-item">		
				<h3>Mai menü</h3>
				<div class="menu-item-name">'.$record['date'].'</div>
				<div class="menu-item-name">'.$record['name'].'</div>
				<div class="menu-item-price">'.$record['price'].'</div>
				<div class="menu-item-description">'.$record['description'].'</div>
				</div>';
				
			
			}
		}
		
		//összes menü
		$sql='SELECT * FROM menu';
		$query=pg_query($connect,$sql);
		$result=pg_fetch_all($query);		
		if ($result!==false)
		{
			foreach ($result as $record)
			{
				
				print'
				<div class="menu-item">				
				<div class="menu-item-name">'.$record['date'].'</div>
				<div class="menu-item-name">'.$record['name'].'</div>
				<div class="menu-item-price">'.$record['price'].'</div>
				<div class="menu-item-description">'.$record['description'].'</div>
				</div>';
				
			
			}
		}
	  
	  
	  ?>
      <div class="col-xs-12 col-sm-6">
        <div class="menu-section">
          <h2 class="menu-section-title">Főételek</h2>
          <hr>
          <div class="menu-item">
            <div class="menu-item-name"> Párizsi csirkemell filé </div>
            <div class="menu-item-price"> 1200ft </div>
            <div class="menu-item-description"> Chicken breast Paris style </div>
          </div>
          <div class="menu-item">
            <div class="menu-item-name"> Rántott csirkemell filé </div>
            <div class="menu-item-price"> 1050ft </div>
            <div class="menu-item-description"> Coated chicken breast fillet </div>
          </div>
          <div class="menu-item">
            <div class="menu-item-name"> Tengeri halfilé fűszervajjal, cézár salátával </div>
            <div class="menu-item-price"> 1300ft </div>
            <div class="menu-item-description"> Mullet fillet with flavoured butter and caesar salad </div>
          </div>
          <div class="menu-item">
            <div class="menu-item-name"> Rántott sertéskaraj </div>
            <div class="menu-item-price"> 1260ft </div>
            <div class="menu-item-description"> Coated pork chop </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-6">
        <div class="menu-section">
          <h2 class="menu-section-title">Pizzák</h2>
          <hr>
          <div class="menu-item">
            <div class="menu-item-name"> California </div>
            <div class="menu-item-price"> 1400ft </div>
            <div class="menu-item-description"> (szósz, hagyma, paprikás szalámi, sonka, kukorica, paprika, sajt)
(sauce, onion, salami, ham, corn, pepper, cheese) </div>
          </div>
          <div class="menu-item">
            <div class="menu-item-name"> Bud Spencer </div>
            <div class="menu-item-price"> 1350ft </div>
            <div class="menu-item-description"> (szósz, sonka, bab, szalonna, tojás, füstölt sajt)
(sauce, ham, bean, bacon, egg, smoked cheese) </div>
          </div>
          <div class="menu-item">
            <div class="menu-item-name"> Csizmás Kandúr </div>
            <div class="menu-item-price"> 1500ft </div>
            <div class="menu-item-description"> (bolognai ragu, sajt)
(bolognaise ragout, cheese) </div>
          </div>
          <div class="menu-item">
            <div class="menu-item-name"> Magyaros</div>
            <div class="menu-item-price"> 1450ft </div>
            <div class="menu-item-description"> (szósz, kolbász, szalonna, hagyma, pfefferoni, sajt)
(sauce, sausage, bacon, onion, pfefferoni, cheese) </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6">
        <div class="menu-section">
          <h2 class="menu-section-title">Italok</h2>
          <hr>
          <div class="menu-item">
            <div class="menu-item-name"> Lipton Ice Tea (üveges - 0,2 l) </div>
            <div class="menu-item-price"> 300ft </div>
          </div>
          <div class="menu-item">
            <div class="menu-item-name"> Espresso kávé </div>
            <div class="menu-item-price"> 320ft </div>
          </div>
          <div class="menu-item">
            <div class="menu-item-name"> Hosszúkávé </div>
            <div class="menu-item-price"> 300ft </div>           
          </div>
          <div class="menu-item">
            <div class="menu-item-name"> Pepsi Light </div>
            <div class="menu-item-price"> 450ft </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Portfolio Section -->
<div id="portfolio">
  <div class="section-title text-center center">
    <div class="overlay">
      <h2>Galléria</h2>
      <hr>
      <p>Tekintse meg séfeink által készített ételkülönlegességeket</p>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="categories">
        <ul class="cat">
          <li>
            <ol class="type">
              <li><a href="#" data-filter="*" class="active">Minden</a></li>
              <li><a href="#" data-filter=".breakfast">Reggeli</a></li>
              <li><a href="#" data-filter=".lunch">Ebéd</a></li>
              <li><a href="#" data-filter=".dinner">Vacsora</a></li>
            </ol>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
    </div>
    <div class="row">
      <div class="portfolio-items">
        <div class="col-sm-6 col-md-4 col-lg-4 breakfast">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="img/portfolio/01-large.jpg" title="Dish Name" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4>Tengeri halfilé fűszervajjal, cézár salátával</h4>
              </div>
              <img src="img/portfolio/01-small.jpg" class="img-responsive" alt="Project Title"> </a> </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-4 dinner">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="img/portfolio/02-large.jpg" title="Dish Name" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4> Rántott sertéskaraj</h4>
              </div>
              <img src="img/portfolio/02-small.jpg" class="img-responsive" alt="Project Title"> </a> </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-4 breakfast">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="img/portfolio/03-large.jpg" title="Dish Name" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4>Párizsi csirkemell filé</h4>
              </div>
              <img src="img/portfolio/03-small.jpg" class="img-responsive" alt="Project Title"> </a> </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-4 breakfast">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="img/portfolio/04-large.jpg" title="Dish Name" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4>Tárkonyos csirkeraguleves</h4>
              </div>
              <img src="img/portfolio/04-small.jpg" class="img-responsive" alt="Project Title"> </a> </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-4 dinner">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="img/portfolio/05-large.jpg" title="Dish Name" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4>Grillezett marhacomb</h4>
              </div>
              <img src="img/portfolio/05-small.jpg" class="img-responsive" alt="Project Title"> </a> </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-4 lunch">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="img/portfolio/06-large.jpg" title="Dish Name" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4>Sertéskaraj sajttal, tejföllel</h4>
              </div>
              <img src="img/portfolio/06-small.jpg" class="img-responsive" alt="Project Title"> </a> </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-4 lunch">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="img/portfolio/07-large.jpg" title="Dish Name" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4>Grillezett csirkemellfilé</h4>
              </div>
              <img src="img/portfolio/07-small.jpg" class="img-responsive" alt="Project Title"> </a> </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-4 breakfast">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="img/portfolio/08-large.jpg" title="Dish Name" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4>Saláta csirkemell filével</h4>
              </div>
              <img src="img/portfolio/08-small.jpg" class="img-responsive" alt="Project Title"> </a> </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-4 dinner">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="img/portfolio/09-large.jpg" title="Dish Name" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4>Magyaros pizza </h4>
              </div>
              <img src="img/portfolio/09-small.jpg" class="img-responsive" alt="Project Title"> </a> </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-4 lunch">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="img/portfolio/10-large.jpg" title="Dish Name" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4>Paradicsomos tészta</h4>
              </div>
              <img src="img/portfolio/10-small.jpg" class="img-responsive" alt="Project Title"> </a> </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-4 lunch">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="img/portfolio/11-large.jpg" title="Dish Name" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4>Bolognai spaghetti</h4>
              </div>
              <img src="img/portfolio/11-small.jpg" class="img-responsive" alt="Project Title"> </a> </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-4 breakfast">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="img/portfolio/12-large.jpg" title="Dish Name" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4>Marha steak</h4>
              </div>
              <img src="img/portfolio/12-small.jpg" class="img-responsive" alt="Project Title"> </a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Team Section -->
<div id="team" class="text-center">
  <div class="overlay">
    <div class="container">
      <div class="col-md-10 col-md-offset-1 section-title">
        <h2>Ismerkedjen meg szakácsainkkal</h2>
        <hr>
        <p>Szakácsaink küldetése, hogy ön mindig a lehető legjobb minőségű ételt tudja nálunk fogyasztani.</p>
      </div>
      <div id="row">
        <div class="col-md-4 team">
          <div class="thumbnail">
            <div class="team-img"><img src="img/team/01.jpg" alt="..."></div>
            <div class="caption">
              <h3>Magyar Miklós</h3>
              <p>Egész életében a főzés volt a szenvedélye, nyugdíjas éveinek ellenére még mindig nálunk dolgozik.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 team">
          <div class="thumbnail">
            <div class="team-img"><img src="img/team/02.jpg" alt="..."></div>
            <div class="caption">
              <h3>Kerekes Krisztián</h3>
              <p>Annak ellenére hogy fiatal és kezdő már több nemzetközi megmérettetésen is részt vett, inkább több mint kevesebb sikerrel.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 team">
          <div class="thumbnail">
            <div class="team-img"><img src="img/team/03.jpg" alt="..."></div>
            <div class="caption">
              <h3>Lakatos László</h3>
              <p>SZakácsaink legsikeresebbike, Jelenleg főszakácsi pozíciót tölt be.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--asztal foglalás -->
<div class="overlay"></div>
		<div class="gtco-container">
			<div class="row">
				<div class="col-md-12 col-md-offset-0 text-left">
					<div name="reservation" class="row row-mt-15em">
						<div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
							<h1 class="cursive-font">
							Foglaljon asztalt nálunk!						</h1>	
						</div>
						<div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
							<div class="form-wrap">
								<div class="tab">
									
									<div class="tab-content">
										<div class="tab-content-inner active" data-content="signup">
											<h3 class="cursive-font">Asztalfoglalás</h3>
											<form action="vbeni_reservation.php" method="post" name="reserveform">
												<div class="row form-group">
													<div class="col-md-12"> 
														<label for="activities">Név</label>
														<input type="text" id="name" name= "name" class="form-control">
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12"> 
														<label for="activities">E-mail</label>
														<input type="text" id="email" name= "email" class="form-control">
													</div>
												</div>														
												<div class="row form-group">
													<div class="col-md-12">
														<label for="activities">Személyek</label>
														<select name="people" id="activities" >
															<option value="1">1</option>
															<option value="2">2</option>
															<option value="3">3</option>
															<option value="4">4</option>
															<option value="5">5</option>
															<option value="6">6</option>
															<option value="7">7</option>
															<option value="8">8</option>
															<option value="9">9</option>
														</select>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<label for="date-start">Dátum</label>
														<input type="date" name="date" class="form-control" >
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<label for="date-start">Idő</label>
														<input type="time" name= "time" class="form-control">
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
													<input name="resoke" type="submit" class="btn btn-primary btn-block" id="submit" value="Foglalás">	
													</div>
												</div>
											</form>	
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<!--asztal foglalás -->
<!-- Call Reservation Section -->
<div id="call-reservation" class="text-center">
  <div class="container">
    <h2>Érdeklődéshez kérjük keresse vel a következő számot <strong>06-887-654-3210</strong></h2>
  </div>
</div>
<!--map-->
	
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1383.8498733460915!2d18.211216268980333!3d46.0770277965149!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4742b195e942b073%3A0x341f4f792a59af20!2sP%C3%A9cs%2C+Tavasz+u.+2-10%2C+7624!5e0!3m2!1shu!2shu!4v1543587584918"
 width="600" height="450" frameborder="0"  style="border:0" allowfullscreen></iframe>
	<!--map-->
<!-- Contact Section -->
<div id="contact" class="text-center">
  <div class="container">
    <div class="section-title text-center">
	
      <h2>Feliratkozás hírlevlére</h2>
      <hr>
      <p>Értesüljön elsőként az újdonságokról.</p>
    </div>
	<div class="row animate-box"></div>
			<div class="row animate-box">
				<div class="col-md-8 col-md-offset-2">
					
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
							<form action="subscribe.php" method="post">
								
								<input type="email" class="email" name= "email" placeholder="Add meg az emailed">
								<input name="regbarmi" type="submit" class="btn btn-primary btn-block" id="submit" value="Foglalás">	
								</form>
							</div>
						</div>
						
					
				</div>
		</div>
  </div>
</div>
<div id="footer">
  <div class="container text-center">
    <div class="col-md-4">
      <h3>Cím</h3>
      <div class="contact-item">
        <p>4321 California St,</p>
        <p>San Francisco, CA 12345</p>
      </div>
    </div>
    <div class="col-md-4">
      <h3>Nyitvatartás</h3>
      <div class="contact-item">
        <p>Hétfő-Csütörtök: 10:00 - 22:00</p>
        <p>Péntek- Vasárnap: 11:00 - 02:00</p>
      </div>
    </div>
    <div class="col-md-4">
      <h3>Kapcsolat:</h3>
      <div class="contact-item">
        <p>Phone: +1 123 456 1234</p>
        <p>Email: info@company.com</p>
      </div>
    </div>
  </div>
  <div class="container-fluid text-center copyrights">
    <div class="col-md-8 col-md-offset-2">
      <div class="social">
        <ul>
          <li><a href="#"><i class="fa fa-facebook"></i></a></li>
          <li><a href="#"><i class="fa fa-twitter"></i></a></li>
          <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
        </ul>
      </div>
      <p>&copy; 2016 Touché. All rights reserved. Designed by <a href="http://www.templatewire.com" rel="nofollow">TemplateWire</a></p>
    </div>
  </div>
</div>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>
<script>
window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#000"
    },
    "button": {
      "background": "#f1d600"
    }
  }
})});
</script>
<!--
<script type="text/javascript" src="js/jquery.1.11.1.js"></script> 
<script type="text/javascript" src="js/bootstrap.js"></script> 
<script type="text/javascript" src="js/SmoothScroll.js"></script> 
<script type="text/javascript" src="js/nivo-lightbox.js"></script> 
<script type="text/javascript" src="js/jquery.isotope.js"></script> 
<script type="text/javascript" src="js/jqBootstrapValidation.js"></script> 
<script type="text/javascript" src="js/contact_me.js"></script> 
<script type="text/javascript" src="js/main.js"></script>
*/</body>-->
</html>
