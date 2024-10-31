<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use App\Models\GoodsModel;

class Goods extends \App\Controllers\BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->auth = new Auth;
        $this->auth->isSessionExist();
        $this->goodsModel = new GoodsModel;
    }

    public function getItemList(){
        try {
            $goods = $this->goodsModel->getItemList();
            $data = [];
            foreach($goods as $value){
                $result = (array) $value;
                $result['status'] = (intval($result['qty']) < intval($result['eoq_result'])) ? 'need_order' : 'fulfilled';
                $data[] = $result;
            }
            $response = [
                'status' => 'success',
                'data' => $data
            ];
            return $this->respond($response);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function getItemDetail(){
        try {
            $params = ['id'];
            if(!$this->validate($this->goodsValidation($params))){
                return $this->fail($this->validator->getErrors());
            }
            
            $data = $this->request->getGet();
            $goods = $this->goodsModel->getItemDetail($data['id']);
            if(!$goods){
                return $this->failNotFound('Item not found');
            }

            $response = [
                'status' => 'success',
                'data' => $goods
            ];
            return $this->respond($response);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function insertItem(){
        try {
            $params = ['name', 'eoq_id', 'qty'];
            if(!$this->validate($this->goodsValidation($params))){
                return $this->fail($this->validator->getErrors());
            }            

            $data = $this->request->getPost();
            $data = [
                'name' => $data['name'],
                'eoq_id' => $data['eoq_id'],
                'qty' => $data['qty']
            ];
            $this->goodsModel->insertItem($data);
            
            $response = [
                'status' => 'success',
                'message' => 'Item added successfully'
            ];
            return $this->respond($response);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function updateItem(){
        try {
            $params = ['id', 'name', 'eoq_id', 'qty'];
            if(!$this->validate($this->goodsValidation($params))){
                return $this->fail($this->validator->getErrors());
            }

            $data = $this->request->getPost();
            $updateData = [
                'name' => $data['name'],                
                'eoq_id' => $data['eoq_id'],
                'qty' => $data['qty']                
            ];
            $this->goodsModel->updateItem($updateData, ['id' => $data['id']]);
            $response = [
                'status' => 'success',
                'message' => 'Item updated successfully'
            ];            
            return $this->respond($response);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function deleteItem(){
        try {
            $params = ['id'];
            if(!$this->validate($this->goodsValidation($params))){
                return $this->fail($this->validator->getErrors());
            }
            
            $data = $this->request->getPost();
            $this->goodsModel->deleteItem(['id' => $data['id']]);
            $response = [
                'status' => 'success',
                'message' => 'Item deleted successfully'
            ];
            return $this->respond($response);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    private function goodsValidation($params){
        $rules = [
            'id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Id is required',
                ]
            ],
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Item name is required',
                ]
            ],
            'qty' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Quantity is required',
                ]
            ],
            'eoq_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'EOQ id is required',
                ]
            ],
        ];
        if(!empty($params)){
            $getRule = [];
            foreach($params as $value){
                $getRule[$value] = $rules[$value];
            }
            return $getRule;
        }
        return $rules;
    }
}