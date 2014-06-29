<?php
require('manager/connect.php');
$currency = "$";
$rooms = "";
if (!isset($_GET['roomnumber']) || empty($_GET['roomnumber']))
{

header("Location: rooms.php");
}
$info = "";

if (!empty($_POST))
{
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	$_POST['email'] = "invalid";
}
if ($_POST['email'] != "invalid")
{
if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['telephone']))
{
if (!empty($_POST['duration']) && is_numeric($_POST['duration'])){
if ($_POST['duration'] != "0")
{
if (isset($_POST['rooms']) && !empty($_POST['rooms']))
{
$rooms = $_POST['rooms'];
}
	if (isset($rooms) && !empty($rooms) && strpos($rooms, ';') !== FALSE)
	{	

 foreach (explode(";", $rooms) as $val) {
 if ($val != "")
 {
	
$query = " 
            SELECT 
                * 
            FROM requests WHERE email=:email AND room_number=:room
        "; 
         
         
        $query_params = array( 
            ':email' => $_POST['email'],
            ':room' => $val
			
            
        ); 
        try 
        { 
            // These two statements run the query against your database table. 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        $rowcnt = $stmt->rowCount();
		} 
        catch(PDOException $ex) {
        } 
        if ($rowcnt > 0)
		{
		$info="<div class='alert alert-danger'>This email address has already requested these rooms before.</div>";
		}else{
  $query = " 
            INSERT INTO requests ( 
                room_number, 
                requested_by, 
                email, 
                telephone,
				comments,
				duration
            ) VALUES ( 
                :roomnumber, 
                :name, 
                :email, 
                :telephone,
				:comments,
				:duration
            ) 
        "; 
         
        $query_params = array( 
            ':roomnumber' => $val,
			':name' => $_POST['name'],
            ':email' => $_POST['email'],
            ':telephone' => $_POST['telephone'],
            ':comments' => $_POST['comments'],
            ':duration' => $_POST['duration']
			
            
        ); 
         
      try{
            // Execute the query to create the user 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
			$info = "<div class='alert alert-info'>We have received your request. Thanks!</div>";
      }catch(PDOException $ex){
	  $info = "<div class='alert alert-danger'>An error occured. Please try again later: " . $ex . "</div>";}

 }}}
	}else{
	
$query = " 
            SELECT 
                * 
            FROM requests WHERE email=:email AND room_number=:room
        "; 
         
         
        $query_params = array( 
            ':email' => $_POST['email'],
            ':room' => $rooms
			
            
        ); 
        try 
        { 
            // These two statements run the query against your database table. 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        $rowcnt = $stmt->rowCount();
		} 
        catch(PDOException $ex) {
        } 
        if ($rowcnt > 0)
		{
		$info="This email address has already requested the same room.";
		}else{
    $query = " 
            INSERT INTO requests ( 
                room_number, 
                requested_by, 
                email, 
                telephone,
				comments,
				duration
            ) VALUES ( 
                :roomnumber, 
                :name, 
                :email, 
                :telephone,
				:comments,
				:duration
            ) 
        "; 
         
        $query_params = array( 
            ':roomnumber' => $rooms,
			':name' => $_POST['name'],
            ':email' => $_POST['email'],
            ':telephone' => $_POST['telephone'],
            ':comments' => $_POST['comments'],
            ':duration' => $_POST['duration']
			
            
        ); 
         
      try{
            // Execute the query to create the user 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
			$info = "<div class='alert alert-info'>We have received your request. Thanks!</div>";
      }catch(PDOException $ex){
	  $info = "<div class='alert alert-danger'>An error occured. Please try again later: " . $ex . "</div>";}


}
}
}else
{

  $info = "<div class='alert alert-danger'>Please enter a valid amount of hours to stay.</div>";
}}else
{

  $info = "<div class='alert alert-danger'>Please enter a valid amount of hours to stay.</div>";
}}
else
{
  $info = "<div class='alert alert-danger'>Some required fields were left blank.</div>";
}
}
else
{
    $info = "<div class='alert alert-danger'>The email address submitted is not valid.</div>";
}
}?>
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
			<!--		remove this comment to position the footer at the bottom of the page
			
				min-height: 100%;
				-->
			}

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
		
	
	if (strpos($_GET['roomnumber'], ';') !== FALSE)
	{	
	
	echo 'You are about to book the following rooms:';
 echo '<table width="100%" id="newspaper-b">
    <thead>
    	<tr>
        	<th scope="col"><b>Room Number</b></th>
            <th scope="col"><b>Features</b></th>
            <th scope="col"><b>Additional Information</b></th>
            <th scope="col"><b>Images</b></th>
            <th scope="col"><b>Price</b></th>
        </tr>
    </thead>';

    echo '
    <tbody>
    	<tr>
    	';
	$price =0;
 while($row = $stmt->fetch(PDO::FETCH_BOTH)) 
 { 
 
 foreach (explode(";", $_GET['roomnumber']) as $val) {
 if ($val == $row['r_number'])
 {
 
 echo "<td>" .$row[0] . "</td>";
 echo "<td>" .$row[1] . "</td>";
 if (isset($row[2]) && !empty($row[2]))
 {
 echo "<td>" . $row[2] . "</td>";
 }else
 {
 echo "<td>-</td>";
 }
 $rooms .= $val . ";";
 
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
    	echo '</tr>';
 $price = $row['price'] + $price;
 
 }
 }
 
	}
	
echo '
 </tbody>
</table>';
 echo '<br><br>';
 echo '<legend> Contact details </legend>';
 echo '<form method="post">';
 echo 'Full name* :<br> <input type="text" placeholder="Full name" name="name"/><br>';
 echo 'E-mail* :<br> <input type="email" placeholder="E-mail" name="email" /><br>';
 echo 'Telephone (international format)* :<br> <input type="text" placeholder="Telephone" name="telephone" /><br>';
 echo 'Comments (optional):<br> <textarea type="text" placeholder="Comments" name="comments"></textarea><br>';
 
 
 
  echo '<legend> Payment </legend>';
 echo 'How long are you going to stay?<br>';
?><select id="duration_select" onchange="document.getElementById('duration').value = this.value; getPrice();">
    <option value="24">1 day</option>
    <option value="72">3 days</option>
    <option value="168">7 days</option>
	<option value="720">30 days</option>
</select>
<input id="duration" onchange="getPrice();"onpaste="getPrice();" oninput="getPrice();" onkeypress="return isNumberKey(event);" type="text"value="24" name="duration"> hours

<?php

 echo '<p id="total">Total: ' . $currency . $price . ' for 24 hours</p>';
 ?>
 <script type="text/javascript">
 function getPrice()
 {
 
		var price = <?php echo $price?>;
		var hours = document.getElementById('duration').value;
		document.getElementById('total').innerText = 'Total: <?php echo$currency;?>'+ (price * (hours/ 24)) +' for '+ hours +' hours';
 }
	function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        {return false;}
		getPrice();
    return true;
}</script>
<?php
 
 
 
 
 
 
 
 
 
 
 
 
 
echo '<input type="hidden" value="' .$rooms.'" name="rooms"></input>';

 echo '<input type="submit" class="btn btn-primary" value="Submit application" /><input onclick="window.location.href =\'rooms.php\';" style="margin-left: 5px"type="button" class="btn" value="See available rooms">';




if (!empty($info))
echo '<br><br>' . $info;

 echo '</form>';
	}
	else{
	
 while($row = $stmt->fetch(PDO::FETCH_BOTH)) 
 { 
 if ($row['r_number'] == $_GET['roomnumber'])
 {
 echo 'You are about to book the following room:';
 echo '<table width="100%" id="newspaper-b">
    <thead>
    	<tr>
        	<th scope="col"><b>Room Number</b></th>
            <th scope="col"><b>Features</b></th>
            <th scope="col"><b>Additional Information</b></th>
            <th scope="col"><b>Images</b></th>
            <th scope="col"><b>Price</b></th>
        </tr>
    </thead>';

    echo '
    <tbody>
    	<tr>
    	';
 echo "<td>" .$row[0] . "</td>";
 echo "<td>" .$row[1] . "</td>";
 if (isset($row[2]) && !empty($row[2]))
 {
 echo "<td>" . $row[2] . "</td>";
 }else
 {
 echo "<td>-</td>";
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
    	
 $rooms = $row['r_number'];
echo '
</tr> </tbody>
</table>';
 echo '<br><br>';
 echo '<legend> Contact details </legend>';
 echo '<form method="post">';
 echo 'Full name* :<br> <input type="text" placeholder="Full name" name="name"/><br>';
 echo 'E-mail* :<br> <input type="email" placeholder="E-mail" name="email" /><br>';
 echo 'Telephone (international format)* :<br> <input type="text" placeholder="Telephone" name="telephone" /><br>';
 echo 'Comments (optional):<br> <textarea type="text" placeholder="Comments" name="comments"></textarea><br>';
 echo '<legend> Payment </legend>';
 echo 'How long are you going to stay?<br>';
?><select id="duration_select" onchange="document.getElementById('duration').value = this.value; getPrice();">
    <option value="24">1 day</option>
    <option value="72">3 days</option>
    <option value="168">7 days</option>
	<option value="720">30 days</option>
</select>
<input id="duration" onchange="getPrice();"onpaste="getPrice();" oninput="getPrice();" onkeypress="return isNumberKey(event);" type="text"value="24" name="duration"> hours

<?php

 echo '<p id="total">Total: ' . $currency . $row['price'] . ' for 24 hours</p>';
 ?>
 <script type="text/javascript">
 function getPrice()
 {
 
		var price = <?php echo $row['price'];?>;
		var hours = document.getElementById('duration').value;
		document.getElementById('total').innerText = 'Total: <?php echo$currency;?>'+ (price * (hours/ 24)) +' for '+ hours +' hours';
 }
	function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        {return false;}
		getPrice();
    return true;
}</script>
 <?php
 echo '<input type="hidden" value="'. $rooms .'" name="rooms"></input>';
echo '<input type="submit" class="btn btn-primary" value="Submit application" /><input onclick="window.location.href =\'rooms.php\';" style="margin-left: 5px"type="button" class="btn" value="See available rooms">';

if (!empty($info))
echo '<br><br>' . $info;

 echo '</form>';

 
$cnt = $cnt + 1;
}


}

if ($cnt ==0)
{
echo 'The room number is not available anymore.<br><input onclick="window.location.href =\'rooms.php\';" style="margin-left: 5px"type="button" class="btn pull-right" value="See available rooms">';
}
}
 ?> 
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
