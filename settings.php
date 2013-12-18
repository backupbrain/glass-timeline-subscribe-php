<?php
// settings.php

// google oauth2 settings
$settings['oauth2']['oauth2_client_id'] = 'YOURCLIENTID.apps.googleusercontent.com';
$settings['oauth2']['oauth2_secret'] = 'YOURCLIENTSECRET';
$settings['oauth2']['oauth2_redirect'] = 'https://example.com/oauth2callback';

$settings['app']['subscription_callback'] = 'http://example.com/timeline_callback.php';

// mysql settings
$settings['mysql']['server'] = 'localhost';
$settings['mysql']['username'] = 'mysqluser';
$settings['mysql']['password'] = 'mysqlpassword';
$settings['mysql']['schema'] = 'schema';


?>
