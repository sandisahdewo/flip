<?php

class DisburseController {

    protected $model;

    protected $validation;

    public function __construct()
    {
        $this->model = new Disburse;
        $this->validation = new DisburseValidation;
    }

    public function index()
    {
        echo json_encode([
            'success' => [
                'code' => 200,
                'message' => 'welcome'
            ]
        ]);
        exit();
    }

    public function find($id)
    {
        $api = json_decode(Api::get('disburse/' . $id), true);

        $disburse = $this->model->find($id);

        if($disburse['status'] != $api['status'] && $disburse['status'] != 'SUCCESS') {
            $updateData = [
                'status' => $api['status'],
                'receipt' => $api['receipt'],
                'time_served' => $api['time_served']
            ];
            $this->model->update($id, $updateData);
        } 

        echo json_encode([
            'success' => [
                'code' => '200',
                'data' => $disburse
            ]
        ]);
    }

    public function store()
    {
        Router::methodWant('POST');

        if($this->validation->runFails()) {
            echo json_encode([
                'error' => [
                    'code' => 'validation_error',
                    'message' => $this->validation->error()
                ]
            ]);   
            exit();
        }

        $this->model->store($result = Api::post('disburse', $this->validation->validated()));

        echo json_encode([
            'success' => [
                'code' => '200',
                'data' => $result
            ]
        ]);
        exit();
    }
}