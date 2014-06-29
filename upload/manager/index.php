<?php
require_once('connect.php');

$mode = "";
if (!empty($_POST))
{
$rooms ="";
if (isset($_POST['accid']) && !empty($_POST['accid']))
{
$mode = "ACCEPT";
$rooms = $_POST['accid'];
}
else if (isset($_POST['refid']) && !empty($_POST['refid']))
{
$mode = "REFUSE";
$rooms = $_POST['refid'];
}


	if (isset($rooms) && !empty($rooms) && strpos($rooms, ';') !== FALSE)
	{	

 foreach (explode(";", $rooms) as $val) {
 if ($val != "")
 {
 $query ="";
 if ($mode == "ACCEPT"){
  
		
		$query_1 = " 
            SELECT 
                * 
            FROM requests WHERE ID=:id_1
        "; 
            
        $query_params_1 = array( 
            ':id_1' => $val,
			
            
        ); 
        try 
        { 
            $stmt = $db->prepare($query_1); 
            $result = $stmt->execute($query_params_1); 
        } 
        catch(PDOException $ex) {
        } 
        
        $row = $stmt->fetch();
		 
  
$query = " 
            UPDATE rooms SET status='taken', owner=:email, owner_name=:name, telephone=:telephone end_date=:end_date WHERE r_number=:id
        "; 
		 $query_params = array( 
            ':id' => $row['room_number'],
            ':email' => $row['email'],
            ':name' => $row['requested_by'],
            ':telephone' => $row['telephone'],
			':end_date' => date("Y-m-d H:i:s", strtotime('+'. $row['duration'] . ' hours'))
            
        );		
		 
         
      try{
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
	  }catch(PDOException $ex){
	  $info = "<div class='alert alert-danger'>An error occured. Please try again later: " . $ex . "</div>";}
	  
	  
	$query = " 
            DELETE FROM requests WHERE ID=:id
        "; 
         	 
        $query_params = array( 
            ':id' => $val,           
        ); 
		 
         
      try{
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
	  }catch(PDOException $ex){
	  $info = "<div class='alert alert-danger'>An error occured. Please try again later: " . $ex . "</div>";}
		}
		else if ($mode == "REFUSE")
		{
	$query = " 
            DELETE FROM requests WHERE ID=:id
        "; 
         	 
        $query_params = array( 
            ':id' => $val,           
        ); 
		 
      try{
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
	  }catch(PDOException $ex){
	  $info = "<div class='alert alert-danger'>An error occured. Please try again later: " . $ex . "</div>";}

 }}
 }
	}
}






?>
<!DOCTYPE html>
<html>
	<head>

		<meta charset="utf-8">
		<title>Book Management</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<link href="../css/bootstrap.css" rel="stylesheet">
		<style type="text/css">
		
<!--
@import url("../css/style.css");
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
    <h3>Booking Management</h3>


  <h4>Requests <a class="pull-right" href="edit.php">Edit Rooms</a></h4><p>
  <p><a class="pull-right" href=""><h4>Refresh</h4></a></p>
<b>Notice: </b> Please accept requests only when the payment has been processed.</p><p>
<b>Notice: </b> Please don't accept requests if the room is already taken (has a current owner).</p>
<?php if (isset($info))echo $info;?>
 <?php 
$query = " 
            SELECT 
                * 
            FROM requests
        "; 
         
        try 
        { 
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
        	<th scope="col"><b>ID</b></th>
        	<th scope="col"><b>Room Number</b></th>
            <th scope="col"><b>Requested By</b></th>
            <th scope="col"><b>E-mail</b></th>
            <th scope="col"><b>Telephone</b></th>
            <th scope="col"><b>Comments</b></th>
            <th scope="col"><b>Duration</b></th>
            <th scope="col"><b>Amount Due</b></th>
            <th scope="col"><b>Current Owner</b></th>
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
        <td><input class="checkbox_row"id="checkbox_'.$cnt.'" value="'. $row['ID'] .'" type="checkbox" /></td>
	
    	<td id="id_' . $cnt . '"><b>'. $row['ID']. '</b></td>
    	<td id="row_' . $cnt . '">'. $row['room_number']. '</td>';
    
		echo '<td>'. $row['requested_by']. '</td>';
    	echo '<td>'. $row['email']. '</td>';
    	echo '<td>'. $row['telephone']. '</td>';
		if ($row['comments'] != "")
		{
    	echo '<td>'. $row['comments']. '</td>';
    	}
else
{
    	echo '<td>'. '-'. '</td>';
}	


    	echo '<td>'. $row['duration']. ' hours</td>';
		
		
		
		$query_2 = " 
            SELECT 
                * 
            FROM rooms
        "; 
         
        try 
        { 
            $stmt_2 = $db->prepare($query_2); 
            $result_2 = $stmt_2->execute(); 
        } 
        catch(PDOException $ex) {
        } 
		
    while($row_2 = $stmt_2->fetch(PDO::FETCH_BOTH)) 
    { 
if ($row_2['r_number'] == $row['room_number'])	{
	echo '<td>'. $currency .(($row['duration'] / 24) * $row_2['price']). '</td>';
	
	if (!empty($row_2['owner'])){
echo '<td>'. $row_2['owner_name'].  ' : '. $row_2['owner'] .'</td>';


 echo '<td><form action="index.php" method="POST" style="margin: 0 0 5px;"><input type="hidden" name="accid" value="'.$row['ID'].';"><input type="submit" value="Replace" class="btn btn-warning"></input></form><form action="index.php" method="POST"><input type="hidden" name="refid" value="'.$row['ID'].';"><input type="submit" value="Refuse" class="btn btn-danger"></input></form>
</tr>
     
  ';
  }else
  {
 echo '<td>-</td>';
 
 echo '<td><form action="index.php" method="POST" style="margin: 0 0 5px;"><input type="hidden" name="accid" value="'.$row['ID'].';"><input type="submit" value="Accept" class="btn"></input></form><form action="index.php" method="POST"><input type="hidden" name="refid" value="'.$row['ID'].';"><input type="submit" value="Refuse" class="btn btn-danger"></input></form>
</tr>';
  }
	
	}
	
	
	
	}
$cnt = $cnt + 1;
}
if ($cnt ==0)
{
echo 'There are no more requests for today.';
}
echo '  </tbody>
</table>';
 ?> 
 <br> 
  <div id="errors"></div>
      <input onclick="refuseSelected();"  style="margin-left: 5px;"type="button" class="pull-right btn btn-danger" value="Refuse selected"><input id="book_selected"onclick="acceptSelected();" type="button" class="btn pull-right" value="Accept selected">
	 
<br>
    
    
	</div>
	<script type="text/javascript">
	function post(path, params, method) {
    method = method || "post"; 

    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}
	function acceptSelected()
	{
var rooms = "";
var array = document.getElementsByClassName('checkbox_row');
for (index = 0; index < array.length; index++) {
if (array[index].checked)
    rooms += array[index].value + ";";
}
if (rooms != ""){
post('index.php', {accid: rooms});
}else {
document.getElementById("errors").innerHTML = "<div class='alert alert-danger'>There were no requests selected.</div>";
}
}
function refuseSelected()
	{
var rooms = "";
var array = document.getElementsByClassName('checkbox_row');
for (index = 0; index < array.length; index++) {
if (array[index].checked)
    rooms += array[index].value + ";";
}
if (rooms != ""){

post('index.php', {refid: rooms});
}else {
document.getElementById("errors").innerHTML = "<div class='alert alert-danger'>There were no requests selected.</div>";
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
