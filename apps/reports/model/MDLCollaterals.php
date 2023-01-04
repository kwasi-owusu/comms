<?php

class MDLCollaterals{

    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO){

        $this->newPDO       = new ConnectDatabase();
        $this->thisPDO      = $this->newPDO->Connect();
    }

    public function get_lists_of_collaterals(string $table_a): array
    {
        $stmt = $this->thisPDO->prepare("SELECT * FROM $table_a ORDER BY collateral_id ASC");
        $stmt->execute();

        return $stmt->fetchAll();
    }
   
}