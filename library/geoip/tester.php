<?php

require_once './geoip.inc';

$gi = geoip_open("./GeoIP.dat", GEOIP_STANDARD);

// US
$ip = "208.185.244.250";

// Paris
//$ip = "178.32.114.131";

// Sweden
//$ip = "193.105.134.161";

// London
//$ip = "192.165.213.18";

// Denmark
//$ip = "82.143.192.1";

// Turkey
//$ip = "80.251.32.1";

$gicc = geoip_country_name_by_addr($gi, $ip);

echo $gicc . "\n";
