<?php
require_once 'app/public/models/OrdemServico.php';

class OrdemServicoController
{
    private $ordemServico;

    public function __construct($db)
    {
        $this->ordemServico = new OrdemServico($db);
    }

    public function list()
    {
        $ordens = $this->ordemServico->list();
        echo json_encode($ordens);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->descricao) && isset($data->status) && isset($data->aeronave_id)) {
            try {
                $this->ordemServico->create($data->descricao, $data->status, $data->aeronave_id);

                http_response_code(201);
                echo json_encode(["message" => "Ordem de serviço criada com sucesso."]);
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao criar a ordem de serviço."]);
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
                $ordem = $this->ordemServico->getById($id);
                if ($ordem) {
                    echo json_encode($ordem);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Ordem de serviço não encontrada."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao buscar a ordem de serviço."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($id) && isset($data->descricao) && isset($data->status)) {
            try {
                $count = $this->ordemServico->update($id, $data->descricao, $data->status);
                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Ordem de serviço atualizada com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao atualizar a ordem de serviço."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao atualizar a ordem de serviço."]);
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
                $count = $this->ordemServico->delete($id);
                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Ordem de serviço deletada com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao deletar a ordem de serviço."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao deletar a ordem de serviço."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }
}
