<?php

class MDLCollateralStatusFilter
{

    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO)
    {

        $this->newPDO       = new ConnectDatabase();
        $this->thisPDO      = $this->newPDO->Connect();
    }

    public function search_collateral_lists(string $table_a, string $table_b, string $table_c, string $table_d, string $table_e, string $classification): object
    {

        $stmt = $this->thisPDO->prepare("SELECT $table_a.*,  $table_e.*
        
        FROM $table_a

        INNER JOIN $table_e ON $table_a.branch_code = $table_e.branch_code
        
        WHERE $table_a.classification = :cls
       
        ");
        $stmt->bindValue(':cls', $classification, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }

    public function search_collateral_group_by_branch(string $table_a, string $table_b, string $table_c, string $table_d, string $table_e, string $classification, $branch_code): object
    {

        $stmt = $this->thisPDO->prepare("SELECT COUNT($table_a.collateral_id) AS totalCollateral, SUM($table_a.collateral_value( AS sumCollateral, 
        $table_a.classification, $table_a.collateral_currency, $table_e.branch_code, $table_e.branch_name
        
        FROM $table_a

        INNER JOIN $table_e ON $table_a.branch_code = $table_e.branch_code
        WHERE $table_a.classification = :cls
        AND $table_e.branch_code = :branch_code
        GROUP BY $table_a.branch_code
        ");
        $stmt->bindValue(':cls', $classification, PDO::PARAM_STR);
        $stmt->bindValue(':branch_code', $branch_code, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }
}
