<?php
require getcwd() . '/vendor/autoload.php'; // Composer

header("Last-Modified: " . gmdate('D, d M Y H:i:s') . " GMT");
header("Content-Type: text/plain; charset=utf-8");

$httpModSince = !empty($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) : 0;

$feed = new SimplePie();
$feed->set_feed_url(str_replace("]]", "", str_replace("![CDATA[", "", $_REQUEST["feedurl"])));
$feed->init();
$feed->handle_content_type();

$wc24mimebounary = "BoundaryForDL" . date("YmdHi") . "/" . rand(1000000, 9999999);

echo "--".$wc24mimebounary."\r\n";
echo "Content-Type: text/plain\r\n\r\n";
echo "This part is ignored.\r\n\r\n\r\n";

foreach($feed->get_items() as $item) {
    

    if (strtotime($item->get_date()) - $httpModSince < 0) {
        continue;
    }

	/* Create the main body text. */

	echo "--".$wc24mimebounary."\r\n".
	"Content-Type: text/plain\r\n\r\n".
	"Date: " . gmdate('D, d M Y H:i:s') . " +0000 (UTC)\r\n".
    //"Date: " . $item->get_gmdate("D, d M Y H:i:s") . " +0000 (UTC)\r\n".
	"From: w9999999900000000@rc24.xyz\r\n".
	"To: allusers@rc24.xyz\r\n".
	"Subject: \r\n".
	"MIME-Version: 1.0\r\n".
	"Content-Type: text/plain; charset=utf-8\r\n".
	"Content-Transfer-Encoding: 7bit\r\n".
	"X-Wii-AltName: " . base64_encode(mb_convert_encoding($_REQUEST["title"], "UTF-16", "auto")) . "\r\n".
	"X-Wii-MB-NoReply: 1\r\n\r\n";

	$raw_description = \Soundasleep\Html2Text::convert($item->get_content(), array("drop_links" => true));
    $description = mb_convert_encoding($item->get_title(), "UTF-8", "auto") . "\r\n";
	$description .= mb_convert_encoding($raw_description, "UTF-8", "auto");

	echo $description . "\r\n\r\n" . "-- " . $item->get_link() . "\r\n\r\n";
    
    if ($httpModSince == 0) {
        break;  // Show only one entry for first request
    }

}
echo "--".$wc24mimebounary."--"."\r\n\r\n";

?>
