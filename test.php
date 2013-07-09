<?php

require_once '/Users/mf2492/Desktop/DreamIt Ventures/Perkle//RetailMeNot Scrape/vendor/autoload.php';
use Symfony\Component\DomCrawler\Crawler;

$html = <<<'HTML'
<!DOCTYPE html>
<html>
    <body>
        <ul class="offer_list popular"> 
        <li id="c4858194" class="offer clearfix coupon " data-offerid="4858194" data-couponid="" data-siteId="136719" data-storename="Bath and Body Works" data-storedomain="bathandbodyworks.com" data-titleslug="today-only-20-percent-off-50-sitewide-plus-free-shipping" > 
        	<div class="detail"> 
        	<div class="description"> <div class="title"> <h3> Today Only! 20% Off $50 Sitewide + Free Shipping </h3> </div> <div class="codelabel">Coupon Code:</div> <div class="crux attachFlash "> <div class="cover">Show coupon code</div> <div class="label">&nbsp;</div> <div class="code">RMN20FS50</div> </div> <p class="discount"> Bath and Body Works: Today Only! Save 20% Off Any Purchase + Free Shipping On $50 Or More. Ends 07/09/2013 </p> </div> <ul class="offer_status" data-expires="2013-07-09 23:59:59" data-last-click="-4248000" data-num-clicks-today="457"> <li class="metadata1 border-right">457 people used today</li> <li class="metadata2">Last used 1 hour ago</li> </ul> 
    </body>
</html>
HTML;

$crawler = new Crawler($html);

$base_selector = '//ul[@class="offer_list popular"]/li';

$second = '/div[@class="detail"]/div[@class="description"]';


$attributes = $crawler
    ->filterXPath(($base_selector.$second))
    ->extract(array('id', 'class', 'data-offerid'))
;

print_r($attributes);

?>