<?php
// oauth2callback/index.php

require('../settings.php');

require_once('../classes/Google_OAuth2_Token.class.php');
require_once('../classes/Google_SubscriptionList.class.php');
	
/**
 * the OAuth server should have brought us to this page with a $_GET['code']
 */
if(isset($_GET['code'])) {
    // try to get an access token
    $code = $_GET['code'];
 
	// authenticate the user
	$Google_OAuth2_Token = new Google_OAuth2_Token();
	$Google_OAuth2_Token->code = $code;
	$Google_OAuth2_Token->client_id = $settings['oauth2']['oauth2_client_id'];
	$Google_OAuth2_Token->client_secret = $settings['oauth2']['oauth2_secret'];
	$Google_OAuth2_Token->redirect_uri = $settings['oauth2']['oauth2_redirect'];
	$Google_OAuth2_Token->grant_type = "authorization_code";

	try {
		$Google_OAuth2_Token->authenticate();
	} catch (Exception $e) {
		// handle this exception
		print_r($e);
	}

	// A user just logged in.  
	if ($Google_OAuth2_Token->authenticated) {
		
		// let's instert a Subscription
		$Google_Subscription = new Google_Subscription($Google_OAuth2_Token);
		$Google_Subscription->collection = Google_Subscription::COLLECTION_TIMELINE;
		$Google_Subscription->userToken = 'unique_glass_user_identifier';
		$Google_Subscription->verifyToken = md5('https://example.com/timeline_callback.php');
		
		// don't have an SSL web server?  You can use the Mirror Subscription proxy for development:
//		$Google_Subscription->callbackUrl = 'https://mirrornotifications.appspot.com/forward?url=https://example.com/timeline_callback.php';
		
		$Google_Subscription->callbackUrl = 'https://example.com/timeline_callback.php';
			
		
		try {
			$Google_Subscription->insert();
		} catch (Exception $e) {
			// handle this exception
			print_r($e);
		}		
		
		// let's list our current subscriptions
		$Google_SubscriptionList = new Google_SubscriptionList($Google_OAuth2_Token);
		
		try {
			$Google_SubscriptionList->list_subscriptions();
		} catch (Exception $e) {
			// handle this exception
			print_r($e);
		}
		
		
	}
}


?>
<? if ($Google_SubscriptionList->items) { ?>
<? $numTimelineItems = count($Google_SubscriptionList->items); ?>
Found <?= $numTimelineItems; ?> Subscription<? if ($numTimelineItems !== 1) { ?>s<? } ?>:
<? foreach ($Google_SubscriptionList->items as $SubscriptionItem) { ?>
	<h2>Subscription</h2>
	<dl>
		<dt>ID</dt>
		<dd><?= $SubscriptionItem->id; ?></dd> 
		
		<dt>Collection</dt>
		<dd><?= $SubscriptionItem->collection; ?></dd> 

		<dt>Updated</dt>
		<dd><?= $SubscriptionItem->updated; ?></dd>
		
		<dt>userToken</dt>
		<dd><?= $SubscriptionItem->userToken; ?></dd>
		
		<dt>callbackUrl</dt>
		<dd><?= $SubscriptionItem->callbackUrl; ?></dd>
			
	</dl>
<? } ?>
<? } ?>
<?
/* */
?>