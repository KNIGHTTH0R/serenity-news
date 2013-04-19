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
    public $title = 'Ace Coder\'s Blog!';
    public $link = 'http://www.ist.rit.edu/~acjvks/pfw/092/examples/project2/project2.rss';
    public $description = 'Ace Coder\'s Extremely cool blog feed!';
    public $lastBuildDate = 'Default RSS lastBuildDate';
    public $items = array();
    public $dom;
      
     
     public function __construct(){
     	
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