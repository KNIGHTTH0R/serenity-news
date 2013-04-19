<?php
include("LIB_parse.php");
include("LIB_template.php");
include("template.css");
$top = "";
$top .= i_header($title = "Serenity: News", $styles = "", $keywords = "news, weather");
$top .= i_body($font = "tahoma", $size = "12px", $text = "white", $bgcolor = "#27b1f1", $subcolor = "");
$weather = weather();
$banner = banner($ban_file = "banners.txt");
$banners = <<<END
<table>
	<td width = "240px">$weather</td>
	<td>$banner</td>
</table>
END;
$top .= $banners;
$top .= menu($menu = "nav.png");
echo $top;
$body = "";
$body .= newsindex($rit = "rit.txt", $nation = "nation.txt", $world = "world.txt", $business = "business.txt", $technology = "technology.txt", $entertainment = "entertainment.txt", $sports = "sports.txt", $miscellaneous = "misc.txt");
echo $body;
$bottom = "";
$bottom .= ads($ad_file = "ads.txt");
$bottom .= userinfo();
$bottom .= saveuserinfo();
$bottom .= copyright($copyright = "Jenny Zhen, 2010");
echo $bottom;
?>