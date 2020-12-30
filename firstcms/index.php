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
        <!-- Content Area Start --->     <?php include ("includes/post_content.php"); ?><!-- Content AREA END --->	
	
<!-- Sidebar Area Stars ---> <?php include ("includes/sidebar.php"); ?><!-- Sidebar AREA END --->

</div>
<div class="footer_area">
		<h1 style="padding:20px; text-align: center;">&copy; All Rights Reserved 2019 - BloodPressureDiagnostics</h1> 
	</div>
</body>
</html>