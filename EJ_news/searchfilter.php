<?php 
session_start();
if ($_POST['key'] != $_SESSION['key'] or $_POST['key']=="")
{
	echo "<p class=\"EJ_user_error\"><strong>AUTHORISATION ERROR</strong>: Unable to verify key!</p>";
	echo "<p>{$_SESSION['key']}::{$_POST['key']}</p>";
} else
{
	$EJ_initPage ='ajax';
	require('../../init.inc.php');
	$query="SELECT SQL_CALC_FOUND_ROWS * FROM {$EJ_mysql->prefix}module_EJ_news WHERE EJ_newsId != 0";
	if ($_POST['date']!=0)
	{
		$date = date('Y-m-d', strtotime($_POST['date']));
		$query .= " AND EJ_newsDate = '$date'";
	}
	if (!empty($_POST['text']))
	{
		$query .= " AND (EJ_newsTitle LIKE '%{$_POST['text']}%' OR EJ_newsText LIKE '%{$_POST['text']}%')";
	}
	if ($_POST['cat']!=0)
	{
		$query .= " AND EJ_newsCat = ".$_POST['cat'];
	}
	if ($_POST['poster']!="0")
	{
		$query .= " AND EJ_newsPoster = '".$_POST['poster']."'";
	}
	if ($_POST['hidden']==1)
	{
		$query .= " AND EJ_newsHidden = 0";
	}
	$query .= " LIMIT ".$_POST['limit'];
	$EJ_mysql->query($query);
	if ($EJ_mysql->numRows() == 0)
	{
		echo '<div class="news_result" style="text-align: center;"><p><strong>No Results Found! Please try a broader search.</strong></p></div>';
	} else
	{
		while ($result = $EJ_mysql->getRow())
		{
			if (empty($result['EJ_newsImage']) or !file_exists("images/".$result['EJ_newsImage']))
			{
				$img = "noimage.png";
			} else
			{
				$img = $result['EJ_newsImage'];
			}
			echo '
				<div class="news_result" id="'.$result['EJ_newsId'].'">
					<div style="float: right;"><img src="modules/EJ_news/recycle.png" alt="delete" title="Delete news" style="cursor: pointer;" onclick="deletenews(\''.$result['EJ_newsId'].'\', \''.$_SESSION['key'].'\')" /> <a href="?module=EJ_news&action=editnews&newsid='.$result['EJ_newsId'].'"><img src="modules/EJ_news/edit.png" alt="edit" title="Edit news" style="cursor: pointer;" /></a> <img src="modules/EJ_news/blue_down.png" alt="show/hide details" title="Show/Hide Details" style="cursor: pointer;" onclick="Slide(this.parentNode.parentNode, 16, 150)" /></div>
					<p><strong>'.date("d/m/Y", strtotime($result['EJ_newsDate'])).' - '.$result['EJ_newsTitle'].'</strong> posted by: '.$result['EJ_newsPoster'].'</p>
					<p><img class="newsImage" src="modules/EJ_news/images/'.$img.'" alt="'.$news['EJ_newsTitle'].'" />'.$result['EJ_newsText'].'</p>
				</div>';
		}
	}
	$EJ_mysql->query("SELECT FOUND_ROWS() as results");
	$rows = $EJ_mysql->getRow();
	echo ":::".$rows['results'];
}
?>