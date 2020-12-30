<html>
  <head>
         <title>Viewing the Records</title>
  </head>

<body>
  <a href ='user_registration.php'>Insert New Record </a>
  <a href ='logout.php' >LOGOUT </a>
  <center><font color ='red' size='6' >
    <?php echo @$_GET['deleted'] ; ?>
    <?php echo @$_GET['updated'] ; ?>
    <?php echo @$_GET['logged'] ; ?>

      
    </font></center>
   <table align="center" width="1000" border="4">
   
    <tr>
      <td colspan="20" align="center" bgcolor='yellow'>
      <h1>Viewing All the Records</td></h1>
    </tr>
  
            <tr align='center'>
               <th>Serial No</th>
               <td>Student's Name </td>
               <td>Father's Name </td>
               <td>Roll Number </td>
               <td>Delete </td>
               <td>Edit</td>
               <td>Details</td>
            </tr>
    
<?php 
$conn=mysql_connect("localhost","root","");
$db=mysql_select_db('students',$conn);

$que = "select * from u_reg order by 1 DESC";
$run=mysql_query($que);
$i=1;

while ($row=mysql_fetch_array($run)){
   $u_id=$row['u_id'];
   $u_name=$row[1];
   $u_father=$row[2];
   $u_roll=$row[4];

?>
<tr align='center'>
      <td><?php echo $i; $i++ ?></td>
      <td><?php echo $u_name; ?></td>
      <td><?php echo $u_father; ?></td>
      <td><?php echo $u_roll; ?></td>
      <td><a href='delete.php?del=<?php echo $u_id; ?>'>Delete</a></td>
      <td><a href ='edit.php?edit=<?php echo $u_id; ?>'>Edit</a></td>
      <td><a href ='view.php?details=<?php echo $u_id; ?>'>Details</a></td>
    </tr>
<?php } ?>
 </table>

<?php 
$record_details=@$_GET['details'];// @ is very necessary to remove error
$query="select * from u_reg where u_id='$record_details'";
$run1=mysql_query($query);

while($row1=mysql_fetch_array($run1)){
   
   $name=$row1[1];
   $father=$row1[2];
   $school=$row1[3];
   $roll=$row1[4];
   $class=$row1[5];
?>
<br><br>
<table align="center" border='4' bgcolor='gray' width='800'>

     <tr>
      <td colspan= '6' bgcolor='yellow' align='center'><h2>Your Details here</h2></td>
     </tr>


     <tr align='center' bgcolor="white">
      <td><?php echo $name; ?></td>
      <td><?php echo $father; ?></td>
      <td><?php echo $school; ?></td>
      <td><?php echo $roll; ?></td>
      <td><?php echo $class; ?></td>

     </tr>
   <?php  } ?>
</table>
<br><br><br><br><br><br>

<form action='view.php' method='get'>Search a Record : <input type='text' name ='search'>
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