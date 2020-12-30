<?php require_once('Connections/seoExchangeDbConnection.php'); ?>
<?php

if(!isset($_SESSION)){ 	// Redirect User to AlreadyLogged.php page if User Already Logged.
	session_start();
	if(isset($_SESSION['MM_Username'])){
		 header('Location: alreadyLogged.php');
		 }
	}
?>
<?php
	///////// function for getting SQL String value 
if (!function_exists("GetSQLValueString")) {
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
}////////////////////////////////////////////////////////////////////////////
?>
<?php 
 //Performing Server Side Form Validation IF JavaScript is Turned Off.
 $errors = array();
 $missing = array();
 if (isset($_POST['Button'])){
	 if (empty($_POST['UsernameTextBox'])){$missing['Username']=true;}
	 else{//Checks if Username Already Exist....
		   $loginUsername = $_POST['UsernameTextBox'];
  		$checkUserQuery = sprintf("SELECT username FROM users WHERE username=%s", GetSQLValueString($loginUsername, "text"));
  		mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
  		$LoginRS = mysql_query($checkUserQuery, $seoExchangeDbConnection) or die(mysql_error());
  		$loginFoundUser = mysql_num_rows($LoginRS);
		if ($loginFoundUser){$errors['UserExist']=true;}
		 }
	 
	 if (empty($_POST['EmailTextBox'])){$missing['Email']=true;}
	 	else{	//Checks if email format is valid.
			if(!filter_var($_POST['EmailTextBox'], FILTER_VALIDATE_EMAIL)){
				$errors['InvalidEmail']=true;
				}
			}
			
	 if (empty($_POST['ConfirmEmailTextBox'])){$missing['ConfirmEmail']=true;}
	 	else{	//Checks Case Insensitive comparision of both emails.
			if( strcasecmp($_POST['EmailTextBox'],$_POST['ConfirmEmailTextBox'])!= 0){
				$errors['ConfirmEmail']=true;
				}
			}
			
	 if (empty($_POST['PasswordTextBox'])){$missing['Password']=true;}
	 
	 if (empty($_POST['ConfirmPasswordTextBox'])){$missing['ConfirmPassword']=true;}
	 	else{ //Performs case sensitive Comparision on password fields.
			if(strcmp($_POST['PasswordTextBox'],$_POST['ConfirmPasswordTextBox'])!= 0){
				$errors['ConfirmPassword']=true;
				}
			}
			
	 if (empty($_POST['captchaValue'])){$missing['captchaValue']=true;}
	 	else{	//Checks if Entered Captcha is Wronge
			if($_POST['captchaValue'] != $_SESSION['randomnr2']){
				$errors['wrongCaptcha']=true;
				}
			}
			
	 if (empty($_POST['CheckBoxAgreement'])){$missing['CheckBox']=true;}
	 
	 }
 
 ?>
<?php if(isset($_POST['Button'])){ //checks if there are no errors of missing then insert data into database.
		if((count($missing)==0)&&(count($errors)==0)){
			

  $insertSQL = sprintf("INSERT INTO users (username, password, email) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['UsernameTextBox'], "text"),
                       GetSQLValueString($_POST['PasswordTextBox'], "text"),
                       GetSQLValueString($_POST['EmailTextBox'], "text"));

  mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
  $Result1 = mysql_query($insertSQL, $seoExchangeDbConnection) or die(mysql_error());
  if($Result1){
	  $queryResult='Registeration Successfull..!';
	  }

}
		}?>

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
<link href="Styles/login.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.panel .panelBody #login {
	position: absolute;
	width: 129px;
	top: 95px;
	left: 560px;
	padding: 20px;
	border-left: solid 1px darkGray;
	height: 265px;
}
.panelBody #singup {
	padding-left: 20px;
	width: 520px;
}
</style>
<link href="SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
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
        <div class="panelBody">
          <h1>User Registeration</h1>
          <?php 
         if(isset($queryResult)){
	  echo "<span style=\"color:#F00\">".$queryResult."</span>";
	  }?>
          <div id="singup">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" id="SignupForm" name="SignupForm" method="POST" enctype="multipart/form-data">
              <table width="529" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="146"><h4>Username:</h4></td>
                  <td width="383"><span id="sprytextfieldUsername"> <span id="spryUsernameTextBox">
                    <input name="UsernameTextBox" type="text" id="UsernameTextBox" size="30" 
		   <?php if((count($missing)>0)||(count($errors)>0)){
			   echo "value=\"".$_POST['UsernameTextBox']."\"";}//Restoring Previous Value if Any errors or Missing are there....?> />
                    <span class="textfieldRequiredMsg">A value is required.</span></span>
                    <?php if(isset($missing['Username'])){echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?>
                    <?php if(isset($errors['UserExist'])){echo "<span style=\"color:#F00\">Userneame Already Exist..</span>";}//Display Error Message.?>
                    <span class="textfieldRequiredMsg">Username  required.</span><span class="textfieldMaxCharsMsg">Exceeded maximum number of characters.</span></span></td>
                </tr>
                <tr>
                  <td><h4>Email:</h4></td>
                  <td><span id="sprytextfieldEmail"> <span id="spryEmailTextBox">
                    <label for="EmailTextBox"></label>
                    <input name="EmailTextBox" type="text" id="EmailTextBox" size="30" <?php if((count($missing)>0)||(count($errors)>0)){
			   echo "value=\"".$_POST['EmailTextBox']."\"";}//Restoring Previous Value if Any errors or Missing are there....?> />
                    <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
                    <?php if(isset($missing['Email'])){echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?>
                    <?php if(isset($errors['InvalidEmail'])){echo "<span style=\"color:#F00\">Invalid Email.</span>";}//Display Error Message.?>
                    <span class="textfieldRequiredMsg">Email Eequired.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span><span class="textfieldMaxCharsMsg">Exceeded maximum number of characters.</span></span></td>
                </tr>
                <tr>
                  <td><h4>Confirm Email:</h4></td>
                  <td><span id="spryconfirmEmail"> <span id="spryConfirmEmailTextBox">
                    <label for="ConfirmEmailTextBox"></label>
                    <input name="ConfirmEmailTextBox" type="text" id="ConfirmEmailTextBox" size="30" <?php if((count($missing)>0)||(count($errors)>0)){
			   echo "value=\"".$_POST['ConfirmEmailTextBox']."\"";}//Restoring Previous Value if Any errors or Missing are there....?> />
                    <span class="confirmRequiredMsg">A value is required.</span><span class="confirmInvalidMsg">Email don't match.</span></span>
                    <?php if(isset($missing['ConfirmEmail'])){echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?>
                    <?php if(isset($errors['ConfirmEmail'])){echo "<span style=\"color:#F00\">Email not Matched.</span>";}//Display Error Message.?>
                    <span class="confirmRequiredMsg">A value is required.</span><span class="confirmInvalidMsg">Email not matched.</span></span></td>
                </tr>
                <tr>
                  <td><h4>Password:</h4></td>
                  <td><span id="sprypassword1"> <span id="spryPasswordTextBox">
                    <label for="PasswordTextBox"></label>
                    <input name="PasswordTextBox" type="password" id="PasswordTextBox" size="30" <?php if((count($missing)>0)||(count($errors)>0)){
			   echo "value=\"".$_POST['PasswordTextBox']."\"";}//Restoring Previous Value if Any errors or Missing are there....?>/>
                    <span class="passwordRequiredMsg">A value is required.</span></span>
                    <?php if(isset($missing['Password'])){echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?>
                    <span class="passwordRequiredMsg">A Password is required.</span></span></td>
                </tr>
                <tr>
                  <td><h4>Re-Type Password:</h4></td>
                  <td><span id="spryconfirmPassword"> <span id="spryConfirmPasswordTextBox">
                    <label for="ConfirmPasswordTextBox"></label>
                    <input name="ConfirmPasswordTextBox" type="password" id="ConfirmPasswordTextBox" size="30" <?php if((count($missing)>0)||(count($errors)>0)){	echo "value=\"".$_POST['ConfirmPasswordTextBox']."\"";}//Restoring Previous Value if Any errors or Missing are there....?>/>
                    <span class="confirmRequiredMsg">A value is required.</span><span class="confirmInvalidMsg">Password don't match.</span></span>
                    <?php if(isset($missing['ConfirmPassword'])){echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?>
                    <?php if(isset($errors['ConfirmPassword'])){echo "<span style=\"color:#F00\">Password don't match.</span>";}//Display Error Message.?>
                    <span class="confirmRequiredMsg">A value is required.</span><span class="confirmInvalidMsg">Password don't match.</span></span></td>
                </tr>
                <tr>
                  <td><h4>Captcha:</h4></td>
                  <td><img src="capcha/Captcha.php"/></td>
                </tr>
                <tr>
                  <td><h4>Enter Captcha:</h4></td>
                  <td><span id="sprycaptchaValue">
                    <label for="captchaValue"></label>
                    <input name="captchaValue" type="text" id="captchaValue" size="30" <?php if((count($missing)>0)||(count($errors)>0)){echo "value=\"".$_POST['captchaValue']."\"";}//Restoring Previous Value if Any errors or Missing are there....?>/>
                    <span class="textfieldRequiredMsg">A value is required.</span></span>
                    <?php if(isset($missing['captchaValue'])){echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?>
                    <?php if(isset($errors['wrongCaptcha'])){echo "<span style=\"color:#F00\">Entered Captcha Invalid.</span>";}//Display Error Message.?></td>
                </tr>
                <tr>
                  <td><h4>Agree to the Terms of Service:</h4></td>
                  <td><span id="sprycheckbox1"> <span id="spryCheckBoxAgreement">
                    <input type="checkbox" name="CheckBoxAgreement" id="CheckBoxAgreement" />
                    <label for="CheckBoxAgreement"></label>
                    <span class="checkboxRequiredMsg">Agreement is Required.</span></span>
                    <?php if(isset($missing['CheckBox'])){echo "<span style=\"color:#F00\">Agreement is Required.</span>";}//Display Error Message.?>
                    <span class="checkboxRequiredMsg">Agreement is Required.</span></span></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input name="Button" type="submit" class="Button" id="Button" value="Signup" /></td>
                </tr>
              </table>
            </form>
          </div>
          <!--signup div ending-->
          <div id="login">
            <h3>Already Member:</h3>
            <p><a href="/login.php">Click Here for Login</a></p>
          </div>
          <!--login div ending--> 
        </div>
        <!--panelBody ending div--> 
      </div>
      <!--panel ending div--> 
    </div>
    <script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("spryUsernameTextBox");
var sprytextfield2 = new Spry.Widget.ValidationTextField("spryEmailTextBox", "email");
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryConfirmEmailTextBox", "EmailTextBox");
var sprypassword2 = new Spry.Widget.ValidationPassword("spryPasswordTextBox");
var spryconfirm2 = new Spry.Widget.ValidationConfirm("spryConfirmPasswordTextBox", "PasswordTextBox");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprycaptchaValue");
var sprycheckbox2 = new Spry.Widget.ValidationCheckbox("spryCheckBoxAgreement");
  </script><!--content ending div. --> 
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