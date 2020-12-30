<html>
  <head>
<title>Student's Registration Form</title>
  </head>

<body>
  <form method="post" action="user_registration.php">

  <table width="500" border="3" align="center">
    <tr>
      <th bgcolor="yellow" colspan="5">Registration Form </th>
    </tr>

    <tr>
       <td>Student's Name</td>
       <td><input type="text" name = 'user_name'> 
        <font color='red'><?php echo @$_GET['name'];?></font>
       </td>
    </tr>

    <tr>
       <td>Father's Name</td>
       
       <td><input type="text" name = 'father_name'> 
       <font color='red'><?php echo @$_GET['father'];?></font>
     </td>
    </tr>


    <tr>
       <td>School's Name</td>
       <td><input type="text" name = 'school_name'>
        <font color='red'><?php echo @$_GET['school'];?></font>

       </td>
    </tr>

    <tr>
       <td>Roll Number</td>

       <td><input type="text" name = 'roll_no'>

       <font color='red'><?php echo @$_GET['roll'];?></font>
     </td>
    </tr>
    

    
    <tr>
      <td> Class: </td>
      <td><select name="student_class">
      <option value="null">Select Class </option>
      <option value ='10th'>10th</option>
      <option value ='9th'>9th</option>
    </select> 
    <font color='red'><?php echo @$_GET['class'];?></font>
     </td> 
   </tr>
    <tr>
      <td align="center" colspan="6">
      <input type='submit' name = 'submit' value = 'submit' > </td>
    </tr>
  </table>

 </form>
</body>
</html>

<?php 
$conn=mysql_connect("localhost","root","");
$db=mysql_select_db('students',$conn);
if(isset($_POST['submit'])){

  $student_name=$_POST['user_name'];
  $student_father=$_POST['father_name'];
  $student_school=$_POST['school_name'];
  $student_roll=$_POST['roll_no'];
  $student_class=$_POST['student_class'];

if($student_name==''){
  echo "<script>window.open('user_registration.php?name=Name is Required','_self')</script>";
  exit();

}
if($student_father==''){
  echo "<script>window.open('user_registration.php?father=Father name is Required','_self') </script>";
  exit();

}
if($student_school==''){
  echo "<script>window.open('user_registration.php?school=School Name write','_self')</script>";
  exit();

}
if($student_roll==''){
  echo "<script>window.open('user_registration.php?roll=Roll Number is Required','_self')</script>";
  exit();

}
if($student_class=='null'){
  echo "<script>window.open('user_registration.php?class=Select your Class','_self') </script>";
  exit();
}
$que = "insert into u_reg (u_name,u_father,u_school,u_roll,u_class) values ('$student_name','$student_father','$student_school','$student_roll','$student_class')";
if(mysql_query($que)){
  
  echo "<center><b>The followind data is being inserted into database</b></center>";
  echo "<table align='center' border='4'>
  <tr>
  <td>$student_name</td>
  <td>$student_father</td>
  <td>$student_school</td>
  <td>$student_roll</td>
  <td>$student_class</td>
  <tr>
  </table>";

}
}

?>