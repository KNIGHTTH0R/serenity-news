<?php
class rss{
	public $title, $link, $description, $pubdate, $article;
	public function __construct($title = "Title of Article", $link = "link", $description = "comments", $pubdate = "date('M. d, Y')", $article = "article"){
		$this->title = $title;
		$this->link = $link;
		$this->description = $description;
		$this->pubdate = $pubdate;
		$this->article = $article;
	}
	public function rss(){
		
	}
?>