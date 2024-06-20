<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClienteModel;
use CodeIgniter\HTTP\ResponseInterface;

class ClienteController extends BaseController
{
    private $clienteModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
    }

    public function index()
    {
        return view('cliente/index');
    }

    public function getAll()
    {
        //garatindo que este método seja chamado apenas via ajax
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }
        $atributos = ['cliente.id', 'cliente.nome', 'cliente.ativo', 'cliente.email', 'cliente.telefone'];
        $clientes = $this->clienteModel->select($atributos)
            ->orderBy('nome', 'asc')->findAll();

        $data = [];

        foreach ($clientes as $cliente) {
            $id = encrypt($cliente->id);
            $data[] = [
                'nome'       => $cliente->nome,
                'telefone'   => $cliente->telefone,
                'email'   => $cliente->email,
                'acoes'      => '<a  href="' . base_url("clientes/editar/$id") . '" title="Editar"><i class="fas fa-edit text-success"></i></a> &nbsp; 
                                 <a  href="' . base_url("clientes/deletar/$id") . '" title="Excluir"><i class="fas fa-trash-alt text-danger"></i></a>'
            ];
        }

        $retorno = [
            'data' => $data
        ];

        return $this->response->setJSON($retorno);
    }

    public function criar()
    {
        $cliente = new \App\Entities\Cliente();

        $data = [
            'titulo' => "Criando novo cliente",
            'cliente' => $cliente
        ];

        return view('cliente/criar', $data);
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
        $cliente = new \App\Entities\Cliente($post);
        $cliente->ativo = true;

        if ($this->clienteModel->protect(false)->save($cliente)) {

            //captura o id do cliente que acabou de ser inserido no banco de dados
            $retorno['id'] = $this->clienteModel->getInsertID();
            $NovoCliente = $this->buscaClienteOu404($retorno['id']);
            session()->setFlashdata('sucesso', "O cliente ($NovoCliente->nome) foi incluído no sistema");
            $retorno['redirect_url'] = base_url('clientes');

            return $this->response->setJSON($retorno);
        }

        //se chegou até aqui, é porque tem erros de validação
        $retorno['erro'] = "Verifique os aviso de erro e tente novamente";
        $retorno['erros_model'] = $this->clienteModel->errors();

        return $this->response->setJSON($retorno);
    }

    private function buscaClienteOu404(int $id = null)
    {
        //vai considerar inclusive os registros excluídos (softdelete)
        if (!$id || !$cliente = $this->clienteModel->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Cliente não encontrado com o ID: $id");
        }

        return $cliente;
    }
}
