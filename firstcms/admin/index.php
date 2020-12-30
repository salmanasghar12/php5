<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
	<link rel="stylesheet" href="style.css" />
</head>
<body>
<div class ="wrapper">

	<a href="index.php"><div class = "header" ></div></a>

	<div class = "left">

	 <h3 style ="padding:5px;">Manage Content </h3>


	 <a href="index.php?insert_post" > Insert New Post </a>
	 <a href="index.php?view_posts" > View all Posts </a>
	 <a href="index.php?insert_cat" > Insert New Category </a>
	 <a href="index.php?view_cats" > View all Categories </a>
	 <a href="index.php?view_comments" > View all Comments </a>
	 <a href="index.php?logout" > Admin Logout </a>
</div>
	<div class ="right" >
	<span style="padding:5px; margin:5px;"> <b>To do Tasks : </b><span style="color:red; padding: 5px;margin:5px;"><a href="index.php?view_comments">Pending Comments(0) </a></span></span>


<?php 
if (isset($_GET['insert_post'])){
include ("includes/insert_post.php");
}

if (isset($_GET['view_posts'])){
include ("includes/view_posts.php");
}

if (isset($_GET['edit_post'])){
include ("includes/edit_post.php");
}

?>
	</div>
</div>
</body>
</html>