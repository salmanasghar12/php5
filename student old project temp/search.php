<html>
  <head>
<title>Search a Record</title>
  </head>
<body>
<?php 
$conn=mysql_connect("localhost","root","");
$db=mysql_select_db('students',$conn);

?>



<form action='search.php' method='get'>Search a Record : <input type='text' name ='search'>
  <input type='submit' name ='submit' value ='Find Now'>
</form>
<?php 
  if(isset($_GET['search'])){

    $search_record=$_GET['search'];

    $query2="select * from u_reg where u_name='$search_record' OR u_roll ='$search_record'";

    $run2=mysql_query ($query2);
    while ($row2=mysql_fetch_assoc($run2))// ITs same like mysql_fetch_array
    {
      $name123=$row2['u_name'];// it will give error in it if we write 1,2 instead of database names as in the fields in phpmyadmin
      $father123=$row2['u_father'];
      $school123=$row2['u_school'];
      $roll123=$row2['u_roll'];
      $class123=$row2['u_class'];
?>



<table width='800' bgcolor='yellow' align='center' border='1'>



   <tr align='center'>
     <td><?php echo $name123; ?> </td>
     <td><?php echo $father123; ?> </td>
     <td><?php echo $school123; ?> </td>
     <td><?php echo $roll123; ?> </td>
     <td><?php echo $class123; ?> </td>

   </tr>

</table>
<?php }} ?>
</body>
</html>