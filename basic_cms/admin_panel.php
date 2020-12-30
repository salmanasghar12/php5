<?php
session_start();

if(!$_SESSION['admin_name']){

header('location:login.php?error=You are not an Administrator');
}

?>
<html>
	<head>
		<title>Admin Panel</title>
	</head>
	
<body>
<div style='width:100%; height:100px; background:blue; text-align:center; font-size:33px; color:white;'>
Welcome to Admin Panel!
</div>
Welcome: <font size='8' color='red'>
<?php echo $_SESSION['admin_name']; ?></font>

<h2><a href='logout.php' style='margin-top:30px;'>Logout</a></h2>
<h2 align='center'><?php echo @$_GET['deleted']; ?></h2>
<h2 align='center'><?php echo @$_GET['inserted']; ?></h2>
<h2 align='center'><?php echo @$_GET['logged']; ?></h2>

<h2><a href='admin_panel.php?view_page=View page'>View Pages</a></h2>
<h2><a href='insert_page.php'>Insert New Page</a></h2>
<h2><a href='admin_panel.php?view_menu=View menu'>View Menus</a></h2>
<h2><a href='insert_menu.php'>Insert New Menu</a></h2>
<?php
include("includes/db.php");

if(isset($_GET['view_page']))
{

?>

<table width='1000' border='2' align='center'>
	<tr>
	<td align='center' bgcolor='yellow' colspan='6'><h2>All pages here!</h2></td>
	</tr>
	
	<tr align='center'>
	<th>Page NO:</th>
	<th>Page Title:</th>
	<th>Page Content:</th>
	<th>Delete</th>

	</tr>
	
	<tr>
<?php 

$query = "select * from pages";
$run = mysql_query($query);
while ($row=mysql_fetch_array($run))
{
	$p_id = $row['p_id'];
	$p_title = $row[1];
	$p_desc = substr($row[2],0,200);
	

?>
	<td><?php echo $p_id; ?></td>
	<td><?php echo $p_title; ?></td>
	<td><?php echo $p_desc; ?></td>
	<td><a href='delete_page.php?del_page=<?php echo $p_id; ?>'>Delete</a></td>
	</tr>
<?php }} ?>


</table>
<?php 
if(isset($_GET['view_menu']))
{
?>
<table width='400' border='3' align='center'>
	<tr>
	<td colspan='5' bgcolor='aqua' align='center'>
	<h2>All menus here</h2></td>
	</tr>
	
	<tr align='center'>
		<th>Menu No:</th>
		<th>Menu Title:</th>
		<th>Delete</th>
	</tr>
	
	
<?php 
$query = "select * from menus order by 1 DESC";
$run = mysql_query($query);
while ($row=mysql_fetch_array($run))
{
	$m_id = $row['m_id'];
	$m_title = $row[1];
?>
	<tr align='center'>
	<td><?php echo $m_id; ?></td>
	<td><?php echo $m_title; ?></td>
	<td><a href='delete_menu.php?del_menu=<?php echo $m_id; ?>'>Delete</a></td>
	
	</tr>
<?php }} ?>
</table>
</body>
</html>