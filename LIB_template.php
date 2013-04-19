<?php
//html head, belongs in the top of all pages
function i_header($title = "News", $styles = "", $keywords = ""){
//heredocs must not be indented
$header = <<<END
<!DOCTYPE html>
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv = "content-type" content = "text/html; charset=utf-8" />
	<meta name = "keywords" content = "$keywords">
	<title>$title</title>
	<link type = "text/css" rel = "stylesheet" href = "$styles" />
	<link href = "http://people.rit.edu/jxz6853/539/project2/images/favicon.ico" rel = "shortcut icon" />
	<link href = "http://people.rit.edu/jxz6853/539/project2/images/favicon.png" rel = "icon" type = "image/gif" />
	</head>
</head>
END;
	return $header;
}
//starting the body/content of every page, setting up
function i_body($font = "tahoma", $size = "12px", $text = "white", $bgcolor = "black", $subcolor = "white"){
//getting the current day in a -dayofweek-, -date- of -month- -year- format
$date = date('l\, jS \of F Y');
//getting the hour:mins:secs of current time
$time = date('h:i:s A');
$body = <<<END
<body background="http://people.rit.edu/jxz6853/539/project2/images/bg1.png" style = "font-family: $font; font-size: $size; color: $text; background-color: $bgcolor; text-align: center; background-position:center; background-repeat: repeat-y;">
<p style = "margin-left:500px"><strong>It is $date | $time</strong></p>
END;
	return $body;
}
//getting the current weather in Rochester
function weather(){
//the place can be changed in the url
$url = "http://www.weather.com/weather/today/Rochester+NY+USNY1232:1:US";
$info = file_get_contents($url);
$img = return_between($info, '<div class="wx-data-part wx-first">', '</div>', EXCL);
$image = return_between($img, '<img src="', '"', EXCL);
$des = return_between($info, '<div class="wx-data-part wx-first">', '="wx-weather-icon">', EXCL);
$desc = return_between($des, 'alt="', '" class', EXCL);
$temp = return_between($info, '<div class="wx-temperature"><span itemprop="temperature-fahrenheit">', '</span><span class="wx-degrees">&deg;<span class="wx-unit">F</span></span></div>', EXCL);

$weather = <<<END
<table>
	<tr>
		<td>
			<img src = "$image" width = "90px" height = "90px" />
			<span style = "font-size: 42px; color:#999999;">$temp &deg; F</span>
		</td>
	</tr>
	<tr>
		<td align = "right">
			<span style = "color:#999999;">$desc</span>
		</td>
	</tr>
</table>
END;

return $weather;
}
//getting site logo-banners and displaying randomly
function banner($ban_file = "banners.txt"){
//if the file with the names of the banner images exist
if(file_exists($ban_file) && is_readable($ban_file)){
	//file opens the file as an array
	$banners = file($ban_file);
	//takes a random index in the array of images
	$randban = $banners[array_rand($banners)];
	return '<img src = "http://people.rit.edu/jxz6853/539/project2/images/'.$randban.'" border = "0" usemap = "#ss" /><map name="ss"><area shape="rect" coords="400,100,580,130" href="https://members.csh.rit.edu/~coffee/index.php"></map>';
}else
	//raise an error if file doesn't exist/not readable
	die("<strong>Problem loading file at $ban_file!</strong>");
}
//menu/navigation linking to other pages
function menu($menu = "nav.png"){
$menu = <<<END
<a class = "opacity">
<img src = "http://people.rit.edu/jxz6853/539/project2/images/$menu" border = "0" usemap = "#map" />
<map name="map">
	<area shape="rect" coords="0,0,180,35" href="http://people.rit.edu/jxz6853/539/project2/index.php">
	<area shape="rect" coords="180,0,360,35" href="http://people.rit.edu/jxz6853/539/project2/news.php">
	<area shape="rect" coords="360,0,540,35" href="http://people.rit.edu/jxz6853/539/project2/news/archives.php">
	<area shape="rect" coords="540,0,720,35" href="http://people.rit.edu/jxz6853/539/project2/contact.php">
	<area shape="rect" coords="720,0,900,35" href="http://people.rit.edu/jxz6853/539/project2/admin.php">
</map>
</a>
END;
return $menu;
}
//editorial loads in the file with the content and displays it with the pic
function editorial($editorial = "editorial.txt", $picture = "pic.jpg"){
if(file_exists($editorial) && is_readable($editorial)){
	$editorial = file_get_contents($editorial);
}else
	$editorial = "<strong>No news available for editorial.</strong>";
$editorials = <<<END
<table style = "font-size:12px" width = "888px" border="1">
	<tr>
		<th colspan = "2">
			<a href = "">Editorial</a>
		</th>
	</tr>
		<td width = "125px">
			<a class = "opacity"><img src = "images/$picture" width = "120px" height = "150px" /></a>
		</td>
		<td>
			$editorial
		</td>
	</tr>
</table>
END;
return $editorials;
}
//takes in content in file as array and returns the title for each article
function titlenews($cat = "none", $txt = "file.txt"){
	if(file_exists($txt) && is_readable($txt)){
		$data = file($txt);
		foreach($data as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$index[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			echo '<li><a href = "/jxz6853/539/project2/news.php/#'.$cat.'">'.$title.'</a></li>';
		}
	}else
		//if file doesn't exist/not readable
		echo "<strong>No news available for the ".$cat.".</strong>";
}
//news, the homepage with all of the news sections and titles
function news($rit = "rit", $rittxt = "rit.txt", $nation = "nation", $nationtxt = "nation.txt", $world = "world", $worldtxt = "world.txt", $business = "business", $businesstxt = "business.txt", $technology = "technology", $technologytxt = "technology.txt", $entertainment = "entertainment", $entertainmenttxt = "entertainment.txt", $sports = "sports", $sportstxt = "sports.txt", $miscellaneous = "miscellaneous", $misctxt = "misc.txt"){
echo '
<table width = "888px" border="1" style = "font-size: 12px";>
	<tr>
		<th>
			<a href = "news/rit.php">RIT: News &amp; Events</a>
		</th>
		<th>
			<a href = "news/nation.php">US News</a>
		</th>
	</tr>
	<tr>
		<td height = "200px" width = "50%">';
titlenews($rit, $rittxt);
echo '</td>
		<td height = "200px">';
titlenews($nation, $nationtxt);
echo '</td>
	</tr>
	<tr>
		<th>
			<a href = "news/world.php">World News</a>
		</th>
		<th>
			<a href = "news/business.php">Business News</a>
		</th>
	</tr>
	<tr>
		<td height = "200px">';
titlenews($world, $worldtxt);
echo '</td>
		<td height = "200px">';
titlenews($business, $businesstxt);
echo '</td>
	</tr>
	<tr>
		<th>
			<a href = "news/technology.php">Technology News</a>
		</th>
		<th>
			<a href = "news/entertainment.php">Entertainment News</a>
		</th>
	</tr>
	<tr>
		<td height = "200px">';
titlenews($technology, $technologytxt);
echo '</td>
		<td height = "200px">';
titlenews($entertainment, $entertainmenttxt);
echo '</td>
	</tr>
	<tr>
		<th>
			<a href = "news/sports.php">Sports News</a>
		</th>
		<th>
			<a href = "news/miscellaneous.php">Miscellaneous News</a>
		</th>
	</tr>
	<tr>
		<td height = "200px">';
titlenews($sports, $sportstxt);
echo '</td>
		<td height = "200px">';
titlenews($miscellaneous, $misctxt);
echo '</td>
	</tr>
</table>';
}
//advertisements on the bottom of page, random images displayed from the array
function ads($ad_file = "ads.txt"){
if(file_exists($ad_file) && is_readable($ad_file)){
	$ads = file($ad_file);
	$randad = $ads[array_rand($ads)];
	return '<p><img src = "http://people.rit.edu/jxz6853/539/project2/images/'.$randad.'" /></p>';
}else
	//if the file for the ads doesn't exist/not readable
	die("<strong>Problem loading file at $ad_file!</strong>");
}
//userinfo, gets the user's ip, host, browser, page they were on when logged
function userinfo(){
$ip = $_SERVER['REMOTE_ADDR'];
$hostaddress = gethostbyaddr($ip);
$browser = $_SERVER['HTTP_USER_AGENT'];
$referred = @$_SERVER['HTTP_REFERER'];
//displays the info on the page
$userinfo = <<<END
<br />
<table style = "font-size: 10px; color:#999999;">
	<tr>
		<th>The following information is being saved for nefarious purposes:</th>
	</tr>
	<tr>
		<td>
		<ul>
			<li>IP address: $ip || Host Address: $hostaddress</li>
			<li>Browser: $browser</li>
			<li>Page you came from: 
END;
if ($referred == ""){
	saveuserinfo();
	return $userinfo."Page was directly requested.</li></ul></td></tr></table>";
}else{
	saveuserinfo();
	return $userinfo."$referred"."</li></ul></td></tr></table>";
}
}
//logs the info into a file that can be viewed by the admin
function saveuserinfo(){
	$userlog = fopen("userlog.txt", "a+");
	fwrite($userlog, date('l\, jS \of F Y')."|".date('h:i:s A')."|".@$_SERVER['REMOTE_ADDR']."|".@gethostbyaddr($_SERVER['REMOTE_ADDR'])."|".@$_SERVER['HTTP_USER_AGENT']."|".@$_SERVER['HTTP_REFERER']."\n");
	fclose($userlog);
}
//copyright on the bottom of the page with the footer
function copyright($copyright = "Jenny Zhen, 2010"){
$copyright = <<<END
<div id="footer_wrapper">
	<div id="footer">
		<br />Copyright &copy; $copyright. All rights reserved.
	</div>
</div>
END;
return $copyright;
}
//contact form to send me an email
function contact($to = "random@sweetsimplicity.com", $subject = "", $message = "", $headers = ""){
echo '<table style = "font-size:12px" width = "30%" align = "center">';
echo '<tr><th colspan = "2">Contact the Editor</th></tr>';
echo '<form action = "'.$_SERVER["PHP_SELF"].'" method = "POST">';
echo '<tr><td width = "50%">Subject: </td><td><input type = "input" name = "subject" size = "26" /></tr>';
echo '<tr><td>Message: </td><td><textarea id = "message" name = "message" rows = "5" cols = "20"></textarea></td></tr>';
echo '<tr><td>Your Email: </td><td><input type = "input" name = "header" size = "26" /></td></tr>';
echo '<tr><td colspan = "2" align = "center"><input type = "reset" value = "Reset Form" />';
echo '<input type = "submit" name = "submit_email" value = "Send Email" /></td></tr></table></form>';
}
//checks and validates that all form inputs are filled and send the email
function checkContact($to = "random@sweetsimplicity.com", $subject = "", $message = "", $headers = ""){
if(isset($_POST["submit_email"])){
	//if no errors, send email
	$msg = "";	
	if(empty($_POST["subject"]))
		$msg = "Please enter the subject.<br />";
	if(empty($_POST["message"]))
		$msg .= "Please enter the message.<br />";
	if(empty($_POST["header"]))
		$msg .= "Please enter your email.<br />";
	if($msg == ""){
		unset($_POST["submit_email"]);
		mail("random@sweetsimplicity.com", $_POST["subject"], $_POST["message"], $_POST["header"]);
		return 'Email sent successfully.';
	}
else
	//if errors, return the message
	return $msg;
}
}
//news links, navigates to the different news sections
function newslinks(){
$links = <<<END
<table style = "font-size:12px" width = "888px">
	<tr>
		<th>
		 <a href = "http://people.rit.edu/jxz6853/539/project2/news/rit.php">RIT News</a>
		|<a href = "http://people.rit.edu/jxz6853/539/project2/news/nation.php">US News</a>
		|<a href = "http://people.rit.edu/jxz6853/539/project2/news/world.php">World News</a>
		|<a href = "http://people.rit.edu/jxz6853/539/project2/news/business.php">Business News</a>
		|<a href = "http://people.rit.edu/jxz6853/539/project2/news/technology.php">Technology News</a>
		|<a href = "http://people.rit.edu/jxz6853/539/project2/news/entertainment.php">Entertainment News</a>
		|<a href = "http://people.rit.edu/jxz6853/539/project2/news/sports.php">Sports News</a>
		|<a href = "http://people.rit.edu/jxz6853/539/project2/news/miscellaneous.php">Miscellaneous</a>
		</th>
	</tr>
</table>
END;
echo $links;
}
//news index, shows the articles in every group and the first 200 chars per article
function newsindex($rit = "rit.txt", $nation = "nation.txt", $world = "world.txt", $business = "business.txt", $technology = "technology.txt", $entertainment = "entertainment.txt", $sports = "sports.txt", $miscellaneous = "misc.txt"){
echo newslinks();
echo '<table style = "font-size:12px" width = "888px">';
echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project2/news/rit.php" name = "rit">RIT: News &amp; Events</a>';
if(file_exists($rit) && is_readable($rit)){
$ritdata = file($rit);
foreach($ritdata as $line){
	list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
	$ritindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
	//permalinks to show just one article at a time
	echo '<tr><td><a href = "/jxz6853/539/project2/news/rit.php/?page='.$url.'&max=1">'.$title.' <i>By '.$author.'</i></a></td><td rowspan = "2" width = "10%">'.$date.'</td></tr>';
	echo '<tr><td><i>'.$articleA.'...</i></td></tr>';
	}
}else	
	echo "<td><i>No news available for the rit.</i></td>";
echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project2/news/nation.php" name = "nation">US News</a></th></tr>';
if(file_exists($nation) && is_readable($nation)){
$nationdata = file($nation);
foreach($nationdata as $line){
	list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
	$nationindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
	echo '<tr><td><a href = "/jxz6853/539/project2/news/nation.php/?page='.$url.'&max=1">'.$title.' <i>By '.$author.'</i></a></td><td rowspan = "2" width = "10%">'.$date.'</td></tr>';
	echo '<tr><td><i>'.$articleA.'...</i></td></tr>';
	}
}else	
	echo "<td><i>No news available for the nation.</i></td>";
echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project2/news/world.php" name = "world">World News</a></th></tr>';
if(file_exists($world) && is_readable($world)){
$worlddata = file($world);
foreach($worlddata as $line){
	list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
	$worldindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
	echo '<tr><td><a href = "/jxz6853/539/project2/news/world.php/?page='.$url.'&max=1">'.$title.' <i>By '.$author.'</i></a></td><td rowspan = "2" width = "10%">'.$date.'</td></tr>';
	echo '<tr><td><i>'.$articleA.'...</i></td></tr>';
	}
}else	
	echo "<td><i>No news available for the world.</i></td>";
echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project2/news/business.php" name = "business">Business News</a></th></tr>';
if(file_exists($business) && is_readable($business)){
$businessdata = file($business);
foreach($businessdata as $line){
	list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
	$businessindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
	echo '<tr><td><a href = "/jxz6853/539/project2/news/business.php/?page='.$url.'&max=1">'.$title.' <i>By '.$author.'</i></a></td><td rowspan = "2" width = "10%">'.$date.'</td></tr>';
	echo '<tr><td><i>'.$articleA.'...</i></td></tr>';
	}
}else	
	echo "<td><i>No news available for the business.</i></td>";
echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project2/news/technology.php" name = "technology">Technology News</a></th></tr>';
if(file_exists($technology) && is_readable($technology)){
$technologydata = file($technology);
foreach($technologydata as $line){
	list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
	$technologyindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
	echo '<tr><td><a href = "/jxz6853/539/project2/news/technology.php/?page='.$url.'&max=1">'.$title.' <i>By '.$author.'</i></a></td><td rowspan = "2" width = "10%">'.$date.'</td></tr>';
	echo '<tr><td><i>'.$articleA.'...</i></td></tr>';
	}
}else
	echo "<td><i>No news available for the technology.</i></td>";
echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project2/news/entertainment.php" name = "entertainment">Entertainment News</a></th></tr>';
if(file_exists($entertainment) && is_readable($entertainment)){
$entertainmentdata = file($entertainment);
foreach($entertainmentdata as $line){
	list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
	$entertainmentindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
	echo '<tr><td><a href = "/jxz6853/539/project2/news/entertainment.php/?page='.$url.'&max=1">'.$title.' <i>By '.$author.'</i></a></td><td rowspan = "2" width = "10%">'.$date.'</td></tr>';
	echo '<tr><td><i>'.$articleA.'...</i></td></tr>';
	}
}else	
	echo "<td><i>No news available for the entertainment.</i></td>";
echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project2/news/sports.php" name = "sports">Sports News</a></th></tr>';
if(file_exists($sports) && is_readable($sports)){
$sportsdata = file($sports);
foreach($sportsdata as $line){
	list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
	$sportsindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
	echo '<tr><td><a href = "/jxz6853/539/project2/news/sports.php/?page='.$url.'&max=1">'.$title.' <i>By '.$author.'</i></a></td><td rowspan = "2" width = "10%">'.$date.'</td></tr>';
	echo '<tr><td><i>'.$articleA.'...</i></td></tr>';
	}
}else	
	echo "<td><i>No news available for the sports.</i></td>";
echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project2/news/miscellaneous.php"  name = "misc">Miscellaneous News</a></th></tr>';
if(file_exists($miscellaneous) && is_readable($miscellaneous)){
$miscellaneousdata = file($miscellaneous);
foreach($miscellaneousdata as $line){
	list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
	$miscellaneousindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
	echo '<tr><td><a href = "/jxz6853/539/project2/news/miscellaneous.php/?page='.$url.'&max=1">'.$title.' <i>By '.$author.'</i></a></td><td rowspan = "2" width = "10%">'.$date.'</td></tr>';
	echo '<tr><td><i>'.$articleA.'...</i></td></tr>';
	}
echo newslinks();
}else{
	echo newslinks();
	echo "<td><i>No news available for the miscellaneous.</i></td>";
}
echo '</table>';
}
//max per page
function maxpp(){
$max = <<<END
<table style = "font-size: 12px" width = "888px">
	<tr>
		<td><div style = "margin-left:750px">
		<form name = "selmax" method = "GET">
			<br />Posts per page:
			<select name = "max" onchange = "selmax.submit();">
				<option value = ""></option>
				<option value = "1">1</option>
				<option value = "3">3</option>
				<option value = "5">5</option>
				<option value = "10">10</option>
				<option value = "20">20</option>
			</select>
		</form>
		</td>
	</tr>
</table>
</div>
END;
echo $max;
}
//pagination, reading the actual articles with option to choose how many per page
//tells user to go back when there are no more results
function readnews($category = "none", $filen = "file.txt"){
	if(!isset($_GET['page']) && !isset($_GET['max']))
		@header("Location: /jxz6853/539/project2/news/".$category.".php?page=1&max=5");
	if(!isset($_GET['page']))
		@$_GET['page'] = 1;
	if(file_exists($filen) && is_readable($filen)){
		echo newslinks();
		echo maxpp();
		$filedata = file($filen);
		$articles = array();
		foreach($filedata as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$fileindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			$article = '<table style = "font-size:12px" width = "888px">';
			$article .= '<tr><th colspan = "2">';
			$article .= '<a href = "/jxz6853/539/project2/news/rit.php/?page='.$url.'&max=1">';
			$article .= $title.'</u></a></th></tr>';
			$article .= '<tr><td width = "50%">Published: '.$date.'</td><td width = "50%">Written by: '.$author.'</td></tr><tr><td colspan = "2">'.$articleA.$articleB.'</td></tr>';
			$article .= '<tr><td colspan = "2" align = "right"><b><i><a href = "/jxz6853/539/project2/comments.php">View Comments</a></i></b></table>';
			$articles[] .= $article;
		}
		if(isset($_POST["max"]))
			$numposts = @$_POST["max"];
		else
			$numposts = @$_GET["max"];
		$lines = count($line);
		@$numpages = ceil($lines / $numposts);
		$page = @$_GET['page'];
		$loop_start = (@$page - 1) * @$numposts;
		//10 - (5 * (2 + 1)) = -5 then last is 9
		if(($page * $numposts) - count($articles) > 0)
			$loop_end = count($articles) - 1;
		elseif(($page * $numposts) - count($articles) <= 0)
			if($loop_start == 0)
				@$loop_end = @$numposts - 1;
			elseif($numposts == 1)
				$loop_end = $page - 1;
			else
				$loop_end = ($loop_start * $page) - 1;
		//page 2: less than enough for that page (6, index 5)
		//($page * $numposts) - count($articles) > 0...10-6
		//page 2: enough to fill it (10, index 9), (12, index 9)
		//($page * $numposts) - count($articles) <= 0...10-10...10-12
		for($i = $loop_start; $i <= $loop_end; $i++){
			echo @$articles[$i];
		}
		echo '<table style = "font-size: 12px" width = "888px"><td align = "center">';
		if(($page <= 0) || ($page >= ceil(count($articles)/$numposts) + 1))
			echo "<p><strong>No more results, go back.</strong></p>";
			if($page <= 0){
				echo '&raquo; Go to: ';
				for($i = 1; $i <= @ceil(count($articles)/$numposts); $i++)
					echo ' <a href="?page='.$i.'&max='. $numposts .'">'.$i.'</a> ';
				echo '<a href = "?page='.($page + 1).'&max='.$numposts.'">Next </a>';
			}
			elseif($page >= ceil(count($articles)/$numposts) + 1){
				echo '&raquo; Go to: ';
				echo '<a href="?page='.($page - 1).'&max='.$numposts.'"> Previous</a>';
				for($i = 1; $i <= @ceil(count($articles)/$numposts); $i++)
					echo ' <a href="?page='.$i.'&max='. $numposts .'">'.$i.'</a> ';
			}
		else{
			echo '&raquo; Go to: ';
			echo '<a href="?page='.($page - 1).'&max='.$numposts.'"> Previous</a>';
			for($i = 1; $i <= @ceil(count($articles)/$numposts); $i++)
				echo ' <a href="?page='.$i.'&max='. $numposts .'">'.$i.'</a> ';
			echo '<a href = "?page='.($page + 1).'&max='.$numposts.'">Next </a>';
		}
		echo '&laquo;</td></table>';
		echo newslinks();
	}else{
		echo newslinks();
		return '<table style = "font-size:12px" width = "888px"><tr><th>No news available for the '.$category.'.</th></tr></table>';
	}
}
/* ---------------- Without pagination ---------------
//reading the news for only rit with the full articles
function readritt($rit = "rit.txt"){
	if(file_exists($rit) && is_readable($rit)){
		echo newslinks();
		$ritdata = file($rit);
		echo '<table style = "font-size:12px" width = "888px">';
		foreach($ritdata as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$ritindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			echo '<tr><th colspan = "2"><a name="'.$url.'"><u>'.$title.'</u></a></th></tr>';
			echo '<tr><td width = "50%">Published: '.$date.'</td><td width = "50%">Written by: '.$author.'</td></tr><tr><td colspan = "2">'.$articleA.$articleB.'</td></tr>';
			echo '<tr><td colspan = "2" align = "right"><b><i><a href = "/jxz6853/539/project2/comments.php">View Comments</a></i></b>';
			}
		echo '</table>';
		echo newslinks();
	}else{
		echo newslinks();
		return '<table style = "font-size:12px" width = "888px"><tr><th>No news available for the rit.</th></tr></table>';
	}
}
//reading the news for only national with the full articles
function readnation($nation = "nation.txt"){
	if(file_exists($nation) && is_readable($nation)){
		echo newslinks();
		$nationdata = file($nation);
		echo '<table style = "font-size:12px" width = "888px">';
		foreach($nationdata as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$nationindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			echo '<tr><th colspan = "2"><a name="'.$url.'"><u>'.$title.'</u></a></th></tr>';
			echo '<tr><td width = "50%">Published: '.$date.'</td><td width = "50%">Written by: '.$author.'</td></tr><tr><td colspan = "2">'.$articleA.$articleB.'</td></tr>';
			echo '<tr><td colspan = "2" align = "right"><b><i><a href = "/jxz6853/539/project2/comments.php">View Comments</a></i></b>';
			}
		echo '</table>';
		echo newslinks();
	}else{
		echo newslinks();
		return '<table style = "font-size:12px" width = "888px"><tr><th>No news available for the nation.</th></tr></table>';
	}
}
//reading the news for only world with the full articles
function readworld($world = "world.txt"){
	if(file_exists($world) && is_readable($world)){
		echo newslinks();
		$worlddata = file($world);
		echo '<table style = "font-size:12px" width = "888px">';
		foreach($worlddata as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$worldindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			echo '<tr><th colspan = "2"><a name="'.$url.'"><u>'.$title.'</u></a></th></tr>';
			echo '<tr><td width = "50%">Published: '.$date.'</td><td width = "50%">Written by: '.$author.'</td></tr><tr><td colspan = "2">'.$articleA.$articleB.'</td></tr>';
			echo '<tr><td colspan = "2" align = "right"><b><i><a href = "/jxz6853/539/project2/comments.php">View Comments</a></i></b>';
			}
		echo '</table>';
		echo newslinks();
	}else{
		echo newslinks();
		return '<table style = "font-size:12px" width = "888px"><tr><th>No news available for the world.</th></tr></table>';
	}
}
//reading the news for only business with the full articles
function readbusiness($business = "business.txt"){
	if(file_exists($business) && is_readable($business)){
		echo newslinks();
		$businessdata = file($business);
		echo '<table style = "font-size:12px" width = "888px">';
		foreach($businessdata as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$businessindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			echo '<tr><th colspan = "2"><a name="'.$url.'"><u>'.$title.'</u></a></th></tr>';
			echo '<tr><td width = "50%">Published: '.$date.'</td><td width = "50%">Written by: '.$author.'</td></tr><tr><td colspan = "2">'.$articleA.$articleB.'</td></tr>';
			echo '<tr><td colspan = "2" align = "right"><b><i><a href = "/jxz6853/539/project2/comments.php">View Comments</a></i></b>';
			}
		echo '</table>';
		echo newslinks();
	}else{
		echo newslinks();
		return '<table style = "font-size:12px" width = "888px"><tr><th>No news available for the business.</th></tr></table>';
	}
}
//reading the news for only technology with the full articles
function readtechnology($technology = "technology.txt"){
	if(file_exists($technology) && is_readable($technology)){
		echo newslinks();
		$technologydata = file($technology);
		echo '<table style = "font-size:12px" width = "888px">';
		foreach($technologydata as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$technologyindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			echo '<tr><th colspan = "2"><a name="'.$url.'"><u>'.$title.'</u></a></th></tr>';
			echo '<tr><td width = "50%">Published: '.$date.'</td><td width = "50%">Written by: '.$author.'</td></tr><tr><td colspan = "2">'.$articleA.$articleB.'</td></tr>';
			echo '<tr><td colspan = "2" align = "right"><b><i><a href = "/jxz6853/539/project2/comments.php">View Comments</a></i></b>';
			}
		echo '</table>';
		echo newslinks();
	}else{
		echo newslinks();
		return '<table style = "font-size:12px" width = "888px"><tr><th>No news available for the technology.</th></tr></table>';
	}
}
//reading the news for only entertainment with the full articles
function readentertainment($entertainment = "entertainment.txt"){
	if(file_exists($entertainment) && is_readable($entertainment)){
		echo newslinks();
		$entertainmentdata = file($entertainment);
		echo '<table style = "font-size:12px" width = "888px">';
		foreach($entertainmentdata as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$entertainmentindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			echo '<tr><th colspan = "2"><a name="'.$url.'"><u>'.$title.'</u></a></th></tr>';
			echo '<tr><td width = "50%">Published: '.$date.'</td><td width = "50%">Written by: '.$author.'</td></tr><tr><td colspan = "2">'.$articleA.$articleB.'</td></tr>';
			echo '<tr><td colspan = "2" align = "right"><b><i><a href = "/jxz6853/539/project2/comments.php">View Comments</a></i></b>';
			}
		echo '</table>';
		echo newslinks();
	}else{
		echo newslinks();
		return '<table style = "font-size:12px" width = "888px"><tr><th>No news available for the entertainment.</th></tr></table>';
	}
}
//reading the news for only sports with the full articles
function readsports($sports = "sports.txt"){
	if(file_exists($sports) && is_readable($sports)){
		echo newslinks();
		$sportsdata = file($sports);
		echo '<table style = "font-size:12px" width = "888px">';
		foreach($sportsdata as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$sportsindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			echo '<tr><th colspan = "2"><a name="'.$url.'"><u>'.$title.'</u></a></th></tr>';
			echo '<tr><td width = "50%">Published: '.$date.'</td><td width = "50%">Written by: '.$author.'</td></tr><tr><td colspan = "2">'.$articleA.$articleB.'</td></tr>';
			echo '<tr><td colspan = "2" align = "right"><b><i><a href = "/jxz6853/539/project2/comments.php">View Comments</a></i></b>';
			}
		echo '</table>';
		echo newslinks();
	}else{
		echo newslinks();
		return '<table style = "font-size:12px" width = "888px"><tr><th>No news available for the sports.</th></tr></table>';
	}
}
//reading the news for only miscellanenous with the full articles
function readmiscellanous($miscellanous = "misc.txt"){
	if(file_exists($miscellanous) && is_readable($miscellanous)){
		echo newslinks();
		$miscellanousdata = file($miscellanous);
		echo '<table style = "font-size:12px" width = "888px">';
		foreach($miscellanousdata as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$miscellanousindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			echo '<tr><th colspan = "2"><a name="'.$url.'"><u>'.$title.'</u></a></th></tr>';
			echo '<tr><td width = "50%">Published: '.$date.'</td><td width = "50%">Written by: '.$author.'</td></tr><tr><td colspan = "2">'.$articleA.$articleB.'</td></tr>';
			echo '<tr><td colspan = "2" align = "right"><b><i><a href = "/jxz6853/539/project2/comments.php">View Comments</a></i></b>';
			}
		echo '</table>';
		echo newslinks();
	}else{
		echo newslinks();
		return '<table style = "font-size:12px" width = "888px"><tr><th>No news available for the miscellaneous.</th></tr></table>';
	}
}
*/
//archives index, for the older articles
function archivessindex($archives = "archives.txt"){
if(file_exists($archives) && is_readable($archives)){
echo newslinks();
echo '<table style = "font-size:12px" width = "888px">';
echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project2/news/archives.php">Archives</a></th></tr>';
$archivesdata = file($archives);
foreach($archivesdata as $line){
	list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
	$archivesindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
	echo '<tr><td><a href = "/jxz6853/539/project2/news/archives.php?'.$url.'">'.$title.' <i>By '.$author.'</i></a></td><td rowspan = "2" width = "10%">'.$date.'</td></tr>';
	echo '<tr><td><i>'.$articleA.'...</i></td></tr>';
	}
echo newslinks();
}else
	echo newslinks();
	echo '<table style = "font-size:12px" width = "888px">';
	echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project2/news/archives.php">Archives</a></th></tr>';
	echo "<td><i>No news available in the archives.</i></td>";
echo '</table>';
}
//admins page to update the editorial, password protected
function updateEditorial(){
$string = '<h2>Update the editorial:</h2>';
$string .= '<form action = "'.$_SERVER["PHP_SELF"].'" method = "POST">';
$string .= '<table style = "font-size:12px" width = "700"><th>Preview:</th>';
$string .= '<tr><td>'.file_get_contents("editorial.txt").'</td></tr></table><br />';
$string .= '<textarea id = "update_editorial" name = "update_editorial" rows="10" cols="80">';
$string .= file_get_contents("editorial.txt").'</textarea>';
$string .= '<br /><br /><strong>File name: <input type = "input" name = "editorial_title" />';
$string .= ' Password: <input type="password" name="password" size="15" /></strong><br /><br />';
$string .= '<input type="reset" value="Reset Form" /><input type="submit" name="submit_editorial" value="Submit Changes" />';
$string .= '</form>';
return $string;
}
//admins page to check the editorial's form fields before saving to file
function checkUEditorial(){
if(isset($_POST["submit_editorial"])){
	$msg = "";
	echo "<br /><br />";
	if(empty($_POST["editorial_title"]))
		$msg = "Please enter the file name.<br />";
	if(empty($_POST["update_editorial"]))
		$msg .= "Please enter the editorial update.<br />";
	if((strlen($_POST["password"]) < 6) || ($_POST["password"] != "thepassword"))
		$msg .= "Invalid password.<br />";
	if($msg == ""){
		unset($_POST["submit_editorial"]);
		$fh = fopen($_POST["editorial_title"], "a+");
		$data = $_POST["update_editorial"];
		fwrite($fh, "$data\n");
		fclose($fh);
		return '<p>Editorial submitted successfully.</p>';
	}
else
	return $msg;
}
}
//admins page to add news articles, password protected
function updateNews(){
$string = '<h2>Add a news posting:</h2>';
$string .= '<form action = "'.$_SERVER["PHP_SELF"].'" method = "POST">';
$string .= '<strong>Title of Article: <input type = "input" name = "news_title" size = "50" />';
$string .= ' Author: <input type = "input" name = "news_author" size = "25" />';
$string .= '<textarea id = "addNews" name = "addNews" rows="10" cols="80"></textarea>';
$string .= ' <br /><br />Keyword: <input type = "text" name = "news_url" />';
$string .= ' Section: <select name = "newsf_title">';
$string .= '<option value = "rit.txt">RIT: News & Events</option>';
$string .= '<option value = "nation.txt">US News</option>';
$string .= '<option value = "world.txt">World News</option>';
$string .= '<option value = "business.txt">Business News</option>';
$string .= '<option value = "technology.txt">Technology News</option>';
$string .= '<option value = "entertainment.txt">Entertainment News</option>';
$string .= '<option value = "sports.txt">Sports News</option>';
$string .= '<option value = "misc.txt">Miscellaneous News</option>';
$string .= '</select>';
$string .= '<br /><br />Password: <input type="password" name="ppassword" size="15" /></strong><br /><br />';
$string .= '<input type="reset" value="Reset Form" /><input type="submit" name="submit_news" value="Submit News" />';
$string .= '</form>';
return $string;
}
//admins page to check the news article's form fields before saving to file
function checkNews(){
if(isset($_POST["submit_news"])){
	$msgg = "";
	echo "<br /><br />";
	if(empty($_POST["news_title"]))
		$msgg .= "Please enter the article name.<br />";
	if(empty($_POST["news_author"]))
		$msgg .= "Please enter the name of the author.<br />";
	if(empty($_POST["addNews"]))
		$msgg .= "Please enter the article content.<br />";
	elseif((strlen($_POST["addNews"]) < 200))
		$msgg .= "The article content is too short (200 chars).<br />";
	if(empty($_POST["news_url"]))
		$msgg .= "Please enter the url keyword.<br/ >";
	if(empty($_POST["newsf_title"]))
		$msgg .= "Please select the section name.<br/ >";
	if((strlen($_POST["ppassword"]) < 6) || ($_POST["ppassword"] != "thepassword"))
		$msgg .= "Invalid password.<br />";
	if($msgg == ""){
		unset($_POST["submit_news"]);
		$fhh = fopen($_POST["newsf_title"], "a+");
		$titlee = $_POST["news_title"];
		$authorr = $_POST["news_author"];
		$dataaA = substr($_POST["addNews"], 0, 200);
		$dataaB = substr($_POST["addNews"], 200);
		$urll = $_POST["news_url"];
		$datee = date("M. d, Y");
		fwrite($fhh, "$titlee|$urll|$datee|$authorr|$dataaA|$dataaB\n");
		fclose($fhh);
		return "<p>News article submitted successfully.</p>";
	}
else
	return $msgg;
}
}
//admins page to add an image file as an ad
function updateAds(){
$string = '<h2>Add an ad:</h2>';
$string .= '<form action = "'.$_SERVER["PHP_SELF"].'" method = "post" enctype = "multipart/form-data">';
$string .= '<strong><label for = "file">Filename:</label>';
$string .= '<input type = "file" name = "file" id = "file" /><br />';
$string .= '<input type = "submit" name = "submit_ads" value = "Submit" /></strong></form>';
return $string;
}
//admins page to check the ad's properties before uploading as image
function checkAds(){
if(isset($_POST["submit_ads"])){
	if(((($_FILES["file"]["type"] == "image/gif")|| ($_FILES["file"]["type"] == "image/jpeg")|| ($_FILES["file"]["type"] == "image/pjpeg"))|| ($_FILES["file"]["type"] == "image/png"))&& ($_FILES["file"]["size"] < 20000)){
		if ($_FILES["file"]["error"] > 0)
			echo "<br />Return Code: " . $_FILES["file"]["error"] . "<br />";
		else{
			echo "<br />Upload: " . $_FILES["file"]["name"] . "<br />";
			echo "Type: " . $_FILES["file"]["type"] . "<br />";
			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
			echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
			$fa = fopen("ads.txt", "a+");
			fwrite($fa, "\n".$_FILES["file"]["name"]);
			fclose($fa);
			if (file_exists("upload/" . $_FILES["file"]["name"]))
				echo $_FILES["file"]["name"] . " already exists. ";
			else{
				move_uploaded_file($_FILES["file"]["tmp_name"],
				"images/" . $_FILES["file"]["name"]);
				echo "Stored in: " . "images/" . $_FILES["file"]["name"];
			}
		}
	}
	else
		echo "<p>Invalid file.</p>";
	}
}
//admins page to add a site's logo-banner as an image file
function updateBanners(){
$string = '<h2>Add a banner:</h2>';
$string .= '<strong><form action = "'.$_SERVER["PHP_SELF"].'" method = "post" enctype = "multipart/form-data">';
$string .= '<label for="file">Filename:</label>';
$string .= '<input type="file" name="file" id="file" /><br />';
$string .= '<input type="submit" name="submit_ban" value="Submit" /></strong></form>';
return $string;
}
//admins page to check the image properties before uploading
function checkBanners(){
if(isset($_POST["submit_ban"])){
	if(((($_FILES["file"]["type"] == "image/gif")|| ($_FILES["file"]["type"] == "image/jpeg")|| ($_FILES["file"]["type"] == "image/pjpeg"))|| ($_FILES["file"]["type"] == "image/png"))&& ($_FILES["file"]["size"] < 20000)){
		if ($_FILES["file"]["error"] > 0)
			echo "<br />Return Code: " . $_FILES["file"]["error"] . "<br />";
		else{
			echo "<br />Upload: " . $_FILES["file"]["name"] . "<br />";
			echo "Type: " . $_FILES["file"]["type"] . "<br />";
			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
			echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
			$fa = fopen("banners.txt", "a+");
			fwrite($fa, "\n".$_FILES["file"]["name"]);
			fclose($fa);
			if (file_exists("upload/" . $_FILES["file"]["name"]))
				echo $_FILES["file"]["name"] . " already exists. ";
			else{
				move_uploaded_file($_FILES["file"]["tmp_name"],
				"images/" . $_FILES["file"]["name"]);
				echo "Stored in: " . "images/" . $_FILES["file"]["name"];
			}
		}
	}
	else
		echo "<p>Invalid file.</p>";
	}
}
//form to comment on the site in general or on an article
function comments(){
	$string = '<table style = "font-size:12px" align = "center" width = "500px"><tr><h2>Comment:</h2></tr>';
	$string .= '<tr><td width = "15%"><form action = "'.$_SERVER["PHP_SELF"].'" method = "POST">';
	$string .= 'Subject:</td><td><input type = "input" name = "subject" size = "66" /></td></tr>';
	$string .= '<tr><td>Message:</td><td><textarea id = "addComment" name = "addComment" rows = "5" cols = "50"></textarea></td></tr>';
	$string .= '<tr><td>Your Email:</td><td><input type = "text" name = "email" size = "66" /></td></tr>';
	$string .= '<tr><td colspan = "2" align = "center"><input type="reset" value="Reset Form" />';
	$string .= '<input type="submit" name="submit_comment" value="Submit Comment" /></form></td></tr></table>';
	echo $string;
}
//validates/sanitizes all comments before appending to a file for the comments
function checkcomments($comments = "comments.txt"){
	if(isset($_POST["submit_comment"])){
		$msg = "";	
		if(empty($_POST["subject"]))
			$msg = "Please enter the message subject.<br />";
		if(empty($_POST["addComment"]))
			$msg .= "Please enter your message.<br />";
		if(empty($_POST["email"]))
			$msg .= "Please enter your email.<br />";
		if($msg == ""){
			unset($_POST["submit_comment"]);
			$fh = fopen($comments, "a+");
			$subject = $_POST["subject"];
			$comment = filter_var($_POST["addComment"], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH);
			$email = $_POST["email"];
			$date = date('l\, jS \of F Y');
			$time = date('h:i:s A');
			fwrite($fh, "$date|$time|$subject|$comment|$email\n");
			fclose($fh);
			return 'Comment submitted successfully.';
		}
	else
		return $msg;
	}
}
//displays the comments automatically as they are added
function viewcomments($comments = "comments.txt"){
	if(file_exists($comments) && is_readable($comments)){
		$commentsdata = file($comments);
		echo '<p><h3>Posted Comments</h3></p>';
		echo '<hr width = "500px" color = "white">';
		foreach($commentsdata as $line){
			list($date, $time, $subject, $comment, $email) = explode("|",$line);
			$commentsindex[] = array('date' => $date,'time' => $time, 'subject' => $subject, 'comment' => $comment, 'email' => $email);
			echo '<table style = "font-size:12px" width = "500px">';
			echo '<tr><td align = "right">'.$date.'|'.$time.'</td></tr>';
			echo '<tr><td align = "right">Posted by: <a href = "mailto:'.$email.'">'.$email.'</a></td></tr>';
			echo '<tr><td><strong>'.$subject.'</strong></td></tr>';
			echo '<tr><td>'.$comment.'</td></tr></table>';
			echo '<hr width = "500px" color = "white">';
			}
	}else{
		return '<table style = "font-size:12px" width = "500px"><tr><th>No comments yet.</th></tr></table>';
	}
}
?>