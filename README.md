Subscribe to User Timeline Updates
=============================
This code shows how to use callback urls to track user's Google Glass interactions
with the portion of their timeline that is shared with your service.

It is intended as a complement to my tutorial:
http://20missionglass.tumblr.com/post/67676363275/add-your-service-as-a-contact


You will need to first insert your service as a contact, which you can read about at:
http://20missionglass.tumblr.com/post/67676363275/add-your-service-as-a-contact


Configuration
--------------
Set up an OAuth2 Client App in the Google Code Console:
https://code.google.com/apis/console/

Once you register an app, create  you will get a client id and client secret. 
You will also need to create a Browser API Key for the Google Maps API.  

Edit your settings.php to reflect your oauth2 client app's settings.

$settings['oauth2']['oauth2_client_id'] = 'YOURCLIENTID.apps.googleusercontent.com';
$settings['oauth2']['oauth2_secret'] = 'YOURCLIENTSECRET';
$settings['oauth2']['oauth2_redirect'] = 'https://example.com/oauth2callback';


There is also a database component so we can store the incoming timeline notifications

$settings['mysql']['server'] = 'localhost';
$settings['mysql']['username'] = 'mysqluser';
$settings['mysql']['password'] = 'mysqlpassword';
$settings['mysql']['schema'] = 'schema';


Now you should be good to go.


