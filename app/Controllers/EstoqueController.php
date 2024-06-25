<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClienteModel;
use App\Models\EstoqueModel;
use App\Models\ModeloModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

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
                'nome'   => $veiculo->modelo . ' - ' . $veiculo->versao,
                'ano'    => $veiculo->ano,
                'motor'  => $veiculo->motor,
                'acoes'  => '<a href="' . base_url("manutencao/lancar/$id") . '" title="Gasto com manutenção"><i class="fas fa-wrench"></i> </a>&nbsp
                             <a href="' . base_url("estoque/editar/$id") . '" title="Editar"><i class="fas fa-edit text-success"></i></a> &nbsp; 
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

        // Remove máscara dos valores monetários e substitui a vírgula pelo ponto
        if (isset($post['preco_compra'])) {
            $post['preco_compra'] = str_replace('.', '', $post['preco_compra']);
            $post['preco_compra'] = str_replace(',', '.', $post['preco_compra']);
        }

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

        $estoque->disponivel = 1;
        $estoque->vendido = 'n';
        $estoque->reservado = 'n';

        try {
            if ($this->estoqueModel->protect(false)->save($estoque)) {

                //captura o id do cliente que acabou de ser inserido no banco de dados
                //$retorno['id'] = $this->clienteModel->getInsertID();
                //$NovoCliente = $this->buscaClienteOu404($retorno['id']);
                session()->setFlashdata('sucesso', "O veículo foi incluído no estoque");
                $retorno['redirect_url'] = base_url('estoque');

                return $this->response->setJSON($retorno);
            }
        } catch (Exception $e) {
            echo "exception <pre>";
            var_dump($e);
            die();
        }

        //se chegou até aqui, é porque tem erros de validação
        $retorno['erro'] = "Verifique os aviso de erro e tente novamente";
        $retorno['erros_model'] = $this->estoqueModel->errors();

        return $this->response->setJSON($retorno);
    }

    public function edit($enc_id)
    {
        $id = decrypt($enc_id);
        if (!$id) {
            return redirect()->to('estoque');
        }

        $estoque = $this->estoqueModel->find($id);
        $clientes = $this->getClientes();
        $veiculos = $this->getVeiculos();

        $data = [
            'titulo' => "Editando item no estoque",
            'estoque' => $estoque,
            'clientes' => $clientes,
            'veiculos' => $veiculos
        ];
        return view('estoque/editar', $data);
    }

    public function atualizar()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $retorno['token'] = csrf_hash();
        $post = $this->request->getPost();

        // Normaliza os valores dos checkboxes
        $post['ar'] = isset($post['ar']) ? '1' : '0';
        $post['vidro'] = isset($post['vidro']) ? '1' : '0';
        $post['alarme'] = isset($post['alarme']) ? '1' : '0';

        // Remove máscara dos valores monetários e substitui a vírgula pelo ponto
        if (isset($post['preco_compra'])) {
            $post['preco_compra'] = str_replace('.', '', $post['preco_compra']);
            $post['preco_compra'] = str_replace(',', '.', $post['preco_compra']);
        }

        $estoque = $this->estoqueModel->find($post['id']);

        // Adiciona declarações de depuração
        //log_message('debug', 'Dados do POST: ' . json_encode($post));
        //log_message('debug', 'Dados antes do fill: ' . json_encode($estoque->toArray()));

        $estoque->fill($post);

        //log_message('debug', 'Dados depois do fill: ' . json_encode($estoque->toArray()));

        if ($estoque->hasChanged() == false) {
            $retorno['info'] = "Não houve alteração no registro!";
            return $this->response->setJSON($retorno);
        }

        if ($this->estoqueModel->protect(false)->save($estoque)) {
            session()->setFlashdata('sucesso', "O estoque foi atualizado");
            $retorno['redirect_url'] = base_url('estoque');
            return $this->response->setJSON($retorno);
        }

        //se chegou até aqui, é porque tem erros de validação
        $retorno['erro'] = "Verifique os aviso de erro e tente novamente";
        $retorno['erros_model'] = $this->estoqueModel->errors();

        return $this->response->setJSON($retorno);
    }

    public function deletar($enc_id)
    {
        $id = decrypt($enc_id);
        if (!$id) {
            return redirect()->to('estoque');
        }

        $estoque = $this->buscaEstoqueOu404($id);
        $data = [
            'estoque' => $estoque
        ];
        return view('estoque/deletar', $data);
    }

    public function confirma_exclusao($enc_id)
    {
        $id = decrypt($enc_id);
        if (!$id) {
            return redirect()->to('estoque');
        }

        /*$vendaVinculada = $this->certificadoModel->select('id')
            ->where('idcliente', $id)->first();*/

        //if (!is_null($vendaVinculada)) {
        //$cliente = $this->clienteModel->find($id);
        // session()->setFlashdata('atencao', "O cliente " . $cliente->nomecli . " está vinculado a uma ou mais vendas, por isso não pode ser excluído");
        //} else {

        if ($this->estoqueModel->delete($id)) {
            session()->setFlashdata('atencao', "O veículo foi excluído do estoque");
        }
        //}

        return redirect()->to('estoque');
    }

    private function buscaEstoqueOu404(int $id = null)
    {
        //vai considerar inclusive os registros excluídos (softdelete)
        if (!$id || !$cliente = $this->estoqueModel
            ->select('estoque.id,estoque.versao, estoque.motor,veiculo_modelo.modelo')->join('veiculo_modelo', 'veiculo_modelo.id = estoque.idveiculo')->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Cliente não encontrado com o ID: $id");
        }

        return $cliente;
    }
}
