Crafty-Minecraft-Controller
===========================
*A Completely OPEN SOURCE Server Controller for Bukkit (or Minecraft)*<br />


##Requirements
This system requires the following:
 * Apache Version: 2.2.20 (default on ubuntu)
 * PHP Version 5.3.6 (default on ubuntu)
 * SQLite 3 Support
 * Bukkit and some type of Java.

###fresh install help
If doing a fresh install on ubuntu you can select the LAMP setup config, or

* sudo apt-get install apache2

* sudo apt-get install php5

* sudo apt-get install libapache2-mod-php5

* sudo apt-get install php5-sqlite

* sudo /etc/init.d/apache2 restart

* Currently to save data www-data must have access to /var/www and the dir bukkit is installed to.
    * chown -R www-data /var/www
    * chown -R www-data /bukkit (or where ever bukkit is installed)


##License / Copyright

Copyright (c) 2012-2013, Phillip Tarrant
All rights reserved.

Design Interface by: 1001Zippy and Phillip Tarrant

License: http://creativecommons.org/licenses/by-sa/3.0/legalcode

 
