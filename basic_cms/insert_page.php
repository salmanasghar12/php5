<?php
session_start();

if(!$_SESSION['admin_name']){

header('location:login.php?error=You are not an Administrator');
}

?>

<html>
<?php
include("includes/db.php");
include("admin_panel.php");

?>
<form action='' method='post'> 
	<table width='500' border='3' align='center'>
		<tr>
		<td colspan='4' bgcolor='pink' align='center'><h2>Insert New Page Here</h2></td>
		</tr>
		<tr>
		<th>Page Title:</th>
		<td><input type='text' name='page_title'></td>
		</tr>
		
		<tr>
		<th>Page Content:</th>
		<td><textarea name='page_content' cols='20' rows='10'></textarea></td>
		</tr>
		
		<tr>
		<td align='center' colspan='6'><input type='submit' name='submit' value='submit'></td>
		</tr>
	</table>
</form>
</html>
<?php 
if(isset($_POST['submit'])){

	$post_title = $_POST['page_title'];
	$post_content = $_POST['page_content'];
	
	$query = "insert into pages (p_title,p_desc) values ('$post_title','$post_content')";

	if(mysql_query($query)){
	echo "<script>window.open('admin_panel.php?inserted=A new page has been inserted..!','_self')</script>";
	}


}

?>