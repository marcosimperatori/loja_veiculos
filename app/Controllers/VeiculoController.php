<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FabricanteVeiculoModel;
use App\Models\ModeloModel;
use App\Models\TipoVeiculoModel;
use CodeIgniter\HTTP\ResponseInterface;

class VeiculoController extends BaseController
{
    private $veiculo;
    private $fabricante;
    private $tipo;

    public function __construct()
    {
        $this->veiculo = new ModeloModel();
        $this->fabricante = new FabricanteVeiculoModel();
        $this->tipo = new TipoVeiculoModel();
    }

    public function index()
    {
        return view('veiculos/index');
    }

    private function getFabricantes()
    {
        return $this->fabricante->select('id,fabricante')->where('ativo', '1')->orderBy('fabricante', 'asc')->findAll();
    }

    private function getTipos()
    {
        return $this->tipo->select('id,descricao')->where('ativo', '1')->orderBy('descricao', 'asc')->findAll();
    }

    public function getAll()
    {
        $data = [];
        $lista = $this->veiculo->orderBy('modelo', 'asc')->findAll();

        foreach ($lista as $item) {
            $id = encrypt($item->id);

            switch ($item->idtipo) {
                case '1':
                    $icone = '<i class="fas fa-car"></i>&nbsp;&nbsp;';
                    break;
                case '2':
                    $icone = '<i class="fas fa-motorcycle"></i>&nbsp;&nbsp;';
                    break;
                case '3':
                    $icone = '<i class="fas fa-truck"></i>&nbsp;&nbsp;';
                    break;

                default:
                    $icone = "";
                    break;
            }

            $data[] = [
                'descricao'   => $icone . $item->modelo,
                'potencia'    => $item->potencia,
                'combustivel' => $item->combustivel,
                'acoes'       => '<a href="' . base_url("veiculos/editar/$id") . '" title="Editar" style="cursor:pointer;"><i class="fas fa-edit text-success btn-edit"></i></a> &nbsp; 
                                  <a href="' . base_url("veiculos/deletar/$id") . '" title="Excluir" style="cursor:pointer;"><i class="fas fa-trash-alt text-danger btn-delete"></i></a>'
            ];
        }

        $retorno = [
            'data' => $data
        ];

        return $this->response->setJSON($retorno);
    }

    public function criar()
    {
        $veiculo = new \App\Entities\Veiculo();
        $fabricantes = $this->getFabricantes();
        $tipos = $this->getTipos();

        $data = [
            'titulo'      => "Criando novo cliente",
            'veiculo'     => $veiculo,
            'fabricantes' => $fabricantes,
            'tipos'       => $tipos
        ];

        return view('veiculos/criar', $data);
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
        $veiculo = new \App\Entities\Veiculo($post);
        $veiculo->ativo = true;

        if ($this->veiculo->protect(false)->save($veiculo)) {

            //captura o id do cliente que acabou de ser inserido no banco de dados
            $retorno['id'] = $this->veiculo->getInsertID();
            $NovoVeiculo = $this->buscaVeiculoOu404($retorno['id']);
            session()->setFlashdata('sucesso', "O  veículo ($NovoVeiculo->modelo) foi incluído no sistema");
            $retorno['redirect_url'] = base_url('veiculos');

            return $this->response->setJSON($retorno);
        }

        //se chegou até aqui, é porque tem erros de validação
        $retorno['erro'] = "Verifique os aviso de erro e tente novamente";
        $retorno['erros_model'] = $this->veiculo->errors();

        return $this->response->setJSON($retorno);
    }

    public function edit($enc_id)
    {
        $id = decrypt($enc_id);
        if (!$id) {
            return redirect()->to('veiculos');
        }

        $veic = $this->buscaVeiculoOu404($id);
        $fabricantes = $this->getFabricantes();
        $tipos = $this->getTipos();

        $data = [
            'titulo' => "Editando veículo",
            'veiculo' => $veic,
            'fabricantes' => $fabricantes,
            'tipos' => $tipos
        ];
        return view('veiculos/editar', $data);
    }

    public function atualizar()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $retorno['token'] = csrf_hash();
        $post = $this->request->getPost();
        $veic = $this->buscaVeiculoOu404($post['id']);
        $veic->fill($post);

        if ($veic->hasChanged() == false) {
            $retorno['info'] = "Não houve alteração no registro!";
            return $this->response->setJSON($retorno);
        }

        if ($this->veiculo->protect(false)->save($veic)) {
            session()->setFlashdata('sucesso', "O veículo $veic->modelo foi atualizado");
            $retorno['redirect_url'] = base_url('veiculos');
            return $this->response->setJSON($retorno);
        }

        //se chegou até aqui, é porque tem erros de validação
        $retorno['erro'] = "Verifique os aviso de erro e tente novamente";
        $retorno['erros_model'] = $this->veiculo->errors();

        return $this->response->setJSON($retorno);
    }

    public function deletar($enc_id)
    {
        $id = decrypt($enc_id);
        if (!$id) {
            return redirect()->to('home');
        }

        $veic = $this->buscaVeiculoOu404($id);
        $data = [
            'veiculo' => $veic
        ];
        return view('veiculos/deletar', $data);
    }

    public function confirma_exclusao($enc_id)
    {
        $id = decrypt($enc_id);
        if (!$id) {
            return redirect()->to('veiculos');
        }

        /* $vendaVinculada = $this->veiculo->select('id')
            ->where('idcliente', $id)->first();*/

        // if (!is_null($vendaVinculada)) {
        //     $cliente = $this->clienteModel->find($id);
        //     session()->setFlashdata('atencao', "O cliente " . $cliente->nomecli . " está vinculado a uma ou mais vendas, por isso não pode ser excluído");
        // } else {
        $veic = $this->veiculo->find($id);
        $this->veiculo->delete($id);
        session()->setFlashdata('atencao', "O veículo " . $veic->modelo . " foi excluído do sistema");
        // }

        return redirect()->to('veiculos');
    }

    private function buscaVeiculoOu404(int $id = null)
    {
        //vai considerar inclusive os registros excluídos (softdelete)
        if (!$id || !$cliente = $this->veiculo->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Veiculo não encontrado com o ID: $id");
        }

        return $cliente;
    }
}
