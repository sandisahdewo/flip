<?php

class DisburseValidation extends BaseValidation {

    protected $rules = [
        'bank_code' => 'required',
        'account_number' => 'required|numeric',
        'amount' => 'required|numeric',
        'remark' => 'required'
    ];
}