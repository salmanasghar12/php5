<?php require_once('Connections/seoExchangeDbConnection.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION))
{
	session_start();
}
	///////// function for getting SQL String value
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
}////////////////////////////////////////////////////////////////////////////

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_RecordsetSubCategories = 30;////// displaying maximum categories on this page.
$pageNum_RecordsetSubCategories = 0;
if (isset($_GET['pageNum_RecordsetSubCategories'])) {
  $pageNum_RecordsetSubCategories = $_GET['pageNum_RecordsetSubCategories'];
}
$startRow_RecordsetSubCategories = $pageNum_RecordsetSubCategories * $maxRows_RecordsetSubCategories;

$colname_RecordsetSubCategories = "-1";
if (isset($_GET['catname'])) {
  $colname_RecordsetSubCategories = $_GET['catname']; // user selected category from get array////
}
///////////////////////Getting id and name of subcategories of a user selected category form db ///////////
mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
$query_RecordsetSubCategories = sprintf("SELECT subcategory.id, subcategory.Name FROM subcategory INNER JOIN category ON subcategory.id=category.subcategory WHERE category.Name = %s", GetSQLValueString($colname_RecordsetSubCategories, "text"));
$query_limit_RecordsetSubCategories = sprintf("%s LIMIT %d, %d", $query_RecordsetSubCategories, $startRow_RecordsetSubCategories, $maxRows_RecordsetSubCategories);
$RecordsetSubCategories = mysql_query($query_limit_RecordsetSubCategories, $seoExchangeDbConnection) or die(mysql_error());
$row_RecordsetSubCategories = mysql_fetch_assoc($RecordsetSubCategories);
////////////////////////////////////////////////////////////////////////////
if (isset($_GET['totalRows_RecordsetSubCategories'])) {
  $totalRows_RecordsetSubCategories = $_GET['totalRows_RecordsetSubCategories'];
} else {
  $all_RecordsetSubCategories = mysql_query($query_RecordsetSubCategories);
  $totalRows_RecordsetSubCategories = mysql_num_rows($all_RecordsetSubCategories);
}
$totalPages_RecordsetSubCategories = ceil($totalRows_RecordsetSubCategories/$maxRows_RecordsetSubCategories)-1;

$queryString_RecordsetSubCategories = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecordsetSubCategories") == false && 
        stristr($param, "totalRows_RecordsetSubCategories") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecordsetSubCategories = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RecordsetSubCategories = sprintf("&totalRows_RecordsetSubCategories=%d%s", $totalRows_RecordsetSubCategories, $queryString_RecordsetSubCategories);


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
#main #content .panel .panelBody ul {
	margin: 0;
	padding: 0;
	list-style-type: none;
	width: auto;
}
#main #content .panel .panelBody ul li {
	padding: 10px;
	list-style-type: none;
	position: relative;
	text-align: left;
	float: left;
	width: 209px;
	margin-right: 10px;
	margin-bottom: 10px;
	height: auto;
	font-weight: bold;
	color: #0344a8;
	border: solid 1px lightgray;
	border-radius: 5px;
}
</style>
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
            <?php  /////// displaying user info if user is logged
		  if (isset($_SESSION['MM_Username'])){?>
            <li><a href="../myAccount.php">My Account</a></li>
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
    <div id="content">
      <div class="panel">
        <div class="panelBody" style="height:600px">
          <h2><a href="LinkDirectory.php">Categories</a> &gt; Sub-Categories</h2>
          <h3>
            <?php if (isset($_GET['catname'])) {
			echo $_GET['catname'];
			}?>
          </h3>
          <ul>
            <?php do { 
			/*here it directs the user to links page along with passing  the values of subcategory id, category name and subcategory name using $_GET[] array...*/ ?>
            <li><a href="links.php<?php echo "?id=".$row_RecordsetSubCategories['id']."&amp;subcatname=".urlencode($row_RecordsetSubCategories['Name'])."&amp;catname=".urlencode($_GET['catname']); ?>"> <?php echo $row_RecordsetSubCategories['Name']; ?></a></li>
            <?php } while ($row_RecordsetSubCategories = mysql_fetch_assoc($RecordsetSubCategories)); ?>
          </ul>
          
          <!--------------------------------------- Paging Section-------------------------------------------------------------------------->
          <?php if ($pageNum_RecordsetSubCategories > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_RecordsetSubCategories=%d%s", $currentPage, 0, $queryString_RecordsetSubCategories); ?>">First&nbsp;&nbsp;&nbsp;</a>
            <?php } // Show if not first page ?>
          <?php if ($pageNum_RecordsetSubCategories > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_RecordsetSubCategories=%d%s", $currentPage, max(0, $pageNum_RecordsetSubCategories - 1), $queryString_RecordsetSubCategories); ?>">
            <?php if ($totalRows_RecordsetSubCategories > 0) { // Show if recordset not empty ?>
              Previous
              <?php } // Show if recordset not empty ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
            <?php } // Show if not first page ?>
          <?php if ($pageNum_RecordsetSubCategories < $totalPages_RecordsetSubCategories) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_RecordsetSubCategories=%d%s", $currentPage, min($totalPages_RecordsetSubCategories, $pageNum_RecordsetSubCategories + 1), $queryString_RecordsetSubCategories); ?>">
            <?php if ($totalRows_RecordsetSubCategories > 0) { // Show if recordset not empty ?>
              Next
              <?php } // Show if recordset not empty ?>
            &nbsp;&nbsp;&nbsp;</a>
            <?php } // Show if not last page ?>
          <?php if ($pageNum_RecordsetSubCategories < $totalPages_RecordsetSubCategories) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_RecordsetSubCategories=%d%s", $currentPage, $totalPages_RecordsetSubCategories, $queryString_RecordsetSubCategories); ?>">Last</a>
            <?php } // Show if not last page ?>
          
          <!--------------------paging section Ending---------------------------> 
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
        <?php if(isset($_SESSION['MM_Username'])&&($_SESSION['MM_Username']=='admin')){?>
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
mysql_free_result($RecordsetSubCategories);
?>
