<?php
require_once('manager/connect.php');
?>
<!DOCTYPE html>
<html>
	<head>

		<meta charset="utf-8">
		<title>Room Booking</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

  <!-- SlidesJS Required (if responsive): Sets the page width to the device width. -->
  <meta name="viewport" content="width=device-width">
  <!-- End SlidesJS Required -->

		<!-- Le styles -->
		<link href="css/bootstrap.css" rel="stylesheet">
		<style type="text/css">
		
<!--
@import url("css/style.css");
-->
</style>
		<style type="text/css">
			body {
			margin-left: 15px;
			margin-right: 15px;
			}
			.sidebar-nav {
				padding: 9px 0;
			}

			@media (max-width: 980px) {
				/* Enable use of floated navbar text */
				.navbar-text.pull-right {
					float: none;
					padding-left: 5px;
					padding-right: 5px;
				}
			}
			a {
				color: RoyalBlue;
				-webkit-transition: all 0.3s linear;
				-moz-transition: all 0.3s linear;
			}
			a:hover {
				color: Blue;
			}
			.copyright-text {
				color: #f3f3f3;
			}
			html, body {
		remove this comment to position the footer at the bottom of the page
			height: 100%;
			
			}

			#main {
				overflow: auto;
				padding-bottom: 50px;
			}/* must be same height as the footer */

			#footer {
				position: relative;
				margin-top: -50px; /* negative value of footer height */
				padding: 10px 5px 5px 5px;
				height: 50px;
				clear: both;
			}
			#wrap {
			<!--		remove this comment to position the footer at the bottom
			
				min-height: 100%;
		-->	}

			/*Opera Fix*/
			body:before {
				content: "";
				height: 100%;
				float: left;
				width: 0;
				margin-top: -32767px;/
			}
		</style>
		  <script src="/js/placeholder.js"></script>
 
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
	</head>
	
  
  <body>

  	<div id="wrap">
			<div id="header">
<td valign="center">
    <h3>Room Booking</h3>


  <h4> Available Rooms</h4>


 <?php 
$query = " 
            SELECT 
                * 
            FROM rooms WHERE status LIKE 'available'
        "; 
         
        // This contains the definitions for any special tokens that we place in 
        // our SQL query.  In this case, we are defining a value for the token 
        // :username.  It is possible to insert $_POST['username'] directly into 
        // your $query string; however doing so is very insecure and opens your 
        // code up to SQL injection exploits.  Using tokens prevents this. 
        // For more information on SQL injections, see Wikipedia: 
        // http://en.wikipedia.org/wiki/SQL_Injection
            
        try 
        { 
            // These two statements run the query against your database table. 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute(); 
        } 
        catch(PDOException $ex) {
        } 
        
        $cnt = 0;
		echo 'Select a room to observe:<br> <form method="GET">';
		echo '<select name="id" id="rooms">';
		
  while($row = $stmt->fetch(PDO::FETCH_BOTH)) 
 {if (!empty($_GET['id']) && $_GET['id'] == $row['r_number'])
		{
echo '<option value="'.$row['r_number'].'" selected>'.$row['r_number']. '</option>' ;
}else 
{
echo '<option value="'.$row['r_number'].'">'.$row['r_number']. '</option>' ;

} }
		echo '</select>';
echo '<br><input type="submit" style="margin-left: 5px;" class="btn" value="View" /></form>';

if (!empty($_GET['id'])){
$cnt =0;
if (file_exists('images/'.$_GET['id']))
{
$dir = "images/" .$_GET['id'];
?> 
	<div id="gallery" class="carousel slide">
  <ol class="carousel-indicators">

<?php
$a = scandir($dir);
foreach ($a as $entry)
{
	if ($entry != "." && $entry != ".." && $entry != "...")
	{
        ?> 
	<?php if($cnt ==0){?>
    <li data-target="#gallery" data-slide-to="<?php echo $cnt; ?>" class="active"><?php }
	else
	{
	?><li data-target="#gallery" data-slide-to="<?php echo $cnt; ?>">
	<?php
	}?>
</li>
	<?php	
	
	
    
	$cnt = $cnt + 1;
	}
}
?>
  </ol>
 <!-- Carousel items -->
  <div class="carousel-inner">
   
<?php 
$cnt =0;
foreach ($a as $entry)
{
if ($entry != "." && $entry != ".." && $entry != "...")
	{
if($cnt == 0) { echo'  <div class="active item"><img src="images/'.$_GET['id'].'/'. $entry.'"></div>'; } else { echo '<div class="item"><img src="images/'.$_GET['id'].'/'. $entry.'"></div>';} 
	$cnt = $cnt + 1;
    }
}
?>




 <?php
if ($cnt ==0)
{
echo 'This room number has no images.';

}else{?>
  </div>
  <!-- Carousel nav -->
  <a class="carousel-control left" href="#gallery" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#gallery" data-slide="next">&rsaquo;</a>
</div>

<?php
}

}else
{
echo 'This room number has no images.';
}

}
 ?> 
 <br> 
  <div id="errors"></div>
     <form method="GET" action="book.php">
	 <input type="hidden" name="roomnumber" value="<?php echo $_GET['id']?>"><input type="submit" style="margin-left: 5px;"value="Book this room" class="pull-right btn btn-primary"></input> <input onclick="window.location.href ='rooms.php';" style="margin-left: 5px;"type="button" class="pull-right btn" value="Back to rooms"></form>
	 
<br>
    
    
	</div>
	</div>
	<hr>
	<footer>
		<p class="pull-right"></p>
		<p class="pull-left" style=" font-size: 13px;">
			&copy; 2014 Company name. All rights reserved &nbsp;
		</p>
	</footer>


  </body>
</html>
