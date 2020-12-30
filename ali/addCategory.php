<?php require_once('Connections/seoExchangeDbConnection.php'); ?>

<?php
if (!isset($_SESSION)) {
  session_start();
   ///////it checks if current user is not admin it will redirect the user to index page///////
 if(isset($_SESSION['MM_Username'])&&($_SESSION['MM_Username']!='admin')){
	 header('Location: index.php');
	 }
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>



<?php if (!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
		if (PHP_VERSION < 6) {
    	$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
		}
		$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
			switch ($theType) {
    			case "text":
				  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				  break;    
				case "long":
				case "int":
				  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
				  break;
				case "double":
				  $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
				  break;
				case "date":
				  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				  break;
				case "defined":
				  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
				  break;
  				}
 			return $theValue;
			}
		}
?>



<?php 
// we will first check weather newly entered category name already exist or not

if(isset($_POST['Add'])){
	$categoryName = $_POST['catname'];
	mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
	$queryCheckExistance = sprintf("SELECT name FROM category WHERE name = %s", GetSQLValueString($categoryName,"text"));
	$recordSetCheckExistance = mysql_query($queryCheckExistance, $seoExchangeDbConnection) or die(mysql_error());
	$categoryFound = mysql_num_rows($recordSetCheckExistance);

	if (empty($categoryFound)){// if category not already existed...
	//now we will first add new subcategory, then we will get the id of newly added subcatgory.
	//the id of subcategoy will be used as foreign key value while creating new category.
	
	mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
	$queryAddNewSubCategory = sprintf("INSERT INTO subcategory (Name) VALUES (%s)", GetSQLValueString($_POST['subCategory'], "text"));
	$recordSetAddNewSubCategory = mysql_query($queryAddNewSubCategory, $seoExchangeDbConnection) or die(mysql_error());

	//Getting the id of newly Added SubCategory
	mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
	$queryGetSubcatId = sprintf("SELECT id FROM subcategory ORDER BY id DESC 
LIMIT 1");
	$recordGetSubcatId = mysql_query($queryGetSubcatId, $seoExchangeDbConnection) or die(mysql_error());
	$row_recordGetSubcatId = mysql_fetch_assoc($recordGetSubcatId);
	$subCategoryId = $row_recordGetSubcatId['id'];//will be used as foreign key while adding new category.

	//now we will add new category 
	 
	mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
	$queryAddNewCategory = sprintf("INSERT INTO category (name, subcategory) VALUES (%s, %s)", GetSQLValueString($_POST['catname'], "text"), GetSQLValueString($subCategoryId, "int"));
	$recordSetAddNewCategory = mysql_query($queryAddNewCategory, $seoExchangeDbConnection) or die(mysql_error());
		
		}
		else{echo "Something Got Wrong...";}
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SeoExchange.com</title>
<script type="text/javascript" src="Scripts/HomePage.js"></script>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="Styles/main.css" rel="stylesheet" type="text/css" />
<style type="text/css">
</style>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
</style>
</head>

<body>
<div id="HeaderText">
<p>Improve Ranking</p>
<p style="text-indent:25px">Increase Traffic</p>
<p style="text-indent:50px">Increase Revenue</p>
</div>

<div id="container">

<div id="header">
      <div id="logo"> <a href="index.php"><img src="images/Logo SEO Exchange.png" width="268" height="58" alt="seo Exchange Logo" longdesc="index.php" border="none;"/></a></div><!--logo ending div. -->
      <div id="navbar">
      <ul id="MenuBar1" class="MenuBarHorizontal">
        <li><a href="index.php">Home</a></li>
        <li><a href="AboutUs.php">About Us</a></li>
        <li><a href="LinkDirectory.php">Link Directory</a></li>
        <li><a href="SubmitLink.php">Submit Link</a></li>
        <li><a href="ExchangeLink.php">Exchange Link</a></li>
        <li><a href="ContactUs.php">Contact Us</a></li>
        <li><a href="Signup.php">Signup</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>

</div>
      <div id="DivUserWelcome"><?php /////// displaying user info if user is logged
	   $urlLogout="<a href='/doLogout.php' style='color:#F6F6F6'> [Logout] </a>";
if (isset($_SESSION['MM_Username'])){echo "Welcome  ".$_SESSION['MM_Username']."  ".$urlLogout;
        /////// displaying admin panel if user is admin
         echo  "<br /><a href='/myAccount.php' style='color:#F6F6F6'> My Account </a><br />";}?>
          <?php if(isset($_SESSION['MM_Username'])&&($_SESSION['MM_Username']=='admin')){?>
			  <a style='color:#F6F6F6' href="admin.php">Admin Panel</a>
			  <?php }?>
      </div>
    <!--navbar ending div. -->
      <div id="searchbar">
        <form id="Searchform" name="Searchform" method="get" action="Search.php">
          <input name="searchField" type="text" id="searchField" placeholder=" Search Links....." />
          <input type="submit" name="searchButton" id="searchButton" value="  " />
          
        </form>
      </div><!--searchbar ending div. -->
  </div><!--header ending div. -->
  
  <div id="main">
<div id="sidebar">
      <div class="panel">
        <div class="panelHeading">Common Tasks</div>
        <!--panelHeading ending div-->
        <div class="panelBody">
          <ul>
          <?php if (isset($_SESSION['MM_Username'])){?>
		  <li><a href="myAccount.php">My Account</a></li>
		  <?php }?>
            <a href="LinkDirectory.php">
              <li>Browse Links Directory</li>
            </a> <a href="SubmitLink.php">
    			<li>Submit Link - Free</li>
                </a> <a href="ExchangeLink.php">
                  <li>Exchange Link</li>
                  </a> <a href="AddFeatured.php">
                    <li>Add Featured Links</li>
                    </a> <a href="login.php">
                      <li>Login</li>
                      </a></ul>
        </div>
        <!--panelBody ending div-->
      </div>
      <!--panel ending div-->
      <div class="panel">
        <div class="panelHeading">Help</div>
        <!--panelHeading ending div-->
        <div class="panelBody">
          <ul>
            <a href="HowToSubmitLink.php">
              <li>How to Submit a link</li>
            </a> <a href="HowToExchange.php">
    			<li>How to Exchange link</li>
                </a> <a href="HowToManage.php">
                  <li>Managing Exchanged links</li>
                  </a> <a href="Tips.php">
                    <li>Tips and Tricks</li>
                    </a>
          </ul>
        </div>
        <!--panelBody ending div-->
      </div>
      <!--panel ending div-->
      <div class="panel">
        <div class="panelHeading">Rules and policies</div>
        <!--panelHeading ending div-->
        <div class="panelBody">
          <ul>
            <a href="LinkSubmitRules.php">
              <li>Link Submittion Rules</li>
            </a> <a href="LinkExchangeRules.php">
    <li>Link Exchange Rules</li>
                </a> <a href="Privacy.php">
                  <li>Privacy Policy        </li>
                </a>
          </ul>
        </div>
        <!--panelBody ending div-->
      </div>
      <!--panel ending div-->
      <!--<label for="searchbar"></label>-->
    </div>
  <!--sidebar ending div. -->
  <div id="content">
    <div class="panel">
      <div class="panelBody">
      <?php if(isset($recordSetAddNewCategory)){echo "A new Category and Sub-Category Added..";}?>
        <h1>Add New Category:</h1>
        <p>To Add a New Category, atleast one new Sub-Category is required for new Category.</p>
        <form id="formCategory" method="post" action="<?php echo $_SERVER['PHP_SELF']?>"><table width="716">
          <tr>
            <td width="133" class="linksStyle">New Category Name:</td>
            <td width="567"><span id="sprytextfieldCatName">
              <input name="catname" type="text" id="catname" size="30" maxlength="30" />
              <span class="textfieldRequiredMsg">Please Enter a Valid Category Name.</span></span></td>
            </tr>
          <tr>
            <td class="linksStyle">Sub-Category Name:</td>
            <td><span id="sprytextfieldsubCatName">
              <input name="subCategory" type="text" id="subCategory" size="30" maxlength="30" />
              <span class="textfieldRequiredMsg">Please Enter a Valid Sub-Category Name.</span></span></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="Add" type="submit" class="Button" id="Add" value="Add" /></td>
            </tr>
          </table>
          </form>
        <p>&nbsp;</p>
        </div>
      <!--panelBody ending div-->
      </div>
    <!--panel ending div-->
  </div>
  <script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfieldCatName");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfieldsubCatName");
  </script>
  <!--content ending div. -->
  </div><!--main ending div. -->
  
<div id="footer">
      <div id="footnav">
        <ul>
          <a href="index.php"><li>Home Page</li></a>
          <a href="LinkDirectory.php"><li>link directory</li></a>
          <a href="SubmitLink.php"><li>submit link</li></a>
          <a href="ExchangeLink.php"><li>exchange link</li></a>
          <a href="Signup.php"><li>signup</li></a>
          <a href="login.php"><li>Login</li></a>
          <?php if(isset($_SESSION['MM_Username'])&&($_SESSION['MM_Username']=='admin')){?>
			  <a href="admin.php"><li>Admin</li></a>
			  <?php }?>
        </ul>
      </div>
      <!--footnav ending div. -->
      <div id="footcontent">
      
      <ul>
          <a href="AboutUs.php"><li>About Us</li></a>
        <a href="ContactUs.php"><li>Contact Us</li></a>
        <a href="TermConditions.php"><li>Terms & Condition</li></a>
   	    <a href="Privacy.php"><li>Privacy Policy</li></a>
        <a href="index.php"><li>Sitemap</li></a>
        </ul>
      
      </div><!--footcontent ending div. -->
      <div id="copyright">
      
      
Copyright &copy; <?php echo date('Y');?> All Rights Reserved

      </div><!--copright ending div. -->
  </div>
<p><!--footer ending div. --></p>
</div>
<!--container ending div. -->
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>