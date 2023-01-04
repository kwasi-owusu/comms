<?php

class MDLGetBranchesForModal{

    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO)
    {

        $this->newPDO       = new ConnectDatabase();
        $this->thisPDO      = $this->newPDO->Connect();

    }

    public function getBranches(string $table_e): object{

        $stmt = $this->thisPDO->prepare("SELECT * FROM $table_e ORDER BY branch_name ASC
        ");
        $stmt->execute();

        return $stmt;
    }
}