<?php
//PHP configuration file for Swift Mailer, with configurations for PHP mail server

/*
 * $loader needs to be a relative path to an autoloader script.
 * Swift Mailer's autoloader is swift_required.php in the lib directory.
 * If you used Composer to install Swift Mailer, use vendor/autoload.php.
 */

//path to file autoload.php of composer, inside vendor folder
#$loader = __DIR__ . '/../vendor/autoload.php';  

 //path to autoloader of swift mailer, only load swift mail classes
#$loader = __DIR__ . '/../vendor/swiftmailer/swiftmailer/lib/swift_required.php';   

#require_once $loader;

/*
 * Login details for mail server
 */
#$smtp_server = 'smtp.gmail.com';
#$smtp_server = 'ssl://smtp.gmail.com';
/* $smtp_server = '';
$username = '';
$password = ''; */

/* $smtp_server = 'email-smtp.eu-west-1.amazonaws.com';
$username = 'AKIAJP3IRDOMM72DYJWA';
$password = 'BMi/sAG2p5BRdYz35RLVd2Yw/LmyuYbp/w4ksgY309Hr'; */

$smtp_server = 'smtp.gmail.com';
$username = 'academiaphp2019@gmail.com';
$password = 'academiaphp2019';

/*
 * Email addresses for testing
 * The first two are associative arrays in the format
 * ['email_address' => 'name']. The rest contain just
 * an email address as a string.
 */
#$from = ['no-reply@foundationphp.com' => 'Foundation PHP'];

