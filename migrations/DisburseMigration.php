<?php

class DisburseMigration extends BaseMigration {

    public static function up()
    {
        self::create('disburses', [
            ['name' => 'id', 'type' => 'BIGINT', 'length' => 20],
            ['name' => 'amount', 'type' => 'BIGINT', 'length' => 20], 
            ['name' => 'status', 'type' => 'VARCHAR', 'length' => 16],
            ['name' => 'timestamp', 'type' => 'TIMESTAMP'],
            ['name' => 'bank_code', 'type' => 'VARCHAR', 'length' => 64],
            ['name' => 'account_number', 'type' => 'VARCHAR', 'length' => 64],
            ['name' => 'beneficiary_name', 'type' => 'VARCHAR', 'length' => 64],
            ['name' => 'remark', 'type' => 'VARCHAR', 'length' => 64],
            ['name' => 'receipt', 'type' => 'VARCHAR', 'length' => 255, 'null' => true],
            ['name' => 'time_served', 'type' => 'VARCHAR', 'length' => 32, 'null' => true], 
            ['name' => 'fee', 'type' => 'BIGINT', 'length' => 20]
        ]);
    }

    public static function down()
    {
        self::drop('disburses');
    }
}