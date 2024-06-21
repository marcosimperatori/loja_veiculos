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

    public function cadastrar()
    {
        //garatindo que este método seja chamado apenas via ajax
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        //atualiza o token do formulário
        $retorno['token'] = csrf_hash();

        //recuperando os dados que vieram na requisiçao
        $post = $this->request->getPost();

        //Criando um novo objeto da entidade cliente
        $estoque = new \App\Entities\Estoque($post);
        $estoque->iduser = 1;

        if (isset($post['ar'])) {
            $estoque->ar = 1;
        } else {
            $estoque->ar = 0;
        }

        if (isset($post['vidro'])) {
            $estoque->vidro = 1;
        } else {
            $estoque->vidro = 0;
        }

        if (isset($post['alarme'])) {
            $estoque->alarme = 1;
        } else {
            $estoque->alarme = 0;
        }


        if ($this->estoqueModel->protect(false)->save($estoque)) {

            //captura o id do cliente que acabou de ser inserido no banco de dados
            //$retorno['id'] = $this->clienteModel->getInsertID();
            //$NovoCliente = $this->buscaClienteOu404($retorno['id']);
            session()->setFlashdata('sucesso', "O veículo foi incluído no estoque");
            $retorno['redirect_url'] = base_url('estoque');

            return $this->response->setJSON($retorno);
        } else {
            echo "aqui<pre>";
            var_dump($estoque);
            die();
        }

        //se chegou até aqui, é porque tem erros de validação
        $retorno['erro'] = "Verifique os aviso de erro e tente novamente";
        $retorno['erros_model'] = $this->estoqueModel->errors();

        return $this->response->setJSON($retorno);
    }
}
