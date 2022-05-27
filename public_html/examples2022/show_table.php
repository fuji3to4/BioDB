<!DOCTYPE html>
<html lang="ja">

<head>
<title>Tables</title>
</head>
<body>

<?php
$db_user = "user";
$db_pass = "password";
$db_host = "docker-mysql";
$db_name = $_GET["dbname"];

$dsn="mysql:host={$db_host};dbname={$db_name};charset=utf8";

try{
        $pdo = new PDO($dsn,$db_user,$db_pass);

        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

} catch(PDOException $Exception){
        die("DB接続エラー:".$Exception->getMessage());

}


$sql ="show tables";

try{
	$stmh=$pdo->prepare($sql);
        $stmh->execute();
} catch(PDOException $Exception){
        die("DB検索エラー:".$Exception->getMessage());

}

$tables=$stmh->fetchAll(PDO::FETCH_ASSOC);

/*
print "<pre>";
print_r($tables);
print "</pre>";
*/



foreach($tables as $tb){

	print "<h3>".$tb["Tables_in_$db_name"]."</h3>";
	
	$sql="select * from ".$tb["Tables_in_$db_name"];
	//print $sql;

	try{
	$stmh=$pdo->prepare($sql);
        $stmh->execute();
	} catch(PDOException $Exception){
  	      die("DB検索エラー:".$Exception->getMessage());
	}

	$result=$stmh->fetchAll(PDO::FETCH_ASSOC);

	/*
	print "<pre>";
	print_r($fields);
	print "</pre>";
	*/

	print "<table border='1' cellpadding='2' cellspacing='0'><tbody><tr bgcolor='#00CCCC'>";

	foreach(array_keys($result[0]) as $f){
		print "<th>".htmlspecialchars($f,ENT_QUOTES)."</th>";
	}
	print "</tr>";

	

	foreach($result as $row) {
	        print "<tr>";

		foreach(array_keys($row) as $f){
			print "<td>";
	        	print htmlspecialchars($row[$f],ENT_QUOTES);
	        	print "</td>";
		}
	        print  "</tr>";
	}
	

	print "</tbody></table>";
	

}
	
?>

</body>
</html>

