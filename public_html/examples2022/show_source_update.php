<!DOCTYPE html>
<html lang="ja">

<head>
<script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js?skin=sunburst"></script>
<title>Sources</title>
</head>

<?php
/*
if(isset($_GET["name"])){
	$path =$_GET["name"];
	chdir($path);
}
*/

foreach(glob('login.php') as $file){
	if(is_file($file)){
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

foreach(glob('pro_update.php') as $file){
        if(is_file($file)){
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


?>

</body>
</html>

