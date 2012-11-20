<?php
echo '{"cpu":"' . trim(`ps aux|awk 'NR > 0 { s +=$3 }; END {print s}'`) . '","temperature":"' . preg_replace('/[^0-9.]/', '', `/opt/vc/bin/vcgencmd measure_temp`) . '"}';
?>