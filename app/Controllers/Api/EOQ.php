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