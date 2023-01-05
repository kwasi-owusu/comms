<?php

require_once dirname(__DIR__) . '/controller/ICollateralAnalysis.php';

class MDLCustomerCollateralAnalysis implements ICollateralAnalysis{

    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO)
    {

        $this->newPDO       = $newPDO;
        $this->thisPDO      = $thisPDO;
    }
   

    public function collateral_by_currency(string $table_a, int $customer_id): object{

        $stmt = $this->thisPDO->prepare("SELECT COUNT(collateral_id) AS totalCollaterals, collateral_code, account_number, 
        liability_number, collateral_category, customer_name, SUM(collateral_value) AS sumCollateralValue, classification, collateral_currency
        FROM $table_a 
        WHERE liability_number = :cd
        GROUP BY collateral_currency
        ");

        $stmt->bindValue(':cd', $customer_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;

    }


    public function collateral_by_category(string $table_a, int $customer_id): object{

        $stmt = $this->thisPDO->prepare("SELECT COUNT(collateral_id) AS totalCollaterals, collateral_code, account_number, 
        liability_number, collateral_category, customer_name, SUM(collateral_value) AS sumCollateralValue, classification, collateral_currency
        FROM $table_a 
        WHERE liability_number = :cd
        GROUP BY collateral_category
        ");

        $stmt->bindValue(':cd', $customer_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;

    }


    public function collateral_by_type(string $table_a, int $customer_id): object{

        $stmt = $this->thisPDO->prepare("SELECT COUNT(collateral_id) AS totalCollaterals, collateral_code, account_number, collateral_type,
        liability_number, collateral_category, customer_name, SUM(collateral_value) AS sumCollateralValue, classification, collateral_currency
        FROM $table_a 
        WHERE liability_number = :cd
        GROUP BY collateral_type
        ");

        $stmt->bindValue(':cd', $customer_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;

    }

    
    public function collateral_by_classification(string $table_a, int $customer_id): object{

        $stmt = $this->thisPDO->prepare("SELECT COUNT(collateral_id) AS totalCollaterals, collateral_code, account_number, 
        liability_number, collateral_category, customer_name, SUM(collateral_value) AS sumCollateralValue, classification, collateral_currency
        FROM $table_a 
        WHERE liability_number = :cd
        GROUP BY classification
        ");

        $stmt->bindValue(':cd', $customer_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }


}