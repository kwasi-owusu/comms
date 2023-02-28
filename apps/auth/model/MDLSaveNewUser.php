<?php

require_once dirname(__DIR__) . '/interfaces/ISaveNewUserInterface.php';

class MDLSaveNewUser implements ISaveNewUserInterface{

    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO){

        $this->newPDO       = $newPDO;
        $this->thisPDO      = $thisPDO;
    }

    public function save_new_user(array $data, string $table_f) : object{

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $stmt = $this->thisPDO->prepare("INSERT INTO $table_f(first_name, middle_name, last_name, email, password, user_key, user_access_level, 
        user_status, entry_by)VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(array(
            $data['first_name'],
            $data['middle_name'],
            $data['last_name'],
            $data['email'],
            $data['password'],
            $data['user_key'],
            $data['user_access_level'],
            $data['user_status'],
            $data['entry_by']

        ));

        return $stmt;
    }
}