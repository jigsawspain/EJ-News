<?php

function to_utf8( $string ) { 
    if ( preg_match('%^(?: 
      [\x09\x0A\x0D\x20-\x7E]            # ASCII 
    | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte 
    | \xE0[\xA0-\xBF][\x80-\xBF]         # excluding overlongs 
    | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte 
    | \xED[\x80-\x9F][\x80-\xBF]         # excluding surrogates 
    | \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3 
    | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15 
    | \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16 
)*$%xs', $string) ) { 
        return $string; 
    } else { 
        return iconv( 'CP1252', 'UTF-8', $string); 
    } 
} 

session_start();
if ($_SESSION['key'] != $_POST['key'] or $_POST['key']=="")
{
	echo "<p class=\"EJ_user_error\"><strong>AUTHORISATION ERROR</strong>: Unable to verify key!</p>";
} else
{
	$EJ_initPage ='ajax';
	require('../../init.inc.php');
	if (!isset($_POST['id']))
	{
	 $query = "INSERT INTO {$EJ_mysql->prefix}module_EJ_news SET EJ_newsTitle='".urldecode(to_utf8($_POST['title']))."', EJ_newsText='".str_replace(array("\n", "<br>", "<br/>", "£"),array("<br />","<br />","<br />", "&pound;"),urldecode(to_utf8($_POST['desc'])))."', EJ_newsCat = {$_POST['cat']}, EJ_newsDate = '".date("Y-m-d", strtotime($_POST['date']))."', EJ_newsImage='".$_POST['image']."', EJ_newsHidden = ".$_POST['hidden'].", EJ_newsPoster = '".$_POST['poster']."', EJ_newsTime = '".$_POST['time']."'";
	} else
	{
		$query = "UPDATE {$EJ_mysql->prefix}module_EJ_news SET EJ_newsTitle='".urldecode(to_utf8($_POST['title']))."', EJ_newsText='".str_replace(array("\n", "<br>", "<br/>", "£"),array("<br />","<br />","<br />", "&pound;"),urldecode(to_utf8($_POST['desc'])))."', EJ_newsCat = ".$_POST['cat'].", EJ_newsDate = '".date("Y-m-d", strtotime($_POST['date']))."', EJ_newsImage='".$_POST['image']."', EJ_newsHidden = ".$_POST['hidden'].", EJ_newsPoster = '".$_POST['poster']."', EJ_newsTime = '".$_POST['time']."' WHERE EJ_newsId = ".$_POST['id']."";
	}
	$EJ_mysql->query($query);
	echo "OK";
}
?>