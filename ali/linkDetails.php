<?php require_once('Connections/seoExchangeDbConnection.php'); ?>
<?php require_once("./pr.php"); ?>
<?php
//initialize the session
if (!isset($_SESSION))
{
	session_start();
	}
	///////// funcation for getting SQL String value
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
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

$colname_RecordsetLinks = "-1";
if (isset($_GET['id'])) {
  $colname_RecordsetLinks = $_GET['id'];
}
////////////////getting link data from links table of user selected link////////////////////////
mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
$query_RecordsetLinks = sprintf("SELECT * FROM links WHERE id = %s", GetSQLValueString($colname_RecordsetLinks, "int"));
$RecordsetLinks = mysql_query($query_RecordsetLinks, $seoExchangeDbConnection) or die(mysql_error());
$row_RecordsetLinks = mysql_fetch_assoc($RecordsetLinks);
$totalRows_RecordsetLinks = mysql_num_rows($RecordsetLinks);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SeoExchange.com</title>
<script type="text/javascript" src="Scripts/HomePage.js"></script>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="Styles/main.css" rel="stylesheet" type="text/css" />
<style type="text/css"></style>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
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
<div id="container" style="height:1200px">
  <div id="header">
    <div id="logo"> <a href="index.php"><img src="images/Logo SEO Exchange.png" width="268" height="58" alt="seo Exchange Logo" longdesc="index.php" border="none;"/></a></div>
    <!--logo ending div. -->
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
    <div id="DivUserWelcome">
      <?php /////// displaying user info if user is logged
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
    </div>
    <!--searchbar ending div. --> 
  </div>
  <!--header ending div. -->
  
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
            </a>
          </ul>
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
            <li>Privacy Policy </li>
            </a>
          </ul>
        </div>
        <!--panelBody ending div--> 
      </div>
      <!--panel ending div--> 
      <!--<label for="searchbar"></label>--> 
    </div>
    <!--sidebar ending div. -->
    <div id="content" style="height:901px">
      <div class="panel">
        <div class="panelBody">
          <h1>Link Details: </h1>
          <table width="700" height="409" style=" border: solid 1px lightgray;
    border-radius: 5px;
    margin: 15px;
    padding: 5px;">
            <tr>
              <td width="154" height="35"><h4>Title:</h4></td>
              <td width="534"><strong><?php echo $row_RecordsetLinks['title']; ?></strong></td>
            </tr>
            <tr>
              <td height="27"><h4>Link Address:</h4></td>
              <td><strong> <?php echo "<a href=\"".$row_RecordsetLinks['link']."\" target=\"_blank\">".$row_RecordsetLinks['link']."</a>"; ?> </strong></td>
            </tr>
            <tr>
              <td height="36"><h4>Page Rank:</h4></td>
              <td><?php $grc= new GooglePageRankChecker();
			 echo "<img src="."images/pr_".$grc->getRank($row_RecordsetLinks['link']).".jpg"." />"; ?></td>
            </tr>
            <tr>
              <td height="31"><h4>Category:</h4></td>
              <td><strong>
                <?php ///getting id name of category of current link//////////////////
				mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
		$query_RecordsetCategory = sprintf("SELECT name FROM category WHERE id = %s", GetSQLValueString($row_RecordsetLinks['category'], "int"));
$RecordsetCategory = mysql_query($query_RecordsetCategory, $seoExchangeDbConnection) or die(mysql_error());
$row_RecordsetCategory = mysql_fetch_assoc($RecordsetCategory);
echo $row_RecordsetCategory['name']; ?>
                </strong></td>
            </tr>
            <tr>
              <td height="65"><h4>Sub-Category:</h4></td>
              <td><strong>
                <?php  ///getting id name of subcategory of current link//////////////////
				mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
		$query_RecordsetSubCategory = sprintf("SELECT Name FROM subcategory WHERE id = %s", GetSQLValueString($row_RecordsetLinks['subcatgory'], "int"));
$RecordsetSubCategory = mysql_query($query_RecordsetSubCategory, $seoExchangeDbConnection) or die(mysql_error());
$row_RecordsetSubCategory = mysql_fetch_assoc($RecordsetSubCategory);
echo $row_RecordsetSubCategory['Name']; ?>
                </strong></td>
            </tr>
            <tr>
              <td height="65"><h4>Discription:</h4></td>
              <td><strong><?php echo $row_RecordsetLinks['discription']; ?></strong></td>
            </tr>
            <tr>
              <td height="65"><h4>Keywords:</h4></td>
              <td><strong><?php echo $row_RecordsetLinks['keywords']; ?></strong></td>
            </tr>
            <tr>
              <td height="65"><h4>Owner's Email Address:</h4></td>
              <td><strong><?php echo $row_RecordsetLinks['email']; ?></strong></td>
            </tr>
          </table>
          <p>&nbsp;</p>
        </div>
        <!--panelBody ending div--> 
      </div>
      <!--panel ending div--> 
    </div>
    <!--content ending div. --> 
  </div>
  <!--main ending div. -->
  
  <div id="footer">
    <div id="footnav">
      <ul>
        <a href="index.php">
        <li>Home Page</li>
        </a> <a href="LinkDirectory.php">
        <li>link directory</li>
        </a> <a href="SubmitLink.php">
        <li>submit link</li>
        </a> <a href="ExchangeLink.php">
        <li>exchange link</li>
        </a> <a href="Signup.php">
        <li>signup</li>
        </a> <a href="login.php">
        <li>Login</li>
        </a>
        <?php /////// displaying admin panel if user is admin
		if(isset($_SESSION['MM_Username'])&&($_SESSION['MM_Username']=='admin')){?>
        <a href="admin.php">
        <li>Admin</li>
        </a>
        <?php }?>
      </ul>
    </div>
    <!--footnav ending div. -->
    <div id="footcontent">
      <ul>
        <a href="AboutUs.php">
        <li>About Us</li>
        </a> <a href="ContactUs.php">
        <li>Contact Us</li>
        </a> <a href="TermConditions.php">
        <li>Terms & Condition</li>
        </a> <a href="Privacy.php">
        <li>Privacy Policy</li>
        </a> <a href="index.php">
        <li>Sitemap</li>
        </a>
      </ul>
    </div>
    <!--footcontent ending div. -->
    <div id="copyright"> 
      
      <!--	dynamically changing year--> 
      Copyright &copy; <?php echo date('Y');?> All Rights Reserved </div>
    <!--copright ending div. --> 
  </div>
  <p><!--footer ending div. --></p>
</div>
<!--container ending div. --> 
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>
<?php
mysql_free_result($RecordsetLinks);
?>
