<html>
	<head>
		<title>basic CMS</title>
<style type='text/css'>
a:link {
color:white;
text-decoration:none;
}
a:visited{
color:white;
}
h2 {color:blue; margin:5px; padding:5px; font-size:28px;
text-decoration:underline; text-align:center;
}
</style>
	</head>
	
<body>
<table width='1000' border='2' align='center'>
	<!--Header Starts-->
	<tr>
	<td><?php include("includes/header.php"); ?></td>
	</tr>
	
	<!--Navigation Bar starts-->
	<tr>
	<td>
	<table border='0'>
		<tr>
<?php 
include("includes/db.php");

$query = "select * from menus";

$run = mysql_query($query);

while ($row=mysql_fetch_array($run)){
	
	$m_title = $row[1];
	
	echo "<td bgcolor='black' width='100' align='center'><a href='pages.php?pages=$m_title'>$m_title</a></td>";
}
?> 
		</tr>
	</table>
	</td>
	</tr>
	
	<!--Main Content Starts-->
	<tr>
	<td bgcolor='pink' height='500' valign='top'>
	<h2>Welcome to my website</h2>
	<p> This website is for all users who want to learn PHP with its advance level and we are a team of developers, designers and SEO optimizers, who are actually working for last 3 years online and have a huge experience and knowledge of these subjects....</p>
	
	<p> This website is for all users who want to learn PHP with its advance level and we are a team of developers, designers and SEO optimizers, who are actually working for last 3 years online and have a huge experience and knowledge of these subjects....</p>
	<center><img src='abdulwali.jpg'></center>
	</td>
	</tr>
	
	<!--Footer Starts-->
	<tr>
	<td bgcolor='black' height='60' align='center'>
	<h2 style='color:white;'>Created by: www.onlineustaad.com</h2>
	</td>
	</tr>


</table>
</body>
</html>