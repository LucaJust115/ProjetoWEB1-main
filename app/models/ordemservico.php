<?php

class OrdemServico {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM ordens_servico");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar($descricao, $status, $aeronave_id) {
        try {
            $sql = "INSERT INTO ordens_servico (descricao, status, aeronave_id) 
                    VALUES (:descricao, :status, :aeronave_id)";
            
            $stmt = $this->pdo->prepare($sql);
            
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':aeronave_id', $aeronave_id);
            
            if ($stmt->execute()) {
                return true;
            } else {
                error_log('Erro ao executar a query de inserção.');
                return false;
            }
        } catch (PDOException $e) {
            error_log('Erro ao salvar ordem de serviço: ' . $e->getMessage());
            return false;
        }
    }

    public function remover($id) {
        $sql = "DELETE FROM ordens_servico WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
