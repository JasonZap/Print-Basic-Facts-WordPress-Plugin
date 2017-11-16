<?php
// Seems this function is return total amount of avail space instead of space used. 
// Need to re-work to show acurate size of install. 
function dataSize() { 
$Bytes = disk_total_space(ABSPATH); 
$Type=array("", "kilo", "mega", "giga","tera"); 
$counter=0; 
while($Bytes>=1024) { 
$Bytes/=1024; 
$counter++;
}
return("".$Bytes." ".$Type[$counter]."bytes");
}

// Function will return a query of database using get_option and a foreach loop,
// to number and list the contentes of the array. 
function activePlugins() {
$activeplugs = get_option('active_plugins');
$total = 0;
foreach ($activeplugs as $key => $value)
{
$total++;
echo $total.' = '.$value.'<br>';
}
echo 'Total Active Plugin(s) = '.$total;
}







?>
