<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = '\Entities\UsuarioEntity';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome', 'telefone', 'email', 'ativo', 'aparece_listagens',
        'senha', 'foto'
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
        'nome' => 'required|min_length[5]|max_length[60]|is_unique[usuarios.nome,id,{$id}]',
        'email' => 'required|max_length[255]|is_unique[usuarios.email,id,{$id}]',
    ];

    protected $validationMessages   = [
        'nome' =>  [
            'required'   => 'O nome é obrigatório.',
            'min_length' => 'O nome precisa ter ao menos 05 caracteres.',
            'max_length' => 'O nome pode ter no máximo 60 caracteres.',
            'is_unique'  => 'Este nome já está sendo usado'
        ],
        'emailcli' => [
            'is_unique' => 'Este email já está sendo utilizado'
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
