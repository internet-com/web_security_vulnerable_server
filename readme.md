# Project 10 - Fortress Globitek

Time spent: **3** hours spent in total

> Objective: Create an intentionally vulnerable version of the Globitek application with a secret that can be stolen.

### Requirements

- [X] All source code and assets necessary for running app
		* a webserver running ubuntu 14.04 LTS 
		* webserver must have port 22 open to allow ssh
		* a weak password for ssh 
- [X] `/globitek.sql` containing all required SQL, including the `secrets` table
- [X] GIF Walkthrough of compromise
	<img src='http://i.imgur.com/xQD0qqC.gif' title='Video Walkthrough' width='' alt='Video Walkthrough' />
- [X] Brief writeup about the vulnerabilities introduced below

### Vulnerabilities

	* In this case the application itself is very secured against sql, xss, and csrf attacks. However the 
	administrator of the server has left port 22 open for ssh and has used a very weak password for his account. 
	Using kali linux i used nmap against the host in order to determine which ports where open. Nmap showed both 
	port 80 and 22 as open.  I then used hydra with rockyou-75.txt file against the host using root as the username.
	I was then able to ssh into the server. MySQL had a password needed in order to login, however i was able to stop 
	mysql and start the mysqld daemon using the --skip-grant-tables command then from there i was able to edit root 
	password or add another user with all priviledges. Lastly i restarted mysql and looked at its tables and columns 
	until i found the flag. Another path one could take is to just edit the .php files to allow for sql injection or other
	vulnerabilities once inside the server. Once inside the server possibilities are endless since you control everything 
	if the user you log in as has all priviledges. 
