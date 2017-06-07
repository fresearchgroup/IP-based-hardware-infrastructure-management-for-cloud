# IP-based-hardware-infrastructure-management-for-cloud

Appropriate cloud management is essential. Popular management actions to handle dynamic changes inside the cloud environment are: migration and elasticity of virtual resources, load balancing, system failure detection. 
 
A one hour down-time could cost as much as 6.45 million dollars in brokerage business or 90 thousand dollars in retail business. It becomes the responsibility of IT and network engineers to make sure these servers and networks are operational 24x7. In order to achieve this 100% service availability, cloud monitoring software becomes essential as these network engineers cannot afford to manually check each device constantly, especially in a large network.
 
Monitoring is a core function of systems administration, and is primarily a matter of communication. A good monitoring tool communicates with users about problems, and communicates with hosts and software to take remedial action. The better it communicates, the greater the confidence administrators will have in its view of their environment.
 
One such open source monitoring solution for over a decade has been Nagios. At its core, Nagios is an event loop that runs through a list of checks for a set of hosts, and then executes further commands to notify or take corrective actions when the output of the check
changes from the last time it was run.  As checks execute, a small text file is written out by the collector process that contains the textual and numerical output as well as some statistical and timing information for the executed check. The master Nagios process periodically reads all these text files, parses the output of the checks, takes any actions (like notifying the owner of
the check or taking corrective action).
 
But Nagios monitors the cloud at the Operating System level. So, using Nagios one cannot manage a computer system which is powered off or otherwise unresponsive by the network.
The Intelligent Platform Management Interface (IPMI) is a set of computer interface specifications for an autonomous computer subsystem that provides management and monitoring capabilities independently of the host system's CPU, firmware (BIOS or UEFI) and operating system. IPMI defines a set of interfaces used by system administrators for out-of-band management of computer systems and monitoring of their operation. For example, IPMI provides a way to manage a computer even when it becomes unresponsive.
 
The aim of this project is to build a hardware infrastructure manager using IPMI protocol and set up a user interface (on a Docker container) suited to the needs of the cloud management. 
 
References:
 
https://www.taashee.com/nagios

http://collaboration.cmc.ec.gc.ca/science/rpn/biblio/ddj/Website/articles/SA/v14/i03/a5.htm

http://docs.opennebula.org/4.12/administration/monitoring/mon.html#the-monitor-metrics

http://openipmi.sourceforge.net/

https://www.docker.com/what-docker

https://www.docker.com/what-container
