<?php

class DisburseController extends BaseController {

    protected $model;

    protected $request;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Disburse;
        $this->validation = new DisburseValidation;
    }

    public function find($id)
    {
        $api = json_decode($this->getApi('disburse/' . $id), true);

        $disburse = $this->model->find($id);

        if($disburse['status'] != $api['status'] && $disburse['status'] != 'SUCCESS') {
            $this->model->update($id, $api);
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
        if($this->validation->runFails()) {
            echo json_encode([
                'error' => [
                    'code' => 'validation_error',
                    'message' => $this->validation->error()
                ]
            ]);   
            exit();
        }

        $this->model->store($result = $this->postApi('disburse', $this->validation->validated()));

        echo json_encode([
            'success' => [
                'code' => '200',
                'data' => $result
            ]
        ]);
    }
}