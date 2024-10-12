<?php

namespace App\Models;

use CodeIgniter\Model;

class EOQModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'eoq_analysis';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','name', 'annual_demand', 'purchasing_price', 'eoq_result', 'number_order', 'frequency_order', 'created'];

    public function __construct(){
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getItemList(){
        return $this->select('id, name, annual_demand, purchasing_price, eoq_result, number_order, frequency_order, created')->findAll();
    }

    public function getItemDetail($id)
    {
        return $this->select('id, name, annual_demand, purchasing_price')->where(['id' => $id])->first();
    }

    public function getParameter($category){ 
        $builder = $this->db->table('eoq_parameter');
        $builder->select('id, code, name, category, value, type');
        $builder->where('category', $category);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getParameterDetail($where){
        $builder = $this->db->table('eoq_parameter');
        $builder->select('id, code, name, category, value, type');
        $builder->where($where);
        $query = $builder->get();
        return $query->getRow();
    }

    public function getDefaultParameter($where = []){ 
        $builder = $this->db->table('eoq_default_parameter');
        $builder->select('id, code, name, category, value, type');
        if(!empty($where)) $builder->where($where);
        $query = $builder->get();
        return $query->getRow();
    }

    public function getDefaultParameterList($where = []){ 
        $builder = $this->db->table('eoq_default_parameter');
        $builder->select('id, code, name, category, value, type');
        if(!empty($where)) $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }


    public function insertItem($dataArray){
        $this->db->table($this->table)->insert($dataArray);
        return $this->db->insertID();
    }

    public function updateItem($dataArray, $where){
        $this->db->table($this->table)->where($where)->update($dataArray);
    }

    public function deleteItem($where){
        $this->db->table($this->table)->where($where)->delete();
    }

    public function insertParameter($dataArray){
        $this->db->table('eoq_parameter')->insert($dataArray);
    }

    public function updateParameter($dataArray, $where){
        $this->db->table('eoq_parameter')->where($where)->update($dataArray);
    }

    public function updateDefaultParameter($dataArray, $where){
        $this->db->table('eoq_default_parameter')->where($where)->update($dataArray);
    }

    public function deleteParameter($where){
        $this->db->table('eoq_parameter')->where($where)->delete();
    }

    public function deleteDefaultParameter($where){
        $this->db->table('eoq_default_parameter')->where($where)->delete();
    }

}