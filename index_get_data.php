<?php
session_name("Memes");
session_start();


$dir = ".";
if ($_GET["memes"] === null) 
$memes = 40; 
else
$memes = $_GET["memes"];

function fetch_memes($file_array) {
foreach ($file_array as $key => $file) 
			{
				$memes = count($file_array);
				$memeinterval = 40;
				$cycles = floor($memes / $memeinterval);
				if($_SESSION['reload'] > $cycles) {
					$_SESSION['reload'] = 0;
				}
				
				$starthere = $memeinterval*$_SESSION['reload'];
				$stophere = $starthere + $memeinterval;
				
				
				if($key >= $starthere && $key < $stophere && preg_match('/.+\.\w+/', $file) && !preg_match('/.+\.webm$/', $file) && !preg_match('/.+\.mp4$/', $file) && !preg_match('/.+\.php/', $file)) 
				{
					echo "<a href='".$file."'><img class='animu' src='".$file."'></a>";
				}
				elseif($key >= $starthere && $key < $stophere && preg_match('/.+\.(webm|mp4)$/', $file) && !preg_match('/.+\.php/', $file) && !preg_match('/.+\.css/', $file) && !preg_match('/.+\.js/', $file))
				{
					echo "<video class='animu' controls loop muted ><source src='".$file."' type='video/mp4'>Your browser does not support the video tag.</video>";
				}
				
			}
		echo "<div style='display:none;'>Starthere: ".$starthere."// Stophere: ".$stophere."// Memes: ".$memes." // Cycle:".$_SESSION['reload']." / ".$cycles."<div>";
}

//memes by directory
if ($memes === "memeguide")
	{
		$dir_array = glob('*',GLOB_ONLYDIR);
		array_push($dir_array, "gif", "jpg", "png");
		foreach ($dir_array as $key => $dir) 
			{
				if($dir === "gif" || $dir === "jpg" || $dir === "png" ) 
				{
					$file_array = glob('*.'.$dir.'');
					}
				else {
					$file_array = glob($dir.'/*.{gif,jpg,png}', GLOB_BRACE);
					}
				shuffle($file_array);
				echo "<a href='?memes=".$dir."'><div data-content='".$dir."' class='memedir'><img class='memeimg' src='".array_rand(array_flip($file_array), 1)."'></div></a>";
				
			}
	}

//only the freshest memes	
elseif ($memes === "fresh")
	{
				$dir_array = glob('*',GLOB_ONLYDIR);
				$file_array = glob('*.*');
				foreach ($dir_array as $dir)
				{
					$file_array = array_merge($file_array,(glob($dir.'/*.*')));
				}
				
				usort($file_array, create_function('$a,$b', 'return filemtime($a)<filemtime($b);'));
				fetch_memes($file_array);
	}
	
//give out subfolders
elseif ($memes === "rare") 
	{
		$dir_array = glob('*',GLOB_ONLYDIR);
		$file_array = glob('*/konobi.*');
		foreach ($dir_array as $dir)
		{
			$file_array = array_merge($file_array,(glob($dir.'/*.*')));
		}
		shuffle($file_array);
		fetch_memes($file_array);
	}
//give out only filetypes	
elseif ($memes === "gif" || $memes === "jpg" || $memes === "webm" || $memes === "mp4"  || $memes === "png" )
	{
		$filetype = $memes;
		$file_array = glob('*.'.$filetype.'');
		usort($file_array, create_function('$a,$b', 'return filemtime($a)<filemtime($b);'));
		fetch_memes($file_array);
	}	
	
//give out one subfolder
elseif (!preg_match('/\d+/', $memes)) 
	{
		$file_array = (glob($memes.'/*.*'));
		usort($file_array, create_function('$a,$b', 'return filemtime($a)<filemtime($b);'));
		fetch_memes($file_array);
	}
	
else 
	{
		$file_array = glob('*/*.*');
		$file_array = array_merge($file_array, glob('*.*'));
		shuffle($file_array);
		
		//get a certain amount of memes
		if ($memes > 1) 
		{
			foreach ($file_array as $key => $file) 
			{
				if($key < $memes && preg_match('/.+\.\w+/', $file) && !preg_match('/.+\.webm$/', $file) && !preg_match('/.+\.mp4$/', $file)) 
				{
					echo "<a href='".$file."'><img class='animu' src='".$file."'></a>";
				}
				elseif($key < $memes && preg_match('/.+\.(webm|mp4)$/', $file) && !preg_match('/.+\.php/', $file))
				{
					echo "<video class='animu' controls loop muted autoplay ><source src='".$file."' type='video/mp4'>Your browser does not support the video tag.</video>";
				}
			}
		}
		
		//haha what a loser
		elseif ($memes == 1)
		{
			$file = array_rand(array_flip($file_array), 1);
				if (preg_match('/.+\.\w+/', $file) && !preg_match('/.+\.webm/', $file) && !preg_match('/.+\.mp4/', $file))
				{
					echo "<a href='onememe.jpg'><img src='onememe.jpg'></a><br><br>Anyways here's your meme:<br><br><a href='".$file."'><img src='".$file."'></a>";
				}
		}
		
		//somehow exactly gets 0 don't even ask
		elseif ($memes > -1 && $memes != 1 )
		{
			$file = array_rand(array_flip($file_array), 1);
				if (preg_match('/.+\.\w+/', $file) && !preg_match('/.+\.webm/', $file) && !preg_match('/.+\.mp4/', $file))
				{
					echo "<a href='".$file."'><img src='".$file."'></a><br><br> zero memes how the fuck would I know man";
				}
		}
		//negative amount of memes or error
		else
		{
			echo "<a href='geh.jpg'><img src='geh.jpg'></a><br><br>You owe me ".($memes+2*(abs($memes))+1)." memes now, dick.";
			echo "<br><br>".$memes;
		}
	}
if($memes!=="memeguide")
{	
	$_SESSION['reload']++;
	}
?>