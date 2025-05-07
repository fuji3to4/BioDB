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

$id = (isset($_GET['id']) && $_GET['id'] !== "") ? $_GET['id'] : "%";
$name = (isset($_GET['name']) && $_GET['name'] !== "") ? $_GET['name'] : "%";
$class = (isset($_GET['class']) && $_GET['class'] !== "") ? $_GET['class'] : "%";
$org = (isset($_GET['org']) && $_GET['org'] !== "") ? $_GET['org'] : "%";

// $res だけ特別扱いする
$res = (isset($_GET['res']) && $_GET['res'] !== "") ? $_GET['res'] : null;

 

$sql = "
select PDB.pdbID, PDB.method, PDB.resolution,PDB.class, Protein.name, Protein.organism
from PDB natural join PDB2Protein natural join Protein
where (PDB.pdbID like :id)
and (PDB.class like :class) 
and (Protein.name like :name) 
and (Protein.organism like :org) 
";


// resolution指定がある場合、条件を追加
if ($res !== null) {
        $sql .= " AND (PDB.resolution <= :res)";
}


try{

        $stmh=$pdo->prepare($sql);

	$stmh->bindvalue(":id","%{$id}%",PDO::PARAM_STR);
        $stmh->bindvalue(":class","%{$class}%",PDO::PARAM_STR);
	$stmh->bindvalue(":name","%{$name}%",PDO::PARAM_STR);
	$stmh->bindvalue(":org","%{$org}%",PDO::PARAM_STR);

        if(isset($res)) {
                $stmh->bindvalue(":res","$res",PDO::PARAM_INT);
        }
	
        $stmh->execute();

        $count=$stmh->rowCount();

        print "検索結果は{$count}件です。<br><br>";

} catch(PDOException $Exception){
        die("DB検索エラー:".$Exception->getMessage());

}

?>

<table border='1' cellpadding='2' cellspacing='0'>
<thead>
<tr bgcolor="#00CCCC"><th>PDBID</th><th>Method</th><th>Resolution</th><th>Class</th><th>Protein Name</th><th>Organism</th></tr>
</thead>
<tbody>

<?php
 
$result=$stmh->fetchAll(PDO::FETCH_ASSOC);

foreach($result as $row) {
	print "<tr><td>";

	/*search_get.phpとここだけ異なる
	<a>タグを入れてリンクを貼っている*/
	print "<a href='./link2pdb.php?pdbID=".htmlspecialchars($row["pdbID"],ENT_QUOTES)."'>";
	print htmlspecialchars($row["pdbID"],ENT_QUOTES);
	print "</a>";
	//

	print "</td><td>";
        print htmlspecialchars($row["method"],ENT_QUOTES);
        print "</td><td>";
        print htmlspecialchars($row["resolution"],ENT_QUOTES);
	print "</td><td>";
	print htmlspecialchars($row["class"],ENT_QUOTES);
	print "</td><td>";
	print htmlspecialchars($row["name"],ENT_QUOTES);
	print "</td><td>";
	print htmlspecialchars($row["organism"],ENT_QUOTES);
	print "</td></tr>\n";
}

?>

</tbody></table>
</body>
</html>
