<?php
require_once 'app/public/BD/db.php';

class OrdemServico
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($descricao, $status, $data_criacao, $aeronave_id)
    {
        $sql = "INSERT INTO ordens_servico (descricao, status, data_criacao, aeronave_id) 
                VALUES (:descricao, :status, :data_criacao, :aeronave_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':data_criacao', $data_criacao);
        $stmt->bindParam(':aeronave_id', $aeronave_id);
        return $stmt->execute();
    }

    public function list()
    {
        $sql = "SELECT id, descricao, status, data_criacao, aeronave_id FROM ordens_servico";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM ordens_servico WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $descricao, $status, $data_criacao, $aeronave_id)
    {
        $sql = "UPDATE ordens_servico SET descricao = :descricao, status = :status, 
                data_criacao = :data_criacao, aeronave_id = :aeronave_id WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':data_criacao', $data_criacao);
        $stmt->bindParam(':aeronave_id', $aeronave_id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM ordens_servico WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
