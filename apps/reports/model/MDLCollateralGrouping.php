<?php
require_once dirname(__DIR__) . '/controller/ICollateralGrouping.php';

class MDLCollateralGrouping implements ICollateralGrouping
{

    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO)
    {

        $this->newPDO       = $newPDO;
        $this->thisPDO      = $thisPDO;
    }

    public function group_collateral_by_currency(string $table_a): object
    {
        $stmt = $this->thisPDO->prepare("SELECT COUNT(collateral_id) AS totalCollaterals, SUM(collateral_value) AS sumCollateralValue, classification,
        collateral_currency
        FROM $table_a 
        GROUP BY collateral_currency, classification
        ");
        
        $stmt->execute();

        return $stmt;
    }

    public function group_collateral_by_category(string $table_a): object{

        $stmt = $this->thisPDO->prepare("SELECT COUNT(collateral_id) AS totalCollaterals, collateral_category, customer_name, collateral_currency,
        SUM(collateral_value) AS sumCollateralValue
        FROM $table_a 
        GROUP BY collateral_category, collateral_currency
        ");
        
        $stmt->execute();

        return $stmt;

    }
    public function group_collateral_by_type(string $table_a): object{

        $stmt = $this->thisPDO->prepare("SELECT COUNT(collateral_id) AS totalCollaterals, collateral_type, collateral_currency, 
        SUM(collateral_value) AS sumCollateralValue
        FROM $table_a 
        GROUP BY collateral_type, collateral_currency
        ");
        
        $stmt->execute();

        return $stmt;

    }
    public function group_collateral_by_classification(string $table_a): object{

        $stmt = $this->thisPDO->prepare("SELECT COUNT(collateral_id) AS totalCollaterals, SUM(collateral_value) AS sumCollateralValue, collateral_currency,
        classification
        FROM $table_a 
        GROUP BY classification, collateral_currency
        ");
        
        $stmt->execute();

        return $stmt;
    }

   
}
