<?php
$fn=$_GET['fn'];
$fh=fopen($fn,"r");
$c = fread($fh,filesize($fn));
fclose($fh);
header("Content-disposition:attachment;filename=".basename($fn));
echo $c;
?>