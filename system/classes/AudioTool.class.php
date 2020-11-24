<?php defined('Imperial') or die('No direct script access.');

class AudioTool {
    /**
     * Получение данных
     */
    public function runExternal($cmd) {
    	$descriptorspec = array(
       		0 => array("pipe", "r"),
       	 	1 => array("pipe", "w"),
        	2 => array("pipe", "w")
   		);
    	$pipes = array();
    	$process = proc_open($cmd, $descriptorspec, $pipes);

    	$output= '';
    	if (!is_resource($process))
       		return false;

    	fclose($pipes[0]);
    	stream_set_blocking($pipes[1],false);
    	stream_set_blocking($pipes[2],false);
    	$todo = array($pipes[1], $pipes[2]);
    	while(true) {
        	$read = array();
        	if( !feof($pipes[1]) )
            	$read[]= $pipes[1];

        	if( !feof($pipes[2]) )
            	$read[]= $pipes[2];
        	
        	if (!$read)
           		break;

        	$ready = @stream_select($read, $write = NULL, $ex = NULL, 2);
        	if ($ready === false)
            	break;

        	foreach ($read as $r) {
            	$s = fread($r,1024);
            	$output .= $s;
       		}
    	}
    	
    	fclose($pipes[1]);
    	fclose($pipes[2]);
    	$code = proc_close($process);
    	return $output;
	}
	
	/**
     * Кодек
     */
	public function codec($codec) {
		$iCodecs = array (
			'AAC' => 'libfaac',
			'M4A' => 'libfaac',
			'MP3' => 'libmp3lame',
			'WAV' => 'adpcm_ima_wav',
			'WMA' => 'wmav1'
		);
	
		return $iCodecs[$codec];
	}
	
    /**
     * Конвертирование
     */
	public function convert($fFile, $sFile, $bitrate, $format, $sample_rate = FALSE) {
		if(!$sample_rate)
			$sample_rate = $this -> sample_rate($bitrate);
	
		return $this -> runExternal('ffmpeg -i ' . $fFile . ' -ab ' . $bitrate . 'K -ar ' . $sample_rate . ' -acodec ' . $this -> codec($format) . ' ' . $sFile);
	}
	
	/**
     * Нарезка
     */
	public function cut($fFile, $sFile, $bitrate, $sample_rate, $codec, $fTime, $sTime) {
		function time2seconds($time = '00:00:00') {
   			list($hours, $mins, $secs) = explode(':', $time);
    	
    		return ($hours * 3600) + ($mins * 60) + $secs;
    	}
    	
    	function seconds2time($seconds) {
    		$hours = floor($seconds / 3600);
    		$minutes = floor($seconds % 3600 / 60);
   			$seconds = $seconds % 60;
		
		    return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
		}
    	
		return $this -> runExternal('ffmpeg -i ' . $fFile . ' -ab ' . $bitrate . 'K -ar ' . $sample_rate . ' -acodec ' . $this -> codec($codec) . ' -ss ' . $fTime . ' -t ' . seconds2time(time2seconds($sTime) - time2seconds($fTime)) . ' ' . $sFile);
	}
	
	/**
     * Получение обложки
     */
	public function getCover($file, $cover) {	
		$TaggingFormat = 'cp1251';
	
		require_once('system/library/getid3/getid3.php');

		$getID3 = new getID3;
		$getID3 -> encoding = 'cp1251';
		$getid = $getID3 -> analyze($file);
			
		if(isset($getid['id3v2']['APIC'][0]['data'])) {
			file_put_contents($cover, $getid['id3v2']['APIC'][0]['data']);
			
			$size = getimagesize($cover);
			$img_x = $size[0];
           	$img_y = $size[1];
			
			if ($img_x>$img_y) {
				$prop=$img_x/$img_y;
				$width=150;
				$height=ceil($width/$prop);
			} else {
				$prop=$img_y/$img_x;
				$height=150;
				$width=ceil($height/$prop);
			}
			$GLOBALS['function'] -> image_resize($cover, $cover, $width, $height);
		} else return FALSE;
	}
	
	/**
     * Установка обложки
     */
	public function putCover($file, $cover) {
		$TaggingFormat = 'cp1251';
	
		require_once('system/library/getid3/getid3.php');

		$getID3 = new getID3;
		$getID3 -> encoding = 'cp1251';
		$getid = $getID3 -> analyze($file);
		
		if(!empty($getid['tags']['id3v2']))
			$TagData = $getid['tags']['id3v2'];
		elseif(!empty($getid['tags']['id3v1']))
			$TagData = $getid['tags']['id3v1'];
					
		$TagData['attached_picture'][] = array(
    		'picturetypeid'	=>	2,
    		'description'	=>	'cover',
    		'mime'			=>	'image/gif',
    		'data'			=>	file_get_contents($cover)
		);

		require_once('system/library/getid3/write.php');

		$tagwriter = new getid3_writetags;

		$tagwriter -> filename       	= $file;
		$tagwriter -> overwrite_tags 	= true;
		$tagwriter -> remove_other_tags = false;
		$tagwriter -> tagformats 		= array('id3v1', 'id3v2.3');
		$tagwriter -> tag_encoding  	= $TaggingFormat;
		$tagwriter -> tag_data 			= $TagData;
		
		return $tagwriter -> WriteTags();
	}
	
	/**
     * Получение ID3-тегов
     */
	public function getID3($file) {
			require_once(ROOT . 'system/library/getid3/getid3.php');

			$getID3 = new getID3;
			$getID3 -> encoding = 'cp1251';
			$getid = $getID3 -> analyze($file);

			$tagexist = true;

			if(!empty($getid['tags']['id3v2'])) {
				$TagData = $getid['tags']['id3v2'];
			} elseif(!empty($getid['tags']['id3v1'])) {
				$TagData = $getid['tags']['id3v1'];
			} else {
				$tagexist = false;
			}
			
			$fInfo = $getid['audio'];
			$fInfo['bitrate'] 		= 		ceil($fInfo['bitrate']/1000);
			$fInfo['channels'] 		= 		$getid['audio']['channels'] . ' (' . $getid['audio']['channelmode'] . ')';
			$fInfo['mduration'] 	= 		($getid['playtime_seconds'] >= 3600) ? gmdate('G:i:s', $getid['playtime_seconds']) : gmdate('i:s', $getid['playtime_seconds']);
			$fInfo['duration'] 		= 		$getid['playtime_seconds'];
			$fInfo['filesize'] 		= 		$getid['filesize'];
			$fInfo['sample_rate'] 	= 		ceil($getid['audio']['sample_rate']/1000);
						
			if($tagexist) {
				$fInfo['TagData']['getArtist'] 		= 	isset($TagData['artist'][0]) ? htmlspecialchars(iconv('windows-1251','UTF-8', $TagData['artist'][0])) : FALSE;
				$fInfo['TagData']['getTitle'] 		= 	isset($TagData['title'][0]) ? htmlspecialchars(iconv('windows-1251','UTF-8', $TagData['title'][0])) : FALSE;
				$fInfo['TagData']['getAlbum'] 		= 	isset($TagData['album'][0]) ? htmlspecialchars(iconv('windows-1251','UTF-8', $TagData['album'][0])) : FALSE;
				$fInfo['TagData']['getYear'] 		= 	isset($TagData['year'][0]) ? (int)$TagData['year'][0] : FALSE;
				$fInfo['TagData']['getGenre'] 		= 	isset($TagData['genre'][0]) ? htmlspecialchars(iconv('windows-1251','UTF-8', $TagData['genre'][0])) : FALSE;
				$fInfo['TagData']['getComments'] 	= 	isset($TagData['comment'][0]) ? htmlspecialchars(iconv('windows-1251','UTF-8', $TagData['comment'][0])) : FALSE;
			}
			
			$fInfo['tagexist'] = $tagexist;
			
			return $fInfo;
	}
	
	/**
     * Установка ID3-тегов
     */
	public function putID3($file, $Tags) {
		$TaggingFormat = 'cp1251';
	
		require_once(ROOT . 'system/library/getid3/getid3.php');

		$getID3 = new getID3;
		$getID3 -> encoding = 'cp1251';
		$getid = $getID3 -> analyze($file);
		
		if(!empty($getid['tags']['id3v2']))
			$TagData = $getid['tags']['id3v2'];
		elseif(!empty($getid['tags']['id3v1']))
			$TagData = $getid['tags']['id3v1'];
			
		$TagData = array_merge($TagData, $Tags);

		require_once(ROOT . 'system/library/getid3/write.php');

		$tagwriter = new getid3_writetags;

		$tagwriter -> filename       	= $file;
		$tagwriter -> overwrite_tags 	= true;
		$tagwriter -> remove_other_tags = false;
		$tagwriter -> tagformats 		= array('id3v1', 'id3v2.3');
		$tagwriter -> tag_encoding  	= $TaggingFormat;
		$tagwriter -> tag_data 			= $TagData;
		
		return $tagwriter -> WriteTags();
	}
	
	/**
     * Копирование тегов
     */
	public function id3cp($fFile, $sFile) {
		$TaggingFormat = 'cp1251';
	
		require_once(ROOT . 'system/library/getid3/getid3.php');

		$getID3 = new getID3;
		$getID3 -> encoding = 'cp1251';
		$getid = $getID3 -> analyze($fFile);
		
		if(!empty($getid['tags']['id3v2']))
			$TagData = $getid['tags']['id3v2'];
		elseif(!empty($getid['tags']['id3v1']))
			$TagData = $getid['tags']['id3v1'];
			
		require_once(ROOT . 'system/library/getid3/write.php');

		$tagwriter = new getid3_writetags;

		$tagwriter -> filename       	= $sFile;
		$tagwriter -> overwrite_tags 	= true;
		$tagwriter -> remove_other_tags = false;
		$tagwriter -> tagformats 		= array('id3v1', 'id3v2.3');
		$tagwriter -> tag_encoding  	= $TaggingFormat;
		$tagwriter -> tag_data 			= $TagData;
		
		return $tagwriter -> WriteTags();
	}
	
	/**
     * Частота
     */
	public function sample_rate($bitrate) {	
		$arr = array(320 => 44100,
		256 => 44100,
		192 => 44100,
		160 => 44100,
		128 => 44100,
		96 => 44100,
		64 => 22050,
		32 => 22050);
		
		return $arr[(int)$bitrate];
	}
}