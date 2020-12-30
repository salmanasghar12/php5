<?php require_once('Connections/seoExchangeDbConnection.php'); ?>
<?php require_once("./pr.php"); ?>
<?php if (!isset($_SESSION)) {	//Checks if User not Logged and sets a session variable LoginFirst as True.
  session_start();
	if (!isset($_SESSION['MM_Username'])){
		$_SESSION['LoginFirst']=true;
		}
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
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

if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM links WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
  $Result1 = mysql_query($deleteSQL, $seoExchangeDbConnection) or die(mysql_error());

  $deleteGoTo = "myLinks.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$maxRows_RecordsetMylinks = 5;
$pageNum_RecordsetMylinks = 0;
if (isset($_GET['pageNum_RecordsetMylinks'])) {
  $pageNum_RecordsetMylinks = $_GET['pageNum_RecordsetMylinks'];
}
$startRow_RecordsetMylinks = $pageNum_RecordsetMylinks * $maxRows_RecordsetMylinks;
/////////////// getting all current user submitted link from links table //////////////////////
mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
$query_RecordsetMylinks = sprintf("SELECT * FROM links WHERE links.`user` = %s", GetSQLValueString($_SESSION['MM_UserId'],"int"));
$query_limit_RecordsetMylinks = sprintf("%s LIMIT %d, %d", $query_RecordsetMylinks, $startRow_RecordsetMylinks, $maxRows_RecordsetMylinks);
$RecordsetMylinks = mysql_query($query_limit_RecordsetMylinks, $seoExchangeDbConnection) or die(mysql_error());
$row_RecordsetMylinks = mysql_fetch_assoc($RecordsetMylinks);
/////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_GET['totalRows_RecordsetMylinks'])) {
  $totalRows_RecordsetMylinks = $_GET['totalRows_RecordsetMylinks'];
} else {
  $all_RecordsetMylinks = mysql_query($query_RecordsetMylinks);
  $totalRows_RecordsetMylinks = mysql_num_rows($all_RecordsetMylinks);
}
$totalPages_RecordsetMylinks = ceil($totalRows_RecordsetMylinks/$maxRows_RecordsetMylinks)-1;

$queryString_RecordsetMylinks = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecordsetMylinks") == false && 
        stristr($param, "totalRows_RecordsetMylinks") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecordsetMylinks = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RecordsetMylinks = sprintf("&totalRows_RecordsetMylinks=%d%s", $totalRows_RecordsetMylinks, $queryString_RecordsetMylinks);


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
        <div class="panelHeading">user tasks</div>
        <!--panelHeading ending div-->
        <div class="panelBody">
          <ul>
            <?php  /////// displaying user info if user is logged
		  if (isset($_SESSION['MM_Username'])){?>
            <li><a href="../myAccount.php">My Account</a></li>
            <?php }?>
            <a href="myLinks.php">
            <li>My Links</li>
            </a> <a href="SubmitLink.php">
            <li>Add a Link</li>
            </a> <a href="MyExchangedLinks.php">
            <li>My Exchanged Links</li>
            </a> <a href="ExchangeLink.php">
            <li>Exchange a Link</li>
            </a> <a href="RemoveMyLink.php">
            <li>Remove My  Link</li>
            </a> <a href="AddFeatured.php">Add a Featured link</a>
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
        <div class="panelBody">
          <h1>My Submitted Links:</h1>
          <?php do { if ($row_RecordsetMylinks){?>
          <?php do { ?>
            <table width="693" style=" border: solid 1px lightgray;
    border-radius: 5px;
    margin: 5px;
    padding: 5px;">
              <tr>
                <td width="98" height="18" align="left" valign="top" class="linksStyle">&nbsp;PR:
                  <?php
			$grc= new GooglePageRankChecker();
			$pr =$grc->getRank($row_RecordsetMylinks['link']);
			 echo $pr; /*$grc->getRank($row_RecordsetMylinks['link']);*/ ?></td>
                <td width="291" height="18" align="left" valign="top" class="linksStyle"><?php echo $row_RecordsetMylinks['title']; ?></td>
                <td width="288" height="18" align="left" valign="top" class="linksStyle"><?php echo "<a href=\"".$row_RecordsetMylinks['link']."\" target=\"_blank\">".$row_RecordsetMylinks['link']."</a>"; ?></td>
              </tr>
              <tr>
                <td height="50" valign="top"><?php
				/*$grc= new GooglePageRankChecker();*/
			 echo "<img src="."images/pr_".$pr/*$grc->getRank($row_RecordsetMylinks['link'])*/.".jpg"." />"; ?></td>
                <td height="50" colspan="2" align="left" valign="top"><?php echo $row_RecordsetMylinks['discription']; ?><a href="linkDetails.php?id=<?php echo  $row_RecordsetMylinks['id'];?>">&nbsp;&nbsp;More...</a></td>
              </tr>
              <tr>
                <td height="15" valign="top">&nbsp;</td>
                <td height="15" colspan="2" align="right" valign="bottom"><a href="<?php echo "removeMyLink.php?id=".$row_RecordsetMylinks['id'].""; ?>">Remove Link</a></td>
              </tr>
            </table>
            <?php } while ($row_RecordsetMylinks = mysql_fetch_assoc($RecordsetMylinks)); ?>
          <?php }
	else {echo "No Links Found..";}
		} while ($row_RecordsetMylinks = mysql_fetch_assoc($RecordsetMylinks)); ?>
          <br />
          <!--------------------paging section---------------------------------------->
          <?php if ($totalRows_RecordsetMylinks > 0) { // Show if recordset not empty ?>
            <?php if ($pageNum_RecordsetMylinks > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_RecordsetMylinks=%d%s", $currentPage, 0, $queryString_RecordsetMylinks); ?>">First&nbsp;&nbsp;&nbsp;</a>
              <?php } // Show if not first page ?>
            <?php } // Show if recordset not empty ?>
          <?php if ($totalRows_RecordsetMylinks > 0) { // Show if recordset not empty ?>
            <?php if ($pageNum_RecordsetMylinks > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_RecordsetMylinks=%d%s", $currentPage, max(0, $pageNum_RecordsetMylinks - 1), $queryString_RecordsetMylinks); ?>">Previous&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a><a href="<?php printf("%s?pageNum_RecordsetMylinks=%d%s", $currentPage, max(0, $pageNum_RecordsetMylinks - 1), $queryString_RecordsetMylinks); ?>">Previous&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
              <?php } // Show if not first page ?>
            <?php } // Show if recordset not empty ?>
          <?php if ($totalRows_RecordsetMylinks > 0) { // Show if recordset not empty ?>
            <?php if ($pageNum_RecordsetMylinks < $totalPages_RecordsetMylinks) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_RecordsetMylinks=%d%s", $currentPage, min($totalPages_RecordsetMylinks, $pageNum_RecordsetMylinks + 1), $queryString_RecordsetMylinks); ?>">Next&nbsp;&nbsp;&nbsp;</a><a href="<?php printf("%s?pageNum_RecordsetMylinks=%d%s", $currentPage, min($totalPages_RecordsetMylinks, $pageNum_RecordsetMylinks + 1), $queryString_RecordsetMylinks); ?>">Next&nbsp;&nbsp;&nbsp;</a>
              <?php } // Show if not last page ?>
            <?php } // Show if recordset not empty ?>
          <?php if ($totalRows_RecordsetMylinks > 0) { // Show if recordset not empty ?>
            <?php if ($pageNum_RecordsetMylinks < $totalPages_RecordsetMylinks) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_RecordsetMylinks=%d%s", $currentPage, $totalPages_RecordsetMylinks, $queryString_RecordsetMylinks); ?>">Last </a>
              <?php } // Show if not last page ?>
            <?php } // Show if recordset not empty ?>
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
mysql_free_result($RecordsetMylinks);
?>
