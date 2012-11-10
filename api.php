<?php
function getServerLoad()
{
	$load = explode(' ', `cat /proc/loadavg`);
	return $load[0];
}
echo '{"cpu":"' . trim(getServerLoad(), ',') . '","temp":"' . preg_replace('/[^0-9.]/', '', `/opt/vc/bin/vcgencmd measure_temp`) . '"}';

?>