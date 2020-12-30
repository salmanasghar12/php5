<?php 
include("includes/db.php");

$delete_menu = $_GET['del_menu'];

$query = "delete from menus where m_id='$delete_menu'";

$run = mysql_query($query);

if(mysql_query($query)){

echo "<script>window.open('admin_panel.php?deleted=A menu has been deleted...!','_self')</script>";
}

?>