<?php

function pp($content, $bg = 'lightgrey', $fg = 'black')
{
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
		if ($val->url != '') {
			$retFeedsArr[] .= $val->url;
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
	$html .= '<div class="pubdate">' . $date . '</div>';
	$html .= '<span class="host">' . $host . '</span>';
	$html .= '<h2>' . $title . '</h2>';
	$html .= html_entity_decode($description, ENT_QUOTES, 'UTF-8');
	$html .= '<br/><br/>';
	$html .= '<a href="' . $link . '" target="nieuwsartikel">&rarr; Verder op ' . $host . '</a>';
	$html .= '</div>';
	return $html;
}

function msgLink($link, $date, $title, $host = '')
{
	$html = '<a href="' . $link . ' target="nieuwsartikel" style="font-weight:normal">';
	$html .= '<div class="pubdate">' . $date . '</div>';
	$html .= '<div>' . $title;
	if ($host != '') {
		$html .= '<span class="host"> - ' . $host . '</span>';
	}
	$html .= '</div>';
	$html .= '</a>';
	return $html;
}

function getFeeds($groupby, $timeframe)
{
	$feeds = getFeedsArr();
	$html = '';

	$nu = strtotime('now');
	$timeframe = $nu - $timeframe;
	$count = 0;
	if ($groupby == 'datum') {
		$entries = array();
		foreach ($feeds as $feed) {
			$xml = simplexml_load_file($feed, "SimpleXMLElement", LIBXML_NOERROR |  LIBXML_ERR_NONE);
			$entries = array_merge($entries, $xml->xpath('//item'));
		}

		if (!empty($entries)) {
			usort($entries, function ($feed1, $feed2) {
				return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
			});
		} else {
			$html .= 'no entries';
		}
		$html .= '<ul>';

		foreach ($entries as $entry) {
			// echo pp($entry,'red','yellow');
			if (strtotime($entry->pubDate) > $timeframe) {
				// echo (substr($entry->title,0,20)).', '.strtotime($entry->pubDate).' '.$timeframe.'<br/>';
				$pubDate = strftime('%m/%d/%Y %I:%M %p', strtotime($entry->pubDate));
				$pubDate2 = strftime('%H:%M', strtotime($entry->pubDate));
				$count++;

				$html .= '<li class="msg">';
				$html .= expandButton($count);
				$html .= msgLink($entry->link, $pubDate2, $entry->title, str_replace('www.', '', parse_url($entry->link)['host']));
				$html .= msgDescription($count = $count, $date = $pubDate, $host = str_replace('www.', '', parse_url($entry->link)['host']), $title = $entry->title, $description = $entry->description, $link = $entry->link);
				$html .= '</li>';
			}
		}

		$html .= '</ul>';
	} else {  // echo 'hier de ELSE: sort per blog';
		pp($feeds, 'red', 'yellow');
		$channels = array();
		foreach ($feeds as $feed) {
			if ($count < 100) {
				$xml = simplexml_load_file($feed);
				$channels = array_merge($channels, $xml->xpath('//channel'));
			}
			$count += 1;
		}
		usort($channels, function ($feed1, $feed2) {
			return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
		});

		$telChannels = 0;
		$idTeller = 0;
		foreach ($channels as $channelKey => $channelVal) {
			$telChannels++;
			$telChannelDetails = 0;
			$blogTitle = $channelVal->title;

			$opencount = 0;
			foreach ((array) $channelVal as $channelDetailsKey => $channelDetailsVal) {
				if (is_array($channelDetailsVal) == true && $channelDetailsKey == 'item') {
					$msgArr = $channelDetailsVal;
					foreach ((array) $msgArr as $msgKey => $msgVal) {
						$pubDate = $msgVal->pubDate;
						if (strtotime($pubDate) > $timeframe) {
							if ($msgVal->title != '') {
								if ($opencount == 0) {
									$html .= '<div class="blog"><h2>' . $blogTitle . ' - ' . str_replace('www.', '', parse_url($msgVal->link)['host']) . '</h2><ul>';
									$opencount = 1;
								}

								$pubDate2 = strftime('%H:%M', strtotime($pubDate));

								$html .= '<li class="msg">';
								$html .= msgLink($msgVal->link, $pubDate2, $msgVal->title);
								$html .= msgDescription($count = $idTeller, $date = $pubDate, $host = str_replace('www.', '', parse_url($msgVal->link)['host']) . ' - ' . $blogTitle, $title = $msgVal->title, $description = $msgVal->description, $link = $msgVal->link);
								$html .= '</li>';
							}
						}
						$idTeller++;
					}
				}
			}
?>
			</ul>
			</div>
<?php
		}
	}
	return $html;
}
?>