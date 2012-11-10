<?php
echo '{"cpu":"' . preg_replace('/[^0-9.]/', '', `ps aux|awk 'NR > 0 { s +=$3 }; END {print "cpu %",s}'`) . '","temp":"' . preg_replace('/[^0-9.]/', '', `/opt/vc/bin/vcgencmd measure_temp`) . '"}';

?>