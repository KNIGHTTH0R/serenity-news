<?php
// test class here
$feed = new RSSFeed();
$articles[]=array('subject'=>'Today is the exam!','content'=>'I\'m going to do great!');
$articles[]=array('subject'=>'Next time is the practical!','content'=>'I\'m going to do great on that too!');
$feed->items = $articles;
echo $feed->toXML();



// define class here
class RSSFeed{
    // property declaration
    public $items;// = array($title, $author, $link, $description, $lastBuildDate);
    public $dom;
      
     
    public function __construct(){
     	$data = file("rit.txt");
		$fdata = array_reverse($data);
		for($i=0;$i<10;$i++){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$fdata[$i]);
			$items[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			$this->title = $title;
			$this->author = $author;
			$this->link = '/jxz6853/539/project2/news/rit.php/?page='.$url.'&max=1';
			$this->description = $articleA.$articleB;
			$this->lastBuildDate = $date;
		}
		echo '<pre>';
		print_r($items);
	}
      
  
    
    public function toXML(){
    	// I am using string concation here, you MUST use DOM methods instead.
    	$dom="";
    	$dom .="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    	$dom .= "<rss>\n";
    	$dom .= "<channel>\n";
    	$dom .= "<title>$this->title</title>\n";
    	$dom .= "<link>$this->link</link>\n";
    	$dom .= "<description>$this->description</description>\n";
    	$dom .= "<lastBuildDate>$this->lastBuildDate</lastBuildDate>\n";
    	
    	foreach($this->items as $k=>$v){
    		$dom .= "<item>\n";
    		$time = $k;
			$subject = htmlentities($v['subject']);
			$content = htmlentities($v['content']);
			//$time == don't forget to do this
    		$dom .= "<title>$subject</title>\n";
    		$dom .= "<description><![CDATA[$content]]></description>\n";
    		$dom .= "<pubDate>$time</pubDate>\n";
    		$dom .= "</item>\n";
    	}
    	
     $dom .= "</channel>";
    $dom .= "</rss>";
    	
    	return $dom;
    }
    
}

?>