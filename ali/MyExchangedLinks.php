<?php require_once('Connections/seoExchangeDbConnection.php'); ?>
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

$maxRows_RecordsetExchangedLinks = 2;
$pageNum_RecordsetExchangedLinks = 0;
if (isset($_GET['pageNum_RecordsetExchangedLinks'])) {
  $pageNum_RecordsetExchangedLinks = $_GET['pageNum_RecordsetExchangedLinks'];
}
$startRow_RecordsetExchangedLinks = $pageNum_RecordsetExchangedLinks * $maxRows_RecordsetExchangedLinks;

$colname_RecordsetExchangedLinks = "-1";
if (isset($_SESSION['MM_UserId'])) {
  $colname_RecordsetExchangedLinks = $_SESSION['MM_UserId'];
}
//// getting exchangedlinks by current user//////////////////////////
mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
$query_RecordsetExchangedLinks = sprintf("SELECT * FROM exchangedlinks WHERE user1 = %s OR user2 = %s", GetSQLValueString($colname_RecordsetExchangedLinks, "int"),GetSQLValueString($colname_RecordsetExchangedLinks, "int"));
$query_limit_RecordsetExchangedLinks = sprintf("%s LIMIT %d, %d", $query_RecordsetExchangedLinks, $startRow_RecordsetExchangedLinks, $maxRows_RecordsetExchangedLinks);
$RecordsetExchangedLinks = mysql_query($query_limit_RecordsetExchangedLinks, $seoExchangeDbConnection) or die(mysql_error());
$row_RecordsetExchangedLinks = mysql_fetch_assoc($RecordsetExchangedLinks);

if (isset($_GET['totalRows_RecordsetExchangedLinks'])) {
  $totalRows_RecordsetExchangedLinks = $_GET['totalRows_RecordsetExchangedLinks'];
} else {
  $all_RecordsetExchangedLinks = mysql_query($query_RecordsetExchangedLinks);
  $totalRows_RecordsetExchangedLinks = mysql_num_rows($all_RecordsetExchangedLinks);
}
$totalPages_RecordsetExchangedLinks = ceil($totalRows_RecordsetExchangedLinks/$maxRows_RecordsetExchangedLinks)-1;

$queryString_RecordsetExchangedLinks = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecordsetExchangedLinks") == false && 
        stristr($param, "totalRows_RecordsetExchangedLinks") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecordsetExchangedLinks = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RecordsetExchangedLinks = sprintf("&totalRows_RecordsetExchangedLinks=%d%s", $totalRows_RecordsetExchangedLinks, $queryString_RecordsetExchangedLinks);


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
<style type="text/css"></style>
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
<div id="container" style="height:1033px">
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
    <div id="content" style="height:734px">
      <div class="panel">
        <div class="panelBody">
          <h1>My Exchanged Links:</h1>
          <p>*Note: Dear User Since we don't have any type of mechanism to check wheather your partner has embedded your link to their website or not. So it is recommended to please visit your partner's Website regularly to check weather your link is there or not. </p>
          <?php do { if ($row_RecordsetExchangedLinks){?>
          <table width="663" 
          style=" border: solid 1px lightgray; border-radius: 5px; margin: 5px; padding: 5px;">
            <tr>
              <td width="139"><h4>My Link:</h4></td>
              <td width="508"><?php 
			  /////////////////////////////////////////////////////////////////
			  //in this part we check weather user1 is current user by comparing
			  // the id. if yes then link1 will be current user's link id.
			  // it will then, reterive the http link from links table in db and 
			  //displays as http link.
			  if ($row_RecordsetExchangedLinks['user1']== $_SESSION['MM_UserId'])
			  { $myLinkId = $row_RecordsetExchangedLinks['link1'];
			  mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
			  $query_RecordsetMyLinks = sprintf("SELECT link FROM links WHERE id = %s", 
			  GetSQLValueString($myLinkId, "int"));
			  $RecordsetMyLinks = mysql_query($query_RecordsetMyLinks,$seoExchangeDbConnection) or 
			  die(mysql_error());
			  $row_RecordsetMyLinks = mysql_fetch_assoc($RecordsetMyLinks);
			  echo "<a href=\"".$row_RecordsetMyLinks['link']
			  ."\" target=\"_blank\">".$row_RecordsetMyLinks['link']."</a>"; // Displaying Http Link
			  }
			  
			  else {/////////////////////////////////////////////////////////////////
			  // In this part, if the above condition goes wrong, then link2 will be the
			  // current user id and it will query data based on link2.
			  $myLinkId = $row_RecordsetExchangedLinks['link2'];
			  mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
			  $query_RecordsetMyLinks = sprintf("SELECT link FROM links WHERE id = %s", 
			  GetSQLValueString($myLinkId, "int"));
			  $RecordsetMyLinks = mysql_query($query_RecordsetMyLinks,$seoExchangeDbConnection) or 
			  die(mysql_error());
			  $row_RecordsetMyLinks = mysql_fetch_assoc($RecordsetMyLinks);
			  echo "<a href=\"".$row_RecordsetMyLinks['link']
			  ."\" target=\"_blank\">".$row_RecordsetMyLinks['link']."</a>"; // Displaying Http Link
			  }
			  ?></td>
            </tr>
            <tr>
              <td><h4>Partner's Link:</h4></td>
              <td><?php
			  /////////////////////////////////////////////////////////////////
			  //in this part we check weather user1 is current user by comparing
			  // the id. if yes then link2 will be our Partner user's link id.
			  // it will then, reterive the http link from links table in db and 
			  //displays as http link.
			  
			   if ($row_RecordsetExchangedLinks['user1']== $_SESSION['MM_UserId'])
			  {$myLinkId = $row_RecordsetExchangedLinks['link2'];
			  mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
			  $query_RecordsetMyLinks = sprintf("SELECT link FROM links WHERE id = %s", 
			  GetSQLValueString($myLinkId, "int"));
			  $RecordsetMyLinks = mysql_query($query_RecordsetMyLinks,$seoExchangeDbConnection) or 
			  die(mysql_error());
			  $row_RecordsetMyLinks = mysql_fetch_assoc($RecordsetMyLinks);
			  echo "<a href=\"".$row_RecordsetMyLinks['link']
			  ."\" target=\"_blank\">".$row_RecordsetMyLinks['link']."</a>"; // Displaying Http Link
			  }
			  
			  
			  else {/////////////////////////////////////////////////////////////////
			  // In this part, if the above condition goes wrong, then link1 will be the
			  // our Partner user id and it will query data based on link1.
			  $myLinkId = $row_RecordsetExchangedLinks['link1'];
			  mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
			  $query_RecordsetMyLinks = sprintf("SELECT link FROM links WHERE id = %s", 
			  GetSQLValueString($myLinkId, "int"));
			  $RecordsetMyLinks = mysql_query($query_RecordsetMyLinks,$seoExchangeDbConnection) or 
			  die(mysql_error());
			  $row_RecordsetMyLinks = mysql_fetch_assoc($RecordsetMyLinks);
			  echo "<a href=\"".$row_RecordsetMyLinks['link']
			  ."\" target=\"_blank\">".$row_RecordsetMyLinks['link']."</a>"; // Displaying Http Link
			  }?></td>
            </tr>
            <tr>
              <td><h4>Partner's Username:</h4></td>
              <td><?php
			  /////////////////////////////////////////////////////////////////////
			  //We check if user2 is current user then user1 will be our partner's user id
			  //and retrive our partner's username and email address from users table based on user1
			   if ($row_RecordsetExchangedLinks['user2'] == $_SESSION['MM_UserId'])
			  { mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
			  $query_RecordsetPartnerUser = sprintf("SELECT username, email FROM users WHERE id =%s", GetSQLValueString($row_RecordsetExchangedLinks['user1'], "int"));
			  $RecordsetPartnerUser = mysql_query($query_RecordsetPartnerUser, $seoExchangeDbConnection )
			  or die(mysql_error());
			  $row_RecordsetPartnerUser = mysql_fetch_assoc($RecordsetPartnerUser);
			   echo "<a href=\"\">".$row_RecordsetPartnerUser['username']."</a>"; // Displaying username
			   }
			   
			  else {//////////////////////////////////////////////////////////////////////////////
			  // if above condition goes wrong then user2 will be the id of our partner.
			  // and retrive user data from users table in db
			  mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
			  $query_RecordsetPartnerUser = sprintf("SELECT username, email FROM users WHERE id =%s", GetSQLValueString($row_RecordsetExchangedLinks['user2'], "int"));
			  $RecordsetPartnerUser = mysql_query($query_RecordsetPartnerUser, $seoExchangeDbConnection )
			  or die(mysql_error());
			  $row_RecordsetPartnerUser = mysql_fetch_assoc($RecordsetPartnerUser);
			  echo "<a href=\"\">".$row_RecordsetPartnerUser['username']."</a>"; // Displaying username
			  }?></td>
            </tr>
            <tr>
              <td><h4>Partner's Email:</h4></td>
              <td><?php
			  if (isset ($row_RecordsetPartnerUser['email'])){
				  echo "<a href=\"mailto:".$row_RecordsetPartnerUser['email']."\">".$row_RecordsetPartnerUser['email']."</a>"; // Displaying username
				  }?></td>
            </tr>
            <tr>
              <td><h4>Status:</h4></td>
              <td><?php 
			  if($row_RecordsetExchangedLinks['isValid']==1)
			  {echo "Active*";}
			  else {echo "Exchange may not be Active*";} ?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><a href="removeExchanged.php<?php echo"?id=".$row_RecordsetExchangedLinks['id']."&amp;status=".$row_RecordsetExchangedLinks['isValid']."&amp;partneremail=".$row_RecordsetPartnerUser['email']."&amp;mylink=".$row_RecordsetMyLinks['link'];?>">Remove</a></td>
            </tr>
          </table>
          <?php }
	else {echo "No Links Found..";}
	 } while ($row_RecordsetExchangedLinks = mysql_fetch_assoc($RecordsetExchangedLinks)); ?>
     <!------------------------paging section---------------------------------------------------->
          <?php if ($pageNum_RecordsetExchangedLinks > 0) { // Show if not first page ?>
            <?php if ($totalRows_RecordsetExchangedLinks > 0) { // Show if recordset not empty ?>
              <a href="<?php printf("%s?pageNum_RecordsetExchangedLinks=%d%s", $currentPage, 0, $queryString_RecordsetExchangedLinks); ?>">First&nbsp;&nbsp;&nbsp;</a>
              <?php } // Show if recordset not empty ?>
            <?php } // Show if not first page ?>
          <?php if ($pageNum_RecordsetExchangedLinks > 0) { // Show if not first page ?>
            <?php if ($totalRows_RecordsetExchangedLinks > 0) { // Show if recordset not empty ?>
              <a href="<?php printf("%s?pageNum_RecordsetExchangedLinks=%d%s", $currentPage, max(0, $pageNum_RecordsetExchangedLinks - 1), $queryString_RecordsetExchangedLinks); ?>">Previous&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
              <?php } // Show if recordset not empty ?>
            <?php } // Show if not first page ?>
          <?php if ($pageNum_RecordsetExchangedLinks < $totalPages_RecordsetExchangedLinks) { // Show if not last page ?>
            <?php if ($totalRows_RecordsetExchangedLinks > 0) { // Show if recordset not empty ?>
              <a href="<?php printf("%s?pageNum_RecordsetExchangedLinks=%d%s", $currentPage, min($totalPages_RecordsetExchangedLinks, $pageNum_RecordsetExchangedLinks + 1), $queryString_RecordsetExchangedLinks); ?>">Next&nbsp;&nbsp;&nbsp;</a>
              <?php } // Show if recordset not empty ?>
            <?php } // Show if not last page ?>
          <?php if ($pageNum_RecordsetExchangedLinks < $totalPages_RecordsetExchangedLinks) { // Show if not last page ?>
            <?php if ($totalRows_RecordsetExchangedLinks > 0) { // Show if recordset not empty ?>
              <a href="<?php printf("%s?pageNum_RecordsetExchangedLinks=%d%s", $currentPage, $totalPages_RecordsetExchangedLinks, $queryString_RecordsetExchangedLinks); ?>">Last </a>
              <?php } // Show if recordset not empty ?>
            <?php } // Show if not last page ?>
            <!------------------------paging section---------------------------------------------------->
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
        <?php  /////// displaying admin panel if user is admin
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
mysql_free_result($RecordsetExchangedLinks);
?>
