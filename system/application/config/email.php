<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['mailtype'] = 'html';
$config['charset'] =  'utf-8';

//Additional mail settings, uncomment as needed. 
//$config['mailpath'] = ''; //Server path to sendmail. Default is /usr/sbin/sendmail
$config['protocol']= 'sendmail'; //Protocol to usse for email. Can be mail,sendmail, or smtp. Default is mail.

//Below are used if you are sending a email via smtp
//$config['smtp_host'] = ''; //SMTP server address.
//$config['smtp_user'] = ''; //SMTP username
//$config['smtp_pass'] = ''; //SMTP password;
//$config['smtp_port'] = ''; //SMTP Port. Default port 25
//$config['smtp_timeout'] = ''; //SMTP Timeout (in seconds);

//The lines below is to make sure emails follow RFC recommendations.
$config['clrf'] = "\r\n";
$config['newline'] = "\r\n";
