<?php

namespace App\Models;

use CodeIgniter\Model;

class FabricanteVeiculoModel extends Model
{
    protected $table            = 'fabricanteveiculos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = '\Entities\Fabricante';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['fabricante', 'ativo'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'fabricante' => 'required|min_length[3]|max_length[90]|is_unique[veiculo_fabricante.fabricante,id,{$id}]'
    ];

    protected $validationMessages   = [
        'nome' =>  [
            'required'   => 'O nome do fabricante é obrigatório.',
            'min_length' => 'O nome precisa ter ao menos 03 caracteres.',
            'max_length' => 'O nome pode ter no máximo 90 caracteres.',
            'is_unique'  => 'Esta descrição já está sendo usada'
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
