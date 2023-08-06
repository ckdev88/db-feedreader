<?php
function pp($content,$bg='lightgrey',$fg='black'){
		ob_start();
		echo '<pre style="background-color:'.$bg.';color:'.$fg.'"><br/>';
		print_r($content);
		echo '</pre>';
		$r=ob_get_clean();
		echo $r;
}

function getFeedsArr() {
	$feeds=array(
		'https://hackernoon.com/feed',
		// 'https://codeburst.io/feed', // fout of leeg?
		'https://medium.com/feed/@upekshadilshan000',
		// 'https://medium.com/feed/@zac_heisey', // fout of leeg?
		'https://www.geeksforgeeks.org/category/javascript/feed/',
		// 'https://www.geeksforgeeks.org/tag/picked/feed/',
		// 'https://bitsofco.de/rss', // "no entries" , goed?
		// 'https://developer.mozilla.org/en-US/blog/rss.xml',// fout of leeg?
		// 'https://infoworld.com/index.rss',
		// 'https://news.vuejs.org/feed.xml',// fout of leeg?
		// 'https://www.smashingmagazine.com/feed',
		// 'https://davidwalsh.name/feed',// fout of leeg?
		// 'https://www.reddit.com/r/vuejs.rss',// fout of leeg?
		// 'https://github.com/impressivewebs/frontend-feeds#more-front-end-bloggers',// fout of leeg?
		// 'https://stackoverflow.com/questions/tagged/?tagnames=css&sort=newest',// fout of leeg?
		
		// non working format
		// 'https://www.linux.org/articles/index.rss',
		// 'https://www.reddit.com/r/reactjs.rss',
		// 'https://blog.chromium.org/feeds/posts/default'
	);
	return $feeds;
}

function expandButton($count){
	return '<button href="#" onclick="javascript:expand('.$count.')" id="msg-description-button'.$count.'">+</button>';
} 
function msgDescription($count,$date,$host,$title,$description,$link){
	return '
	<div class="msg-description" id="msg-description'.$count.'">
		<div class="pubdate">'.$date.'</div>
		<span class="host">'.$host.'</span>
		<h2>'.$title.'OO</h2>
		'.html_entity_decode($description, ENT_QUOTES, 'UTF-8').'<br/>
		<br/>
		<a href="'.$link.'" target="nieuwsartikel">&rarr; Verder op '.$host.'</a>
	</div>';
} 
 
function msgLink($link,$date,$title,$host=''){
	$html='<a href="'.$link.'" target="nieuwsartikel" style="font-weight:normal">
		<div class="pubdate">'.$date.'</div>
		<div>'.$title;
			if($host!=''){
				$html.='<span class="host"> - '.$host.'</span>';
			}
		$html.='</div>
	</a>';
	return $html;
}

function getFeeds($groupby,$timeframe){
	$feeds=getFeedsArr();
	$html='';

	$nu=strtotime('now');
	$timeframe=$nu-$timeframe;
	$count=0;
	if($groupby=='datum'){

		$entries = array();
		foreach($feeds as $feed) {
			$xml = simplexml_load_file($feed,'SimpleXMLElement', LIBXML_NOCDATA);
			$entries = array_merge($entries, $xml->xpath("//item"));
		}
		
		if(!empty($entries)){
			usort($entries, function ($feed1, $feed2) {
				return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
			});
		}
		else {
			$html.='no entries';
		}
		$html.='<ul>';
			
			foreach($entries as $entry){
				// echo pp($entry,'red','yellow');
				if(strtotime($entry->pubDate) > $timeframe){
					// echo (substr($entry->title,0,20)).', '.strtotime($entry->pubDate).' '.$timeframe.'<br/>';
					$pubDate=strftime('%m/%d/%Y %I:%M %p', strtotime($entry->pubDate));
					$pubDate2=strftime('%H:%M', strtotime($entry->pubDate));
					$count++;

					$html.='<li class="msg">';
						$html.=expandButton($count);
						$html.=msgLink($entry->link,$pubDate2,$entry->title,str_replace('www.','',parse_url($entry->link)['host']));
						$html.=msgDescription($count=$count,$date=$pubDate,$host=str_replace('www.','',parse_url($entry->link)['host']),$title=$entry->title,$description=$entry->description,$link=$entry->link);
					$html.='</li>';
				}
			}

		$html.='</ul>';

	}
	else{// echo 'hier de ELSE: sort per blog';
		pp($feeds,'red','yellow');
		$channels=array();
		foreach($feeds as $feed){
			if($count<100){ 
				$xml = simplexml_load_file($feed);
				$channels = array_merge($channels, $xml->xpath("//channel"));
			}
			$count+=1;
		}
		usort($channels, function($feed1,$feed2){
			return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
		});

		$telChannels=0;
		$idTeller=0;
		foreach($channels as $channelKey=>$channelVal){
			$telChannels++;
			$telChannelDetails=0;
			$blogTitle=$channelVal->title;

					$opencount=0;
					foreach((array)$channelVal as $channelDetailsKey=>$channelDetailsVal){
						if(is_array($channelDetailsVal)==true && $channelDetailsKey=='item'){
							$msgArr=$channelDetailsVal;
							foreach((array)$msgArr as $msgKey=>$msgVal){
								$pubDate=$msgVal->pubDate;
								if(strtotime($pubDate) > $timeframe){
									if($msgVal->title!=''){

										if($opencount==0){
											$html.='<div class="blog">
												<h2>'.$blogTitle.' - '.str_replace('www.','',parse_url($msgVal->link)['host']).'</h2>
												<ul>';
												$opencount=1;
										}

										$pubDate2=strftime('%H:%M', strtotime($pubDate));

										$html.='<li class="msg">';
										 	$html.=msgLink($msgVal->link,$pubDate2,$msgVal->title);
											$html.=msgDescription($count=$idTeller,$date=$pubDate,$host=str_replace('www.','',parse_url($msgVal->link)['host']).' - '.$blogTitle,$title=$msgVal->title,$description=$msgVal->description,$link=$msgVal->link);
										$html.='</li>';
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
