<html>
<?php 
include("includes/db.php");
include("admin_panel.php");
?>

<form action='' method='post'>
	<table border='10' align='center' width='400'>
		<tr>
		<td align='center' colspan='4' bgcolor='orange'>
		<h2>Insert New Menu here</h2></td>
		</tr>
		
		<tr>
			<th>Menu Name:</th>
			<td><input type='text' name='menu'></td>
		</tr>
		<tr>
		<td colspan='4' align='center'>
		<input type='submit' name='submit' value='Submit'>
		</tr>


	</table>
</form>
</html>

<?php 
if(isset($_POST['submit'])){
	
	$menu = $_POST['menu'];
	
	$query = "insert into menus (m_title) values ('$menu')";

	if(mysql_query($query)){
	echo "<script>window.open('admin_panel.php?inserted=A menu has been insereted..!','_self')</script>";
	
	}
}



?>