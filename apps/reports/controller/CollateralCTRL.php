<?php

!isset($_SESSION) ? session_start() : null;

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
require_once dirname(__DIR__) . '/model/MDLCollaterals.php';


class CollateralCTRL {

    private string $table_a;
    private string $table_b;
    private string $table_c;
    private string $table_d;
    
    public function __construct($table_a, $table_b, $table_c, $table_d){

        $this->table_a = $table_a;
        $this->table_b = $table_b;
        $this->table_c = $table_c;
        $this->table_d = $table_d;
        
    }

    public function collateralCategory() {

    }

    public function collateralType(){

    }


    public function loanCurrency(){

    }

    public function loanClassification(){
        
    }

    public function facilityType(){
        
    }

    public function lists_of_collaterals(){
        
        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfMDLCollaterals = new MDLCollaterals($newPDO, $thisPDO);
        
        $get_collateral_list_rst = $instanceOfMDLCollaterals->get_lists_of_collaterals($this->table_a);

        return $get_collateral_list_rst;
    }
}