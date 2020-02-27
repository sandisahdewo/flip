<?php

class Disburse extends BaseModel {
    
    protected $table = 'disburses';

    public function store($data)
    {
        return $this->insert($data);
    }

    public function update($id, $data)
    {
        $exists = $this->find($id);
        if(! $exists) {
            echo json_encode([
                'error' => [
                    'code' => 404,
                    'message' => 'Resource not found'
                ]
            ]);
            exit();
        }
        
        return $this->updating($id, $data);
    }
}