<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeloModel extends Model
{
    protected $table            = 'veiculo_modelo';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = '\App\Entities\Veiculo';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idtipo', 'idfabricante', 'modelo', 'potencia', 'combustivel',
        'portas', 'extras', 'ativo'
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
        'modelo' => 'required|min_length[3]|max_length[100]|is_unique[veiculo_modelo.modelo,id,{$id}]'
    ];

    protected $validationMessages   = [
        'modelo' =>  [
            'required'   => 'O modelo é obrigatória.',
            'min_length' => 'O modelo precisa ter ao menos 03 caracteres.',
            'max_length' => 'O modelo pode ter no máximo 100 caracteres.',
            'is_unique'  => 'Este modelo já foi cadastrado'
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
