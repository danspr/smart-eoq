<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Models\EOQModel;

class EOQ extends \App\Controllers\BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->auth = new Auth;
        $this->auth->isSessionExist();
        $this->userModel = new UserModel;
        $this->eoqModel = new EOQModel;
    }

    public function getEOQList(){
        try {
            $eoqList = $this->eoqModel->getItemList();
            $response = [
                'status' => 'success',
                'data' => $eoqList
            ];
            return $this->respond($response);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function getEOQItemDetail(){
        try {
            $data = $this->request->getGet();
            $eoqItem = $this->eoqModel->getItemDetail($data['id']);
            if(!$eoqItem){
                return $this->fail(getString('error.item_not_found'));
            }
            $response = [
                'status' => 'success',
                'data' => $eoqItem
            ];
            return $this->respond($response);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function getDetailAnalysis(){
        try {
            if(!$this->validate($this->detailAnalysisValidation())){
                return $this->fail($this->validator->getErrors());
            }

            $data = $this->request->getGet();
            $detailItem = $this->eoqModel->getItemDetail($data['id']);
            if(!$detailItem){
                return $this->fail(getString('error.item_not_found'));
            }

            $detailItem['total'] = (int) $detailItem['annual_demand'] * (int) $detailItem['purchasing_price'];

            // ### Holding Cost ###
            $holdingCostParameter = $this->eoqModel->getParameter('HC');
            $hcParamTotalPercentage = 0;
            $hcParamTotalCost = 0;
            foreach($holdingCostParameter as $item){
                $param = [
                    'name' => $item->name,
                    'percentage' => strval($item->value) . '%',
                    'cost' => ($item->type == 'Percent') ? $detailItem['purchasing_price'] * ($item->value / 100) : 0
                ];
                $detailItem['holding_cost']['parameters'][] = $param;
                $hcParamTotalPercentage += $item->value;
                $hcParamTotalCost += $param['cost'];
            }
            $detailItem['holding_cost']['total_percentage'] = strval($hcParamTotalPercentage) . '%';
            $detailItem['holding_cost']['total_cost'] = $hcParamTotalCost;
           
            // ### Transaction Cost ###
            $averageHourlySalary = $this->eoqModel->getDefaultParameter(['code' => 'average_hourly_salary']);
            $transactionCostParameter = $this->eoqModel->getParameter('TC');
            $detailItem['transaction_cost']['parameters'][] = [
                'name' => $averageHourlySalary->name,
                'hour' => 1,
                'cost' => $averageHourlySalary->value * 1
            ];
            $tcParamTotalHour = 0;
            $tcParamTotalCost = 0;
            foreach($transactionCostParameter as $item){
                $param = [
                    'name' => $item->name,
                    'hour' => (float) $item->value,
                    'cost' => ($item->type == 'Ammount') ? $averageHourlySalary->value * (float) $item->value : 0
                ];
                $detailItem['transaction_cost']['parameters'][] = $param;
                $tcParamTotalHour += (float) $item->value;
                $tcParamTotalCost += $param['cost'];
            }

            $detailItem['transaction_cost']['total_hour'] = round($tcParamTotalHour, 2);
            $detailItem['transaction_cost']['total_cost'] = $tcParamTotalCost;

            $eoqResult = round(sqrt((2 * (int) $detailItem['annual_demand'] * $detailItem['transaction_cost']['total_cost']) / $detailItem['holding_cost']['total_cost']));
            $detailItem['eoq_analysis'] = [
                'eoq_result' => $eoqResult,
                'number_order' => round($detailItem['annual_demand'] / $eoqResult),
                'frequency_order' => round(365 / ($detailItem['annual_demand'] / $eoqResult)),
            ];

            $response = [
                'status' => 'success',
                'data' => $detailItem
            ];
            return $this->respond($response);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function updateDetailAnalysis(){
        try {
            if(!$this->validate($this->eoqResultValidation())){
                return $this->fail($this->validator->getErrors());
            }

            $data = $this->request->getPost();
            $dataArray = [
                'eoq_result' => $data['eoq_result'],
                'number_order' => $data['number_order'],
                'frequency_order' => $data['frequency_order'],
            ];

            $this->eoqModel->updateItem($dataArray, ['id' => $data['id']]);
            $response = [
                'status' => 'success',
                'message' => getString('success.update'),
                'data' => $data
            ];
            return $this->respond($response);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function updateEOQItem(){
        try {
            if(!$this->validate($this->eoqUpdateAnalysisValidation())){
                return $this->fail($this->validator->getErrors());
            }   

            $data = $this->request->getPost();
            $updateData = [
                'name' => $data['name'],
                'annual_demand' => $data['annual_demand'],
                'purchasing_price' => $data['purchasing_price'],
                'eoq_result' => 0,
                'number_order' => 0,
                'frequency_order' => 0,
            ];

            $this->eoqModel->updateItem($updateData, ['id' => $data['id']]);
            $response = [
                'status' => 'success',
                'message' => getString('success.update'),
            ];
            return $this->respond($response);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function insertNewAnalysis(){
        try {
            if(!$this->validate($this->eoqNewAnalysisValidation())){
                return $this->fail($this->validator->getErrors());
            }

            $data = $this->request->getPost();
            $dataArray = [
                'name' => $data['name'],
                'annual_demand' => $data['annual_demand'],
                'purchasing_price' => $data['purchasing_price'],
            ];

            $itemId = $this->eoqModel->insertItem($dataArray);
            $itemDetail = $this->eoqModel->getItemDetail($itemId);
            $response = [
                'status' => 'success',
                'message' => getString('success.insert'),
                'data' => $itemDetail
            ];
            return $this->respond($response);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function deleteAnalysis(){
        try {
            if(!$this->validate($this->detailAnalysisValidation())){
                return $this->fail($this->validator->getErrors());
            }            

            $data = $this->request->getPost();
            $this->eoqModel->deleteItem(['id' => $data['id']]);
            $response = [
                'status' => 'success',
                'message' => getString('success.delete')
            ];
            return $this->respond($response);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function getParameterList(){
        try {
            $params = ['category'];
            if(!$this->validate($this->eoqParameterValidation($params))){
                return $this->fail($this->validator->getErrors());
            }

            $data = $this->request->getGet();
            if($data['category'] == 'default'){
                $parameterList = $this->eoqModel->getDefaultParameterList();
            } else {
                $parameterList = $this->eoqModel->getParameter($data['category']);
            }
            
            $response = [
                'status' => 'success',
                'data' => $parameterList
            ];
            return $this->respond($response);            
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function getParameterDetail(){
        try {
            $params = ['id', 'category'];
            if(!$this->validate($this->eoqParameterValidation($params))){
                return $this->fail($this->validator->getErrors());
            }

            $data = $this->request->getGet();
            if($data['category'] == 'default'){
                $parameterDetail = $this->eoqModel->getDefaultParameter(['id' => $data['id']]);
            } else {
                $parameterDetail = $this->eoqModel->getParameterDetail(['category' => $data['category'], 'id' => $data['id']]);
            }

            if(empty($parameterDetail)){
                return $this->failNotFound('Data is not found');
            }
           
            $response = [
                'status' => 'success',
                'data' => $parameterDetail
            ];
            return $this->respond($response);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function insertNewParameter(){
        try {
            $params = ['name', 'value', 'category'];
            if(!$this->validate($this->eoqParameterValidation($params))){
                return $this->fail($this->validator->getErrors());
            }

            $data = $this->request->getPost();
            $dataArray = [
                'name' => $data['name'],
                'category' => $data['category'],
                'value' => $data['value'],
                'type' => ($data['category'] == 'hc') ? 'Percent' : 'Ammount',
            ];

            $this->eoqModel->insertParameter($dataArray);
            $response = [
                'status' => 'success',
                'message' => getString('success.insert')
            ];
            return $this->respond($response);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
    
    public function updateParameter(){
        try {
            $params = ['id', 'name', 'value'];
            if(!$this->validate($this->eoqParameterValidation($params))){
                return $this->fail($this->validator->getErrors());
            }

            $data = $this->request->getPost();
            $updateData = [
                'name' => $data['name'],
                'value' => $data['value'],
            ];
            $this->eoqModel->updateParameter($updateData, ['id' => $data['id']]);
            $response = [
                'status' => 'success',
                'message' => getString('success.update')
            ];
            return $this->respond($response);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function updateDefaultParameter(){
        try {
            $params = ['id', 'value'];
            if(!$this->validate($this->eoqParameterValidation($params))){
                return $this->fail($this->validator->getErrors());
            }

            $data = $this->request->getPost();
            $updateData = [
                'value' => $data['value'],
            ];
            $this->eoqModel->updateDefaultParameter($updateData, ['id' => $data['id']]);
            $response = [
                'status' => 'success',
                'message' => getString('success.update')
            ];
            return $this->respond($response);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function deleteParameter(){
        try {
            $params = ['id'];
            if(!$this->validate($this->eoqParameterValidation($params))){
                return $this->fail($this->validator->getErrors());
            }

            $data = $this->request->getPost();
            $this->eoqModel->deleteParameter(['id' => $data['id']]);
            $response = [
                'status' => 'success',
                'message' => getString('success.delete')
            ];
            return $this->respond($response);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function deleteDefaultParameter(){
        try {
            $params = ['id'];
            if(!$this->validate($this->eoqParameterValidation($params))){
                return $this->fail($this->validator->getErrors());
            }

            $data = $this->request->getPost();
            $this->eoqModel->deleteDefaultParameter(['id' => $data['id']]);
            $response = [
                'status' => 'success',
                'message' => getString('success.delete')
            ];
            return $this->respond($response);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    private function eoqParameterValidation($params = []){
        $rules = [
            'id'=> [
                'rules' => 'required',
                'errors' => [
                    'required' => 'ID is required',
                ]
            ],
            'name'=> [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Name is required',
                ]
            ],
            'category'=> [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Category is required',
                ]
            ],
            'value'=> [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Value is required',
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

    private function eoqNewAnalysisValidation(){
        $rules = [
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Name is required',
                ]
            ],
            'annual_demand' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Annual Demand is required',
                ]
            ],
            'purchasing_price' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Purchasing Price is required',
                ]
            ]
        ];
        return $rules;
    }

    private function eoqUpdateAnalysisValidation(){
        $rules = [
            'id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'ID is required',
                ]
            ],
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Name is required',
                ]
            ],
            'annual_demand' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Annual Demand is required',
                ]
            ],
            'purchasing_price' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Purchasing Price is required',
                ]
            ]
        ];
        return $rules;
    }


    private function eoqResultValidation(){
        $rules = [
            'id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Item ID is required',
                ]
            ],
            'eoq_result' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'EOQ Result is required',
                ]
            ],
            'number_order' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Number of Order is required',
                ]
            ],
            'frequency_order' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Frequency Order is required',
                ]
            ],
        ];
        return $rules;
    }


    private function detailAnalysisValidation(){
        $rules = [
            'id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Item ID is required',
                ]
            ],
        ];
        return $rules;
    }

    
}