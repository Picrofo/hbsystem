hbsystem
========

Hotel Booking System - Setup

1. Please edit manager/connect.php to specify MySQL connection details and change the currency if required

2. Import the SQL file database.sql to your MySQL database to setup the database

3. Upload the folder 'upload' to your server

4. Enjoy your new hotel booking system!

<b>Pro Tip</b>: Check out images.rar for screenshots!<br>
<b>Pro Tip:</b> To protect the manager directory from unauthorized accesses, create an .htaccess file and allow access from authenticated users. The file .htpasswd in the below example contains a list of users which can authenticate. You can generate an .htpasswd file here: http://htaccesstools.com/htpasswd-generator/
<br>
Example:
<br>
<br>
File name: .htaccess<br>
Contents: AuthType Basic
AuthName "Please authenticate"
 AuthUserFile "/root/.htpasswd"
 require valid-user<br>
 
