<?php

trait Rules {

    protected $post;

    public function __construct()
    {
        $this->post = $_POST;
    }

    public function numeric($field)
    {
        if(is_numeric($value = $this->getFromPostRequest($field))) {
            $this->passed[$field] = $value;
        } else {
            $this->pushFailedAttribute($field, 'must a numeric value');
        }
    }

    public function required($field)
    {
        if(!empty($value = $this->getFromPostRequest($field))) {
            $this->passed[$field] = $value;
        } else {
            $this->pushFailedAttribute($field, 'can not be empty');
        }
    }

    public function getFromPostRequest($field)
    {
        return trim($this->post[$field]);
    }

    public function pushFailedAttribute($field, $message)
    {
        if(array_search($field, array_column($this->failed, 'attribute')) === false) {
            $this->failed[] = [
                'attribute' => $field,
                'message' => $field . " " . $message
            ];
        }
    }
}