***Syner - Collaborative Problem Solving ***

Preface- 

Server Requirements- 

Installation Instructions-

1. Unpack Syner into your web directory of choice.
2. Go to and open  system/application/config/config.php
3. Within config.php define the SY_SITEPATH constant, notes are within the config file.
4. Within config.php define the Base Site URL.
5. Go to and open  system/application/config/database.php
6. Within database.php set your database information such as hostname, username, password, and database


Notes:

-Change value of $config['encryption_salt'] in
system/application/config/config.php so encrypted data is harder to break.
-Modifiy system/application/config/email.php to fit your email settings. By
default we use /usr/sbin/sendmail and use the mail protocol. 