<?php
function getFeeds($groupby = 'datum', $timeframe)
{
	$feeds = getFeedsArr();
	$html = '';
	$nu = strtotime('now');
	$timeframe = $nu - $timeframe;
	$count = 0;

	if ($groupby == 'datum') {
		// platmaken en gewoon een goede array
		$newArray = array();
		$rnCount = 2000;
		foreach ($feeds as $feedKey => $feedVal) {
			$xml = simplexml_load_file($feedVal['url'] . $feedVal['rss_suffix'], "SimpleXMLElement", LIBXML_NOERROR |  LIBXML_ERR_NONE);
			$xmlPath = $xml->xpath('//item');
			if (empty($xmlPath)) { // exception 1, in case of hidde.blog
				$xmlPath = $xml;
				foreach ($xmlPath as $xmll) {
					if (!isset($xmll->id)) continue;
					$newArray[$feedKey][$rnCount]['title'] = (string)$xmll->title;
					$newArray[$feedKey][$rnCount]['description'] =  '';
					$newArray[$feedKey][$rnCount]['link'] = (string)$xmll->id;
					$newArray[$feedKey][$rnCount]['pubDate'] = (string)$xmll->updated;
					$newArray[$feedKey][$rnCount]['name'] = (string)$feedVal['name'];
					$newArray[$feedKey][$rnCount]['new_window'] = (string)$feedVal['new_window'];
					$rnCount++;
				}
			} else {
				foreach ($xmlPath as $itemKey => $itemVal) {
					$newArray[$feedKey][$itemKey]['title'] = (string)$itemVal->title;
					$newArray[$feedKey][$itemKey]['description'] = (string)$itemVal->description; // TODO: not functioning properly
					$newArray[$feedKey][$itemKey]['link'] = (string)$itemVal->link;
					$newArray[$feedKey][$itemKey]['pubDate'] = (string)$itemVal->pubDate;
					$newArray[$feedKey][$itemKey]['name'] = (string)$feedVal['name'];
					$newArray[$feedKey][$itemKey]['new_window'] = (string)$feedVal['new_window'];
				}
			}
		}
		$entries = array(); // voor sort op datum, onafhankelijk van blog
		foreach ($newArray as $item) {
			$entries = array_merge($entries, $item);
		}
		if (!empty($entries)) {
			usort($entries, function ($feed1, $feed2) {
				return strtotime($feed2['pubDate']) - strtotime($feed1['pubDate']);
			});
		} else {
			$html .= 'no entries';
		}
		$html .= '<ul>';
		foreach ($entries as $entry) {
			if (strtotime($entry['pubDate']) > $timeframe) {
				$pubDate = strftime('%m/%d/%Y %I:%M %p', strtotime($entry['pubDate']));
				$pubDate2 = strftime('%H:%M', strtotime($entry['pubDate']));
				$count++;

				$html .= '<li class="msg">';
				$html .= expandButton($count);
				$html .= msgLink($entry['link'], $pubDate2, $entry['title'], str_replace('www.', '', parse_url($entry['link'])['host']), $entry['new_window']); // TODO: newWindow not working in sort by date
				$html .= msgDescription($count, $pubDate, str_replace('www.', '', parse_url($entry['link'])['host']), $entry['title'], $entry['description'], $entry['link']);
				$html .= '</li>';
			}
		}
		$html .= '</ul>';
	} else {  // echo 'hier de ELSE: sort per blog';
		$channels = array();
		foreach ($feeds as $feed) {
			if ($count > 1000) break;
			$xml = simplexml_load_file($feed['url'] . $feed['rss_suffix'], "SimpleXMLElement", LIBXML_NOERROR |  LIBXML_ERR_NONE);
			$channels = array_merge($channels, $xml->xpath('//channel'));
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

			foreach ($feeds as $feed) {
				if ($feed['url'] == $channelVal->link) $newWindow = $feed['new_window']; // returns 1 or 0
			}

			$opencount = 0;
			foreach ((array) $channelVal as $channelDetailsKey => $channelDetailsVal) {
				if (is_array($channelDetailsVal) == true && $channelDetailsKey == 'item') {
					$msgArr = $channelDetailsVal;
					foreach ((array) $msgArr as $msgKey => $msgVal) {
						if (
							!isset($msgVal->title) ||
							$msgVal->title == '' ||
							strtotime($msgVal->pubDate) < $timeframe
						) continue;


						if ($opencount == 0) {
							$html .= '<div class="blog"><h2>' . $blogTitle . ' - ' . str_replace('www.', '', parse_url($msgVal->link)['host']) . '</h2><ul>';
							$opencount = 1;
						}

						$pubDate2 = strftime('%H:%M', strtotime($msgVal->pubDate));

						$html .= '<li class="msg">';
						$html .= msgLink($msgVal->link, $pubDate2, $msgVal->title, '', $newWindow);
						$html .= msgDescription($count = $idTeller, $date = $msgVal->pubDate, $host = str_replace('www.', '', parse_url($msgVal->link)['host']) . ' - ' . $blogTitle, $title = $msgVal->title, $description = $msgVal->description, $link = $msgVal->link);
						$html .= '</li>';
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