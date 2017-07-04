<html>
<!---AIM: To create form to add services to the host -->
<!-- Save this file at location: /var/www/html/htmlservices.php-->
	<body>
	<!--formservices to add the service to specific host -->
	  <br><br>
	  <center><h4> Add a New Host </h4></center> 
	<form action="form.php" method="post">
		<br><br>
<center>
<div style="width:230px;height:150px;border:1px solid #000;">

<br>
		<font size="2"> Name:</font>&nbsp&nbsp <input type="text" name="hostname" placeholder="HostName"  style="width:150px;height:25px;" />
		<!--Dropdown menu to: Select service which you want to add-->
			<br><br>
			
	<font size="2">IP:</font> <input type="text" name="ip" placeholder="IP address" style="width:150px;height:25px;" />
				
		<br><br>
		<center><input type="submit" value="Add Host"></center>
	</div>
</center>

	</form>
	
	</body>
	
</html>
