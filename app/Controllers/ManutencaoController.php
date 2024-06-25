<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ManutencaoModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class ManutencaoController extends BaseController
{
    private $manutencaoModel;

    public function __construct()
    {
        $this->manutencaoModel = new ManutencaoModel();
    }

    public function index()
    {
        return view('manutencao/index');
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
}
