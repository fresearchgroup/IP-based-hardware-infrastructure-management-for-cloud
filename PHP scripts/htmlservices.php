<html>
<!---AIM: To create form to add services to the host -->
<!-- Save this file at location: /var/www/html/htmlservices.php-->
	<body>
	<!--formservices to add the service to specific host -->
	  <br><br>
	  <center><h4> Add Sevice to a Host </h4></center> 
	<form action="formservices.php" method="post">
		<br><br>
<center>
<div style="width:230px;height:150px;border:1px solid #000;">

<br>
		<font size="2"> Name:</font>&nbsp&nbsp <input type="text" name="hostname" placeholder="HostName"  style="width:150px;height:25px;" />
		<!--Dropdown menu to: Select service which you want to add-->
			<br><br>
			
	<font size="2">Service:</font> <select name="service" style="width:150px;height:25px;">
				<option value="Current Load">Current Load</option>
			<option value="Total Processes">Total Processes</option>
			<option value="Current Users">Current Users</option>
			<option value="Root Partition">Root Partition</option>
		</select>
		
		<br><br>
		<center><input type="submit" value="Add Service"></center>
	</div>
</center>

	</form>
	
	</body>
	
</html>
