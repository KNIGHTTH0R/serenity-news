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
	<link href = "http://people.rit.edu/jxz6853/539/project/images/favicon.ico" rel = "shortcut icon" />
	<link href = "http://people.rit.edu/jxz6853/539/project/images/favicon.png" rel = "icon" type = "image/gif" />
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
<body background="http://people.rit.edu/jxz6853/539/project/images/bg1.png" style = "font-family: $font; font-size: $size; color: $text; background-color: $bgcolor; text-align: center; background-position:center; background-repeat: repeat-y;">
<p style = "margin-left:500px"><strong>It is $date | $time</strong></p>
END;
	return $body;
}
//getting the current weather in Rochester
function weather(){
//the place can be changed in the url
$url = "http://www.weather.com/weather/today/USNY1232";
$info = file_get_contents($url);
$image = return_between($info, '2"><img src="', '" alt="', EXCL);
$des = return_between($info, '2"><img src="', ' w', EXCL);
$desc = return_between($des, 'alt="', '"', EXCL);
$temp = return_between($info, '1 twc-forecast-temperature"><strong>', '"', EXCL);
$weather = <<<END
<table>
	<tr>
		<td>
			<img src = "$image" width = "90px" height = "90px" />
			<span style = "font-size: 42px; color:#999999;">$temp</span>
		</td>
	</tr>
	<tr>
		<td colspan="2">
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
	return '<img src = "http://people.rit.edu/jxz6853/539/project/images/'.$randban.'" border = "0" usemap = "#ss" /><map name="ss"><area shape="rect" coords="400,100,580,130" href="https://members.csh.rit.edu/~coffee/index.php"></map>';
}else
	//raise an error if file doesn't exist/not readable
	die("<strong>Problem loading file at $ban_file!</strong>");
}
//menu/navigation linking to other pages
function menu($menu = "nav.png"){
$menu = <<<END
<a class = "opacity">
<img src = "http://people.rit.edu/jxz6853/539/project/images/$menu" border = "0" usemap = "#map" />
<map name="map">
	<area shape="rect" coords="0,0,180,35" href="http://people.rit.edu/jxz6853/539/project/index.php">
	<area shape="rect" coords="180,0,360,35" href="http://people.rit.edu/jxz6853/539/project/news.php">
	<area shape="rect" coords="360,0,540,35" href="http://people.rit.edu/jxz6853/539/project/news/archives.php">
	<area shape="rect" coords="540,0,720,35" href="http://people.rit.edu/jxz6853/539/project/contact.php">
	<area shape="rect" coords="720,0,900,35" href="http://people.rit.edu/jxz6853/539/project/admin.php">
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
//ritnews, takes in content in file as array and returns the title for each article
function ritnews($rit = "rit.txt"){
	if(file_exists($rit) && is_readable($rit)){
		$ritdata = file($rit);
		foreach($ritdata as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$ritindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			echo '<li><a href = "/jxz6853/539/project/news.php/#rit">'.$title.'</a></li>';
		}
	}else
		//if file doesn't exist/not readable
		echo "<strong>No news available for the rit.</strong>";
}
//nationnews, takes in content in file as array and returns the title for each article
function nationnews($nation = "nation.txt"){
	if(file_exists($nation) && is_readable($nation)){
		$nationdata = file($nation);
		foreach($nationdata as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$nationindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			echo '<li><a href = "/jxz6853/539/project/news.php/#nation">'.$title.'</a></li>';
		}
	}else
		//if file doesn't exist/not readable
		echo "<strong>No news available for the nation.</strong>";
}
//worldnews, takes in content in file as array and returns the title for each article
function worldnews($world = "world.txt"){
	if(file_exists($world) && is_readable($world)){
		$worlddata = file($world);
		foreach($worlddata as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$worldindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			echo '<li><a href = "/jxz6853/539/project/news.php/#world">'.$title.'</a></li>';
		}
	}else
		//if file doesn't exist/not readable
		echo "<strong>No news available for the world.</strong>";
}
//businessnews, takes in content in file as array and returns the title for each article
function businessnews($business = "business.txt"){
	if(file_exists($business) && is_readable($business)){
		$businessdata = file($business);
		foreach($businessdata as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$businessindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			echo '<li><a href = "/jxz6853/539/project/news.php/#business">'.$title.'</a></li>';
		}
	}else
		//if file doesn't exist/not readable
		echo "<strong>No news available for the business.</strong>";
}
//technologynews, takes in content in file as array and returns the title for each article
function technologynews($technology = "technology.txt"){
	if(file_exists($technology) && is_readable($technology)){
		$technologydata = file($technology);
		foreach($technologydata as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$technologyindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			echo '<li><a href = "/jxz6853/539/project/news.php/#technology">'.$title.'</a></li>';
		}
	}else
		//if file doesn't exist/not readable
		echo "<strong>No news available for the technology.</strong>";
}
//entertainmentnews, takes in content in file as array and returns the title for each article
function entertainmentnews($entertainment = "entertainment.txt"){
	if(file_exists($entertainment) && is_readable($entertainment)){
		$entertainmentdata = file($entertainment);
		foreach($entertainmentdata as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$entertainmentindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			echo '<li><a href = "/jxz6853/539/project/news.php/#entertainment">'.$title.'</a></li>';
		}
	}else
		//if file doesn't exist/not readable
		echo "<strong>No news available for the entertainment.</strong>";
}
//sportsnews, takes in content in file as array and returns the title for each article
function sportsnews($sports = "sports.txt"){
	if(file_exists($sports) && is_readable($sports)){
		$sportsdata = file($sports);
		foreach($sportsdata as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$sportsindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			echo '<li><a href = "/jxz6853/539/project/news.php/#sports">'.$title.'</a></li>';
		}
	}else
		//if file doesn't exist/not readable
		echo "<strong>No news available for the sports.</strong>";
}
//miscellaneousnews, takes in content in file as array and returns the title for each article
function miscellaneousnews($miscellaneous = "misc.txt"){
	if(file_exists($miscellaneous) && is_readable($miscellaneous)){
		$miscellaneousdata = file($miscellaneous);
		foreach($miscellaneousdata as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$miscellaneousindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			echo '<li><a href = "/jxz6853/539/project/news.php/#misc">'.$title.'</a></li>';
		}
	}else
		//if file doesn't exist/not readable
		echo "<strong>No news available for the miscellaneous.</strong>";
}
//news, the homepage with all of the news sections and titles
function news($rit = "rit.txt", $nation = "nation.txt", $world = "world.txt", $business = "business.txt", $technology = "technology.txt", $entertainment = "entertainment.txt", $sports = "sports.txt", $miscellaneous = "misc.txt"){
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
ritnews($rit = "rit.txt");
echo '</td>
		<td height = "200px">';
nationnews($nation = "nation.txt");
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
worldnews($world = "world.txt");
echo '</td>
		<td height = "200px">';
businessnews($business = "business.txt");
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
technologynews($technology = "technology.txt");
echo '</td>
		<td height = "200px">';
entertainmentnews($entertainment = "entertainment.txt");
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
sportsnews($sports = "sports.txt");
echo '</td>
		<td height = "200px">';
miscellaneousnews($miscellaneous = "misc.txt");
echo '</td>
	</tr>
</table>';
}
//advertisements on the bottom of page, random images displayed from the array
function ads($ad_file = "ads.txt"){
if(file_exists($ad_file) && is_readable($ad_file)){
	$ads = file($ad_file);
	$randad = $ads[array_rand($ads)];
	return '<p><img src = "http://people.rit.edu/jxz6853/539/project/images/'.$randad.'" /></p>';
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
		 <a href = "http://people.rit.edu/jxz6853/539/project/news/rit.php">RIT News</a>
		|<a href = "http://people.rit.edu/jxz6853/539/project/news/nation.php">US News</a>
		|<a href = "http://people.rit.edu/jxz6853/539/project/news/world.php">World News</a>
		|<a href = "http://people.rit.edu/jxz6853/539/project/news/business.php">Business News</a>
		|<a href = "http://people.rit.edu/jxz6853/539/project/news/technology.php">Technology News</a>
		|<a href = "http://people.rit.edu/jxz6853/539/project/news/entertainment.php">Entertainment News</a>
		|<a href = "http://people.rit.edu/jxz6853/539/project/news/sports.php">Sports News</a>
		|<a href = "http://people.rit.edu/jxz6853/539/project/news/miscellaneous.php">Miscellaneous</a>
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
echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project/news/rit.php" name = "rit">RIT: News &amp; Events</a>';
if(file_exists($rit) && is_readable($rit)){
$ritdata = file($rit);
foreach($ritdata as $line){
	list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
	$ritindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
	echo '<tr><td><a href = "/jxz6853/539/project/news/rit.php/#'.$url.'">'.$title.' <i>By '.$author.'</i></a></td><td rowspan = "2" width = "10%">'.$date.'</td></tr>';
	echo '<tr><td><i>'.$articleA.'...</i></td></tr>';
	}
}else	
	echo "<td><i>No news available for the rit.</i></td>";
echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project/news/nation.php" name = "nation">US News</a></th></tr>';
if(file_exists($nation) && is_readable($nation)){
$nationdata = file($nation);
foreach($nationdata as $line){
	list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
	$nationindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
	echo '<tr><td><a href = "/jxz6853/539/project/news/nation.php/#'.$url.'">'.$title.' <i>By '.$author.'</i></a></td><td rowspan = "2" width = "10%">'.$date.'</td></tr>';
	echo '<tr><td><i>'.$articleA.'...</i></td></tr>';
	}
}else	
	echo "<td><i>No news available for the nation.</i></td>";
echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project/news/world.php" name = "world">World News</a></th></tr>';
if(file_exists($world) && is_readable($world)){
$worlddata = file($world);
foreach($worlddata as $line){
	list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
	$worldindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
	echo '<tr><td><a href = "/jxz6853/539/project/news/world.php/#'.$url.'">'.$title.' <i>By '.$author.'</i></a></td><td rowspan = "2" width = "10%">'.$date.'</td></tr>';
	echo '<tr><td><i>'.$articleA.'...</i></td></tr>';
	}
}else	
	echo "<td><i>No news available for the world.</i></td>";
echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project/news/business.php" name = "business">Business News</a></th></tr>';
if(file_exists($business) && is_readable($business)){
$businessdata = file($business);
foreach($businessdata as $line){
	list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
	$businessindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
	echo '<tr><td><a href = "/jxz6853/539/project/news/business.php/#'.$url.'">'.$title.' <i>By '.$author.'</i></a></td><td rowspan = "2" width = "10%">'.$date.'</td></tr>';
	echo '<tr><td><i>'.$articleA.'...</i></td></tr>';
	}
}else	
	echo "<td><i>No news available for the business.</i></td>";
echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project/news/technology.php" name = "technology">Technology News</a></th></tr>';
if(file_exists($technology) && is_readable($technology)){
$technologydata = file($technology);
foreach($technologydata as $line){
	list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
	$technologyindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
	echo '<tr><td><a href = "/jxz6853/539/project/news/technology.php/#'.$url.'">'.$title.' <i>By '.$author.'</i></a></td><td rowspan = "2" width = "10%">'.$date.'</td></tr>';
	echo '<tr><td><i>'.$articleA.'...</i></td></tr>';
	}
}else
	echo "<td><i>No news available for the technology.</i></td>";
echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project/news/entertainment.php" name = "entertainment">Entertainment News</a></th></tr>';
if(file_exists($entertainment) && is_readable($entertainment)){
$entertainmentdata = file($entertainment);
foreach($entertainmentdata as $line){
	list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
	$entertainmentindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
	echo '<tr><td><a href = "/jxz6853/539/project/news/entertainment.php/#'.$url.'">'.$title.' <i>By '.$author.'</i></a></td><td rowspan = "2" width = "10%">'.$date.'</td></tr>';
	echo '<tr><td><i>'.$articleA.'...</i></td></tr>';
	}
}else	
	echo "<td><i>No news available for the entertainment.</i></td>";
echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project/news/sports.php" name = "sports">Sports News</a></th></tr>';
if(file_exists($sports) && is_readable($sports)){
$sportsdata = file($sports);
foreach($sportsdata as $line){
	list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
	$sportsindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
	echo '<tr><td><a href = "/jxz6853/539/project/news/sports.php/#'.$url.'">'.$title.' <i>By '.$author.'</i></a></td><td rowspan = "2" width = "10%">'.$date.'</td></tr>';
	echo '<tr><td><i>'.$articleA.'...</i></td></tr>';
	}
}else	
	echo "<td><i>No news available for the sports.</i></td>";
echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project/news/miscellaneous.php"  name = "misc">Miscellaneous News</a></th></tr>';
if(file_exists($miscellaneous) && is_readable($miscellaneous)){
$miscellaneousdata = file($miscellaneous);
foreach($miscellaneousdata as $line){
	list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
	$miscellaneousindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
	echo '<tr><td><a href = "/jxz6853/539/project/news/miscellaneous.php/#'.$url.'">'.$title.' <i>By '.$author.'</i></a></td><td rowspan = "2" width = "10%">'.$date.'</td></tr>';
	echo '<tr><td><i>'.$articleA.'...</i></td></tr>';
	}
echo newslinks();
}else{
	echo newslinks();
	echo "<td><i>No news available for the miscellaneous.</i></td>";
}
echo '</table>';
}
//sep groups
function readritt($rit = "rit.txt")
{
	if(file_exists($rit) && is_readable($rit))
	{
		$ritdata = file($rit);
		$articles = array();
		foreach($ritdata as $line)
		{
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$ritindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			$article  = '<table style = "font-size:12px" width = "888px"><tr><th colspan = "2"><a href = "/jxz6853/539/project/news.php?rit='.$url.'">'.$title.'</a></th></tr>';
			$article .= '<tr><td width = "50%">Published: '.$date.'</td><td width = "50%">Written by: '.$author.'</td></tr><tr><td colspan = "2">'.$articleA.$articleB.'</td></tr>';
			$article .= '<tr><td colspan = "2" align = "right"><b><i><a href = "/jxz6853/539/project/comments.php'.$url.'">View Comments</a></i></b></table>';
			$articles[] = $article;
			unset($article);
		}
	}
	else
	{
		return array('<table style = "font-size:12px" width = "888px"><tr><th>No news available for the rit.</th></tr></table>');
	}
}
/* pagination
for($i = 0; $i < count($article); $i++){
	//$article[i];
	return ceil(count($article)/5)
	if
	//ceil, $_get['page'], die("{$_GET['page']}")
}
*/
//reading the news for only rit with the full articles
function readrit($rit = "rit.txt"){
	if(file_exists($rit) && is_readable($rit)){
		echo newslinks();
		$ritdata = file($rit);
		echo '<table style = "font-size:12px" width = "888px">';
		foreach($ritdata as $line){
			list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
			$ritindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
			echo '<tr><th colspan = "2"><a name="'.$url.'"><u>'.$title.'</u></a></th></tr>';
			echo '<tr><td width = "50%">Published: '.$date.'</td><td width = "50%">Written by: '.$author.'</td></tr><tr><td colspan = "2">'.$articleA.$articleB.'</td></tr>';
			echo '<tr><td colspan = "2" align = "right"><b><i><a href = "/jxz6853/539/project/comments.php">View Comments</a></i></b>';
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
			echo '<tr><td colspan = "2" align = "right"><b><i><a href = "/jxz6853/539/project/comments.php">View Comments</a></i></b>';
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
			echo '<tr><td colspan = "2" align = "right"><b><i><a href = "/jxz6853/539/project/comments.php">View Comments</a></i></b>';
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
			echo '<tr><td colspan = "2" align = "right"><b><i><a href = "/jxz6853/539/project/comments.php">View Comments</a></i></b>';
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
			echo '<tr><td colspan = "2" align = "right"><b><i><a href = "/jxz6853/539/project/comments.php">View Comments</a></i></b>';
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
			echo '<tr><td colspan = "2" align = "right"><b><i><a href = "/jxz6853/539/project/comments.php">View Comments</a></i></b>';
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
			echo '<tr><td colspan = "2" align = "right"><b><i><a href = "/jxz6853/539/project/comments.php">View Comments</a></i></b>';
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
			echo '<tr><td colspan = "2" align = "right"><b><i><a href = "/jxz6853/539/project/comments.php">View Comments</a></i></b>';
			}
		echo '</table>';
		echo newslinks();
	}else{
		echo newslinks();
		return '<table style = "font-size:12px" width = "888px"><tr><th>No news available for the miscellaneous.</th></tr></table>';
	}
}

//archives index, for the older articles
function archivessindex($archives = "archives.txt"){
if(file_exists($archives) && is_readable($archives)){
echo newslinks();
echo '<table style = "font-size:12px" width = "888px">';
echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project/news/archives.php">Archives</a></th></tr>';
$archivesdata = file($archives);
foreach($archivesdata as $line){
	list($title, $url, $date, $author, $articleA, $articleB) = explode("|",$line);
	$archivesindex[] = array('title' => $title,'url' => $url, 'date' => $date, 'author' => $author, 'articleA' => $articleA, 'articleB' => $articleB);
	echo '<tr><td><a href = "/jxz6853/539/project/news/archives.php?'.$url.'">'.$title.' <i>By '.$author.'</i></a></td><td rowspan = "2" width = "10%">'.$date.'</td></tr>';
	echo '<tr><td><i>'.$articleA.'...</i></td></tr>';
	}
echo newslinks();
}else
	echo newslinks();
	echo '<table style = "font-size:12px" width = "888px">';
	echo '<tr><th align = "left"><a href = "http://people.rit.edu/jxz6853/539/project/news/archives.php">Archives</a></th></tr>';
	echo "<td><i>No news available in the archives.</i></td>";
echo '</table>';
}
//admins page to update the editorial, password protected
function updateEditorial(){
echo '<h2>Update the editorial:</h2>';
echo '<form action = "'.$_SERVER["PHP_SELF"].'" method = "POST">';
echo '<textarea id = "update_editorial" name = "update_editorial" rows="10" cols="80"></textarea>';
echo '<br /><br /><strong>File name: <input type = "input" name = "editorial_title" />';
echo ' Password: <input type="password" name="password" size="15" /></strong><br /><br />';
echo '<input type="reset" value="Reset Form" /><input type="submit" name="submit_editorial" value="Submit Changes" />';
echo '</form>';
}
//admins page to check the editorial's form fields before saving to file
function checkUEditorial(){
if(isset($_POST["submit_editorial"])){
	$msg = "";	
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
		return 'Editorial submitted successfully.';
	}
else
	return $msg;
}
}
//admins page to add news articles, password protected
function updateNews(){
echo '<h2>Add a news posting:</h2>';
echo '<form action = "'.$_SERVER["PHP_SELF"].'" method = "POST">';
echo '<strong>Title of Article: <input type = "input" name = "news_title" size = "50" />';
echo ' Author: <input type = "input" name = "news_author" size = "25" />';
echo '<textarea id = "addNews" name = "addNews" rows="10" cols="80"></textarea>';
echo ' <br /><br />Keyword: <input type = "text" name = "news_url" />';
echo ' Date: <input type = "text" name = "news_date" />';
echo '<br /><br />File name: <input type = "input" name = "newsf_title" value = "misc.txt" />';
echo ' Password: <input type="password" name="ppassword" size="15" /></strong><br /><br />';
echo '<input type="reset" value="Reset Form" /><input type="submit" name="submit_news" value="Submit News" />';
echo '</form>';
}
//admins page to check the news article's form fields before saving to file
function checkNews(){
if(isset($_POST["submit_news"])){
	$msgg = "";
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
	if(empty($_POST["news_date"]))
		$msgg .= "Please enter the date published.<br/ >";
	if(empty($_POST["newsf_title"]))
		$msgg .= "Please enter the file name.<br/ >";
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
		$datee = $_POST["news_date"];
		fwrite($fhh, "$titlee|$urll|$datee|$authorr|$dataaA|$dataaB\n");
		fclose($fhh);
		return "News article submitted successfully.";
	}
else
	return $msgg;
}
}
//admins page to add an image file as an ad
function updateAds(){
echo '<h2>Add an ad:</h2>';
echo '<form action = "'.$_SERVER["PHP_SELF"].'" method = "post" enctype = "multipart/form-data">';
echo '<strong><label for = "file">Filename:</label>';
echo '<input type = "file" name = "file" id = "file" /><br />';
echo '<input type = "submit" name = "submit_ads" value = "Submit" /></strong></form>';
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
		echo "Invalid file.";
	}
}
//admins page to add a site's logo-banner as an image file
function updateBanners(){
echo '<h2>Add a banner:</h2>';
echo '<strong><form action = "'.$_SERVER["PHP_SELF"].'" method = "post" enctype = "multipart/form-data">';
echo '<label for="file">Filename:</label>';
echo '<input type="file" name="file" id="file" /><br />';
echo '<input type="submit" name="submit_ban" value="Submit" /></strong></form>';
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
		echo "Invalid file.";
	}
}
//form to comment on the site in general or on an article
function comments(){
	echo '<table style = "font-size:12px" align = "center" width = "500px"><tr><h2>Comment:</h2></tr>';
	echo '<tr><td width = "15%"><form action = "'.$_SERVER["PHP_SELF"].'" method = "POST">';
	echo 'Subject:</td><td><input type = "input" name = "subject" size = "66" /></td></tr>';
	echo '<tr><td>Message:</td><td><textarea id = "addComment" name = "addComment" rows = "5" cols = "50"></textarea></td></tr>';
	echo '<tr><td>Your Email:</td><td><input type = "text" name = "email" size = "66" /></td></tr>';
	echo '<tr><td colspan = "2" align = "center"><input type="reset" value="Reset Form" />';
	echo '<input type="submit" name="submit_comment" value="Submit Comment" /></form></td></tr></table>';
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