<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'idUsuario';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['Nombre', 'Password','Email','Telefono', 'idRoles_fk','create_at', 'update_at'];

    protected bool $allowEmptyInserts = false;

    // Fechas
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validaciones
    protected $validationRules      = [];
    protected $validationMessages   = [];
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

    // Método para obtener usuario con su rol
    public function getUserWithRole($email)
    {
        return $this->select('usuarios.*, roles.Rol')  // Selecciona los campos de usuario y rol
                    ->join('roles', 'roles.idRoles = usuarios.idRoles_fk')  // Realiza el JOIN con roles
                    ->where('Email', $email)
                    ->first();  // Devuelve el primer resultado
    }
}
