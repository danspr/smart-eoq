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

    public function getDefaultParameter($where){ 
        $builder = $this->db->table('eoq_default_parameter');
        $builder->select('id, code, name, category, value, type');
        $builder->where($where);
        $query = $builder->get();
        return $query->getRow();
    }

    public function updateItem($dataArray, $where){
        $this->db->table($this->table)->where($where)->update($dataArray);
    }

}