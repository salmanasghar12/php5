<?php 
include("includes/db.php");

$delete_page = $_GET['del_page'];

$query = "delete from pages where p_id='$delete_page'";

if(mysql_query($query)){
echo "<script>window.open('admin_panel.php?deleted=A page has been deleted...!','_self')</script>";

}


?>