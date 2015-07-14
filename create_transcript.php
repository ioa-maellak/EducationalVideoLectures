<?php

// intialize
require 'Zend/Loader/Autoloader.php';
Zend_loader_Autoloader::getInstance();

// take a list of videoid
$ytlist =  explode("\n", file_get_contents('videoid_list.txt')); 
$j = 1;

for($i=0;$i<count($ytlist);$i++){

$videoId = $ytlist[$i]; 

echo "<p> ---------- Create text file including Subtitles for VideoId: " .$videoId . "----------</p>";	   
        $videoCaption ='http://www.youtube.com/api/timedtext?v=' . $videoId . '&lang=en';
		echo $videoCaption;
	    $xml = file_get_contents($videoCaption);
		if (trim($xml) == '') {
			echo "No Subtitles for " . $videoId;
		}
	    else {
		if (@simplexml_load_file($videoCaption)) {
		$captionFeed = simplexml_load_file($videoCaption);
		foreach ($captionFeed->text as $captionText) {
		file_put_contents('cc/'. $videoId . '.txt', $captionText . " ", FILE_APPEND); } //create a file with the video transcript
		} 
		else { echo "<p></p> ERROR= ". $videoId ;} 
		
		$j++;
		} 
}                                             

echo "TOTAL VIDEOS " . $i;		
echo "TOTAL XML LOAD VIDEOS " . $j;		

?>