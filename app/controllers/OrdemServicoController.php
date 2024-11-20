<?php

class OrdemServicoController {
    private $pdo;

    // Recebe a conexão PDO ao ser instanciado
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Método para cadastrar a ordem de serviço
    public function store() {
        // Ler os dados da requisição (formato JSON)
        $data = json_decode(file_get_contents("php://input"), true);

        // Verificar se os dados necessários foram recebidos
        if (isset($data['descricao'], $data['status'], $data['aeronave_id'])) {
            $descricao = $data['descricao'];
            $status = $data['status'];
            $aeronave_id = $data['aeronave_id'];

            // Preparar a consulta SQL para inserir os dados na tabela 'ordens_servico'
            $sql = "INSERT INTO ordens_servico (descricao, status, aeronave_id) VALUES (:descricao, :status, :aeronave_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':aeronave_id', $aeronave_id);

            // Executar a consulta e verificar o sucesso
            if ($stmt->execute()) {
                // Caso de sucesso: resposta com a mensagem de sucesso
                echo json_encode(["message" => "Ordem de serviço cadastrada com sucesso!"]);
            } else {
                // Caso de erro: exibir erro da consulta
                $errorInfo = $stmt->errorInfo();
                echo json_encode(["message" => "Erro ao cadastrar ordem de serviço.", "error" => $errorInfo]);
            }
        } else {
            // Caso os dados estejam faltando
            echo json_encode(["message" => "Dados incompletos. Verifique os campos 'descricao', 'status' e 'aeronave_id'."]);
        }
    }

    // Método para listar todas as ordens de serviço
    public function index() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM ordens_servico");
            $ordensServico = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Adicionar debug aqui
            error_log(print_r($ordensServico, true));
    
            // Retornar as ordens de serviço no formato JSON
            echo json_encode($ordensServico);
        } catch (Exception $e) {
            echo json_encode(['message' => 'Erro ao listar ordens de serviço: ' . $e->getMessage()]);
        }
    }

     // No método delete do controlador
// Método para deletar uma ordem de serviço
public function delete($id) {
    // Lógica para deletar a ordem de serviço com o id
    $stmt = $this->pdo->prepare('DELETE FROM ordens_servico WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(["message" => "Ordem de serviço com ID $id deletada."]);
}
}





?>
