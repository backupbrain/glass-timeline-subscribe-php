<?

require_once('settings.php');
require_once('SQL.class.php');

$SQL = new SQL(
	$settings['mysql']['server'],
	$settings['mysql']['username'],
	$settings['mysql']['password'],
	$settings['mysql']['schema']
);

$tableName = 'HttpPost';

// This is the url that was accessed by the Google Mirror API
$url = 'https://example.com/timeline_callback.php';

// because you are a curious cat, you want to know what headers Google Mirror sent you
// You can grab the incoming request headers with the apache_request_headers variable
$headers = apache_request_headers();
foreach ($headers as $header => $value) {
	$httpheaders[] = $header.': '.$value;
}
$header = implode("\n", $headers)


// PHP expects query post content, but Google Mirror posts JSON instead
// As a result, the PHP post parser that creates the $_POST variables doesn't
// digest Mirror content well, so we have to grab it from the $HTTP_RAW_POST_DATA
// variable instead
if ($HTTP_RAW_POST_DATA ) {
	$postString = $HTTP_RAW_POST_DATA;
}

// we will never see this page in person, so let's save it to
// the dataabase so we can check on it later
$query = "insert into `HttpPost` ".
		"( `url`, `headers`, `post` ) ".
		" values ".
		"('".$url."','".addslashes($header).",'".addslashes($postString)."')";

$SQL->query($query);
	


?>