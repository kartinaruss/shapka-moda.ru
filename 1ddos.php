<?php
$f_json = './cf.json';
$json = file_get_contents("$f_json");

$jss = json_decode($json,true);

$ips = '';
echo time().'<br>';
foreach ($jss as $js) {
  			$ips .= '<br> or ';
		}
		$ips .= '(ip.src eq '.$js['clientIP'].')';
	}
}

echo $ips;


?>
