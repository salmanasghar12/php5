<?php require_once('Connections/seoExchangeDbConnection.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
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
<?php
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
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_RecordsetLinks = 10;
$pageNum_RecordsetLinks = 0;
if (isset($_GET['pageNum_RecordsetLinks'])) {
  $pageNum_RecordsetLinks = $_GET['pageNum_RecordsetLinks'];
}
$startRow_RecordsetLinks = $pageNum_RecordsetLinks * $maxRows_RecordsetLinks;
//////////// getting all data from links table///////////////////////
mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
$query_RecordsetLinks = "SELECT * FROM links";
$query_limit_RecordsetLinks = sprintf("%s LIMIT %d, %d", $query_RecordsetLinks, $startRow_RecordsetLinks, $maxRows_RecordsetLinks);
$RecordsetLinks = mysql_query($query_limit_RecordsetLinks, $seoExchangeDbConnection) or die(mysql_error());
$row_RecordsetLinks = mysql_fetch_assoc($RecordsetLinks);

if (isset($_GET['totalRows_RecordsetLinks'])) {
  $totalRows_RecordsetLinks = $_GET['totalRows_RecordsetLinks'];
} else {
  $all_RecordsetLinks = mysql_query($query_RecordsetLinks);
  $totalRows_RecordsetLinks = mysql_num_rows($all_RecordsetLinks);
}
$totalPages_RecordsetLinks = ceil($totalRows_RecordsetLinks/$maxRows_RecordsetLinks)-1;

$queryString_RecordsetLinks = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecordsetLinks") == false && 
        stristr($param, "totalRows_RecordsetLinks") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecordsetLinks = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RecordsetLinks = sprintf("&totalRows_RecordsetLinks=%d%s", $totalRows_RecordsetLinks, $queryString_RecordsetLinks);
/////////////////////////Link Removal//////////////////////////////////////////////////////////

// we will check if $_GET['remove'] is set it means admin click on remove
// we will use id of link from $_GET['remove'] to remove desired link....
	if (isset($_GET['remove'])){
		// if true then 
		mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
$query_RecordsetRemoveLink = sprintf("DELETE FROM links WHERE id = %s", GetSQLValueString($_GET['remove'],"int"));
$RecordsetRemoveLink = mysql_query($query_RecordsetRemoveLink, $seoExchangeDbConnection) or die(mysql_error());
		unset($_GET['remove']);
		}
	////////////////////////////////////////////////////////////////////////////////////////////	
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
<div id="container" style="height:1080px">
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
      <a style='color:#F6F6F6' href="../admin.php">Admin Panel</a>
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
    <div id="content" style="height:781px">
      <div class="panel">
        <div class="panelBody">
          <?php if (isset($RecordsetRemoveLink)){echo "<p style=\"color:#F00\">Link Removed.</p>";}?>
          <h1>Remove a Link:</h1>
          <p>Showing All Links:</p>
          <p>Please select your desired link to remove.</p>
          <table width="698" style="margin: 15px">
            <tr>
              <td width="126"><h4>Title:</h4></td>
              <td width="181"><h4>Link:</h4></td>
              <td width="209"><h4>User Email:</h4></td>
              <td width="162"><h4>Action</h4></td>
            </tr>
          </table>
          <?php do { ?>
            <table width="698"style="margin: 15px;">
              <tr>
                <td width="128" height="25"><?php echo $row_RecordsetLinks['title']; ?></td>
                <td width="177"><?php echo "<a href=\"".$row_RecordsetLinks['link']."\" target=\"_blank\">".$row_RecordsetLinks['link']."</a>"; ?></td>
                <td width="209"><?php echo $row_RecordsetLinks['email']; ?></td>
                <td width="164"><a href="removeLink.admin.php?remove=<?php echo $row_RecordsetLinks['id'];?>">Remove</a></td>
              </tr>
            </table>
            <?php } while ($row_RecordsetLinks = mysql_fetch_assoc($RecordsetLinks)); ?>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <!--------------------paging section---------------------------------------->
          <?php if ($pageNum_RecordsetLinks > 0) { // Show if not first page ?>
            <?php if ($totalRows_RecordsetLinks > 0) { // Show if recordset not empty ?>
              <a href="<?php printf("%s?pageNum_RecordsetLinks=%d%s", $currentPage, 0, $queryString_RecordsetLinks); ?>">First&nbsp;&nbsp;&nbsp;</a>
              <?php } // Show if recordset not empty ?>
            <?php } // Show if not first page ?>
          <?php if ($totalRows_RecordsetLinks > 0) { // Show if recordset not empty ?>
            <?php if ($pageNum_RecordsetLinks > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_RecordsetLinks=%d%s", $currentPage, max(0, $pageNum_RecordsetLinks - 1), $queryString_RecordsetLinks); ?>">Previous&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
              <?php } // Show if not first page ?>
            <?php } // Show if recordset not empty ?>
          <?php if ($pageNum_RecordsetLinks < $totalPages_RecordsetLinks) { // Show if not last page ?>
            <?php if ($totalRows_RecordsetLinks > 0) { // Show if recordset not empty ?>
              <a href="<?php printf("%s?pageNum_RecordsetLinks=%d%s", $currentPage, min($totalPages_RecordsetLinks, $pageNum_RecordsetLinks + 1), $queryString_RecordsetLinks); ?>">Next&nbsp;&nbsp;&nbsp;</a>
              <?php } // Show if recordset not empty ?>
            <?php } // Show if not last page ?>
          <?php if ($pageNum_RecordsetLinks < $totalPages_RecordsetLinks) { // Show if not last page ?>
            <?php if ($totalRows_RecordsetLinks > 0) { // Show if recordset not empty ?>
              <a href="<?php printf("%s?pageNum_RecordsetLinks=%d%s", $currentPage, $totalPages_RecordsetLinks, $queryString_RecordsetLinks); ?>">Last </a>
              <?php } // Show if recordset not empty ?>
            <?php } // Show if not last page ?>
            <!--------------------paging section---------------------------------------->
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
mysql_free_result($RecordsetLinks);
?>
