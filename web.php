<?php

require_once '/Users/mf2492/Desktop/DreamIt Ventures/Perkle/ScrapeProject/vendor/autoload.php';


use Symfony\Component\DomCrawler\Crawler;

$html = <<<'HTML'
<!DOCTYPE html>
<html>
    <body>
        <p class="message">Hello World!</p>
        <p id = "hey">Hello Crawler!</p>
        <p hey = "what">Hello Crawler!</p>
    </body>
</html>
HTML;

$selector = 'body > p';

$crawler = new Crawler($html);

$results = $crawler->filter($selector)->extract(array('class'));

$list = implode ($results);
echo $list;


function writeName()
{
echo "Kai Jim Refsnes";
}

echo "My name is ";
writeName();


?>



