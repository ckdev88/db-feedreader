<?php
global $DATA;
include('./incl/GetFeeds.php');
function pp($content, $theme = '', $bg = '', $fg = '')
{
	if ($theme == 'lime') {
		$bg = 'lime';
		$fg = 'black';
	} elseif ($theme == 'lime2') {
		$bg = 'black';
		$fg = 'lime';
	} elseif ($theme == 'yellow') {
		$bg = 'yellow';
		$fg = 'black';
	} elseif ($theme == 'yellow2') {
		$bg = 'black';
		$fg = 'yellow';
	} elseif ($theme == 'blue') {
		$bg = 'blue';
		$fg = 'white';
	} elseif ($theme == 'blue2') {
		$bg = 'white';
		$fg = 'blue';
	} elseif ($theme == 'red') {
		$bg = 'red';
		$fg = 'white';
	} elseif ($theme == 'red2') {
		$bg = 'white';
		$fg = 'red';
	} elseif ($theme == 'green') {
		$bg = 'green';
		$fg = 'white';
	} elseif ($theme == 'green2') {
		$bg = 'white';
		$fg = 'green';
	} else {
		$bg = 'lightgrey';
		$fg = 'black';
	}

	ob_start();
	echo '<pre style="background-color:' . $bg . ';color:' . $fg . '"><br/>';
	print_r($content);
	echo '</pre>';
	$r = ob_get_clean();
	echo $r;
}

function getFeedsArr()
{

	$retFeedsArr = array();

	// $feedsData = file_get_contents('incl/feeds.json'); // use this if preferring local feeds json file instead of database 1/2
	// $feedsObjects = json_decode($feedsData); // use this if preferring local feeds json file instead of database 2/2
	$feedsObjects = ListFeeds(); // use this if preferring database instead of local feeds json file 1/1

	foreach ($feedsObjects as $key => $val) {
		if (isset($val->hidden) && $val->hidden === true) continue;
		if (!isset($val->url)) continue;
		if ($val->url != '') {
			$retFeedsArr[$key]['name'] = $val->name;
			$retFeedsArr[$key]['url'] = $val->url;
			$retFeedsArr[$key]['interval'] = $val->interval;
		}
	}
	return $retFeedsArr;
}

function expandButton($count)
{
	if (is_numeric($count)) return '<button href="#" onclick="javascript:expand(' . $count . ')" id="msg-description-button' . $count . '">+</button>';
	else return '<button href="#" onclick="javascript:expand(\'' . $count . '\')" id="button-' . $count . '">+</button>';
}

function msgDescription($count, $date, $host, $title, $description, $link)
{
	$html = '';
	$html .= '<div class="msg-description" id="msg-description' . $count . '">';
	$html .= '<div class="pubdate">pubdate:' . $date . '</div>';
	$html .= '<span class="host">' . $host . '</span>';
	$html .= '<h2>' . $title . '</h2>';
	$html .= html_entity_decode($description, ENT_QUOTES, 'UTF-8');
	$html .= '<br/><br/>';
	$html .= '<a href="' . $link . '" target="_blank">&rarr; Verder op ' . $host . '</a>';
	$html .= '</div>';
	return $html;
}

function msgLink($link, $date, $title, $host = '')
{
	$html = '';
	$html .= '<a href="' . $link . '" target="_blank">';
	$html .= '<div class="pubdate">' . $date . '</div>';
	$html .= $title . ($host != '' ? '<span class="host"> - ' . $host . '</span>' : '');
	$html .= '</a>';
	return $html;
}

function getFilters()
{
	global $DATA;
	if (isset($_GET['group'])) {
		$getGroup = $_GET['group'];
	} else
		$getGroup = 'blog';
	$html = '';
	$html .= '<form action="?group=' . (isset($_GET['group']) ? $_GET['group'] : '') . '&interval=' . (isset($_GET['interval']) ? $_GET['interval'] : '') . '" id="sort-form">';
	$html .= 'Sort: ';
	$html .= '<select name="group">';
	$html .= '<option value="blog"' . (($getGroup == 'blog') ? ' selected' : '') . '>Blog</option>';
	$html .= '<option value="datum"' . (($getGroup == 'datum') ? ' selected' : '') . '>Date</option>';
	$html .= '</select>';
	$html .= '<input type="submit"/>';
	$html .= '</form>';
	return $html;
}
//		https://github.com/impressivewebs/frontend-feeds#top-front-end-bloggers
