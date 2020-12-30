<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>A News Website</title>
<link rel="stylesheet" href="style/style.css" media="all" >
</head>
<body>
<!--.. main container starts   --><div class="container"	>
   <!--..header starts    --> <div class = "head">
		<a href ="index.php"><img id="logo" src= 'images/logo1.png' style="width:130px;height:100px;"/> </a>
		<img id="banner" src = 'images/banner1.jpg' style="width:850px;height:100px;" />
	</div>  <!--..header ends    -->
      <!--Navigation bar STARTS    --><?php include ("includes/navbar.php"); ?>	<!-- Navigation bar ends    -->
        <!-- Content Area Start --->    
	<div class="post_area">
	
	<?php
  if(isset($_GET ['search'])){
$get_query=$_GET['search_query'];
	  if($get_query ==''){
		  echo "<script>alert('Please write keyword to search')</script>";
		  echo "<script>window.open('index.php','_self')</script>";
			  exit();
	  }
 $get_posts= "select * from posts where post_keywords like'%$get_query%'";
	  
$run_posts=mysql_query($get_posts);

while ($row_posts= mysql_fetch_array($run_posts))
{

	$post_id= $row_posts['post_id'];
	$post_title=$row_posts['post_title'];
	$post_date=$row_posts['post_date'];
	$post_author=$row_posts['post_author'];
	$post_image=$row_posts['post_image'];
	$post_content=substr($row_posts['post_content'],0,300  /* On the home page we are only showing 300 characters*/ );

echo "
<h2><a id ='ltitle' href='details.php?post=$post_id'>$post_title</a></h2>
<span> <i> Posted by</i> <b>$post_author</b> &nbsp; &nbsp;&nbsp;  On <b>$post_date</b></span> <span style= 'color:brown;'> &nbsp;<b>Comments</b>
<img src='admin/news_images/$post_image' width='100' height='100' />

<div>$post_content <a id='rmlink'href='details.php?post=$post_id'>Read More</a></div> <br />
";
}
}

if(isset($_GET['cat'])){
		$cat_id=$_GET['cat'];

$get_posts="select * from posts where category_id='$cat_id'";
$run_posts=mysql_query($get_posts);

while ($row_posts= mysql_fetch_array($run_posts))
{

	$post_id= $row_posts['post_id'];
	$post_title=$row_posts['post_title'];
	$post_date=$row_posts['post_date'];
	$post_author=$row_posts['post_author'];
	$post_image=$row_posts['post_image'];
	$post_content=substr($row_posts['post_content'],0,300  /* On the home page we are only showing 300 characters*/ );

echo "
<h2><a id ='ltitle' href='details.php?post=$post_id'>$post_title</a></h2>
<span> <i> Posted by</i> <b>$post_author</b> &nbsp; &nbsp;&nbsp;  On <b>$post_date</b></span> <span style= 'color:brown;'> &nbsp;<b>Comments</b>
<img src='admin/news_images/$post_image' width='100' height='100' />

<div>$post_content <a id='rmlink'href='details.php?post=$post_id'>Read More</a></div> <br />
";
}

}

?>

</div>
	<!-- Content AREA END --->	
	
<!-- Sidebar Area Stars ---> <?php include ("includes/sidebar.php"); ?><!-- Sidebar AREA END --->
<div class="footer_area">
		<h1 style="padding:20px; text-align: center;">&copy; All Rights Reserved 2019 - BloodPressureDiagnostics</h1> 
	</div>
</div>
</body>
</html>