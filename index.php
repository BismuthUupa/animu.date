<?php
ini_set('session.gc_maxlifetime', 300);
session_set_cookie_params(30);
session_name("Memes");
session_start();

$_SESSION['name'] = "Memes";
$_SESSION['reload'] = 0;
$session = $_SESSION['name'].$_SESSION['reload'];

$dir = ".";
if ($_GET["memes"] === null) 
$memes = 40; 
else
$memes = $_GET["memes"];
?>
<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="alternate" href="/feed/" title="FreshMemesRSS" type="application/rss+xml" />
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
<script type="text/javascript">
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
}

$(document).ready(function(){ 
			
	function reqListener () {
      console.log(this.responseText);
    }
	
	function start_scroll_down() { 
	scroll = setInterval(function(){ window.scrollBy(0, 500); console.log('start');}, 5000);
	}
	
	var oReq = new XMLHttpRequest(); //New request object
		oReq.onload = function() {
		$('.memes').append(this.responseText); //Will alert: 42
		};
	
	
	$(window).scroll(function() {
		if($(window).scrollTop() + $(window).height() == $(document).height()) {
	oReq.open("get", "index_get_data.php<?=($_GET['memes']) ? '?memes='.$memes : '?memes=50'?>", true);
    //                               ^ Don't block the rest of the execution.
    //                                 Don't wait until the request finishes to 
    //                                 continue.
    oReq.send();
			
   }
});
	
});
</script>
<!--Stylesheet hier-->
<STYLE type="text/css">
   body {
		background-image:url("strike_witches/lynettesass.png");
		background-repeat: no-repeat;
		background-size: cover;
		background-attachment: fixed;
		<?=($memes==="memeguide") ? "overflow-x: hidden; overflow-y: auto;" : ""?>
   } 
 </STYLE>
</head>
<body id="main">
<span style="font-size:30px; cursor:pointer; position:fixed; top:0px; left:0px; z-index:5;" onclick="openNav()">&#9776;</span>

<div id="mySidenav" class="sidenav">
<a href="index.php?memes=memeguide" style="text-align:center;"><h2>To the MemeGuide!</h2></a>
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
<div class="hidescroll">
  
  <?php 
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
				echo "<a href='?memes=".$dir."'><div data-content='".$dir."' class='sidememe'><img class='memeimg' src='".array_rand(array_flip($file_array), 1)."'></div></a>";
				
			}
  ?>
  <br>
  <p style="margin-top:30px; display:block;">_</p>
</div>
</div>

	<div <?=($memes==="memeguide") ? "class=\"memediv\"" : "class=\"memes\""?>>
<!--
animu.date/?memes=[number] //Get that many memes
animu.date/?memes=0 1 -1 -2 ... // Easter Eggs
animu.date/?memes=fresh // Most recent 100 memes
animu.date/?memes=[filetype] // Get 20 [filetype]
animu.date/?memes=gif // Get 20 gifs

animu.date/?memes=rare // use all of the following sub-folders:
<?
$dir_array = glob('*',GLOB_ONLYDIR);
		foreach ($dir_array as $dir)
		{
			echo "animu.date/?memes=".$dir;
			if($dir == "yryr"){echo " - YU RU YU RI";};
			if($dir == "panz"){echo " - PANZER VOR means PANZER VOR";};
			if($dir == "usamin"){echo " - My safe of rare Usamins";};
			if($dir == "SICP"){echo " - Structure and Integration of Computer Programs";};
			if($dir == "pissed"){echo " - grrrrrrr";};
			if($dir == "karen"){echo " - ZA BESUTO FORUDA DESS";};
			if($dir == "smug"){echo " - essential memes";};
			if($dir == "yamada"){echo " - love and life";};
			if($dir == "burg"){echo " - burg";};
			if($dir == "comfy"){echo " - comfy";};
			if($dir == "sakichan"){echo " - waaaaaaaiii";};
			if($dir == "chiyochan"){echo " - Nozaki-ku~n! Nozaki-ku~n! Nozaki-ku~n! Nozaki-ku~n! ";};
			echo "\n";
		}
?>

-->
<?php
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
				
				
				if($key >= $starthere && $key < $stophere && preg_match('/.+\.\w+/', $file) && !preg_match('/.+\.webm$/', $file) && !preg_match('/.+\.mp4$/', $file) && !preg_match('/.+\.php/', $file) && !preg_match('/.+\.css/', $file) && !preg_match('/.+\.js/', $file)) 
				{
					echo "<a href='".$file."'><img class='animu' src='".$file."'></a>";
				}
				elseif($key >= $starthere && $key < $stophere && preg_match('/.+\.(webm|mp4)$/', $file) && !preg_match('/.+\.php/', $file))
				{
					echo "<video class='animu' controls loop muted ><source src='".$file."' type='video/mp4'>Your browser does not support the video tag.</video>";
				}
				
			}
		$cycles++;
		echo "<div style='display:none;'>Starthere: ".$starthere."// Stophere: ".$stophere."// Memes: ".$memes." // Cycle:".$_SESSION['reload']." / ".$cycles."<div>";
}

//memes by directory
if ($memes === "memeguide")
	{
		$dir_array = glob('*',GLOB_ONLYDIR);
		array_push($dir_array, "gif", "jpg", "png", "fresh");
		foreach ($dir_array as $key => $dir) 
			{
				if($dir === "gif" || $dir === "jpg" || $dir === "png" ) 
				{
					$file_array = glob('*.'.$dir.'');
					}
				elseif($dir === "fresh")
				{
					$file_array = glob('*.*');
					$file_array = array_merge($file_array,(glob($dir.'/*.*')));
					usort($file_array, create_function('$a,$b', 'return filemtime($a)<filemtime($b);'));
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


</div>

</body>
</html>