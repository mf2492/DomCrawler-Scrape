<?php

$x = array();
for ($i = 0; $i <= 10; $i++) {
	array_push($x, $i);
}

$list = implode("\n", $x);
echo $list;

?>