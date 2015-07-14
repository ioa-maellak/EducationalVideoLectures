

<?php


// intialize
require 'Zend/Loader/Autoloader.php';
Zend_loader_Autoloader::getInstance();

//function with attributes
function printVideoEntry($videoEntry) 
{
  echo '<p> Video: ' . $videoEntry->getVideoTitle() . "</p>" ;
  echo '<p> Video ID: ' . $videoEntry->getVideoId() . "</p>" ;
  echo '<p> Updated: ' . $videoEntry->getUpdated() . "</p>" ;
  echo '<p> Description: ' . $videoEntry->getVideoDescription() . "</p>" ;
  echo '<p> Category: ' . $videoEntry->getVideoCategory() . "</p>" ;
  echo '<p> Tags: ' . implode(", ", $videoEntry->getVideoTags()) . "</p>" ;
  echo '<p> Duration: ' . $videoEntry->getVideoDuration() . "</p>" ;
  echo '<p> View count: ' . $videoEntry->getVideoViewCount() . "</p>" ;
  echo '<p> Geo Location: ' . $videoEntry->getVideoGeoLocation() . "</p>" ;
  echo '<p> Recorded on: ' . $videoEntry->getVideoRecorded() . "</p>" ;
 
 
  
 
  foreach ($videoEntry->mediaGroup->content as $content) {
    if ($content->type === "video/3gpp") {
      echo '<p> Mobile RTSP link: ' . $content->url . "</p>";
    }
  }
  
  echo "<p> Thumbnails: </p>" ;
  $videoThumbnails = $videoEntry->getVideoThumbnails();

  foreach($videoThumbnails as $videoThumbnail) {
    echo $videoThumbnail['time'] . ' - ' . $videoThumbnail['url'];
    echo ' height=' . $videoThumbnail['height'];
    echo ' width=' . $videoThumbnail['width'] . "\n";
  }
}



// list of keywords for files that contain the videoid

$arr = array("data mining","database","history","lecture","MIT lecture","stanford lecture","University lecture","lesson lecture","computer science lecture","medicine lecture","theory lecture","physics lecture","space lecture","human lecture","teaching lecture","philosophy lecture","chemistry lecture","database lecture","datamining lecture","web lecture","art lecture");
foreach( $arr as $searchTerm) 
{

// get videoid from keywords list and put it in main section
$ytlist = explode("\n", file_get_contents("files/" . $searchTerm . '_search_list.txt'));
for($i=0;$i<count($ytlist);$i++){

// geting the video id from the first  search_list.txt file   
$videoId = $ytlist[$i];

// define yt with zend gdata
$yt = new Zend_Gdata_YouTube();
// yt api v.2
$yt->setMajorProtocolVersion(2); //optional
// retrieve the data from videoid's web page
$videoEntry = $yt->getVideoEntry($videoId);

// print basic results by calling the function above
echo "<p></p><p> ****************** RESULTS for VideoId: " .$videoId . "****************** </p>";


// print subtitles
echo "<p> ---------- Subtitles (not Automatic CC) for VideoId: " .$videoId . "----------</p>";	   
       
	    $videoCaption ="http://www.youtube.com/api/timedtext?v=" . $videoId . "&lang=en";
	    $xml = file_get_contents($videoCaption);
		if (trim($xml) == '') {
			echo "No Subtitles";
			goto notgood;  //go to the end ... this videos does not have subs!!!!!
		}
	    else {
		$captionFeed = simplexml_load_file($videoCaption);
		foreach ($captionFeed->text as $captionText) {
		echo " " . $captionText;}
		}


echo "<p></p><p>------------ Basic data for VideoId: " .$videoId . "--------------- </p>";


printVideoEntry($videoEntry);
	   
// print comments
echo "<p></p><p>------------Comments for VideoId: " .$videoId . " ----------------</p>";

$commentFeed = $yt->retrieveAllEntriesForFeed($yt->getVideoCommentFeed($videoId));

$countc = 0; // the variable countc counts the video's comments
foreach ($commentFeed as $commentEntry) {
  $countc = $countc + 1;
  echo " ". $countc . ": " . $commentEntry->content->text . "<br />";
  if ($countc == 100) {break;}
}

echo "<p> ---------- Extra Results for VideoId: " .$videoId . "----------</p>";

// get all data (needs $videoId)
	$feedURL = 'http://gdata.youtube.com/feeds/api/videos/' . $videoId . '?v=2';
	$entry = simplexml_load_file($feedURL);


	// a new class to store data
	$obj_extra= new stdClass; 
	
	// retrieve likes and dislikes
		$ytd = $entry->children('http://gdata.youtube.com/schemas/2007');
		$attrs = $ytd->rating->attributes();
		$obj_extra->dislikes = $attrs['numDislikes'];
		$obj_extra->likes = $attrs['numLikes'];
		echo "<p></p><p>Likes: " . $obj_extra->likes . " </p>";
		echo "<p></p><p>Dislikes: " . $obj_extra->dislikes . " </p>";
	
  	// retrieve favorite
	  $ytd = $entry->children('http://gdata.youtube.com/schemas/2007');
	  $attrs = $ytd->statistics->attributes();
	  $obj_extra->favoriteCount = $attrs['favoriteCount'];
	  echo "<p></p><p>Favorite: " . $obj_extra->favoriteCount . " </p>";
	
	// retrieve  author,published
	  $obj_extra->username = $entry->author->name; 
	  $obj_extra->uri = $entry->author->uri; 
	  $obj_extra->published = $entry->published; 
	  echo "<p></p><p>Published: " . $obj_extra->published . " </p>";  
	  
	// get feed URL for video responses
	  $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom');
	  $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/2007#video.responses']");  
	  $obj_extra->responsesURL = count($nodeset);      
	   echo "<p></p><p>Video Responses: " . $obj_extra->responsesURL . " </p>";  
	   
	// get feed URL for related videos
	  $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom');
	  $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/2007#video.related']"); 
	  $obj_extra->relatedURL = count($nodeset);     
	  echo "<p></p><p>Related Videos: " . $obj_extra->relatedURL . " </p>";  


// print Users Data 
echo "<p> ---------- Users Data - Username: " .$obj_extra->username . "----------</p>";	
        		
			$videoAuthor->authorURL = $obj_extra->uri ;  
		$authorFeed = simplexml_load_file($videoAuthor->authorURL);
		if ($authorFeed)
		{
		   	$authorData = $authorFeed->children('http://gdata.youtube.com/schemas/2007');
			$firstName = addslashes($authorData->firstName);
			echo "<p> First Name: " . $firstName. " </p>";
			$lastName = addslashes($authorData->lastName);
			echo "<p> Last Name: " . $lastName. " </p>";
			$gender = addslashes($authorData->gender);
			echo "<p> Genter: " . $gender. " </p>";
		   	$age = $authorData->age;
			echo "<p> Age: " . $age. " </p>";
			$hometown = addslashes($authorData->hometown);
			echo "<p> Hometown: " . $hometown. " </p>";
		    $location =  addslashes($authorData->location);
			echo "<p> Location: " . $location. " </p>";			
		  	$occupation = addslashes($authorData->occupation);
			echo "<p> Occupation: " . $occupation. " </p>";
			$company = addslashes($authorData->company);
			echo "<p> Company: " . $company. " </p>";
			$school = addslashes($authorData->school);
			echo "<p> School: " . $school. " </p>";
			$hobbies = addslashes($authorData->hobbies);
			echo "<p> Hobbies: " . $hobbies. " </p>";
			$movies = addslashes($authorData->movies);
			echo "<p> Movies: " . $movies. " </p>";
			$music = addslashes($authorData->music);
			echo "<p> Music: " . $music. " </p>";
			$books = addslashes($authorData->books);
			echo "<p> Books: " . $books. " </p>";
		} 
	
notgood: 
echo "-";



} // fore explode

} // for array list lessons


mysql_close($link);
	
?>


