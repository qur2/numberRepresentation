<?php // TODO implements true unittests...?>
<?php require 'KlingonNumber.php';?>

<pre>
<?php
$numbers = array(
	0,
	1,
	2,
	11,
	12,
	13,
	20,
	21,
	22,
	30,
	40,
	50,
	1000,
	2000,
	3000,
	123,
	223,
	9999999,
	10000000,
);
foreach ($numbers as $n) {
	$k = new KlingonNumber($n);
	print $k . chr(10);
}
?>
</pre>