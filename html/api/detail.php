
<?php
// api/detail.php
header('Content-Type: application/json; charset=UTF-8');
require('login.php');

// CORSの設定 - 開発環境用
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// PDB IDの取得と検証
$pdbID = (isset($_GET['pdbID']) && $_GET['pdbID'] !== "") ? $_GET['pdbID'] : "%";

if (!$pdbID) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'PDB ID is required'
    ]);
    exit;
}

$sql = "
SELECT 
    PDB.pdbID, 
    PDB.method, 
    PDB.resolution,
    PDB.chain,
    PDB.positions,
    PDB.deposited,
    PDB.class,
    PDB.url,
    Protein.name, 
    Protein.organism,
    Protein.len
FROM PDB 
NATURAL JOIN PDB2Protein 
NATURAL JOIN Protein
WHERE PDB.pdbID = :id
";

try {
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(":id", $pdbID, PDO::PARAM_STR);
    $stmh->execute();
    
    $result = $stmh->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        echo json_encode([
            'status' => 'success',
            'data' => $result
        ], JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(404);
        echo json_encode([
            'status' => 'error',
            'message' => 'PDB not found'
        ], JSON_UNESCAPED_UNICODE);
    }

} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'データベースエラーが発生しました'
    ],JSON_UNESCAPED_UNICODE);
}
?>