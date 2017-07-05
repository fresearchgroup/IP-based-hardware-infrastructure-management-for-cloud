<html>
<body>


<?php 
	# This program is free software; you can redistribute it and/or modify it under
	# the terms of the GNU General Public License as published by the Free Software	
	# Foundation;
	# AIM: TO ADD SERVICE TO THE HOST 
	# SAVE THIS FILE AT LOCATION /var/www/html/formservices.php 
	
	
	
	
	#chdir = change directory
	chdir('/usr/local/nagios/etc/objects');

	#new variable to add '.cfg' extension
	$file_name = $_POST["hostname"].'.cfg';

	#To Check wheather the host exist or not. 
	if(file_exists($file_name) != 1){
		echo "Invalid Hostname ";
		
	}
	else{
		shell_exec('chmod 777 /usr/local/nagios/etc/objects/${$file_name}');
		$myfile = fopen("{$file_name}", "a")  or die("Invalid Hostname!");
		$sname = $_POST["service"];
		switch($sname){
			case "Current Users"  : $check_command="check_nrpe!check_users";
								  	break;
			case "Current Load"   : $check_command="check_nrpe!check_load";
								  	break;
			case "Root Partition" : $check_command="check_nrpe!check_disk";
									break;
			case "Total Processes": $check_command="check_nrpe!check_total_procs";
									break;
		}#end of switch
		#To define the service which we want to add
		$to_write= "\ndefine service{
        								use                             generic-service         
        								host_name  "                    .$_POST["hostname"].
        								"\nservice_description  "       .$_POST["service"]."
										check_command			{$check_command}
        			}";

        #Write the service in $file_name.cfg
		fwrite($myfile, $to_write);	
		fclose($myfile);
		echo "service successfully added";
	}
?>
<a href="http://10.129.26.133/nagios/main.php">Home Page</a>
</body>
</html> 
