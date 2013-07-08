<?php
// File: src/script.php
// Author: Michelle Austria


//RetailMeNot changed the name of their classes and divs. This might be aecurity feature 
//to prevent automatic scraping??
/*


/*
- title: ul.offer_list.popular > li > div.detail > div.description > div.title
- num-clicked: DEPRECATED: li.num-clicked
ul.offer_list.popular > li > div.detail > ul.offer_status > li.metadata1.border-right
- last_used: DEPRECATED: li.last_used; 
  ul.offer_list.popular > li > div.detail > ul.offer_status > li.metadata2
- vote_count: ul.offer_list.popular > li > div.voting > div.vote_count
- rating: ul.offer_list.popular > li > div.voting > div.rating.high || div.rating.new > div.percent
- coupon code: 
	Direct: ul.offer_list.popular > li > div.detail > div.description > div.crux.attachFlash > div.code
	
	Link: data-offerid in li - concatenate with http://www.retailmenot.com/out/<ID>
*/


// update this to the path to the "vendor/" directory, relative to this file
require_once '/Users/mf2492/Desktop/DreamIt Ventures/Perkle//RetailMeNot Scrape/vendor/autoload.php';

use Symfony\Component\DomCrawler\Crawler;
use Guzzle\Http\Client;

	

//CHANGE STORE NAME 	
$store = "bathandbodyworks";

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

//$store_info = array();

$file = $store.".txt";
$fh = fopen($file, 'w');
$current = file_get_contents($file);


$selector = 'ul.offer_list.popular > li';
	


/* SCRAPE: 
- offerid
- couponid
- siteid
- storename
- storedomain
- titleslug
*/

$attr_array = array("data-offerid","data-siteid", "data-storename",
 "data-storedomain", "data-titleslug", "data-offerid", "data-couponid");

for ($i=0; $i<count($attr_array); $i++){
	$att = $attr_array[$i];
	$current .= getAttributes($att)."\n";
	file_put_contents($file, $current);

}



$stat_array = array("> div.detail > div.description > div.title", 
	"> div.detail > ul.offer_status > li.metadata1.border-right", 
	"> div.detail > ul.offer_status > li.metadata2", 
	"> div.voting > div.vote_count", 
	"> div.detail > div.description > div.crux.attachFlash > div.code");


for ($i=0; $i<count($stat_array); $i++){
	$stat = $stat_array[$i];
	getStats($stat);
	echo "\n";
}

   
function getAttributes($att)
{
	global $crawler, $selector;

	$attributes = $crawler->filter($selector)->extract(array($att));
	$list = implode("\n", $attributes);
	$print_out =  strtoupper($att)."\n".$list."\n\n";
	return $print_out;

}

function getStats($stat)
{
	global $crawler, $selector, $current;

	$nodeValues = $crawler->filter($selector.$stat)->each(function($node, $i) {
    	echo $node->text();
    	echo "\n";
	});

}

?>
