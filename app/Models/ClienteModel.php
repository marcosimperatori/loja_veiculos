<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table            = 'cliente';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = '\App\Entities\Cliente';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'ativo', 'cnpj_cpf', 'emailcli', 'nomecli', 'telefone', 'ultima_compra'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    // Validation
    protected $validationRules      = [
        'nomecli'      => 'required|min_length[3]|max_length[250]|is_unique[cliente.nomecli,id,{$id}]',
        'cnpj_cpf'       => 'exact_length[14,18]|is_unique[clientes.cnpj_cpf,id,{$id}]',
        'emailcli'      => 'permit_empty',
    ];

    protected $validationMessages   = [
        'nomecli' => [
            'required'   => 'A razão social é obrigatória.',
            'min_length' => 'A razão social precisa ter ao menos 03 caracteres.',
            'max_length' => 'A razão social pode ter no máximo 250 caracteres.',
            'is_unique'  => 'Este nome de cliente já foi cadastrado'
        ],
        'cnpj_cpf' => [
            'exact_length' => 'CNPJ deve ter 18 caracteres, CPF 14.',
            'is_unique'    => 'O CNPJ|CPF já está sendo usado'
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
