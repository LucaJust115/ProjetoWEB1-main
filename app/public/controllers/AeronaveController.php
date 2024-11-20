<?php
require_once 'app/public/models/Aeronave.php';

class AeronaveController
{
    private $aeronave;

    public function __construct($db)
    {
        $this->aeronave = new Aeronave($db);
    }

    public function list()
    {
        $aeronaves = $this->aeronave->list();
        echo json_encode($aeronaves);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->modelo) && isset($data->fabricante) && isset($data->ano_fabricacao) && isset($data->matricula)) {
            try {
                $this->aeronave->create($data->modelo, $data->fabricante, $data->ano_fabricacao, $data->matricula);

                http_response_code(201);
                echo json_encode(["message" => "Aeronave criada com sucesso."]);
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao criar a aeronave."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function getById($id)
    {
        if (isset($id)) {
            try {
                $aeronave = $this->aeronave->getById($id);
                if ($aeronave) {
                    echo json_encode($aeronave);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Aeronave não encontrada."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao buscar a aeronave."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($id) && isset($data->modelo) && isset($data->fabricante) && isset($data->ano_fabricacao) && isset($data->matricula)) {
            try {
                $count = $this->aeronave->update($id, $data->modelo, $data->fabricante, $data->ano_fabricacao, $data->matricula);
                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Aeronave atualizada com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao atualizar a aeronave."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao atualizar a aeronave."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function delete($id)
    {
        if (isset($id)) {
            try {
                $count = $this->aeronave->delete($id);
                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Aeronave deletada com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao deletar a aeronave."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao deletar a aeronave."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }
}
