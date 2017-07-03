<html>
<!---AIM: To create form to add services to the host -->
<!-- Save this file at location: /var/www/html/htmlservices.php-->
	<body>
	<!--formservices to add the service to specific host -->
	<form action="formservices.php" method="post">
		<br><br>
		Name:&nbsp&nbsp <input type="text" name="hostname" placeholder="HostName"/>
		<br><br>
		<!--Dropdown menu to: Select service which you want to add-->
		Service: <select name="service">
			<option value="Current Load">Current Load</option>
			<option value="Total Processes">Total Processes</option>
			<option value="Current Users">Current Users</option>
			<option value="Root Partition">Root Partition</option>
		</select>
		<br><br>
		<input type="submit" value="Submit!!">
	</form>
	</body>
	
</html>
