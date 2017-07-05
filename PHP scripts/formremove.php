<html>
<body>

<?php 
	# This program is free software; you can redistribute it and/or modify it under
	# the terms of the GNU General Public License as published by the Free Software
	# Foundation;
	# AIM: TO REMOVE ALREADY ADDED HOST FROM NAGIOS 
	# SAVE THIS FILE AT LOCATION: /var/www/html/formremove.php
	
	
	
	
	#chdir = change directory
	chdir('/usr/local/nagios/etc/objects');

	#new variable to add '.cfg' extension
	$file_name = $_POST["hostname"].'.cfg';
	
	#To check wheather the host exist or not 
	if(file_exists($file_name) != 1){
		echo "Invalid Hostname ";
		
	}
	else{
		#To remove .cfg file of host 
		shell_exec('rm -f ${$file_name}');
		chdir('/usr/local/nagios/etc');

		shell_exec('chmod 777 nagios.cfg');
		$myfile = fopen("nagios.cfg","r+") or die("File not found");
		
		$to_match = "cfg_file=/usr/local/nagios/etc/objects/{$file_name}\n";
	
		fseek($myfile, 0);
		$start = $myfile;
		$size = 0;
		//To itterate to the position in the file where location of $file_name.cfg is added
		while (($line = fgets($myfile)) !== false) {
   	     
    		if($line == $to_match){
    			fseek($myfile, $size);
    			//comment that line
    			fwrite($myfile,"#");
    			fclose($myfile);
    			break;
    		}
    		
    		$size += strlen($line);    	
    	}
	
	}

?>
<a href="http://10.129.26.133/nagios/main.php">Home Page</a>
	
</body>
</html>
