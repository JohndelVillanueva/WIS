<?php

$testdata = "S0000005";
$raw = explode("S",$testdata);
echo str_pad(str_pad(intval($raw[1])+1,7,0,STR_PAD_LEFT),"8","S",STR_PAD_LEFT);