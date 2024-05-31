<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FabricanteVeiculoModel;
use CodeIgniter\HTTP\ResponseInterface;

class FabricanteController extends BaseController
{
    private $fabricanteModel;

    public function __construct()
    {
        $this->fabricanteModel = new FabricanteVeiculoModel();
    }
    public function index()
    {
        return view('fabricantes/index');
    }

    public function criar()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        //atualiza o token do formulário
        $retorno['token'] = csrf_hash();

        //recuperando os dados que vieram na requisiçao
        $post = $this->request->getPost();
        $fabricante = new \App\Entities\Fabricante($post);

        if ($this->fabricanteModel->save($fabricante)) {
            $retorno['id'] = $this->fabricanteModel->getInsertID();
            $NovoFabricante = $this->buscaTipoOu404($retorno['id']);
            session()->setFlashdata('sucesso', "O certificado ($NovoFabricante->descricao) foi incluído no sistema");
            $retorno['redirect_url'] = base_url('fabricantes');

            return $this->response->setJSON($retorno);
        }

        //se chegou até aqui, é porque tem erros de validação
        $retorno['erro'] = "Verifique os aviso de erro e tente novamente";
        $retorno['erros_model'] = $this->fabricanteModel->errors();

        return $this->response->setJSON($retorno);
    }


    private function buscaTipoOu404(int $id = null)
    {
        //vai considerar inclusive os registros excluídos (softdelete)
        if (!$id || !$tipo = $this->fabricanteModel->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Fabricante não encontrado com o ID: $id");
        }

        return $tipo;
    }
}
