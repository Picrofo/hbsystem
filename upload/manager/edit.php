<?php
require_once('connect.php');

function delTree($dir) { 
   $files = array_diff(scandir($dir), array('.','..')); 
    foreach ($files as $file) { 
      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
    } 
    return rmdir($dir); 
  } 
//Loop through each file
if (isset($_FILES['upload'])){
for($i=0; $i<count($_FILES['upload']['name']); $i++) {
  //Get the temp file path
  $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

  //Make sure we have a filepath
  if ($tmpFilePath != ""){
    //Setup our new file path
	if (!file_exists("../images/". $_POST['r_id'] ))
	{
	mkdir("../images/". $_POST['r_id']);
	}
    $newFilePath = "../images/" . $_POST['r_id'] . '/'. $_FILES['upload']['name'][$i];

    //Upload the file into the temp dir
    if(move_uploaded_file($tmpFilePath, $newFilePath)) {

      $info = "<div class='alert alert-info'>The files were uploaded.</div>";

    }
	else
	{  $info = "<div class='alert alert-danger'>There was a problem with uploading the files.</div>";

    
	}
  }
}}
if (!empty($_POST))
{
if (empty($_POST['method']))
{
if (!empty($_POST['status']) && !empty($_POST['r_id']))
{
$query = "";
$query_params = "";
if ($_POST['status'] == "available")
{
$query = " 
            UPDATE rooms SET status=:status, owner='', owner_name='', telephone='', end_date='' WHERE r_number=:id
        "; 
		
		 $query_params = array( 
            ':id' => $_POST['r_id'],
            ':status' => $_POST['status']
            
        );	
}
else{
$query = " 
            UPDATE rooms SET status=:status WHERE r_number=:id
        "; 
		}
		 $query_params = array( 
            ':id' => $_POST['r_id'],
            ':status' => $_POST['status']
            
        );		
		 
         
      try{
            
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
	  }catch(PDOException $ex){
	  $info = "<div class='alert alert-danger'>An error occured. Please try again later: " . $ex . "</div>";}
	  
}else if (isset($_POST['number']) && isset($_POST['features']) && isset($_POST['additional']) && isset($_POST['owner']) && isset($_POST['owner_name']) && isset($_POST['telephone']) && isset($_POST['original']) && isset($_POST['price']) && isset($_POST['end_date']))
{
$query = " 
            UPDATE rooms SET r_number=:number,r_contents=:features, r_additional_text=:additional, owner=:owner, owner_name=:owner_name, telephone=:telephone, price=:price, end_date=:end_date WHERE r_number=:original
        "; 
		 $query_params = array( 
            ':number' => html_entity_decode($_POST['number']),
            ':features' =>  html_entity_decode($_POST['features']),
            ':additional' =>  html_entity_decode($_POST['additional']),
            ':owner' =>  html_entity_decode($_POST['owner']),
            ':owner_name' =>  html_entity_decode($_POST['owner_name']),
            ':telephone' =>  html_entity_decode($_POST['telephone']),
            ':price' =>  html_entity_decode($_POST['price']),
            ':end_date' =>  html_entity_decode($_POST['end_date']),
			':original' =>  html_entity_decode($_POST['original'])
        );		
		 
         
      try{
            
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
	  }catch(PDOException $ex){
	  $info = "<div class='alert alert-danger'>An error occured. Please try again later: " . $ex . "</div>";}
	  
}
}else
{
if ($_POST['method'] == "remove"){

if (file_exists("../images/" . $_POST['r_id'])){
if (delTree("../images/" . $_POST['r_id']))
{
      $info = "<div class='alert alert-info'>The image files were removed as well.</div>";

}else
{

      $info = "<div class='alert alert-danger'>The image files couldn't be removed.</div>";
}
}
$query = " 
            DELETE FROM rooms WHERE r_number=:id
        "; 
		 $query_params = array( 
            ':id' => $_POST['r_id']
        );		
		 
         
      try{
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
	  }catch(PDOException $ex){
	  $info = "<div class='alert alert-danger'>An error occured. Please try again later: " . $ex . "</div>";}
	  


}else if ($_POST['method'] == "add"){
 $query = " 
            INSERT INTO rooms ( 
                r_number
            ) VALUES ( 
                :roomnumber
            ) 
        "; 
         
        $query_params = array( 
            ':roomnumber' => $_POST['r_id']	
        ); 
         
      try{
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
      }catch(PDOException $ex){
	  $info = "<div class='alert alert-danger'>An error occured. Please try again later: " . $ex . "</div>";}

}

}}
?>
<!DOCTYPE html>
<html>
	<head>

		<meta charset="utf-8">
		<title>Book Management - Edit Rooms</title>
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
		<script src="../js/jquery.js"></script>
		<script src="../js/bootstrap.min.js"></script>
	</head>
	
  
  <body>

  	<div id="wrap">
			<div id="header">
<td valign="center">
    <h3>Booking Management</h3>


  <h4>Edit Rooms <a class="pull-right" href="index.php">Requests</a></h4>

  <p><a class="pull-right" href=""><h4>Refresh</h4></a></p>
<?php if (isset($info))echo $info;?>
 <?php 
$query = " 
            SELECT 
                * 
            FROM rooms
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
        	<th scope="col"><b>Room Number</b></th>
            <th scope="col"><b>Features</b></th>
            <th scope="col"><b>Additional Text</b></th>
            <th scope="col"><b>Status</b></th>
            <th scope="col"><b>Owner</b></th>
            <th scope="col"><b>Owner Name</b></th>
            <th scope="col"><b>Telephone</b></th>
            <th scope="col"><b>Price</b></th>
            <th scope="col"><b>End Date</b></th>
            <th scope="col"></th>
        </tr>
    </thead>';

    echo '
    <tbody id="mysql_data">
    	';
 while($row = $stmt->fetch(PDO::FETCH_BOTH)) 
 { 
 if (time() > strtotime($row['end_date']))
		{
 if ($row['end_date'] != "0000-00-00 00:00:00" && !empty($row['end_date'])){
		echo'<tr style="background: lightgray">';
		}else
		{echo'<tr style="background: lightblue">';
		
		}}
		else
		{
		echo'<tr>';
		}
echo '
	<input type="hidden" value="'.htmlentities($row['r_number']).'"id="org_number_'.$cnt.'"/>
    	<td contenteditable="true" id="number_' . $cnt . '">'. htmlentities($row['r_number']). '</td>
    	<td contenteditable="true" id="features_' . $cnt . '">'. htmlentities($row['r_contents']). '</td>';
    
		echo '<td id="additional_' . $cnt . '" contenteditable="true">'. htmlentities($row['r_additional_text']). '</td>';
    	echo '<td>'.htmlentities( $row['status']). '</td>';
    	echo '<td id="owner_' . $cnt . '" contenteditable="true">'. htmlentities($row['owner']). '</td>';
    	echo '<td id="owner_name_' . $cnt . '" contenteditable="true">'. htmlentities($row['owner_name']). '</td>';
    	echo '<td id="telephone_' . $cnt . '" contenteditable="true">'.htmlentities( $row['telephone']). '</td>';
    	echo '<td id="price_' . $cnt . '" contenteditable="true">'. htmlentities($row['price']). '</td>';
		
    	echo '<td id="end_date_' . $cnt . '"contenteditable="true">'. htmlentities($row['end_date']). '</td>';
		
	echo '<td>';
	
	if ($row['status'] == "available")
	{
	echo '<br><input onclick="update('.$cnt.')" class="btn btn-success" type="submit" value="Update"></input><br><br><form method="POST"><input type="hidden" value="taken" name="status" /><input type="hidden" value="'. $row["r_number"].'" name="r_id" /><input class="btn" type="submit" value="Switch status"></input></form>
	
		<form method="POST"><input type="hidden" value="remove" name="method" /><input type="hidden" value="'. $row["r_number"].'" name="r_id" /><input onclick="return confirmaction();"class="btn btn-danger" type="submit" value="Remove"></input></form>
	<form method="POST" enctype="multipart/form-data">
	<input type="hidden" value="'. $row['r_number'].'" name="r_id" />
	<input name="upload[]" type="file" multiple="multiple" />
	<input type="submit" class="btn" value="Upload"/>
	</form>
	';
	}else
	{
	
	echo '<br><input class="btn btn-success" onclick="update('.$cnt.')" type="submit" value="Update"></input><br><br><form method="POST"><input type="hidden" value="available" name="status" /><input type="hidden" value="'. $row["r_number"].'" name="r_id" /><input class="btn" type="submit" value="Remove Owner"></input></form>
	
	<form method="POST"><input type="hidden" value="remove" name="method" /><input type="hidden" value="'. $row["r_number"].'" name="r_id" /><input onclick="return confirmaction();"class="btn btn-danger" type="submit" value="Remove"></input></form>
	<form method="POST" enctype="multipart/form-data">
	<input type="hidden" value="'. $row['r_number']. '" name="r_id" />
	<input name="upload[]" type="file" multiple="multiple" />
	<input type="submit" class="btn" value="Upload"/>
	</form>
	';
	}
echo '</td></tr>';

     


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
  <div id="errors"><?php if (isset($info))echo $info; ?></div>
	 
<br><form method="POST">
<input type="hidden" value="add" name="method" />Room number:<br><input name="r_id" type="number"></input><br><input class="btn btn-primary" type="submit" value="Add"></input>
</form>
    
	</div>
	<script type="text/javascript">
function confirmaction()
{
if (confirm('Are you sure?')) { 
 return true;}
 return false;
}
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
function update(rownumber)
	{

	var number = document.getElementById("number_" + rownumber).innerHTML;
	var originalnumb = document.getElementById("org_number_" + rownumber).value;
	var features = document.getElementById("features_" + rownumber).innerHTML;
	var additional = document.getElementById("additional_" + rownumber).innerHTML;
	var owner = document.getElementById("owner_" + rownumber).innerHTML;
	var owner_name = document.getElementById("owner_name_" + rownumber).innerHTML;
	var telephone = document.getElementById("telephone_" + rownumber).innerHTML;
	var price = document.getElementById("price_" + rownumber).innerHTML;
	var end_date = document.getElementById("end_date_" + rownumber).innerHTML;
	$.post('edit.php', {original: originalnumb, number: number, features: features, additional: additional, owner: owner, owner_name: owner_name, telephone: telephone, price: price, end_date: end_date}, function(data,status){
	if (status == "success")
	  $("#errors").html("<div class='alert alert-info'>The row "+number+" was updated</div>");
  else
    $("#errors").html("<div class='alert alert-info'>"+status+"</div>");
  });


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
