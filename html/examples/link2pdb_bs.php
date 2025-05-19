<!DOCTYPE html>
<html lang="ja">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<title>PDB Info.</title>
</head>
<body>

<?php
header('Content-Type:text/html; charset=UTF-8');
require('login.php');


$pdbID = (isset($_GET['pdbID']) && $_GET['pdbID'] !== "") ? $_GET['pdbID'] : "%";


$sql = "
select PDB.pdbID, PDB.method, PDB.resolution,PDB.chain,PDB.positions,PDB.deposited,PDB.class,PDB.url,Protein.name, Protein.organism,Protein.len
from PDB natural join PDB2Protein natural join Protein
where (PDB.pdbID like :id)
";


try{

        $stmh=$pdo->prepare($sql);

	$stmh->bindvalue(":id","%{$pdbID}%",PDO::PARAM_STR);
	
        $stmh->execute();

} catch(PDOException $Exception){
        die("DB検索エラー:".$Exception->getMessage());

}

 
$result=$stmh->fetchAll(PDO::FETCH_ASSOC);

$count=count($result);



?>
<head>
<title><?=$result[0]["pdbID"]?></title>
</head>
<body>
<div class="container">
 <div class="row">
  <div class="col-6">
<h1 class="display-5"><?=$result[0]["pdbID"]?></h1>
<h3 class="display-6"><?=$result[0]["name"]?></h3>
<p><b>Organism:</b> <?=$result[0]["organism"]?></br>
<b>Protein length:</b> <?=$result[0]["len"]?> AA</p>

<h3 class="display-6">PDB informations <a href="<?=$result[0]["url"]?>" target="_blank">link</a></h3>
<?php

print "<ul><li><b>Chain:</b> ".$result[0]["chain"]."</li>";
print "<li><b>Positions:</b> ".$result[0]["positions"]."</li>";
print "<li><b>Deposited:</b> ".$result[0]["deposited"]."</li>";
print "<li><b>Method:</b> ".$result[0]["method"]."</li>";
print "<li><b>Resolution:</b> ";
printf("%.2f",$result[0]["resolution"]);
print " &Aring;</li></ul>";


?>
</div>
<div class="col-6">
<img class="img-fluid" src="./pic/<?=$result[0]["pdbID"]?>.jpeg">
</div>
</div>



</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>


</html>
