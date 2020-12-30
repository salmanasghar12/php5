<?php
session_start();

?>
<?php
  
	@ $db = new mysqli('localhost', 'root', '', 'hms');
	if (mysqli_connect_errno()) {
    echo 'Error: Could not connect to database.  Please try again later.';
    exit;
	}
	$query = "select * from customer_booking where cus_id='$_SESSION[cus_id]' ";
	$result = $db->query($query);
	$row = $result->fetch_assoc(); 
	?>

<?php
 if(isset($_POST['submit']))
	{
	    //$cus_id = $_POST['cus_id'];
	    $customer_name = $_POST['customer_name'];
		//$address = $_POST['address'];
		//$phn_no = $_POST['phn_no'];
		$rate_per_day = $_POST['rate_per_day'];
		$add_capacity = $_POST['add_capacity'];
		$capacity = $_POST['capacity'];
		$stay = $_POST['stay'];
		$subtotal = $rate_per_day*$stay;
		
		
		if($customer_name!=NULL)
		{
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "hms";

		try {
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// begin the transaction
			$conn->beginTransaction();
			// our SQL statememtns
			$conn->exec("INSERT INTO customer_booking(customer_name,rate_per_day,add_capacity,capacity,stay,subtotal )
			VALUES ('$customer_name','$rate_per_day','$add_capacity','$capacity','$stay','$subtotal')");
			
			
			
			
			// commit the transaction
			$conn->commit();
			echo "<script type = \"text/javascript\">
											alert(\"Insert Complete Successfully\");
											window.location = (\"print_invoice.php\")
											</script>"; 
			
			
			//echo '<a href="print_invoice.php" target="content"><center>PRINT INVOICE</a></center><BR><BR><BR>';
	      
			}
		catch(PDOException $e)
			{
			// roll back the transaction if something failed
			$conn->rollback();
			echo "<script>alert('Oops!something wrong.')</script>". $e->getMessage();
			}
		$conn = null;
		}
         else{
		
		
		
		
		} 
		
?>