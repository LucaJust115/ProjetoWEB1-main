<?php

class OrdemServicoController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['descricao'], $data['status'], $data['aeronave_id'])) {
            $descricao = $data['descricao'];
            $status = $data['status'];
            $aeronave_id = $data['aeronave_id'];

            $sql = "INSERT INTO ordens_servico (descricao, status, aeronave_id) VALUES (:descricao, :status, :aeronave_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':aeronave_id', $aeronave_id);

            if ($stmt->execute()) {
                echo json_encode(["message" => "Ordem de serviço cadastrada com sucesso!"]);
            } else {
                $errorInfo = $stmt->errorInfo();
                echo json_encode(["message" => "Erro ao cadastrar ordem de serviço.", "error" => $errorInfo]);
            }
        } else {
            echo json_encode(["message" => "Dados incompletos. Verifique os campos 'descricao', 'status' e 'aeronave_id'."]);
        }
    }

    public function index() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM ordens_servico");
            $ordensServico = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            error_log(print_r($ordensServico, true));
    
            echo json_encode($ordensServico);
        } catch (Exception $e) {
            echo json_encode(['message' => 'Erro ao listar ordens de serviço: ' . $e->getMessage()]);
        }
    }

public function delete($id) {
    $stmt = $this->pdo->prepare('DELETE FROM ordens_servico WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(["message" => "Ordem de serviço com ID $id deletada."]);
}
}





?>
