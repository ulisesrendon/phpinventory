Sure! Here’s a step-by-step guide to installing and using PHP on Windows:

Step 1: Download PHP
1.
Go to thePHP Downloads page.
2.
Click on the "Windows downloads" button.
3.
Choose the "Thread Safe" version and download the zip file.

Step 2: Extract the Files
1.
Extract the downloaded zip file to a directory, for example, C:\php.

Step 3: Configure PHP
1.
Go to the extracted PHP directory.
2.
Rename php.ini-development to php.ini.
3.
Open php.ini in a text editor and configure it as needed. For example, you might want to enable extensions like
extension=mysqli.

Step 4: Add PHP to the System Path
1.
Open the Start Menu and search for "Environment Variables".
2.
Click on "Edit the system environment variables".
3.
In the System Properties window, click on the "Environment Variables" button.
4.
In the Environment Variables window, find the "Path" variable in the "System variables" section and click "Edit".
5.
Click "New" and add the path to your PHP directory (e.g., C:\php).
6.
Click "OK" to close all windows.

Step 5: Verify the Installation
1.
Open Command Prompt.
2.
Type php -v and press Enter. You should see the PHP version information.

Step 6: Configure PHP with a Web Server (Optional)
If you want to use PHP with a web server like Apache or IIS, you’ll need to configure it:

Using Apache
1.
Download and installApache.
2.
Open the Apache configuration file (httpd.conf) in a text editor.
3.
Add the following lines to the file:

LoadModule php_module "C:/php/php8apache2_4.dll"
AddHandler application/x-httpd-php .php
PHPIniDir "C:/php"

1.
Restart Apache.

Using IIS
1.
Install IIS from the Windows Features.
2.
Install thePHP Manager for IIS.
3.
Open IIS Manager and configure PHP using the PHP Manager.

Step 7: Create a Test PHP File
1.
Create a new file named info.php in your web server’s root directory.
2.
Add the following code to the file:

<?php
phpinfo();
?>

1.
Open a web browser and navigate to http://localhost/info.php. You should see the PHP information page.

That’s it!