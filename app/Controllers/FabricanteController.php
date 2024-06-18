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

    public function getAll()
    {
        $data = [];
        $lista = $this->fabricanteModel->orderBy('fabricante', 'asc')->findAll();

        foreach ($lista as $item) {
            $id = encrypt($item->id);
            $data[] = [
                'descricao' => $item->fabricante,
                'acoes' => '<a id="fabri" data-id="' . $id . '" title="Editar" style="cursor:pointer;"><i class="fas fa-edit text-success btn-edit"></i></a> &nbsp; 
                            <a id="delfabri" data-id="' . $id . '" title="Excluir" style="cursor:pointer;"><i class="fas fa-trash-alt text-danger btn-delete"></i></a>'
            ];
        }

        $retorno = [
            'data' => $data
        ];

        return $this->response->setJSON($retorno);
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
            session()->setFlashdata('sucesso', "O certificado ($NovoFabricante->fabricante) foi incluído no sistema");
            $retorno['redirect_url'] = base_url('fabricantes');

            return $this->response->setJSON($retorno);
        }

        //se chegou até aqui, é porque tem erros de validação
        $retorno['erro'] = "Verifique os aviso de erro e tente novamente";
        $retorno['erros_model'] = $this->fabricanteModel->errors();

        return $this->response->setJSON($retorno);
    }

    public function edit($id = null)
    {
        if (is_null($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID inválido ou nulo.'
            ], ResponseInterface::HTTP_BAD_REQUEST);
        }

        $id = decrypt($id);
        $fabricante = $this->fabricanteModel->find($id);
        $fabricante->id = encrypt($fabricante->id);

        // Verifica se o fabricante foi encontrado
        if (!$fabricante) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Fabricante não encontrado.'
            ], ResponseInterface::HTTP_NOT_FOUND);
        }

        return $this->response->setJSON($fabricante);
    }

    public function atualizar()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $retorno['token'] = csrf_hash();
        $post = $this->request->getPost();

        $fabric = $this->buscaTipoOu404(decrypt($post['id']));
        $fabric->fill($post);
        $fabric->id = decrypt($post['id']);

        if ($fabric->hasChanged() == false) {
            $retorno['info'] = "Não houve alteração no registro!";
            return $this->response->setJSON($retorno);
        }

        if ($this->fabricanteModel->save($fabric)) {
            session()->setFlashdata('sucesso', "O registro foi atualizado");
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
