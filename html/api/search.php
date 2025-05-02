<?php
header('Content-Type:text/html; charset=UTF-8');

require('../login.php');
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');


$id = (isset($_GET['id']) && $_GET['id'] !== "") ? $_GET['id'] : "%";
$name = (isset($_GET['name']) && $_GET['name'] !== "") ? $_GET['name'] : "%";
$class = (isset($_GET['class']) && $_GET['class'] !== "") ? $_GET['class'] : "%";
$org = (isset($_GET['org']) && $_GET['org'] !== "") ? $_GET['org'] : "%";

// $res だけ特別扱いする
$res = (isset($_GET['res']) && $_GET['res'] !== "") ? $_GET['res'] : null;



// 基本のSQL文
$sql = "
SELECT 
    PDB.pdbID, 
    PDB.method, 
    PDB.resolution,
    PDB.class, 
    Protein.name, 
    Protein.organism
FROM PDB 
NATURAL JOIN PDB2Protein 
NATURAL JOIN Protein
WHERE (PDB.pdbID LIKE :id)
AND (PDB.class LIKE :class) 
AND (Protein.name LIKE :name) 
AND (Protein.organism LIKE :org)
";


// resolution指定がある場合、条件を追加
if ($res !== null) {
        $sql .= " AND (PDB.resolution <= :res)";
}

try {

        $stmh = $pdo->prepare($sql);

        $stmh->bindvalue(":id", "%{$id}%", PDO::PARAM_STR);
        $stmh->bindvalue(":class", "%{$class}%", PDO::PARAM_STR);
        $stmh->bindvalue(":name", "%{$name}%", PDO::PARAM_STR);
        $stmh->bindvalue(":org", "%{$org}%", PDO::PARAM_STR);

        if ($res !== null) {
                $stmh->bindvalue(":res", "$res", PDO::PARAM_INT);
        }

        $stmh->execute();

        // 検索結果の取得
        $result = $stmh->fetchAll(PDO::FETCH_ASSOC);
        $count = $stmh->rowCount();

        // JSONレスポンスの構築
        $response = [
                'status' => 'success',
                'count' => $count,
                'data' => $result
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE);

} catch(PDOException $e) {
        // エラーレスポンス
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'データベースエラーが発生しました'
        ],JSON_UNESCAPED_UNICODE);
    }

?>