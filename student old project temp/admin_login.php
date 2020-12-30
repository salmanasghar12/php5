<?php
session_start();

?>


<html>
<head>
   <title> Admin Login</title>
</head>
 <body> 



<form action='admin_login.php' method='post' >

 <table width="400" bgcolor ='orange' border="2" align='center'>
        <tr>
        	<td align= 'center' bgcolor="pink" colspan="6"><h2>Admin Panel Form</h2></td>
        </tr>

        <tr>
        	<td align= 'right'>Admin Name <td>
        	<td><input type='text' name='admin_name' > </td>
        </tr>

        <tr>
        	<td align='right'>Admin Password <td>
        	<td><input type='Password' name='admin_pass' > </td>
        </tr>

        <tr>
        	<td colspan="4" align ='center'> <input type='submit' name ='login' value= 'login' ></td>
        	
        </tr>



 </table>
</form>

<center><?php echo @$_GET['error'] ; ?> </center>

 </body>


</html>


<?php
$conn=mysql_connect("localhost","root","");
$db=mysql_select_db('students',$conn);

if(isset($_POST['login'])){

  $admin_name =  $_SESSION['admin_name'] = $_POST['admin_name'];
  $admin_pass=$_POST['admin_pass'];
  

 $query="select * from login where user_name='$admin_name' AND user_password='$admin_pass'";


$run=mysql_query($query);
if(mysql_num_rows($run)>0){

 echo "<script>window.open('view.php?logged=Logged in Successfully','_self')</script>";
}
  else {
  echo "<script>alert('Username or Password is incorrect!')</script>";
  session_destroy();
  }

}
?>