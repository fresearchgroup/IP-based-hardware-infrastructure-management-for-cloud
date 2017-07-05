<?php
	
	# This program is free software; you can redistribute it and/or modify it under
	# the terms of the GNU General Public License as published by the Free Software
	# Foundation;


	# To display the details of all the sensors of the server. These details are coming through IPMI and 
	# Nagios stores its information in status.dat present at /usr/local/nagio/var. 
	# To Get the details we use check_ipmi_sensor.pl present at /usr/local/nagios/libexec. 
	# The respective host of which we want to show details, its information is passed through URL. 
	# The changes for sending the name of the server are done in extinfo.c.  After every 60 seconds, this file get refreshed.

 $file = fopen("/usr/local/nagios/var/status.dat", "r") or exit("Unable to open file!"); //path to nagios file
 $serverName= $_SERVER['REQUEST_URI'];
 $serverName= substr($serverName,strpos($serverName,'?')+1, strlen($serverName) );
 $refreshvalue = 60; //value in seconds to refresh page
 
 $collastcheck=true; //true/false to show last checked date column in table
 $colhost=true; //true/false to show host column in table
 $colstatusinfo=true; //true/false to show status info/plugin info column in table
 $colservice=true; //true/false to show service type column column in table
 
 $pagetitle = "Nagios IPMI Dashboard";
 
 $thedate=date('Y-m-d H:i:s');
 $showthedate=false;
$temperature = array("SSB Therm Trip ", "SSB Temp", "P1 VRD Temp","P1 VRD Temp","P1 VRD Temp","LAN/BMC Temp","Front Temp","LAN NIC Temp","DIMM Thrm Mrgn 1","DIMM Thrm Mrgn 2","DIMM Thrm Mrgn 3","DIMM Thrm Mrgn 4");
$voltage= array("VR Watchdog ","Voltage Fault ","BB +3.3V Vbat","BB +12.0V","BB +5.0V");
$psecurity=array("Physical Scrty ");
$cpu=array("CATERR ","CPU Missing ");
$power=array("Pwr Unit Status ");  
$other=array("System Airflow");
$eventlog=array("System Event Log ");
$sysevent=array("System Event ");
$cint=array("FP NMI Diag Int ");
$button=array("Button ");
$watchdog=array("IPMI Watchdog ");
$syshealth=array("BMC FW Health ");
?>
		<html>
			<body>
	<meta http-equiv="refresh" content="<?php echo($refreshvalue); ?>">
 <title><?php echo($pagetitle); ?></title>
 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>				

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js" ></script>
			
		<title>Notes</title>
			
<style type="text/css">
body
{     
    margin:0px;
}
 
.boldtable, .boldtable TD, .boldtable TH
{
font-family:sans-serif;
font-size:8pt;
font-weight:bold;
color:black;
}
 
.c{ font-size:10pt;font-weight:bold;text-align: center}
 
</style> 
 
<form name=countdown class=c>
 
<?php echo($pagetitle); ?> - Refresh in <input type=text size=2 name=secs> <br>
<?php 
 if ($showthedate==true){
  echo($thedate); 
 }
?>
 
</form>
<br />
<center>
<font color="CRIMSON"><b>Crimson </font> - Critical</b> &nbsp;&nbsp;&nbsp;
<font color="GOLD"><b> Yellow </font> - Warning</b> &nbsp;&nbsp;&nbsp;
<font color="LIMEGREEN"><b>Green </font> - UP/OK</b> &nbsp;&nbsp;&nbsp;
<b><font color="GREY">Grey</font> - Unknown</b>
</center>
 
<script> 
 var milisec=0 
 var seconds=<?php echo($refreshvalue); ?> 
 document.countdown.secs.value='<?php echo($refreshvalue); ?>' 
 
function display(){ 
 if (milisec<=0){ 
    milisec=9 
    seconds-=1 
 } 
 if (seconds<=-1){ 
    milisec=0 
    seconds+=1 
 } 
 else 
    milisec-=1 
    document.countdown.secs.value=seconds+"."+milisec+"s"
    setTimeout("display()",100) 
} 
display() 
</script>  
 

<?php

function dashdisplay($dashstatus,$perarray){    

$length=sizeof($perarray);
$x=0;
 while($x<$length){
  if ($fontcolor!=""){
    echo("<tr bgcolor=\"$trcolor\">");
 
    if ($collastcheck==true){
     echo("<td><font color=\"$fontcolor\">".date("Y-m-d H:i:s",$dashdate)."</font></td>");
    }
 
    if ($colhost==true){
     if ($dashack==0){
      echo("<td><font color=\"$fontcolor\">server</font></td>");
     }elseif ($dashack==1){
      echo("<td bgcolor=\"$tdackcolor\"><font color=\"$fontcolor\">".$dashhost." (ACK)</font></td>");
     }
    }
 
   if ($colstatusinfo==true){
    echo("<td><font color=\"$fontcolor\">".$perarray[$x]."</font></td>");
   }
 
   if ($colservice==true){
   if ($dashservice==""){
     echo("<td><font color=\"$fontcolor\">HOST PING</font></td>");
    }else{
     echo("<td><font color=\"$fontcolor\">IPMI</font></td>");
    }
   }
   echo("</tr>");
  }
 
 echo("</font>");
 echo("</tr>");
  $x++;
  }
} //end display function

function stype($t){
	$sensortype="Missing";
	if (in_array($t,$temperature))
		$sensortype="Temperature";
	elseif (in_array($t,$voltage))
		$sensortype="Voltage";
	elseif (in_array($t,$psecurity))
		$sensortype="Physical Security";
	elseif (in_array($t,$cpu))
		$sensortype="CPU";
	elseif (in_array($t,$power))
		$sensortype="Power";
	elseif (in_array($t,$other))
		$sensortype="Other";
	elseif (in_array($t,$eventlog))
		$sensortype="Event log";
	elseif (in_array($t,$sysevent))
		$sensortype="Sys Event";
	elseif (in_array($t,$cint))
		$sensortype="Cint";
	elseif (in_array($t,$button))
		$sensortype="Button";
	elseif (in_array($t,$watchdog))
		$sensortype="Watch Dog";
	elseif (in_array($t,$syshealth))
		$sensortype="Sys health";
}
 
 //arrays for different fields in nagios status.dat
 $hostarray = array();
 $servicearray = array();
 $statearray = array();
 $checkarray = array();
 $ackarray = array();
 $pluginarray = array();
 $disarray = array();
 $perarray=array();
 //arrays for status of hosts/services
 $finaluparray = array();
 $finalwarnarray = array();
 $finalcritarray = array();
 $finaldisarray = array();
 $perarray=array();
 //field to check in nagios status.dat
 $hostname = 'host_name=';
 $servicedes = 'service_description=';
 $currstate = 'current_state=';
 $pluginout = 'plugin_output=';
 $lastcheck = 'last_check=';
 $ackcheck = 'been_acknowledged=';
 $discheck = 'active_checks_enabled=';
 $percheck= 'performance_data=';
 //counters for loops
 $hostcount = 0;
 $servicecount = 0;
 $currcount = 0;
 $plugcount = 0;
 $lastcount = 0;
 $discount = 0;
 $disttlcount = 0;
 $ackcount = 0;
 $ttlcount = 0;
 $check = 0;
 $okcount = 0;
 $warncount = 0;
 $critcount = 0;
 $count=1;
 $flag=0;


?>

                            <!-- START OF OUR TABLE DEFINITION -->
  <br /><br />

			
				<meta http-equiv="refresh" content="<?php echo($refreshvalue); ?>">
 				<title><?php echo($pagetitle); ?></title>

				<div>			
				
				
					<br/>
					<div class=" table-responsive col-lg-12" style="background-color:white">
						
						<!--<form method="POST" action="updateRanking.php"> -->
						<table  id="preTable" class="table table-striped" border="1" margin="1" >
						<thead>
							<tr>
								<th>SERVICE</th>
	<th>SENSOR TYPE</th>
      <th>READING</th>
      <th>NCT LOW</th>
      <th>NCT HIGH</th>
      <th>CT LOW</th>
      <th>CT HIGH</th>
      <th>STATUS</th>
							</tr>	
						</thead>
						<tbody>
							<?php

/* This loop takes each line from the status.dat file and extracts the required information */
while(!feof($file)){ //begin while through nagios status.dat
	  $line = fgets($file);
 	 //strpos to check for field line by line
 	 //plugpos takes the index of first encounter of string in pluginout - plugin output
  	 //currpos takes the index of first encounter of string in currstate - current state
	 $hostpos = strpos($line,$hostname);  	 
	$plugpos = strpos($line,$pluginout);
  	 $currpos = strpos($line,$currstate);
	  if ($hostpos!==false)
	 	$checkHostName=substr($line,strpos($line,'=')+1,strlen($line)); 
	  if ($plugpos!==false){
   		 $servicecount++;
		 //variable to check if we have encoutered IPMI service
    		 $checkIPMI = substr($line,strpos($line,'=')+1,4);
	     	 $check=1;
  	  }
	  //condition checks if IPMI service has been encountered
  	  if($checkIPMI == 'IPMI' && strpos($checkHostName,$serverName)!==false)
  	  { 
  		  /*If we have encountered plugin_output in the satus.dat file for IPMI, our required data is
    		  after 2 line to this line, hence we next input the next two lines.  
     		*/
    		$line = fgets($file);
	 	$temp2=substr($line,strpos($line,'=')+1,strlen($line));  //long plugin output
		
		while($temp2){
        		$end=0;
        		$t=substr($temp2,0,strpos($temp2,'='));
        		$temp2=substr($temp2,strpos($temp2,'=')+1,strlen($temp2));
			if (strpos($temp2,'(')!==false) {
			          $t1=substr($temp2,0,strpos($temp2,'('));
	 	  		  $temp2=substr($temp2,strpos($temp2,'(')+1,strlen($temp2));
        		}
        		else {
          			$end=1;     
	        	}
			$t2=substr($temp2,0,strpos($temp2,')'));
			$t2=substr($t2,strpos($t2,':')+1,strlen($t2));
			$temp2=substr($temp2,strpos($temp2,')')+3,strlen($temp2));
			 if($t2==" Nominal") {
          			$status_bgcolor = "LIMEGREEN";
          			$status_text = "OK";
        			}
			$tosearch='Fan';
			if (in_array($t,$temperature) || (stripos($t,"Therm")!=false) || (stripos($t,"Temp")!=false))
				$sensortype="Temperature";
			elseif (in_array($t,$voltage))
				$sensortype="Voltage";
			elseif((strpos($t,$tosearch)!==false))
				$sensortype="Fan";
			elseif (in_array($t,$psecurity))
				$sensortype="Physical Security";
			elseif (in_array($t,$cpu))
				$sensortype="Processor";
			elseif (in_array($t,$power))
				$sensortype="Power Unit";
			elseif (in_array($t,$other))
				$sensortype="Other Units-based";
			elseif (in_array($t,$eventlog))
				$sensortype="Event Logging Disabled";
			elseif (in_array($t,$sysevent))
				$sensortype="System Event";
			elseif (in_array($t,$cint))
				$sensortype="Critical Interrupt";
			elseif (in_array($t,$button))
				$sensortype="Button / Switch";
			elseif (in_array($t,$watchdog))
				$sensortype="Watchdog 2";
			elseif (in_array($t,$syshealth))
				$sensortype="Management Subsystem Health";
       			if(!strpos($t1, '.') && ($t!=="")){
?>
  
			<tr>
			  <td style="background-color: #FAFAD2"><?php echo $t;?></td>	
			   <td><?php echo $sensortype;?></td>	
			  <td><?php echo $t1;?></td>
			  <td><?php echo "N/A"; ?></td>
			  <td><?php echo "N/A"; ?></td>
			  <td><?php echo "N/A"; ?></td>
			  <td><?php echo "N/A	"; ?></td>
			  <td style="background-color:<?php echo $status_bgcolor ?>"><?php echo $status_text ?></td>
			  <!--<td><?php echo $t2; ?></td> -->
			</tr>
<?php 
        		}
			$pcount++;
      		} //inner while loop ends
    	

    $line = fgets($file);   //performance data

    $perpos = strpos($line,$percheck);

    if($perpos!==false)
    {
      $temp=substr($line,strpos($line,'=')+1,strlen($line));  //take remaining line after '='
  
      $pcount=0;
    
      /*loop to extract service name and corresponsding data for each individual service in the
        IPMI plugin output
       */
      while($temp){
        $end=0;
        $t=substr($temp,0,strpos($temp,'='));
        $t=substr($t, 1, strlen($t));
        $t=substr($t, 0, strlen($t)-1);
        $temp=substr($temp,strpos($temp,'=')+1,strlen($temp));
        if (strpos($temp,' ')!==false) {
          $t1=substr($temp,0,strpos($temp,' '));
        }
        else {
          $end=1;     
          $t1=substr($temp,0,strlen($temp));
        }

        $temp=substr($temp,strpos($temp,' ')+1,strlen($temp));

        /*            **** STATUS WORK ****             */
      
        $service_values = explode(";", $t1);
        $nct_values = explode(":", $service_values[1]);
        $ct_values = explode(":", $service_values[2]);

        $reading = (int)$service_values[0];
        $nct_low = (int)$nct_values[0];
        $nct_high = (int)$nct_values[1];
        $ct_low = (int)$ct_values[0];
        $ct_high = (int)$ct_values[1];

        $status_bgcolor;
        $status_text;

        if(($reading > $nct_low && $nct_low!=" ") || ($reading < $nct_high && $nct_high!= " ")) {
          $status_bgcolor = "LIMEGREEN";
          $status_text = "OK";
        }
        else if(($reading <= $nct_low && $reading > $ct_low && ($ct_low!=" " || $nct_low!=" ")) || ( $reading >= $nct_high && $reading < $ct_high && ($nct_high!=" " || $nct_high!=" "))) {
          $status_bgcolor = "GOLD";
          $status_text = "WARNING";
        }
        else if (($reading < $ct_low && $ct_low!=" ")|| ($reading > $ct_high && $ct_high!=" ")) {
          $status_bgcolor = "CRIMSON";
          $status_text = "CRITICAL";
        }
        else {
          $status_bgcolor = "GREY";
          $status_text = "UNKNOWN";
        }
	if (in_array($t,$temperature)|| (stripos($t,"Therm")!=false) || (stripos($t,"Temp")!=false))
		$sensortype="Temperature";
	elseif (in_array($t,$voltage))
		$sensortype="Voltage";
	elseif((stripos($t,"Fan")!==false))
		$sensortype="Fan";
	elseif (in_array($t,$psecurity))
		$sensortype="Physical Security";
	elseif (in_array($t,$cpu))
		$sensortype="Processor";
	elseif (in_array($t,$power))
		$sensortype="Power Unit";
	elseif (in_array($t,$other))
		$sensortype="Other Units-based";
	elseif (in_array($t,$eventlog))
		$sensortype="Event Logging Disabled";
	elseif (in_array($t,$sysevent))
		$sensortype="System Event";
	elseif (in_array($t,$cint))
		$sensortype="Critical Interrupt";
	elseif (in_array($t,$button))
		$sensortype="Button / Switch";
	elseif (in_array($t,$watchdog))
		$sensortype="Watchdog 2";
	elseif (in_array($t,$syshealth))
		$sensortype="Management Subsystem Health";
        /*           **** STATUS WORK ENDS HERE ****   */
	if($t!==" "){

?>
        <tr>
          <td style="background-color: #FAFAD2"><?php echo $t;?></td>
		<td><?php echo $sensortype;?></td>
          <td><?php echo $service_values[0];?></td>
          <td><?php echo $nct_values[0]; ?></td>
          <td><?php echo $nct_values[1]; ?></td>
          <td><?php echo $ct_values[0]; ?></td>
          <td><?php echo $ct_values[1]; ?></td>
          <td style="background-color:<?php echo $status_bgcolor ?>"><?php echo $status_text ?></td>
        </tr>
<?php }
        if ($end==1){
          break;
        }


        $pcount++;
      } //inner while loop ends
	if($end==1)
		break;
    }
  } //if condition ends
  
} //outer while loop ends

fclose($file);
?>
							
							
																		
														
						</tbody>
						</table>
				
					</div>
			
				</div>
				
		</div>
	

		<script>
			
	
		
	
		
			$(document).ready(function(){    
			
			
			
			$('#preTable').dataTable({
				"order": [[ 1, "desc" ]],
				responsive: true
			});
			
			
			
				
			
			});
				
			
			
			
			
		</script>
	
	</body>
</html>
