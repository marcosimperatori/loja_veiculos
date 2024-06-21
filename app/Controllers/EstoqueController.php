<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClienteModel;
use App\Models\EstoqueModel;
use App\Models\ModeloModel;
use CodeIgniter\HTTP\ResponseInterface;

class EstoqueController extends BaseController
{
    private $clienteModel;
    private $veiculoModel;
    private $estoqueModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
        $this->veiculoModel = new ModeloModel();
        $this->estoqueModel = new EstoqueModel();
    }

    private function getClientes()
    {
        return $this->clienteModel->select('id,nome')->where('ativo', '1')->orderBy('nome', 'asc')->findAll();
    }

    private function getVeiculos()
    {
        return $this->veiculoModel->select('id,modelo')->where('ativo', '1')->orderBy('modelo', 'asc')->findAll();
    }

    public function index()
    {
        return view('estoque/index');
    }

    public function getAll()
    {
        //garatindo que este método seja chamado apenas via ajax
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }
        $atributos = ['veiculo_modelo.modelo', 'estoque.ano', 'estoque.versao', 'estoque.motor', 'estoque.id'];
        $veiculos = $this->estoqueModel->select($atributos)
            ->join('veiculo_modelo', 'veiculo_modelo.id = estoque.idveiculo')
            ->orderBy('modelo', 'asc')->findAll();

        $data = [];

        foreach ($veiculos as $veiculo) {
            $id = encrypt($veiculo->id);
            $data[] = [
                'nome'   => $veiculo->modelo,
                'ano'    => $veiculo->ano,
                'versao' => $veiculo->versao,
                'motor'  => $veiculo->motor,
                'acoes'  => '<a href="' . base_url("estoque/editar/$id") . '" title="Editar"><i class="fas fa-edit text-success"></i></a> &nbsp; 
                             <a href="' . base_url("estoque/deletar/$id") . '" title="Excluir"><i class="fas fa-trash-alt text-danger"></i></a>'
            ];
        }

        $retorno = [
            'data' => $data
        ];

        return $this->response->setJSON($retorno);
    }

    public function criar()
    {
        $estoque = new \App\Entities\Estoque();
        $clientes = $this->getClientes();
        $veiculos = $this->getVeiculos();

        $data = [
            'titulo' => "Cadastrando novo item no estoque",
            'estoque' => $estoque,
            'clientes' => $clientes,
            'veiculos' => $veiculos
        ];

        return view('estoque/criar', $data);
    }
}
