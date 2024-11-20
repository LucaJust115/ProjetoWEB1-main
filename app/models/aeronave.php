<?php

class Aeronave {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Método para obter todas as aeronaves
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM aeronaves");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para salvar (inserir) uma nova aeronave
    public function salvar($modelo, $fabricante, $ano_fabricacao, $matricula) {
        // Query SQL para inserir uma nova aeronave na tabela
        $sql = "INSERT INTO aeronaves (modelo, fabricante, ano_fabricacao, matricula) 
                VALUES (:modelo, :fabricante, :ano_fabricacao, :matricula)";

        // Preparando a query
        $stmt = $this->pdo->prepare($sql);

        // Vinculando os parâmetros
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':fabricante', $fabricante);
        $stmt->bindParam(':ano_fabricacao', $ano_fabricacao);
        $stmt->bindParam(':matricula', $matricula);

        // Executando a query e verificando se a inserção foi bem-sucedida
        return $stmt->execute();
    }

    public function update($id)
{
    // Capturar os dados enviados no corpo da requisição (em formato JSON)
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        echo json_encode(["error" => "Nenhum dado recebido."]);
        return;
    }

    $modelo = $data['modelo'];
    $fabricante = $data['fabricante'];
    $ano_fabricacao = $data['ano_fabricacao'];
    $matricula = $data['matricula'];

    // Verificar se os dados foram corretamente recebidos
    if (!$modelo || !$fabricante || !$ano_fabricacao || !$matricula) {
        echo json_encode(["error" => "Dados incompletos para atualização."]);
        return;
    }

    // Preparar a consulta SQL de atualização
    $stmt = $this->pdo->prepare("UPDATE aeronaves SET modelo = ?, fabricante = ?, ano_fabricacao = ?, matricula = ? WHERE id = ?");
    
    // Passando o $id e os dados para a consulta
    $stmt->execute([$modelo, $fabricante, $ano_fabricacao, $matricula, $id]);

    // Verificar se a atualização foi realizada com sucesso
    if ($stmt->rowCount() > 0) {
        echo json_encode(["message" => "Aeronave atualizada com sucesso!"]);
    } else {
        echo json_encode(["error" => "Nenhuma aeronave encontrada com o ID fornecido ou nenhum dado foi alterado."]);
    }
}

    public function remover($id) {
        // Verificar se o ID existe antes de tentar remover
        $checkSql = "SELECT COUNT(*) FROM aeronaves WHERE id = :id";
        $checkStmt = $this->pdo->prepare($checkSql);
        $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $checkStmt->execute();
    
        if ($checkStmt->fetchColumn() == 0) {
            return false; // ID não encontrado
        }
    
        // Executar a exclusão
        $sql = "DELETE FROM aeronaves WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
}
?>