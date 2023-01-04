<?php

isset($_SESSION) ? session_start() : null;

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
require_once dirname(__DIR__) . '/model/MDLGetBranchesForModal.php';

class CTRLGetBranchesForModal{

    
    private string $table_e;


    public function __construct($table_e)
    {
        $this->table_e = $table_e;
    }

    public function get_branches_for_modal(){

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfMDLGetBranchesForModal = new MDLGetBranchesForModal($newPDO, $thisPDO);

        $rst = $instanceOfMDLGetBranchesForModal->getBranches($this->table_e);

        return $rst->fetchAll();
    }
}