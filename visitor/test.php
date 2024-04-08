<?php
date_default_timezone_set("Asia/Manila");
$currentTime = time();
if ($currentTime <= strtotime('8:00:00')) {
    echo "On time";
} else
{
	echo "Tardy";
}
