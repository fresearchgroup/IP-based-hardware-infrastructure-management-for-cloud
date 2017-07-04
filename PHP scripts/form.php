<?php
	//AIM:	ADD HOST TO NAGIOS CORE
	//Save this file at location: /var/www/html/form.php
?>

<html>
<body>


<?php 
	//Changing permission for directory object and files nagios.cfg and host.cfg
	shell_exec('chmod 777 /usr/local/nagios/etc/objects');	
	shell_exec('chmod 777 /usr/local/nagios/etc/nagios.cfg');
	shell_exec('chmod 777 /usr/local/nagios/etc/objects/host.cfg');
	
	#chdir = change directory
	chdir('/usr/local/nagios/etc/objects');	
	
	#new variable to add '.cfg' extension
	#$file_name.cfg will be the config file of new host
	$file_name = $_POST["name"].'.cfg';
	
	#To remove space in file name
	$file_name = str_replace(' ', '', $file_name);
	$display = $file_name." successfully added.  Restart nagios deamon to reflect changes";
	
	#shell command to create an empty file
	shell_exec('touch ${$file_name}');
	
	#shell command to change permission
	shell_exec('chmod 777 ${$file_name}');
	
	echo $display;

	$myfile = fopen("{$file_name}", "w")  or die("Unable to open file!");
	#To add details of host in $file_name.cfg. And adding PING as a default service
	$to_write= 	"define host{
								use			 generic-host	
								host_name    ".$_POST["name"].
								"\nalias "	  .$_POST["name"].
								"\naddress   ".$_POST["ip"].
								"\nmax_check_attempts              3              
				}


				define service{
        						use                  		generic-service         
        						host_name "                 .$_POST["name"].
       							"\nservice_description      PING
								check_command				check_ping!100.0,20%!500.0,60%
        		}";


     
	fwrite($myfile, $to_write);	
	fclose($myfile);

	#Adding the location of $file_name.cfg in nagios 
	chdir('/usr/local/nagios/etc');
	$myfile = fopen("nagios.cfg", "a")  or die("Unable to open file!");
	$to_write= "\ncfg_file=/usr/local/nagios/etc/objects/".$file_name."\n";
	fwrite($myfile,$to_write);	
	fclose($myfile);

?>
<a href="http://10.129.26.133/nagios/main.php">Home Page</a>
</body>
</html> 
