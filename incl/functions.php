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
	$feedsData = file_get_contents('incl/feeds.json');
	$feedsObjects = json_decode($feedsData);
	foreach ($feedsObjects as $key => $val) {
		if (!isset($val->url)) continue;
		if ($val->url != '') {
			$retFeedsArr[$key]['name'] = $val->name;
			$retFeedsArr[$key]['url'] = $val->url;
			$retFeedsArr[$key]['rss_suffix'] = $val->rss_suffix;
			$retFeedsArr[$key]['new_window'] = $val->new_window;
		}
	}
	return $retFeedsArr;
}

function expandButton($count)
{
	return '<button href="#" onclick="javascript:expand(' . $count . ')" id="msg-description-button' . $count . '">+</button>';
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

function msgLink($link, $date, $title, $host = '', $newWindow = 1)
{
	$html = '';
	$html .= (boolval($newWindow) === true ?
		'<a href="' . $link . '" target="_blank">' :
		'<a href="?interval=' . (isset($_GET['interval']) ? $_GET['interval'] : '133337') . '&group=' . (isset($_GET['group']) ? $_GET['group'] : 'blog') . '&newsurl=' . $link . '">'
	);

	$html .= '<div class="pubdate">' . $date . '</div>';
	$html .= '<div>' . $title . ($host != '' ? '<span class="host"> - ' . $host . '</span>' : '') . '</div>';
	$html .= '</a>';
	return $html;
}


function getArticle($url = false)
{ // non-active, too primitive to use in most articles, TODO: remove or improve
	if (!$url) return '';
	$lump = file_get_contents($url);
	$start_tag = '"markdown":"';
	$end_tag = '","';

	$startpos = strpos($lump, $start_tag) + strlen($start_tag);
	if ($startpos !== false) {
		$endpos = strpos($lump, $end_tag, $startpos);
		if ($endpos !== false) {
			$html = substr($lump, $startpos, $endpos - $startpos);
		}
	}
	// replaces, approved for hackernoon
	$html = str_replace('\n\n', '</p>', $html); // goed
	$html = str_replace('\\\\\n\u003e', '<p style="border-left:.5em solid yellow;padding-left:3em;font-size:1.25em;font-style:italic;">',  $html); // quote: goed
	$html = str_replace('\\\n### ', '<p class="hekje-3x" style="font-weight:bold;font-size:16px;">', $html); // niet fout
	$html = str_replace('### ', '<p class="hekje-3x" style="font-weight:bold;font-size:16px;">', $html); // niet fout
	$html = str_replace('</p>\\\\\n', '</p><p>', $html); // cleanup
	$html = str_replace('</p>\\\</p>', '</p><p>', $html); // cleanup
	$html = str_replace('</p>\<p', '</p><p', $html); // cleanup
	$html = str_replace('\n', '</p>', $html); // cleanup
	$html = str_replace('![](', '<p style="display:none;">![](', $html); // hide
	$html = str_replace('</p>##', '<p style="font-weight:bold;font-size:1.25em">', $html); // hide
	$html = str_replace('\\\</p>', '', $html); // hide
	$html = str_replace('</p>#<p', '</p><p', $html); // hide
	$html = str_replace('</p>#<p', '</p><p', $html); // hide
	$html = str_replace('</p><p>[   <p', '</p><p', $html); // hide

	return $html;
}

function getFilters()
{
	global $DATA;
	if (isset($_GET['interval'])) {
		$getInterval = $_GET['interval'];
	} else
		$getInterval = 36000;
	if (isset($_GET['group'])) {
		$getGroup = $_GET['group'];
	} else
		$getGroup = 'blog';
	$html = '';
	$html .= '<nav>';
	$html .= '<form action="?group=' . (isset($_GET['group']) ? $_GET['group'] : '') . '&interval=' . (isset($_GET['interval']) ? $_GET['interval'] : '') . '">';
	$html .= 'Sorteer:';
	$html .= '<select name="group">';
	$html .= '<option value="blog"' . (($getGroup == 'blog') ? ' selected' : '') . '>Blog</option>';
	$html .= '<option value="datum"' . (($getGroup == 'datum') ? ' selected' : '') . '>Datum</option>';
	$html .= '</select>';
	$html .= 'Tijd:';
	$html .= '<select name="interval" id="selectInterval" onChange="javascript:changeVal()">';
	$html .= '<option value="300" ' . (($getInterval == 300) ? ' selected' : '') . '>5 minuten</option>';
	$html .= '<option value="600" ' . (($getInterval == 600) ? ' selected' : '') . '>10 minuten</option>';
	$html .= '<option value="900" ' . (($getInterval == 900) ? ' selected' : '') . '>15 minuten</option>';
	$html .= '<option value="1800" ' . (($getInterval == 1800) ? ' selected' : '') . '>30 minuten</option>';
	$html .= '<option value="3600" ' . (($getInterval == 3600) ? ' selected' : '') . '>1 uur</option>';
	$html .= '<option value="7200" ' . (($getInterval == 7200) ? ' selected' : '') . '>2 uur</option>';
	$html .= '<option value="36000" ' . (($getInterval == 36000 || '') ? ' selected' : '') . '>10 uur</option>';
	$html .= '<option value="86400" ' . (($getInterval == 86400) ? ' selected' : '') . '>1 dag</option>';
	$html .= '<option value="432000" ' . (($getInterval == 432000) ? ' selected' : '') . '>5 dagen</option>';
	$html .= '<option value="864000" ' . (($getInterval == 864000) ? ' selected' : '') . '>10 dagen</option>';
	$html .= '<option value="1728000" ' . (($getInterval == 1728000) ? ' selected' : '') . '>20 dagen</option>';
	$html .= '</select>';
	$html .= 'Ververs: <input type="checkbox" name="refresh" id="refreshInterval" value="' . $getInterval . '" ' . ((isset($_GET['refresh']) > 0) ? ' checked' : '') . '/>';
	$html .= '<input type="submit" value="Filter"></input>';

	$html .= '</form>';
	$html .= '</nav>';
	return $html;
}
//		https://github.com/impressivewebs/frontend-feeds#top-front-end-bloggers
