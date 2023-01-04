<?php

class MDLGetCollateralByBranch
{

    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO)
    {

        $this->newPDO       = new ConnectDatabase();
        $this->thisPDO      = $this->newPDO->Connect();
    }

    public function getBranches(string $table_a, string $table_e, $branch_code, $classification): object
    {

        $stmt = $this->thisPDO->prepare("SELECT COUNT(collateral_id) AS totalCount, classification, branch_code, 
        
        SUM(collateral_value) AS sumValue, collateral_currency, collateral_category
        
        FROM $table_a 
        
        WHERE classification = :cls 
        AND branch_code = :bcd
        GROUP BY collateral_currency, collateral_category
        ");
        $stmt->bindValue(':cls', $classification, PDO::PARAM_STR);
        $stmt->bindValue(':bcd', $branch_code, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }
}
