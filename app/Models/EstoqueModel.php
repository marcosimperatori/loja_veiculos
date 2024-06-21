<?php

namespace App\Models;

use CodeIgniter\Model;

class EstoqueModel extends Model
{
    protected $table            = 'estoque';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = '\App\Entities\Estoque';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'iduser', 'idcliente', 'idveiculo', 'data_compra', 'preco_compra',
        'vendido', 'reservado', 'obs', 'ano', 'portas', 'motor', 'versao', 'disponivel',
        'cor', 'tipo', 'combustivel', 'direcao', 'ar', 'vidro', 'alarme'
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
        'data_compra' => 'required',
        'preco_compra' => 'required',
    ];

    protected $validationMessages   = [
        'data_compra' =>  [
            'required'   => 'A data da compra é obrigatória.'
        ],
        'preco_compra' =>  [
            'required'   => 'O preço é obrigatório.'
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
