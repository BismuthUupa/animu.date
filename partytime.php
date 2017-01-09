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
<script src="simple-slider.js"></script>
<link href="simple-slider.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
}

$('#volume-slider').on('slider:changed', function (event, data) {
  // The value as a ratio of the slider (between 0 and 1)
  alert(data.ratio);
});


  $(document).ready(function(){
  	$('video').prop('volume', 0.5);
	$('video')[0].play();
    $('video').on('ended',function(){
      $('.videos').animate({scrollTop: '+=725px'}, 800);
	  $(this).next().trigger('play');
	  
    });
  });

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
   width: 2400px;
   height: 2400px;
   padding: 7% 18%;
   margin-left: -25px; 
   margin-top: -14px;
   color: white;
   }
   
   .videos {
   background-color: rgba(255, 255, 255, 0.1);
   max-width: 1300px;
   max-height: 720px;
   overflow-x: hidden;
   overflow-y: auto;
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
<div style="display: none; position: fixed; top: 50%; left: 30px; z-index:30;"><input id="volume" type="text" data-slider="true" value="0.2"></div>
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
					echo "<video id='video' title='".$videoname[1]."' style='width:1280px; max-height: 720px;' controls><source src='".$file."' type='video/mp4'>Your browser does not support the video tag.</video>";
				}
				
			}
		$cycles++;
		echo "</div><div style='display:none;'>Starthere: ".$starthere."// Stophere: ".$stophere."// Memes: ".$memes." // Cycle:".$_SESSION['reload']." / ".$cycles."<div>";
}

$file_array = glob('keion/*.{webm,mp4}', GLOB_BRACE);
//$file_array = array_merge($file_array, glob('*.webm'));
shuffle($file_array);
fetch_memes($file_array);

?>
</div>

 </body>
 </html>
