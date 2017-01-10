<?php
header("Content-Type: application/rss+xml; charset=UTF-8");
function fetch_memes($file_array) {
foreach ($file_array as $key => $file) 
			{
				$memes = count($file_array);
				$memeinterval = 100;
				$cycles = floor($memes / $memeinterval);
				if($_SESSION['reload'] > $cycles) {
					$_SESSION['reload'] = 0;
				}
				
				$starthere = $memeinterval*$_SESSION['reload'];
				$stophere = $starthere + $memeinterval;
				
				
				if($key >= $starthere && $key < $stophere && preg_match('/.+\.\w+/', $file) && !preg_match('/.+\.webm$/', $file) && !preg_match('/.+\.mp4$/', $file) && !preg_match('/.+\.php/', $file)) 
				{
					echo "<item><description><![CDATA[<a href='".$file."'><img style='max-width:400px; max-height:400px;' src='".$file."'></a>]]>
					</description></item>";
				}				
			}
}

echo "<?xml version='1.0' encoding='UTF-8'?>
<rss version='2.0'>

<channel>
  <title>Memes RSS</title>
  <link>http://animu.date/feed/</link>
  <description>Fresh Memes delivered to your home</description>
  ";
  

	$dir_array = glob('*',GLOB_ONLYDIR);
	$file_array = glob('*.*');
	foreach ($dir_array as $dir)
	{
		$file_array = array_merge($file_array,(glob($dir.'/*.*')));
	}
	
	usort($file_array, create_function('$a,$b', 'return filemtime($a)<filemtime($b);'));
	fetch_memes($file_array);

echo "</channel>
</rss>";
?>