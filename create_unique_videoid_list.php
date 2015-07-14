<?php

$ytlistall =  explode("\n", file_get_contents('videoid_list.txt'));
// create the unique values from a videoid list
$ytlist = array_unique($ytlistall);

for($i=0;$i<count($ytlistall);$i++){
if(isset($ytlist[$i])  ) {   
$videoId = $ytlist[$i]; 
file_put_contents('unique_videoid_list.txt', $videoId . "\n", FILE_APPEND);

}
echo $i;
}

?>