<?php

class Aeronave {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM aeronaves");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar($modelo, $fabricante, $ano_fabricacao, $matricula) {
        $sql = "INSERT INTO aeronaves (modelo, fabricante, ano_fabricacao, matricula) 
                VALUES (:modelo, :fabricante, :ano_fabricacao, :matricula)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':fabricante', $fabricante);
        $stmt->bindParam(':ano_fabricacao', $ano_fabricacao);
        $stmt->bindParam(':matricula', $matricula);

        return $stmt->execute();
    }

    public function update($id)
{
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        echo json_encode(["error" => "Nenhum dado recebido."]);
        return;
    }

    $modelo = $data['modelo'];
    $fabricante = $data['fabricante'];
    $ano_fabricacao = $data['ano_fabricacao'];
    $matricula = $data['matricula'];

    if (!$modelo || !$fabricante || !$ano_fabricacao || !$matricula) {
        echo json_encode(["error" => "Dados incompletos para atualização."]);
        return;
    }

    $stmt = $this->pdo->prepare("UPDATE aeronaves SET modelo = ?, fabricante = ?, ano_fabricacao = ?, matricula = ? WHERE id = ?");
    
    $stmt->execute([$modelo, $fabricante, $ano_fabricacao, $matricula, $id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(["message" => "Aeronave atualizada com sucesso!"]);
    } else {
        echo json_encode(["error" => "Nenhuma aeronave encontrada com o ID fornecido ou nenhum dado foi alterado."]);
    }
}

    public function remover($id) {
        $checkSql = "SELECT COUNT(*) FROM aeronaves WHERE id = :id";
        $checkStmt = $this->pdo->prepare($checkSql);
        $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $checkStmt->execute();
    
        if ($checkStmt->fetchColumn() == 0) {
            return false; 
        }
    
        $sql = "DELETE FROM aeronaves WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
}
?>