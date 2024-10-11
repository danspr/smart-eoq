<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','full_name', 'username', 'password', 'role', 'status'];

    public function getSessionUserInfo($id){
        return $this->select('id, full_name, username')->where(['id' => $id])->first();
    }

    public function getUserLogin($username){
        $userFilter = $this->getActiveUserFilter();
        $userFilter['username'] = $username;
        return $this->select('id, full_name, username, password')->where($userFilter)->first();
    }

    private function getActiveUserFilter(){
        $filter = [
            'status' => 1,
        ];
        return $filter;
    }

}