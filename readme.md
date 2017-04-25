# Project 10 - Fortress Globitek

Time spent: **3** hours spent in total

> Objective: Create an intentionally vulnerable version of the Globitek application with a secret that can be stolen.

### Requirements

- [X] All source code and assets necessary for running app
- [X] `/globitek.sql` containing all required SQL, including the `secrets` table
- [X] GIF Walkthrough of compromise
	<img src='http://i.imgur.com/4axSZ9Q.gif' title='Video Walkthrough' width='' alt='Video Walkthrough' />
- [X] Brief writeup about the vulnerabilities introduced below

### Vulnerabilities

There is an IDOR vulnerability on the salespeople page. If a hacker looks for id 11 it will redirect to a secret page which is under construction. This page allows the user to upload files into the server. A person can upload php files or a webconsole through this page. In my case i uploaded a php webconsole which allows the hacker to explore the paths of the website as well as edit code or simply view the php code of the websites. After looking at the paths i found a file called flag.php which contained the flag value. Another path a person could take if they already know the schema of the database is just simply make a query in php and upload it go the the image path and run their file to get the flag from the database. 
