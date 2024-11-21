<?php

require_once 'app/models/Aeronave.php';

class AeronaveController {
    private $aeronave;

    public function __construct($pdo) {
        $this->aeronave = new Aeronave($pdo);
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['modelo'], $data['fabricante'], $data['ano_fabricacao'], $data['matricula'])) {
            $modelo = $data['modelo'];
            $fabricante = $data['fabricante'];
            $ano_fabricacao = $data['ano_fabricacao'];
            $matricula = $data['matricula'];

            if ($this->aeronave->salvar($modelo, $fabricante, $ano_fabricacao, $matricula)) {
                echo json_encode(["message" => "Aeronave cadastrada com sucesso!"]);
            } else {
                http_response_code(500); 
                echo json_encode(["message" => "Erro ao cadastrar aeronave."]);
            }
        } else {
            http_response_code(400); 
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function index() {
        
        $aeronaves = $this->aeronave->getAll();
    
        
        if ($aeronaves) {
            
            echo json_encode($aeronaves);
        } else {
            
            http_response_code(404); 
            echo json_encode(["message" => "Nenhuma aeronave encontrada."]);
        }
    }

    public function update($id)
{
    // Verificar se o ID é válido
    if (!is_numeric($id)) {
        echo json_encode(["error" => "ID inválido."]);
        return;
    }

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

    // Verificar se a aeronave existe
    $sqlCheck = "SELECT COUNT(*) FROM aeronaves WHERE id = :id";
    $stmtCheck = $this->pdo->prepare($sqlCheck);
    $stmtCheck->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtCheck->execute();

    if ($stmtCheck->fetchColumn() == 0) {
        echo json_encode(["error" => "Aeronave não encontrada."]);
        return;
    }

    // Preparar a consulta SQL de atualização
    $stmt = $this->pdo->prepare("UPDATE aeronaves SET modelo = ?, fabricante = ?, ano_fabricacao = ?, matricula = ? WHERE id = ?");
    $stmt->execute([$modelo, $fabricante, $ano_fabricacao, $matricula, $id]);

    // Verificar se a atualização foi realizada com sucesso
    if ($stmt->rowCount() > 0) {
        echo json_encode(["message" => "Aeronave atualizada com sucesso!"]);
    } else {
        echo json_encode(["error" => "Nenhuma aeronave foi alterada ou erro ao atualizar."]);
    }
}


    public function destroy($id) {
        if (!is_numeric($id)) {
            http_response_code(400); // Requisição inválida
            echo json_encode(["message" => "ID inválido."]);
            return;
        }
    
        if ($this->aeronave->remover($id)) {
            echo json_encode(["message" => "Aeronave removida com sucesso!"]);
        } else {
            http_response_code(500); // Erro interno do servidor
            echo json_encode(["message" => "Erro ao remover aeronave."]);
        }
    }
}

/*