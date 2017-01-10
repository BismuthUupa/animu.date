<?php
ini_set('session.gc_maxlifetime', 300);
session_set_cookie_params(30);
session_name("Memes");
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

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
  	$('video').prop('volume', 0.5);
	$('video')[0].play();
    $('video').on('ended',function(){
      $('.videos').animate({scrollTop: '+=720px'}, 800);
	  $(this).next().trigger('play');
	  
    });
  });
  
(function () {
	function init() {
		var volumeslider = document.querySelector('#volume');
		volumeslider.addEventListener('input', changeVolume);
		changeVolume();
	};

	function changeVolume() {
		var video = document.getElementsByClassName("video");
		$(video).each(function(i, obj) {
		var volumeslider = document.getElementById('volume').value;
		$(obj).prop('volume', volumeslider/100);
		});
		return false;
	};
	document.addEventListener("DOMContentLoaded", function () {
		init();
	});
}());

</script>
<STYLE type="text/css">
   body {
		background-image:url("strike_witches/lynettesass.png");
		background-repeat: no-repeat;
		background-size: cover;
		background-attachment: fixed;
		overflow: hidden;
		
   } 
   
   .background {
   background-color: rgba(0, 0, 0, 0.8);
   width: 86,5%;
   height: 1100px;
   padding: 7% 7%;
   margin-left: -25px; 
   margin-top: -14px;
   color: white;
   }
   
   .videos {
   background-color: rgba(255, 255, 255, 0.1);
   width: 1300px;
   height: 720px;
   margin: auto;
   overflow-x: hidden;
   overflow-y: auto;
   }
  
	.video {
	margin-top: 0px;
	padding-top: 0px;
	margin-bottom: -5px;
	padding-bottom: 0px;
	
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
				echo "<a href='index.php?memes=".$dir."'><div data-content='".$dir."' class='sidememe'><img class='memeimg' src='".array_rand(array_flip($file_array), 1)."'></div></a>";
				
			}
  ?>
  <br>
  <p style="margin-top:30px; display:block;">_</p>
</div>
</div>
<div class="background">
<div style=position: fixed; top: 50%; left: 30px; z-index:30;">
<form oninput="x.value=parseInt(volume.value)">
<label for="volume">Global Volume:</label><br>
<input id="volume" type="range" min="0" max="100" value="">
<output id="volumevalue" name="x" for="volume">50</output></div>
<div class="videos">
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
				
				
				if($key >= $starthere && $key < $stophere && preg_match('/.+\.(webm|mp4)$/', $file) && !preg_match('/.+\.php/', $file))
				{
					$videoname = explode("/", $file);
					echo "<video class='video' title='".$videoname[1]."' style='width:1280px; height: 720px;' controls><source src='".$file."' type='video/mp4'>Your browser does not support the video tag.</video>";
				}
				
			}
		$cycles++;
		echo "</div><div style='display:none;'>Starthere: ".$starthere."// Stophere: ".$stophere."// Memes: ".$memes." // Cycle:".$_SESSION['reload']." / ".$cycles."<div>";
}

$file_array = glob('*/*.{webm,mp4}', GLOB_BRACE);
//$file_array = array_merge($file_array, glob('*.webm'));
shuffle($file_array);
fetch_memes($file_array);

?>
</div>

 </body>
 </html>
