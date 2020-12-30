<?php require_once('Connections/seoExchangeDbConnection.php'); ?>
<?php require_once("./pr.php"); ?>
<?php

//initialize the session
if (!isset($_SESSION)) {
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
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_RecordsetSearch = 10;
$pageNum_RecordsetSearch = 0;
if (isset($_GET['pageNum_RecordsetSearch'])) {
  $pageNum_RecordsetSearch = $_GET['pageNum_RecordsetSearch'];
}
$startRow_RecordsetSearch = $pageNum_RecordsetSearch * $maxRows_RecordsetSearch;

$colname_RecordsetSearch = "-1";
if((isset($_GET['searchField']))&&(!empty($_GET['searchField']))) {
  $colname_RecordsetSearch = $_GET['searchField'];
}


mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);

$query_RecordsetSearch = sprintf("SELECT * FROM links WHERE title LIKE %s OR link LIKE %s OR discription LIKE %s OR keywords LIKE %s", GetSQLValueString("%" . $colname_RecordsetSearch . "%", "text"), GetSQLValueString("%" . $colname_RecordsetSearch . "%", "text"), GetSQLValueString("%" . $colname_RecordsetSearch . "%", "text"), GetSQLValueString("%" . $colname_RecordsetSearch . "%", "text"));
$query_limit_RecordsetSearch = sprintf("%s LIMIT %d, %d", $query_RecordsetSearch, $startRow_RecordsetSearch, $maxRows_RecordsetSearch);
$RecordsetSearch = mysql_query($query_limit_RecordsetSearch, $seoExchangeDbConnection) or die(mysql_error());
$row_RecordsetSearch = mysql_fetch_assoc($RecordsetSearch);

if (isset($_GET['totalRows_RecordsetSearch'])) {
  $totalRows_RecordsetSearch = $_GET['totalRows_RecordsetSearch'];
} else {
  $all_RecordsetSearch = mysql_query($query_RecordsetSearch);
  $totalRows_RecordsetSearch = mysql_num_rows($all_RecordsetSearch);
}
$totalPages_RecordsetSearch = ceil($totalRows_RecordsetSearch/$maxRows_RecordsetSearch)-1;

$queryString_RecordsetSearch = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecordsetSearch") == false && 
        stristr($param, "totalRows_RecordsetSearch") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecordsetSearch = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RecordsetSearch = sprintf("&totalRows_RecordsetSearch=%d%s", $totalRows_RecordsetSearch, $queryString_RecordsetSearch);


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
<div id="container" style="height:1400px">
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
            <a href="/LinkDirectory.php">
            <li>Browse Links Directory</li>
            </a> <a href="/SubmitLink.php">
            <li>Submit Link - Free</li>
            </a> <a href="/ExchangeLink.php">
            <li>Exchange Link</li>
            </a> <a href="/AddFeatured.php">
            <li>Add Featured Links</li>
            </a> <a href="/login.php">
            <li>Login</li>
            </a> <a href="/Signup.php">
            <li>Register</li>
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
            <a href="/HowToSubmitLink.php">
            <li>How to Submit a link</li>
            </a> <a href="/HowToExchange.php">
            <li>How to Exchange link</li>
            </a> <a href="/HowToManage.php">
            <li>Managing Exchanged links</li>
            </a> <a href="/Tips.php">
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
            <a href="/LinkSubmitRules.php">
            <li>Link Submittion Rules</li>
            </a> <a href="/LinkExchangeRules.php">
            <li>Link Exchange Rules</li>
            </a> <a href="/Privacy.php">
            <li>Privacy Policy</li>
            </a>
          </ul>
        </div>
        <!--panelBody ending div--> 
      </div>
      <!--panel ending div--> 
      <!--<label for="searchbar"></label>--> 
    </div>
    <!--sidebar ending div. -->
    <div id="content" style="height:1101px">
      <div class="panel">
        <div class="panelBody">
          <?php if((isset($_GET['searchField']))&&(!empty($_GET['searchField']))){
			  echo "<h2>Search Result for &quot;".$_GET['searchField']."&quot;.....</h2>";}
			  else{echo 'Search Field Empty, Please Enter a Search Query.';}
			  ?>
          <?php do { if ($row_RecordsetSearch){?>
          <?php do { ?>
            <table width="719" style=" border: solid 1px lightgray;
    border-radius: 5px;
    margin: 5px;
    padding: 5px;">
              <tr>
                <td width="99" height="18" align="left" valign="top" class="linksStyle">&nbsp;PR:
                  <?php
			$grc= new GooglePageRankChecker();
			$pr = $grc->getRank($row_RecordsetSearch['link']);
			 echo $pr; /*$grc->getRank($row_RecordsetSearch['link']);*/ ?></td>
                <td width="289" height="18" align="left" valign="top" class="linksStyle"><?php echo $row_RecordsetSearch['title']; ?></td>
                <td width="309" height="18" align="left" valign="top" class="linksStyle"><?php echo "<a href=\"".$row_RecordsetSearch['link']."\" target=\"_blank\">".$row_RecordsetSearch['link']."</a>"; ?></td>
              </tr>
              <tr>
                <td height="50" valign="top"><?php
			/*$grc= new GooglePageRankChecker();*/
			 echo "<img src="."images/pr_".$pr/*$grc->getRank($row_RecordsetSearch['link'])*/.".jpg"." />"; ?></td>
                <td height="50" colspan="2" align="left" valign="top"><?php echo $row_RecordsetSearch['discription']; ?><a href="linkDetails.php?id=<?php echo  $row_RecordsetSearch['id'];?>">&nbsp;&nbsp;More...</a></td>
              </tr>
            </table>
            <?php } while ($row_RecordsetSearch = mysql_fetch_assoc($RecordsetSearch)); ?>
          <?php }
		  else {echo "No Links found...";}
		   } while ($row_RecordsetSearch = mysql_fetch_assoc($RecordsetSearch)); ?>
           
          <!-------------------PAGING SECTION------------------------------------>
          <?php if ($pageNum_RecordsetSearch > 0) { // Show if not first page ?>
            <?php if ($totalRows_RecordsetSearch > 0) { // Show if recordset not empty ?>
              <a href="<?php printf("%s?pageNum_RecordsetSearch=%d%s", $currentPage, 0, $queryString_RecordsetSearch); ?>">First&nbsp;&nbsp;&nbsp;</a>
              <?php } // Show if recordset not empty ?>
            <?php } // Show if not first page ?>
          <?php if ($pageNum_RecordsetSearch > 0) { // Show if not first page ?>
            <?php if ($totalRows_RecordsetSearch > 0) { // Show if recordset not empty ?>
              <a href="<?php printf("%s?pageNum_RecordsetSearch=%d%s", $currentPage, max(0, $pageNum_RecordsetSearch - 1), $queryString_RecordsetSearch); ?>">Previous&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
              <?php } // Show if recordset not empty ?>
            <?php } // Show if not first page ?>
          <?php if ($pageNum_RecordsetSearch < $totalPages_RecordsetSearch) { // Show if not last page ?>
            <?php if ($totalRows_RecordsetSearch > 0) { // Show if recordset not empty ?>
              <a href="<?php printf("%s?pageNum_RecordsetSearch=%d%s", $currentPage, min($totalPages_RecordsetSearch, $pageNum_RecordsetSearch + 1), $queryString_RecordsetSearch); ?>">Next&nbsp;&nbsp;&nbsp;</a>
              <?php } // Show if recordset not empty ?>
            <?php } // Show if not last page ?>
          <?php if ($pageNum_RecordsetSearch < $totalPages_RecordsetSearch) { // Show if not last page ?>
            <?php if ($totalRows_RecordsetSearch > 0) { // Show if recordset not empty ?>
              <a href="<?php printf("%s?pageNum_RecordsetSearch=%d%s", $currentPage, $totalPages_RecordsetSearch, $queryString_RecordsetSearch); ?>">Last </a>
              <?php } // Show if recordset not empty ?>
            <?php } // Show if not last page ?>
            <!-------------------PAGING SECTION------------------------------------>
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
mysql_free_result($RecordsetSearch);
?>
