<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>A News Website</title>
<link rel="stylesheet" href="style/style.css" media="all" >
</head>

	
	
<body>
	
	<!--.. main container starts   -->
<div class="container"	>
	
    <div class = "head"><!--..header starts    -->
		<a href ="index.php"><img id="logo" src= 'images/logo1.png' style="width:130px;height:100px;">
		<img id="banner" src = 'images/banner1.jpg' style="width:850px;height:100px;" />

			 
	</div>
	<!--..header ends    -->
    
<!--Navigation bar STARTS    -->
             <?php include ("includes/navbar.php"); ?>	
<!-- Navigation bar ends    -->
<!-- Content Area Start ---> 
            <div class="post_area">
	
	<?php
	if(isset($_GET['post'])){
		$post_id = $_GET['post'];
$get_posts="select * from posts where post_id='$post_id'";
$run_posts=mysql_query($get_posts);

while ($row_posts= mysql_fetch_array($run_posts))
{

	$post_title=$row_posts['post_title'];
	$post_date=$row_posts['post_date'];
	$post_author=$row_posts['post_author'];
	$post_image=$row_posts['post_image'];
	$post_content= $row_posts['post_content'];

echo "
<h2>$post_title</h2>
<span> <i> Posted by</i> <b>$post_author</b> &nbsp; &nbsp;&nbsp;  On <b>$post_date</b></span> <span style= 'color:brown;'> &nbsp;<b>Comments</b>
<img src='admin/news_images/$post_image' width='300' height='300' />

<div>$post_content</div>
";
}

}
 include("includes/comment_form.php");
	?>	
	</div>	
<!-- Content AREA END --->	
		

	<!-- Sidebar Area Stars --->
	 <?php include ("includes/sidebar.php"); ?>
   <!-- Sidebar AREA END --->


<div class="footer_area"	>
		
	</div>
	
</div>
	
</body>
</html>