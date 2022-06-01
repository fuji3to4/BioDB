<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
<title>result</title>
</head>
<body>

<?php
header('Content-Type:text/html; charset=UTF-8');//文字化け防止

//データベースへの接続情報の設定
$db_user = "user";
$db_pass = "password";
#$db_host = "localhost"; #For virtualBox
$db_host = "docker-mysql"; #For Docker
$db_name = "demo";

$dsn="mysql:host={$db_host};dbname={$db_name};charset=utf8";

//データベースへの接続処理
try{
        $pdo = new PDO($dsn,$db_user,$db_pass);

        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

} catch(PDOException $Exception){
        die("DB接続エラー:".$Exception->getMessage());

}


//データベースへの問い合わせ
try{
    //SQL文を変数へ格納
	$sql = "SELECT PDB.pdbID, resolution, name, organism
                  FROM Protein, PDB, PDB2Protein
                 WHERE PDB.pdbID = PDB2Protein.pdbID
                   AND Protein.proteinID = PDB2Protein.proteinID 
                   AND PDB.resolution <= 2.5";

        //プリペアードステイトメントハンドラへの格納から実行
        $stmh=$pdo->prepare($sql);
        $stmh->execute();

	$count=$stmh->rowCount();//rowCount()検索件数のカウント

	print "検索結果は{$count}件です。<br><br>";

} catch(PDOException $Exception){
        die("DB検索エラー:".$Exception->getMessage());

}
//途中でphpを閉じてhtmlに戻ることも可能
?>

<!-- 表のヘッダーの記述 -->
<table border='1' cellpadding='2' cellspacing='0'>
<thead>
        <tr bgcolor='#00CCCC'>
        <th>PDBID</th>
        <th>Resolution</th>
        <th>Protein name</th>
        <th>Organism</th>
        </tr>
</thead>
<tbody>

<?php //phpを再開させる

//検索の結果を$resultへ連想配列の配列として格納
$result=$stmh->fetchAll(PDO::FETCH_ASSOC);

//デバック用 コメントアウトすれば$resultの構造を見ることができる
/* 
print "<pre>";
print_r($result);
print "</pre>";
*/

//$result配列から１つずつ読み出して$rowに格納のループ
foreach($result as $row) {
        print "<tr><td>";
        //連想配列$rowからpdbIDのみをprint
        //htmspecialchars()はhtmlタグとして使用される「<」「>」などを無視する
        print htmlspecialchars($row["pdbID"],ENT_QUOTES);
        print "</td><td>";
        print htmlspecialchars($row["resolution"],ENT_QUOTES);
        print "</td><td>";
        print htmlspecialchars($row["name"],ENT_QUOTES);
        print "</td><td>";
        print htmlspecialchars($row["organism"],ENT_QUOTES);
        print  "</td></tr>";
}


?>
</tbody></table>

</body>
</html>

