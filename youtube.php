<?php
defined('CHANNEL_ID','YOUR CHANNEL ID');
function get_list_youtube_videos(){
  $url = 'http://www.youtube.com/feeds/videos.xml?channel_id='.CHANNEL_ID;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,3);
  curl_setopt($ch, CURLOPT_TIMEOUT, 3);
  $output = $curl_exec($ch);
  
  $xml_data = simplexml_load_string($output) or die('Cannot create xml object');
  for( $i=0; $i<=9; $i++)
  {
    if($xml_data[$i])
    {
      $data[] = $xml_data->entry[$i];
    } else {
      break;
    }
  }
  
  foreach ($data as $key => $val) {
      preg_match('/[^:]*$/',$val->id,$matches);
      $video_id = $matches[0];
      $list_video[] = array(
        'id'        => $video_id,
        'title'     => $val->title,
        'published' => $val->published,
        'updated'   => $val->updated,
        'thumbnail' => 'http://img.youtube.com/vi/' . $video_id . '/0.jpg',
        'url'       => 'https://www.youtube.com/watch?v='.$video_id
      );
  }
  
  return $list_video;

}
