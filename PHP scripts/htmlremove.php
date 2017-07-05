
<html>
<!-- This program is free software; you can redistribute it and/or modify it under 
     the terms of the GNU General Public License as published by the Free Software
     Foundation;	
     AIM: FORM TO TAKE INPUT FOR HOST NAME WHICH USER WANT TO REMOVE FROM HOST 
     SAVE THIS FILE AT LOCATION: /var/www/html/htmlremove.php	-->

	<body>
	<!---formremove: php file to remove the host -->
	  <br><br>
	  <center><h4> Remove a Host </h4></center> 
	<form action="formremove.php" method="post">
		<br><br>
<center>
<div style="width:230px;height:120px;border:1px solid #000;">

<br>
		<font size="2"> Name:</font>&nbsp&nbsp <input type="text" name="hostname" placeholder="HostName"  style="width:150px;height:25px;" />
			
		<br><br>
		<center><input type="submit" value="Remove Host"></center>
	</div>
</center>

	</form>
	
	</body>
	
</html>

