<?php

!isset($_SESSION) ? session_start() : null;

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
require_once dirname(__DIR__) . '/model/MDLCollateralGrouping.php';


class CollateralGroupingCTRL{

    private string $table_a;
    
    public function __construct($table_a){

        $this->table_a = $table_a;
    }

    public function collateral_grouping_by_currency(){

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfMDLCollateralGrouping = new MDLCollateralGrouping($newPDO, $thisPDO);
        
        $rsp = $instanceOfMDLCollateralGrouping->group_collateral_by_currency($this->table_a);
        
        return $rsp;
    }

    public function collateral_grouping_by_category(){

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfMDLCollateralGrouping = new MDLCollateralGrouping($newPDO, $thisPDO);
        
        $rsp = $instanceOfMDLCollateralGrouping->group_collateral_by_category($this->table_a);
      
        return $rsp;
    }

    public function collateral_grouping_by_type(){

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfMDLCollateralGrouping = new MDLCollateralGrouping($newPDO, $thisPDO);
        
        $rsp = $instanceOfMDLCollateralGrouping->group_collateral_by_type($this->table_a);
      
        return $rsp;
    }

    public function collateral_grouping_by_classification(){

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfMDLCollateralGrouping = new MDLCollateralGrouping($newPDO, $thisPDO);
        
        $rsp = $instanceOfMDLCollateralGrouping->group_collateral_by_classification($this->table_a);
      
        return $rsp;
    }
}
