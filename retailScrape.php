<?php
/* 

File: src/script.php
Author: Michelle Austria


Data being scraped: siteID, storename, storedomain, titleslug, offerid/direct link, title,
number used, last used, rating, coupon code (if available)


NOTE: RetailMeNot changed the name of their classes and divs. This might be aecurity feature 
to prevent automatic scraping??


*/


// update this to the path to the "vendor/" directory, relative to this file
require_once '/Users/mf2492/Desktop/DreamIt Ventures/Perkle//RetailMeNot Scrape/vendor/autoload.php';

use Symfony\Component\DomCrawler\Crawler;
use Guzzle\Http\Client;

	

$store = "walgreens"; //CHANGE STORE NAME 	


$target_url_get = "http://www.retailmenot.com/view/$store.com";

$client = new Client($target_url_get);
$user_agent = array("Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36",
	"Mozilla/5.0 (Windows NT 6.1; WOW64; rv:21.0) Gecko/20100101 Firefox/21.0",
	"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36",
	"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/536.30.1 (KHTML, like Gecko) Version/6.0.5 Safari/536.30.1",
	"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36", 
	"Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36");

$client->setUserAgent($user_agent[rand(0, 5)]);
$request = $client->get();
$response = $request->send();
$response = $response->getBody();

$html = "<<<'HTML'" . $response . 'HTML';

$crawler = new Crawler('', 'http://www.retailmenot.com');
$crawler->addHtmlContent($html);



//PREPARE I/O FILE
$file = $store.".txt";
$fp = fopen($file, 'w');
$current = file_get_contents($file);



//PARSE ATTRIBUTES
$base_selector = 'ul.offer_list.popular > li';
$list = $crawler->filter($base_selector)->extract(array("data-siteid", "data-storename",
 "data-storedomain", "data-titleslug", "data-offerid"));


$attributes_list = array("> div.detail > div.description > div.title", 
	"> div.detail > ul.offer_status > li.metadata1.border-right", 
	"> div.detail > ul.offer_status > li.metadata2", 
	"> div.voting > div.vote_count", 
	"> div.detail > div.description > div.crux.attachFlash > div.code");



for ($i=0; $i<sizeof($attributes_list); $i++){
	$attr = $attributes_list[$i];
	addAttributes($attr);
}

getLink();



//print_r($list);

//WRITE TO FILE
foreach ($list as $fields) {
    fputcsv($fp, $fields, ",");
}
fclose($fp);




function addAttributes($attr){
	global $base_selector, $list, $crawler;

	$selector = $base_selector.$attr;
	$last_array = $crawler->filter($selector)->extract(array('_text'));


	//PUSH EACH NODE FROM ARRAY INTO LIST OF ARRAY
	array_push($list, $last_array);


	for ($i = 0; $i < (sizeof($last_array)); $i++) {
		array_push($list[$i], $list[(sizeof($list))-1][$i]);
	}
	
	array_pop($list);
	
}


function getLink() {
	global $list;

	for ($i = 0; $i < (sizeof($list)); $i++) {
		$list[$i][4] = "http://www.retailmenot.com/out/".$list[$i][4];
	}
}





?>
