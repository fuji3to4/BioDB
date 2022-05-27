<!DOCTYPE html>
<html lang="ja">

<head>
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


	$sql_in="delete from Protein where (proteinID = :id)";


	try{

		$stmh=$pdo->prepare($sql_in);

		$stmh->bindvalue(":id","$id",PDO::PARAM_STR);

		$stmh->execute();

		print "[proteinID:{$id}]のレコードを削除しました<br><br>";

	} catch(PDOException $Exception){
		die("エラー:".$Exception->getMessage());

	}
}

##データベース確認+削除する自身のphpへのリンク

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
<tr bgcolor="#00CCCC"><th>proteinID</th><th>Protein Name</th><th>Organism</th><th>Length</th><th></th></tr>
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
	print "<a href='./pro_delete.php?id=".$row["proteinID"]."' onclick=\"return confirm('proteinID=".$row["proteinID"]."を削除してもよろしいですか?')\">削除する</a>";
	print "</td><tr>\n";


}



?>
</body>
</html>
