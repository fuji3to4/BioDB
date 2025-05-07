<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js?skin=sunburst"></script>

	<style>
		section{
			margin-top:-60px;
			padding-top:60px;
		}
	</style>
<title>Sources</title>
</head>
<!--<body onCopy="return false;">-->
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Top</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
	  	<li class="nav-item">
          <a class="nav-link" href="#php">PHP</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#html">HTML</a>
        </li>
		<li class="nav-item">
          <a class="nav-link" href="#sql">SQL</a>
        </li>
		<li class="nav-item">
          <a class="nav-link" href="#others">Other Files</a>
        </li>
    </div>
  </div>
</nav>

<?php
if(isset($_GET["name"])){
	$path =$_GET["name"];
}else{
	die("directry名を?name=のあとに入れてください。");
}

$chfl=chdir($path);

if(!$chfl){
	die($path."は存在しません。");
}


$file_list = glob("*");

#print_r($file_list);
?>

<section id="php">
	<div class="container">

		<h3>PHP Files:</h3>
<?php

foreach($file_list as $file){
	if(is_file($file)){
		if(preg_match("/.+\.php$/",$file)){
			print "<h3>".htmlspecialchars($file)."</h3>";
			print "<pre class='prettyprint'>";
			$fp = fopen($file,"r");

			while(!feof($fp)){
				$line=fgets($fp);
				print htmlspecialchars($line);
			}
			fclose($fp);
			print "</pre>";
		}

	}
}

?>
</div>
</section>

<section id="html">
	<div class="container">
		<h3>HTML Files:</h3>
<?php

foreach($file_list as $file){
	if(is_file($file)){
		if(preg_match("/.+\.html$/",$file)){
			print "<h3>".htmlspecialchars($file)."</h3>";
			print "<pre class='prettyprint'>";
			$fp = fopen($file,"r");

			while(!feof($fp)){
				$line=fgets($fp);
				print htmlspecialchars($line);
			}
			fclose($fp);
			print "</pre>";
		}

	}
}
?>
</div>
</section>


<section id="sql">
	<div class="container">

		<h3>SQL Files:</h3>
<?php

foreach($file_list as $file){
	if(is_file($file)){
		if(preg_match("/.+\.sql$/",$file)){
			print "<h3>".htmlspecialchars($file)."</h3>";
			print "<pre class='prettyprint'>";
			$fp = fopen($file,"r");

			while(!feof($fp)){
				$line=fgets($fp);
				print htmlspecialchars($line);
			}
			fclose($fp);
			print "</pre>";
		}

	}
}

?>
</div>
</section>

<section id="others">
	<div class="container">

		<div class="accordion" id="others">
			<div class="accordion-item">
				<h3 class="accordion-header" id="headingOne">
					<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						CSS and JavaScript Files:
					</button>
				</h3>
				<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne">
					<div class="accordion-body">
			

<?php


function makeFileLinkCSSJS($dir,$path) {
	$dir=preg_replace('/\/$/', '', $dir);
	$files = glob($dir."/*");
 
    foreach ($files as $file) {
        if (is_file($file)) {
			if(preg_match("/.+\.(css|js)$/",$file)){
				print "<a href=".$path."/".htmlspecialchars($file).">".htmlspecialchars($file)."</a><br>";
			}
        }
	}
	foreach ($files as $file) {
        if (is_dir($file)) {
			makeFileLinkCSSJS($file,$path);
        }
    }
}

makeFileLinkCSSJS("./",$path) ;

?>
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<h3 class="accordion-header" id="headingTow">
					<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
						Picture Files:
					</button>
				</h3>
				<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
					<div class="accordion-body">


<?php

function makeFileLinkPic($dir,$path) {
	$dir=preg_replace('/\/$/', '', $dir);
	$files = glob($dir."/*");
 
    foreach ($files as $file) {
        if (is_file($file)) {
			if(preg_match("/.+\.(png|jpg|jpeg|gif)$/",$file)){
				print "<a href=".$path."/".htmlspecialchars($file).">".htmlspecialchars($file)."</a><br>";
			}
        }
	}
	foreach ($files as $file) {
        if (is_dir($file)) {
			makeFileLinkPic($file,$path);
        }
    }
}

makeFileLinkPic("./",$path) ;

?>
					</div>
				</div>
			</div>
		</div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>

