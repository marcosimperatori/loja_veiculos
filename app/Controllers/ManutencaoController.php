<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EstoqueModel;
use App\Models\ManutencaoModel;
use App\Models\ManutencaoTipoModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class ManutencaoController extends BaseController
{
    private $manutencaoModel;
    private $estoqueModel;
    private $manutTipoModel;

    public function __construct()
    {
        $this->manutencaoModel = new ManutencaoModel();
        $this->estoqueModel = new EstoqueModel();
        $this->manutTipoModel = new ManutencaoTipoModel();
    }

    public function index()
    {
        return view('manutencao/index');
    }

    private function getEstoque()
    {
        $atributos = [
            'estoque.id', 'estoque.versao', 'estoque.motor', 'veiculo_modelo.modelo',
            'estoque.ano', 'estoque.cor'
        ];
        $estoque = $this->estoqueModel->select($atributos)
            ->join('veiculo_modelo', 'veiculo_modelo.id = estoque.idveiculo')
            ->where('vendido', 'n')
            ->orderBy('veiculo_modelo.modelo', 'asc')
            ->findAll();

        foreach ($estoque as $item) {
            $item->modelo = $item->modelo . ' ' . $item->versao . ' ' . $item->motor . '  ' . $item->ano . ' ' . $item->cor;
            unset($item->versao);
            unset($item->motor);
            unset($item->ano);
            unset($item->cor);
        }

        return $estoque;
    }

    private function tiposManutencao()
    {
        return $this->manutTipoModel->orderBy('tipo_manu', 'asc')->findAll();
    }

    public function criar()
    {
        $manutencao = new \App\Entities\Manutencao();
        $estoque = new \App\Entities\Estoque();

        $data = [
            'titulo' => "Cadastrando manutenção do veículo",
            'manutencao' => $manutencao,
            'estoque' => $estoque,
            'veiculos' => $this->getEstoque(),
            'tipos' => $this->tiposManutencao()
        ];

        return view('manutencao/criar', $data);
    }

    public function criarAPartirDe($enc_id)
    {
        $id = decrypt($enc_id);
        if (!$id) {
            return redirect()->to('estoque'); //sempre virá a partir do estoque, melhor volta pra lá quando for o caso
        }

        $manutencao = new \App\Entities\Manutencao();
        $estoque = $this->estoqueModel->find($id);

        $data = [
            'titulo' => "Cadastrando manutenção do veículo",
            'manutencao' => $manutencao,
            'estoque' => $estoque,
            'veiculos' => $this->getEstoque(),
            'tipos' => $this->tiposManutencao()
        ];

        return view('manutencao/criar', $data);
    }

    public function cadastrar()
    {
        //garatindo que este método seja chamado apenas via ajax
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $request = \Config\Services::request();
        $path = $request->getUri()->getPath();
        if (strpos($path, 'lancar') !== false) {
            $url = 'manutencao';
        } else {
            $url = 'estoque';
        }

        //atualiza o token do formulário
        $retorno['token'] = csrf_hash();

        //recuperando os dados que vieram na requisiçao
        $post = $this->request->getPost();

        // Objetivo é certificar que todas as manutenções sejam posteriores a data da aquisição do veículo
        $dados = $this->EAnteriorACompraVeiculo($post['idestoque'], $post['data_manu']);

        if ($dados["dataInvalida"]) {
            $msg = "O veículo foi comprado em <strong>" . date('d/m/Y', strtotime($dados["data_compra"])) . "</strong>, não é permitido lançar custos com manutenção antes da entrada do veículo no estoque.";

            $retorno['erro'] = "Verifique os avisos de erro e tente novamente";
            $retorno['erros_data'] = "A data informada é anterior a da aquisição do veículo. " . $msg;

            return $this->response->setJSON($retorno);
        }

        //Criando um novo objeto da entidade manutençao
        $manutencao = new \App\Entities\Manutencao($post);

        try {
            if ($this->manutencaoModel->protect(false)->save($manutencao)) {

                //captura o id do cliente que acabou de ser inserido no banco de dados
                //$retorno['id'] = $this->clienteModel->getInsertID();
                //$NovoCliente = $this->buscaClienteOu404($retorno['id']);
                session()->setFlashdata('sucesso', "Manutenção lançada");
                $retorno['redirect_url'] = base_url($url);

                return $this->response->setJSON($retorno);
            }
        } catch (Exception $e) {
            /*echo "exception <pre>";
            var_dump($e);
            die();*/
        }

        //se chegou até aqui, é porque tem erros de validação
        $retorno['erro'] = "Verifique os avisos de erro e tente novamente";
        $retorno['erros_model'] = $this->manutencaoModel->errors();

        return $this->response->setJSON($retorno);
    }

    private function EAnteriorACompraVeiculo($idEstoque, $dataManutencao)
    {
        $est = $this->getEstoqueById($idEstoque);

        $resultado = [
            'data_compra' => $est->data_compra,
            'dataInvalida' => ($dataManutencao < $est->data_compra)
        ];

        return $resultado;
    }

    private function getEstoqueById($id = null)
    {
        return  $this->estoqueModel->find($id);
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
            'veiculos' => $this->getEstoque(),
            'tipos' => $this->tiposManutencao()
        ];
        return view('manutencao/editar', $data);
    }

    public function getAll()
    {
        //garatindo que este método seja chamado apenas via ajax
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }
        $atributos = [
            'manutencao.id', 'manutencao.data_manu', 'manutencao.descricao',
            'estoque.versao', 'estoque.vendido', 'estoque.motor', 'estoque.cor',
            'veiculo_modelo.modelo', 'manutencao_tipo.tipo_manu'
        ];

        $manutencoes = $this->manutencaoModel->select($atributos)
            ->join('estoque', 'estoque.id = manutencao.idestoque')
            ->join('veiculo_modelo', 'veiculo_modelo.id = estoque.idveiculo')
            ->join('manutencao_tipo', 'manutencao_tipo.id = manutencao.idtipomanut')
            ->orderBy('manutencao.data_manu', 'desc')
            ->findAll();

        $data = [];

        foreach ($manutencoes as $manut) {
            $id = encrypt($manut->id);
            $data[] = [
                'data'    => date('d/m/Y', strtotime($manut->data_manu)),
                'veiculo' => $manut->modelo . ' ' . $manut->versao . ' ' . $manut->motor . ' ' . $manut->cor,
                'tipo'    => $manut->tipo_manu,
                'servico' => $manut->descricao,
                'acoes'   => '<a  href="' . base_url("manutencao/editar/$id") . '" title="Editar"><i class="fas fa-edit text-success"></i></a> &nbsp; 
                              <a  href="' . base_url("manutencao/deletar/$id") . '" title="Excluir"><i class="fas fa-trash-alt text-danger"></i></a>'
            ];
        }

        $retorno = [
            'data' => $data
        ];

        return $this->response->setJSON($retorno);
    }

    public function detalhar()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $id = $this->request->getGet("id");

        $id = decrypt($id);
        if (!$id) {
            return redirect()->to('estoque');
        }

        $veiculo = $this->estoqueModel
            ->select('modelo,versao,motor, ano')
            ->join("veiculo_modelo", "veiculo_modelo.id = estoque.idveiculo")
            ->find($id);

        $dados = $this->dadosParaLinhaTempo($id);
        $linha = $this->gerarLinhaDoTempo($dados);

        $retorno = [
            'nome' => $veiculo->modelo . ' ' . $veiculo->versao . ' ' . $veiculo->motor . ' ' . $veiculo->ano,
            'linha' => $linha
        ];

        return $this->response->setJSON($retorno);
    }

    private function dadosParaLinhaTempo(int $id)
    {
        $data = [];

        $estoque = $this->estoqueModel
            ->select('data_compra', 'obs')
            ->find($id);

        $data[] = [
            'compra' => [
                'data' => $estoque->data_compra,
                'obs' => $estoque->obs
            ]
        ];

        $manutencoes = $this->manutencaoModel
            ->join('manutencao_tipo', 'manutencao_tipo.id = manutencao.idtipomanut')
            ->where('idestoque', $id)
            ->orderBy('data_manu', 'desc')
            ->orderBy('tipo_manu', 'asc')
            ->findAll();

        foreach ($manutencoes as $manut) {
            $data[] = [
                'manut' => [
                    'data' => $manut->data_manu,
                    'desc' => $manut->descricao,
                    'tipo' => $manut->tipo_manu
                ]
            ];
        }

        //pegar informações sobre a venda neste ponto, futuramente



        return $data;
    }

    private function gerarLinhaDoTempo($dados)
    {
        setlocale(LC_TIME, 'pt_BR.utf-8');
        $linha = '<div class="timeline">';

        foreach ($dados as $dado) {
            if (isset($dado['venda'])) {
                //implementar parte da venda
            } else if (isset($dado['manut'])) {
                $linha .= '<div class="time-label">';
                $linha .= '<span class="bg-gray">' . strftime('%d %b %Y', strtotime($dado['manut']['data'])) . '</span>';
                $linha .= '</div>';
                $linha .= '<div>';

                if ($dado['manut']['tipo'] === 'Higienização') {
                    $linha .= '<i class="fas fa-shower bg-light-gray"></i>';
                } else if ($dado['manut']['tipo'] === 'Elétrica') {
                    $linha .= '<i class="fas fa-car-battery bg-light-gray"></i>';
                } else {
                    $linha .= '<i class="fas fa-tools bg-light-gray"></i>';
                }

                $linha .= ' <div class="timeline-item">';
                $linha .= ' <h3 class="timeline-header">Serviço de ' . $dado['manut']['tipo'] . '</h3>';
                $linha .= ' <div class="timeline-body">' . $dado['manut']['desc'] . '</div>';
                $linha .= ' </div></div>';
            } else if (isset($dado['compra'])) {
                $compra  = '<div class="time-label">';
                $compra .= '<span class="bg-primary">' . strftime('%d %b %Y', strtotime($dado['compra']['data'])) . '</span>';
                $compra .= '</div>';
                $compra .= '<div>';
                $compra .= '<i class="fas fa-cart-plus bg-blue"></i>';
                $compra .= ' <div class="timeline-item">';
                $compra .= ' <h3 class="timeline-header">Compra do veículo</h3>';
                $compra .= ' <div class="timeline-body">' . $dado['compra']['obs'] . '</div>';
                $compra .= ' </div></div>';
            }
        }
        if (isset($compra)) {
            $linha .= $compra;
        }
        $linha .= '<div><i class="fas fa-clock bg-gray"></i></div></div>';

        return $linha;
    }
}
