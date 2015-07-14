
<?php

$arr = array("engineering");
foreach( $arr as $searchTerm) 
{
	// max search depth
	$max =50;
	for ($i=1;$i<3000; $i=$i+$max){
		$feedURL = 'http://gdata.youtube.com/feeds/api/videos/?q=' . $searchTerm . '&start-index=' . $i . '&max-results=' .$max. '&category=Education&v=2';
		$sxml = simplexml_load_file($feedURL);
		foreach ($sxml->entry as $entry) {
			// get nodes in media: namespace for media information
			$media = $entry->children('http://search.yahoo.com/mrss/');
			// get video player URL
			$attrs = $media->group->player->attributes();
			$watch = $attrs['url']; 
			$videoId= substr($watch,31,11);
			echo "<p></p> URL= " . $videoId; 
			file_put_contents('files/'.$searchTerm . '_search_list.txt', $videoId . "\n", FILE_APPEND); // put the search results (videoid) in a text file
		} // end foreach
	} // end for loop 1-4
} // end first foreach				



?>


