<?php

require_once '/Users/mf2492/Desktop/DreamIt Ventures/Perkle//RetailMeNot Scrape/vendor/autoload.php';


use Symfony\Component\DomCrawler\Crawler;

$html = <<<'HTML'
<!DOCTYPE html>
<html>
    <body>
	    <li>
	    	<h3>hey</h3>
	    </li>
        <p class="message">Hello World!</p>
        <p>Hello Crawler!</p>
    </body>
</html>
HTML;

$crawler = new Crawler($html);

$attributes = $crawler
    ->filterXpath('//p')
    ->extract(array('_text'))
;

print_r($attributes);


$message = $crawler->filterXPath('//body/li')->text();
print $message."\n";