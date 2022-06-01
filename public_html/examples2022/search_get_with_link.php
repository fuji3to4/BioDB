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
else {
        $id = "%";
}


if (isset($_GET["name"]) && $_GET["name"] != "") {
        $name = $_GET["name"];
}
else {
        $name = "%";
}

if (isset($_GET["class"]) && $_GET["class"] != "") {
        $class = $_GET["class"];
}
else {
        $class = "%";
}

if (isset($_GET["org"]) && $_GET["org"] != "") {
        $org = $_GET["org"];
}
else {
        $org = "%";
}

if (isset($_GET["res"]) && $_GET["res"] != "") {
        $res = $_GET["res"];
}

 

$sql = "
select PDB.pdbID, PDB.method, PDB.resolution,PDB.class, Protein.name, Protein.organism
from PDB natural join PDB2Protein natural join Protein
where (PDB.pdbID like :id)
and (PDB.class like :class) 
and (Protein.name like :name) 
and (Protein.organism like :org) 
";


if(isset($res)) {
  $sql = "$sql and (PDB.resolution <= :res)";
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
