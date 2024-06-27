<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EstoqueModel;
use App\Models\ManutencaoModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class ManutencaoController extends BaseController
{
    private $manutencaoModel;
    private $estoqueModel;

    public function __construct()
    {
        $this->manutencaoModel = new ManutencaoModel();
        $this->estoqueModel = new EstoqueModel();
    }

    public function index()
    {
        return view('manutencao/index');
    }

    private function getEstoque()
    {
        $atributos = ['estoque.id', 'estoque.versao', 'estoque.motor', 'veiculo_modelo.modelo'];
        $estoque = $this->estoqueModel->select($atributos)
            ->join('veiculo_modelo', 'veiculo_modelo.id = estoque.idveiculo')
            ->where('vendido', 'n')
            ->orderBy('veiculo_modelo.modelo', 'asc')
            ->findAll();

        foreach ($estoque as $item) {
            $item->modelo = $item->modelo . ' ' . $item->versao . ' ' . $item->motor;
            unset($item->versao);
            unset($item->motor);
        }

        return $estoque;
    }

    public function criar()
    {
        $manutencao = new \App\Entities\Manutencao();

        $data = [
            'titulo' => "Cadastrando manutenção do veículo",
            'manutencao' => $manutencao,
            'veiculos' => $this->getEstoque()
        ];

        return view('manutencao/criar', $data);
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

        //Criando um novo objeto da entidade manutençao
        $manutencao = new \App\Entities\Manutencao($post);

        try {
            if ($this->manutencaoModel->protect(false)->save($manutencao)) {

                //captura o id do cliente que acabou de ser inserido no banco de dados
                //$retorno['id'] = $this->clienteModel->getInsertID();
                //$NovoCliente = $this->buscaClienteOu404($retorno['id']);
                session()->setFlashdata('sucesso', "Lançamento incluído no estoque");
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
        $retorno['erros_model'] = $this->manutencaoModel->errors();

        return $this->response->setJSON($retorno);
    }

    public function edit($enc_id)
    {
        $id = decrypt($enc_id);
        if (!$id) {
            return redirect()->to('manutencao');
        }

        $manutencao = $this->manutencaoModel->find($id);

        $data = [
            'titulo' => "Editando manutenção do veículo",
            'manutencao' => $manutencao,
            'veiculos' => $this->getEstoque()
        ];
        return view('manutencao/editar', $data);
    }
}
