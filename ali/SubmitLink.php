<?php require_once('Connections/seoExchangeDbConnection.php'); ?>
<?php
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
///////////////////////////////////////////////////////////////////////////////////////

//////////////// getting Unique Category Names from category table////////////////////////////

mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
$query_RecordsetCategories = "SELECT DISTINCT category.name FROM category ORDER BY category.name";
$RecordsetCategories = mysql_query($query_RecordsetCategories, $seoExchangeDbConnection) or die(mysql_error());
$row_RecordsetCategories = mysql_fetch_assoc($RecordsetCategories);
$totalRows_RecordsetCategories = mysql_num_rows($RecordsetCategories);

//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
	if(isset($_POST['ButtonSubmit'])){
		///////// checking Captcha value//////////////////////
		if($_POST['captchaValue'] == $_SESSION['randomnr2']){
			$accept = "Your Link has been Submitted successively";
			}
			else {
				$error = "Entered Capthca code is not valid";
				}
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
<style type="text/css"></style>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#submit {
	margin-left: 20px;
}
</style>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="HeaderText">
  <p>Improve Ranking</p>
  <p style="text-indent:25px">Increase Traffic</p>
  <p style="text-indent:50px">Increase Revenue</p>
</div>
<div id="container" style="height:989px" >
  <div id="header">
    <div id="logo"> <a href="/index.php"><img src="images/Logo SEO Exchange.png" width="268" height="58" alt="seo Exchange Logo" longdesc="index.php" border="none;"/></a></div>
    <!--logo ending div. -->
    <div id="navbar">
      <ul id="MenuBar1" class="MenuBarHorizontal">
        <li><a href="/index.php">Home</a></li>
        <li><a href="/AboutUs.php">About Us</a></li>
        <li><a href="/LinkDirectory.php">Link Directory</a></li>
        <li><a href="/SubmitLink.php">Submit Link</a></li>
        <li><a href="/ExchangeLink.php">Exchange Link</a></li>
        <li><a href="/ContactUs.php">Contact Us</a></li>
        <li><a href="/Signup.php">Signup</a></li>
        <li><a href="/login.php">Login</a></li>
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
      <form id="Searchform" name="Searchform" method="post" action="Search.php">
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
    <div id="content" style="height:690px">
      <div class="panel">
        <div class="panelBody">
          <div id="submit">
            <h1>Submit Your Link:
              <?php if(!empty($accept)) {echo '     '.$accept;} ?>
            </h1>
            <p> All fields are must.</p>
            <form id="LinkSubmitForm" name="LinkSubmitForm" method="post" action="SubmitLinkp2.php" enctype="multipart/form-data">
              <table width="701" height="202">
                <tr>
                  <td width="154"><h4>Title:</h4></td>
                  <td width="535"><span id="sprytextfieldTitle">
                    <input name="TextBoxTitle" type="text" id="TextBoxTitle" size="30" />
                    <span class="textfieldRequiredMsg">Title is required.</span></span></td>
                </tr>
                <tr>
                  <td><h4>Website Link/URL:</h4></td>
                  <td><span id="sprytextfieldLink">
                    <input name="TextBoxLink" type="text" id="TextBoxLink" value="http://" size="30" />
                    <span class="textfieldRequiredMsg">A valid Link must be provide.</span><span class="textfieldInvalidFormatMsg">Invalid URL format.</span></span></td>
                </tr>
                <tr>
                  <td height="63"><h4>Category:</h4></td>
                  <td><span id="spryselectCategory">
                    <select name="DropdownListCategory" id="DropdownListCategory">
                      <option value="" selected="selected">Please Choose One</option>
                      <?php ///////////////// adding categories into menu from recordset Categories///////////
						do {  
								?>
                      <option value="<?php echo $row_RecordsetCategories['name']?>">
					  <?php echo $row_RecordsetCategories['name']?></option>
                      <?php
					} while ($row_RecordsetCategories = mysql_fetch_assoc($RecordsetCategories));
  					$rows = mysql_num_rows($RecordsetCategories);
  					if($rows > 0) {
     				 mysql_data_seek($RecordsetCategories, 0);
	  				$row_RecordsetCategories = mysql_fetch_assoc($RecordsetCategories);
 					 }////////////////////////////////////////////////////////////////////////////
					?>
                    </select>
                    <span class="selectRequiredMsg">Please select an item.</span></span></td>
                </tr>
                <tr>
                  <td height="33">&nbsp;</td>
                  <td><p>
                      <input name="ButtonNext" type="submit" class="Button" id="ButtonNext" value="Next" />
                    </p></td>
                </tr>
              </table>
            </form>
          </div>
          <!--submit div ending--> 
        </div>
        <!--panelBody ending div--> 
      </div>
      <!--panel ending div--> 
    </div>
    <script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfieldTitle");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfieldLink", "url");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselectCategory");
  </script> 
    <!--content ending div. --> 
  </div>
  <!--main ending div. -->
  
  <div id="footer">
    <div id="footnav">
      <ul>
        <a href="/index.php">
        <li>Home Page</li>
        </a> <a href="/LinkDirectory.php">
        <li>link directory</li>
        </a> <a href="/Privacy.php">
        <li>submit link</li>
        </a> <a href="/ExchangeLink.php">
        <li>exchange link</li>
        </a> <a href="/Signup.php">
        <li>signup</li>
        </a> <a href="/login.php">
        <li>Login</li>
        </a>
      </ul>
    </div>
    <!--footnav ending div. -->
    <div id="footcontent">
      <ul>
        <a href="/AboutUs.php">
        <li>About Us</li>
        </a> <a href="/ContactUs.php">
        <li>Contact Us</li>
        </a> <a href="/TermConditions.php">
        <li>Terms & Condition</li>
        </a> <a href="/Privacy.php">
        <li>Privacy Policy</li>
        </a> <a href="/index.php">
        <li>Sitemap</li>
        </a>
      </ul>
    </div>
    <!--footcontent ending div. --> 
    <!--	dynamically changing year-->
    <div id="copyright"> Copyright &copy; <?php echo date('Y');?> All Rights Reserved </div>
    <!--copright ending div. --> 
  </div>
  <!--footer ending div. --> 
</div>
<!--container ending div. --> 
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>
<?php
mysql_free_result($RecordsetCategories);
?>
