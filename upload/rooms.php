<?php
require_once('manager/connect.php');
$currency = "$";
?>
<!DOCTYPE html>
<html>
	<head>

		<meta charset="utf-8">
		<title>Room Booking</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

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
 
		<script src="/js/jquery.js"></script>
		<script src="/js/bootstrap.min.js"></script>
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
		
		
		
  
echo '
<table width="100%" id="newspaper-b">
    <thead>
    	<tr>
        	<th scope="col"></th>
        	<th scope="col"><b>Room Number</b></th>
            <th scope="col"><b>Features</b></th>
            <th scope="col"><b>Additional Information</b></th>
            <th scope="col"><b>Images</b></th>
            <th scope="col"><b>Price</b></th>
            <th scope="col"></th>
        </tr>
    </thead>';

    echo '
    <tbody>
    	';
 while($row = $stmt->fetch(PDO::FETCH_BOTH)) 
 { 
echo '
    	<tr onclick="document.getElementById(\'checkbox_'.$cnt.'\').checked = !document.getElementById(\'checkbox_'.$cnt.'\').checked; ">
        <td><input class="checkbox_row"id="checkbox_'.$cnt.'" value="'. $row['r_number'] .'" type="checkbox" /></td>
    	<td id="row_' . $cnt . '">'. $row['r_number']. '</td>';
    	echo '<td>'. $row['r_contents']. '</td>';
		if ($row['r_additional_text'] != "")
		{
    	echo '<td>'. $row['r_additional_text']. '</td>';
    	}
else
{
    	echo '<td>'. '-'. '</td>';
}
echo '<td>';
if (file_exists('images/'.$row['r_number']))
{
if ($handle = opendir('images/'.$row['r_number'] )) {

echo '<a href="explore.php?id='. $row['r_number'].'">See images</a>';

}}else
{
echo '-';
}
echo '</td>';
echo '<td>'. $currency. $row['price']. ' every 24 hours</td>';
    	
		echo '<td><form action="book.php" method="get"><br> <input type="hidden" name="roomnumber" value="'.$row['r_number'].'"> <input type="submit" value="Book this room" class="btn btn-primary"></input></form>

</tr>
     
  ';

$cnt = $cnt + 1;
}
if ($cnt ==0)
{
echo 'There are no rooms available to book at the moment.';
}
echo '  </tbody>
</table>';
 ?> 
 <br> 
  <div id="errors"></div>
      <input onclick="window.location.href ='/';" style="margin-left: 5px;"type="button" class="pull-right btn" value="Back to homepage"><input id="book_selected"onclick="bookSelected();" type="button" class="btn btn-primary pull-right" value="Book selected">
	 
<br>
    
    
	</div>
	<script type="text/javascript">
	function bookSelected()
	{
var rooms = "";
var array = document.getElementsByClassName('checkbox_row');
for (index = 0; index < array.length; index++) {
if (array[index].checked)
    rooms += array[index].value + ";";
}
if (rooms != ""){
window.location.href= "book.php?roomnumber=" + rooms;
}else {
document.getElementById("errors").innerHTML = "<div class='alert alert-danger'>There were no rooms selected.</div>";
}

	}
	</script>
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
