<?php

namespace App\Models;

use CodeIgniter\Model;

class GoodsModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'goods';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','name', 'qty', 'eoq_id', 'created', 'modified'];
    protected $eoqTable = 'eoq_analysis';

    public function getItemList(){
        $builder = $this->db->table('goods');
        $builder->select('goods.id, goods.name, goods.eoq_id, goods.qty, eoq_analysis.eoq_result, goods.modified');
        $builder->join('eoq_analysis', 'goods.eoq_id = eoq_analysis.id', 'LEFT');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getItemDetail($id){
        $builder = $this->db->table('goods');
        $builder->select('goods.id, goods.name, goods.eoq_id, goods.qty, eoq_analysis.eoq_result, goods.modified');
        $builder->join('eoq_analysis', 'goods.eoq_id = eoq_analysis.id', 'LEFT');
        $builder->where('goods.id', $id);
        $query = $builder->get();
        return $query->getRow();
    }

    public function insertItem($dataArray){
        $builder = $this->db->table('goods');
        $builder->insert($dataArray);
    }

    public function updateItem($dataArray, $whereArray){
        $builder = $this->db->table('goods');
        $builder->update($dataArray, $whereArray);
    }

    public function deleteItem($whereArray){
        $builder = $this->db->table('goods');
        $builder->delete($whereArray);
    }
}