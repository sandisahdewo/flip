<?php

class BaseValidation {

    use Rules;

    protected $rules = [];

    protected $passed = [];

    protected $failed = [];

    public function validate()
    {
        foreach($this->rules as $key => $rules) {
            $exploding = explode("|", $rules);
            foreach($exploding as $rule) {
                $this->{$rule}($key);
            }
        }
    }

    public function runFails()
    {
        $this->validate();
        return !empty($this->error());
    }

    public function validated()
    {
        return $this->passed;
    }

    public function error()
    {
        return $this->failed;
    }
}