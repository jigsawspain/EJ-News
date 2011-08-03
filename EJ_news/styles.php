<?php
header("Content-Type: text/css");
require('../../config.inc.php');
?>
@charset "utf-8";

/*
*** EJigsaw Site Administration Suite
**
*** EJ_news Module
**
*** By Jigsaw Spain - www.jigsawspain.com
**
*** EJ_news Styles - File Build 0.1
*/

/*
* Common Tags
*/

h2.EJN
{
	border-top: #42769B 1px solid;
	border-bottom: #42769B 1px solid;
	color: #42769B;
	font-size: 1.1em;
	margin: 0;
	padding: 0 3px;
}

h2.EJN img
{
	border:0;
	height: 15px;
	margin-bottom: 0.2em;
	vertical-align: middle;
	width: 15px;
}


/*
* Classes and IDs
*/

#addLeft
{
	float: left;
	margin: 5px;
	padding: 5px;
	text-align: center;
	width: 200px;
}

#addLeft input
{
	width: 100%;
}

#addLeft img
{
	cursor: pointer;
	margin: 5px;
}

#addRight
{
	float: left;
	margin: 5px;
	padding: 5px;
	width: 736px;
}

.button
{
	cursor: pointer;
	display: inline-block;
	height: 100px;
	margin: 15px;
	overflow: hidden;
	text-indent: -1000px;
	width: 100px;
}

.button:hover
{
	background-position: 0 -100px;
}

.cat_result
{
	background-color: #FFF;
	border: #42769B 1px solid;
	height: 16px;
	line-height: 16px;
	margin: 10px;
	overflow: hidden;
	padding: 5px;
}

.cat_result img
{
	vertical-align: middle;
	margin-top: -0.2em;
}

#container
{
	color: #42769B;
	font-size: 0.9em;
}

.EJ_newsSummary
{
	font-size: 10px;
	margin: 3px 0;
	width: 100%;
}

.EJ_newsSummary .header
{
	margin-bottom: 3px;
}

.EJ_newsSummary .header a
{
	font-weight: bold;
	font-size: 12px !important;
}

.EJ_newsSummary a
{
	color: #009ACA;
}

.EJ_newsSummaryImageHolder
{
	display: table-cell;
	height: 60px;
	text-align: center;
	vertical-align: middle;
	width: 80px;
}

.EJ_newsSummaryImageHolder img
{
	display: block;
	margin: 0 auto;
}

.news_result
{
	background-color: #FFF;
	border: #42769B 1px solid;
	height: 16px;
	margin: 10px;
	overflow: hidden;
	padding: 5px;
}

.newsImage
{
	float: left;
	height: 120px;
	margin: 0 5px 5px 0;
	width: 120px;
}

.news_result p
{
	margin-bottom: 5px;
}

#search_form
{
	background-color: #FFF;
	border: #42769B 1px solid;
	margin: 10px;
	padding: 5px;
}

#news_message
{
	text-align: center;
}

.news
{
	background: #42769B;
	color: #E3EEF7;
	cursor: pointer;
	display: inline-block;
	white-space: nowrap;
	width: 200px;
}

.news:hover
{
	background-color: #CCE0EE;
	color: #42769B;
}

.news_day
{
	border: #CCC 1px solid;
	margin: 2px;
}

.news_news
{
	border-top: #CCC 1px solid;
	padding: 3px;
}

.news_news a
{
	color: #42769B;
}

.news_news p
{
	margin: 0;
}

#news_head
{
	background: #E3EEF7;
	color: #42769B;
	font-weight: bold;
	text-align: center;
}

.news_item
{
	background: #42769B;
	color: #E3EEF7;
	display: inline-block;
	height: 16px;
	line-height: 16px;
	overflow: hidden;
	padding: 2px;
	z-index: 98;
}

.news_item:hover
{
	background-color: #CCE0EE;
	color: #42769B;
}

#news_left
{
	background: #FFF;
	border: #CCC 1px solid;
	float: left;
	margin:  5px 0 5px 5px;
	text-align: center;
	width: 250px;
}

#news_right
{
	background: #FFF;
	border: #CCC 1px solid;
	float: right;
	margin: 5px 5px 5px 0;
	width: 720px;
}

#news_right p
{
	margin: 5px;
}

#month_name
{
	background: #E3EEF7;
	border: #CCC 1px solid;
	color: #42769B;
	font-weight: bold;
	height: 16px;
	margin-bottom: -1px;
	text-align: center;
	width: 705px;
}

.today
{
	background: #E3EEF7;
}

.we
{
	background: #DDD;
}

.Xday
{
	background: #999;
}