<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
<title>result</title>
</head>

<body>
<?php
header('Content-Type:text/html; charset=UTF-8');

require('login.php');


if (isset($_GET["id"]) && $_GET["id"] != "") {
        $id = $_GET["id"];
}

if(isset($id)){


	$sql_in="update Protein set fav = fav + 1 where (proteinID = :id)";


	try{

		$stmh=$pdo->prepare($sql_in);

		$stmh->bindvalue(":id","$id",PDO::PARAM_STR);

		$stmh->execute();

	} catch(PDOException $Exception){
		die("エラー:".$Exception->getMessage());

	}
}

##データベース確認

try{
	$sql = "select * from Protein";

	$stmh=$pdo->prepare($sql);
	$stmh->execute();

} catch(PDOException $Exception){
	die("DB検索エラー:".$Exception->getMessage());

}
?>

<table border='1' cellpadding='2' cellspacing='0'>
<thead>
<tr bgcolor="#00CCCC"><th>proteinID</th><th>Protein Name</th><th>Organism</th><th>Length</th><th>Like</th></tr>
</thead>
<tbody>

<?php


$result=$stmh->fetchAll(PDO::FETCH_ASSOC);

foreach($result as $row){
	print "<tr><td>"; 
	print htmlspecialchars($row["proteinID"],ENT_QUOTES);
	print "</td><td>";
	print htmlspecialchars($row["name"],ENT_QUOTES);
	print "</td><td>";
	print htmlspecialchars($row["organism"],ENT_QUOTES);
	print "</td><td>";
	print htmlspecialchars($row["len"],ENT_QUOTES);
	print "</td><td>";
	print "<a href='./pro_update.php?id=".$row["proteinID"]."'>".$row["fav"]."</a>";
	print "</td><tr>\n";


}



?>
</body>
</html>
