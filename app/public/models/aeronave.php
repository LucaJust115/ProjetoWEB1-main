<?php
require_once "../BD/db.php";

class Aeronave
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($modelo, $fabricante, $ano_fabricacao, $matricula)
    {
        $sql = "INSERT INTO aeronaves (modelo, fabricante, ano_fabricacao, matricula) 
                VALUES (:modelo, :fabricante, :ano_fabricacao, :matricula)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':fabricante', $fabricante);
        $stmt->bindParam(':ano_fabricacao', $ano_fabricacao);
        $stmt->bindParam(':matricula', $matricula);
        return $stmt->execute();
    }

    public function list()
    {
        $sql = "SELECT id, modelo, fabricante, ano_fabricacao, matricula FROM aeronaves";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM aeronaves WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $modelo, $fabricante, $ano_fabricacao, $matricula)
    {
        $sql = "UPDATE aeronaves SET modelo = :modelo, fabricante = :fabricante, 
                ano_fabricacao = :ano_fabricacao, matricula = :matricula WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':fabricante', $fabricante);
        $stmt->bindParam(':ano_fabricacao', $ano_fabricacao);
        $stmt->bindParam(':matricula', $matricula);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM aeronaves WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
