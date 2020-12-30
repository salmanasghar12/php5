<html>
	<head>
		<title>Uploading Image</title>
	</head>
<body>
	<form action='image.php' method='post' enctype='multi-part/form-data'>
<table width='400' border='2' align='center'>
	<tr>
	<td>Select image:<input type='file' name='image'></td>
	</tr>
	<tr><td colspan='3' align='center'><input type='submit' name='upload' value='Upload Image'></td>
	</tr>

</table>
	
	</form>



</body>
</html>
<?php
mysql_connect("","","");
mysql_select_db("");

if(isset($_POST['upload'])){

	echo $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
	$image_name = addslashes($_FILES['image']['name']);
	$image_size = getimagesize($_FILES['image']['tmp_name']);

}


?>