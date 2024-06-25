<?php

namespace App\Models;

use CodeIgniter\Model;

class ManutencaoModel extends Model
{
    protected $table            = 'manutencao';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = '\App\Entities\Manutencao';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idestoque', 'data_manu', 'preco', 'descricao'
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'data_manu' => 'required',
        'preco' => 'required',
        'descricao' => 'required'
    ];

    protected $validationMessages   = [
        'data_manu' =>  [
            'required'   => 'A data é obrigatória.'
        ],
        'preco' =>  [
            'required'   => 'O preço é obrigatório.'
        ],
        'descricao' =>  [
            'required'   => 'Descrição é ogrigatória.'
        ]
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
