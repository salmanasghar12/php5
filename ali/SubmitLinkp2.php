<?php require_once('Connections/seoExchangeDbConnection.php');
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}?>
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
}	////////////////////////////////////////////////////////////////////////////
?>
<?php 
 //Performing Server Side Form Validation IF JavaScript is Turned Off.
 $errors = array();
 $missing = array();
 if (isset($_POST['ButtonSubmit'])){
	 if (empty($_POST['TextBoxTitle'])){$missing['TextBoxTitle']=true;}
	 if (empty($_POST['TextBoxLink'])){$missing['TextBoxLink']=true;}
	 if (empty($_POST['DropdownListCategory2'])){$missing['DropdownListCategory2']=true;}
	 if (empty($_POST['TextareaDiscription'])){$missing['TextareaDiscription']=true;}
	 if (empty($_POST['TextBoxKeywords'])){$missing['TextBoxKeywords']=true;}
	 if (empty($_POST['TextBoxEmail'])){$missing['TextBoxEmail']=true;}
	 	else{	//Checks if email format is valid.
			if(!filter_var($_POST['TextBoxEmail'], FILTER_VALIDATE_EMAIL)){
				$errors['InvalidEmail']=true;
				}
			}
	if (empty($_POST['captchaValue'])){$missing['captchaValue']=true;}
	 	else{	//Checks if Entered Captcha is Wronge
			if($_POST['captchaValue'] != $_SESSION['randomnr2']){
				$errors['wrongCaptcha']=true;
				}
			}
			
	 if (empty($_POST['CheckBoxAgreement'])){$missing['CheckBoxAgreement']=true;}
	 
	 }
 ////////////////////////////////////////////////////////////////////////////
 ?>
<?php
//////////////// getting category id from category table, id will be used assigning id of category of link
if (isset($_POST['ButtonSubmit'])){
	 if ((count($missing)==0)&&(count($errors)==0)){ 
mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
$query_RecordsetCatID = sprintf("SELECT category.id FROM category WHERE category.name = %s LIMIT 1", GetSQLValueString($_POST['TextBoxCategory'], "text"));
$RecordsetCatID = mysql_query($query_RecordsetCatID, $seoExchangeDbConnection) or die(mysql_error());
$row_RecordsetCatID = mysql_fetch_assoc($RecordsetCatID);
$totalRows_RecordsetCatID = mysql_num_rows($RecordsetCatID);
////////////////////////////////////////////////////////////////



////// getting SubCategory id from SubCategory table, id will be used assigning id of Subcategory of link
mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
$query_RecordsetSubCatID = sprintf("SELECT subcategory.id FROM subcategory WHERE subcategory.Name = %s LIMIT 1", GetSQLValueString($_POST['DropdownListCategory2'], "text"));
$RecordsetSubCatID = mysql_query($query_RecordsetSubCatID, $seoExchangeDbConnection) or die(mysql_error());
$row_RecordsetSubCatID = mysql_fetch_assoc($RecordsetSubCatID);
$totalRows_RecordsetSubCatID = mysql_num_rows($RecordsetSubCatID);
////////////////////////////////////////////////////////////////////////////



/////// inserting link into links table////////////////////////
if (isset($_SESSION['MM_UserId'])){
	///// if user is logged, then we will assign id of user to user field in links table///////////////
$insertLinkSQL = sprintf("INSERT INTO links (title, link, category, subcatgory, discription, keywords, email, isFeatured, user) VALUES (%s, %s, %s, %s, %s, %s, %s, 0, %s)",
                       GetSQLValueString($_POST['TextBoxTitle'], "text"),
                       GetSQLValueString($_POST['TextBoxLink'], "text"),
					   GetSQLValueString($row_RecordsetCatID['id'], "int"),
                       GetSQLValueString($row_RecordsetSubCatID['id'], "int"),
                       GetSQLValueString($_POST['TextareaDiscription'], "text"),
                       GetSQLValueString($_POST['TextBoxKeywords'], "text"),
                       GetSQLValueString($_POST['TextBoxEmail'], "text"),
					    GetSQLValueString($_SESSION['MM_UserId'], "int"));

  mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
  $Result1 = mysql_query($insertLinkSQL, $seoExchangeDbConnection) or die(mysql_error());
	if (isset($Result1)){header('location: SubmitLinkp3.php');}
}////////////////////////////////////////////////////////////////////////////


	else{///// else if above condition goes wrong then user field will remain null in links table///////
$insertLinkSQL = sprintf("INSERT INTO links (title, link, category, subcatgory, discription, keywords, email, isFeatured) VALUES (%s, %s, %s, %s, %s, %s, %s, 0)",
                       GetSQLValueString($_POST['TextBoxTitle'], "text"),
                       GetSQLValueString($_POST['TextBoxLink'], "text"),
					   GetSQLValueString($row_RecordsetCatID['id'], "int"),
                       GetSQLValueString($row_RecordsetSubCatID['id'], "int"),
                       GetSQLValueString($_POST['TextareaDiscription'], "text"),
                       GetSQLValueString($_POST['TextBoxKeywords'], "text"),
                       GetSQLValueString($_POST['TextBoxEmail'], "text"));

  mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
  $Result1 = mysql_query($insertLinkSQL, $seoExchangeDbConnection) or die(mysql_error());
  if (isset($Result1)){header('location: SubmitLinkp3.php');}
	}
	 }
	 }////////////////////////////////////////////////////////////////////////////



			////////// getting id and name of subcategory using inner join //////////////////////
mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
$query_RecordsetSubCategories = sprintf("SELECT subcategory.id, subcategory.Name FROM subcategory INNER JOIN category ON subcategory.id=category.subcategory WHERE category.Name = %s", GetSQLValueString($_POST['DropdownListCategory'], "text"));
$RecordsetSubCategories = mysql_query($query_RecordsetSubCategories, $seoExchangeDbConnection) or die(mysql_error());
$row_RecordsetSubCategories = mysql_fetch_assoc($RecordsetSubCategories);
$totalRows_RecordsetSubCategories = mysql_num_rows($RecordsetSubCategories);
 //////////////////////////////////////////////////////////////////////////////////////////////////
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
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
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
            <?php /////// displaying user account if user is logged
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
            <h1>Submit Link: </h1>
            <?php ///if insert record returns true it will show a message on page
			if(isset ($Result1))
		  echo "<span style=\"color:#F00\">Your Link Submitted Successfully !</span>";
		  ?>
            <form id="LinkSubmitForm" name="LinkSubmitForm" 
            method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
              <table width="701" height="336">
                <tr>
                  <td width="154"></td>
                  <td width="535">
                  <input name="TextBoxTitle" type="hidden" id="TextBoxTitle" 
                  value="<?php echo $_POST['TextBoxTitle']?>" size="30"
				  <?php if((count($missing)>0)||(count($errors)>0)){
					  echo "value=\"".$_POST['TextBoxTitle']."\"";}
				  //Restoring Previous Value if Any errors 	or Missing are there....?>/>
                  
                    <?php if(isset($missing['TextBoxTitle'])){echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?>
                    <input name="TextBoxLink" type="hidden" id="TextBoxLink" size="30" value="<?php echo $_POST['TextBoxLink']?>"
                  <?php if((count($missing)>0)||(count($errors)>0)){echo "value=\"".$_POST['TextBoxLink']."\"";}
				  //Restoring Previous Value if Any errors 	or Missing are there....?>
                  />
                    <?php if(isset($missing['TextBoxLink'])){echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?>
                    <input name="TextBoxCategory" type="hidden" id="TextBoxCategory" size="30"  
                  value="<?php if ((count($missing)==0)&&(count($errors)==0)){echo $_POST['DropdownListCategory'];}
				  		else{echo $_POST['TextBoxCategory'];}//Restoring Previous Value if Any errors 	or Missing are there....
				  ?>"/>
                    <?php if(isset($missing['TextBoxCategory'])){echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?></td>
                </tr>
                <tr>
                  <td><h4>Sub-Category:</h4></td>
                  <td><select name="DropdownListCategory2" id="DropdownListCategory2">
                      <?php if((count($missing)>0)||(count($errors)>0)){?>
                      <option value="<?php echo $_POST['DropdownListCategory2']?>"> <?php echo $_POST['DropdownListCategory2']?></option>
                      <?php }?>
                      <option value="">Please Choose One</option>
                      <?php
					do {  ?>
                      <option value="<?php echo $row_RecordsetSubCategories['Name']?>"> <?php echo $row_RecordsetSubCategories['Name']?></option>
                      <?php  /// retriveing values of subcategory into dropdown list from RecordsetSubCategories
					} while ($row_RecordsetSubCategories = mysql_fetch_assoc($RecordsetSubCategories));
  						$rows = mysql_num_rows($RecordsetSubCategories);
  					if($rows > 0) {
      					mysql_data_seek($RecordsetSubCategories, 0);
	  					$row_RecordsetSubCategories = mysql_fetch_assoc($RecordsetSubCategories);
  						}?>
                    </select>
                    <?php if(isset($missing['DropdownListCategory2'])){echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?></td>
                </tr>
                <tr>
                  <td><h4>Discription:</h4></td>
                  <td><span id="sprytextareaDiscription">
                    <textarea name="TextareaDiscription" id="TextareaDiscription" cols="35" rows="5"  
                  ><?php if((count($missing)>0)||(count($errors)>0)){
					  echo $_POST['TextareaDiscription'];}
				  //Restoring Previous Value if Any errors 	or Missing are there....?>
</textarea>
                    <?php if(isset($missing['TextareaDiscription'])){echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?>
                    <span class="textareaRequiredMsg">Provide some discription.</span></span></td>
                </tr>
                <tr>
                  <td><h4>Keywords:</h4></td>
                  <td><span id="sprytextfieldKeywords">
                    <input name="TextBoxKeywords" type="text" id="TextBoxKeywords" size="30" 
                  <?php if((count($missing)>0)||(count($errors)>0)){
					  echo "value=\"".$_POST['TextBoxKeywords']."\"";}
				  //Restoring Previous Value if Any errors 	or Missing are there....?>
                  />
                    <?php if(isset($missing['TextBoxKeywords'])){
					  echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?>
                    <span class="textfieldRequiredMsg">Some Keywords  are required.</span></span></td>
                </tr>
                <tr>
                  <td><h4>Email:</h4></td>
                  <td><span id="sprytextfieldEmail">
                    <input name="TextBoxEmail" type="text" id="TextBoxEmail" size="30" 
                  <?php if((count($missing)>0)||(count($errors)>0)){
					  echo "value=\"".$_POST['TextBoxEmail']."\"";}
				  //Restoring Previous Value if Any errors 	or Missing are there....?>
                  />
                    <?php if(isset($missing['TextBoxEmail'])){
					  echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?>
                    <?php if(isset($errors['InvalidEmail'])){
					  echo "<span style=\"color:#F00\">Invalid format.</span>";}//Display Error Message.?>
                    <span class="textfieldRequiredMsg">Email is Required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
                </tr>
                <tr>
                  <td><h4>Captcha:</h4></td>
                  <td><img src="capcha/Captcha.php" /></td>
                </tr>
                <tr>
                  <td><h4>Enter Above Captcha:</h4></td>
                  <td><input type="text" name="captchaValue" id="captchaValue" />
                    <?php if(isset($missing['captchaValue'])){echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?>
                    <?php if(isset($errors['wrongCaptcha'])){echo "<span style=\"color:#F00\">Captcha Value Incorrect!.</span>";}//Display Error Message.?></td>
                </tr>
                <tr>
                  <td height="32" align="center"><span id="sprycheckboxAgreement">
                    <input type="checkbox" name="CheckBoxAgreement" id="CheckBoxAgreement" />
                    <span class="checkboxRequiredMsg">*.</span></span></td>
                  <td>I Agree to the <a href="/LinkSubmitRules.php">Link Submission Rules</a>
                    <?php if(isset($missing['CheckBoxAgreement'])){echo "<span style=\"color:#F00\">Agreement is Required.</span>";}//Display Error Message.?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><p>
                      <input name="ButtonSubmit" type="submit" class="Button" id="ButtonSubmit" value="Submit" />
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



var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextareaDiscription");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfieldKeywords");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfieldEmail", "email");
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("sprycheckboxAgreement");
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
mysql_free_result($RecordsetSubCategories);
?>
