<?php

class MDLFacilityFilter
{

    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO)
    {

        $this->newPDO       = new ConnectDatabase();
        $this->thisPDO      = $this->newPDO->Connect();
    }

    public function search_bonds_lists(string $table_b, string $table_c, string $table_d, string $table_e): object
    {

        $stmt = $this->thisPDO->prepare("SELECT $table_b.*,  $table_e.*
        
        FROM $table_b

        INNER JOIN $table_e ON $table_b.brn = $table_e.branch_code
              
        ");
        $stmt->execute();

        return $stmt;
    }

    public function search_loans_lists(string $table_b, string $table_c, string $table_d, string $table_e): object
    {

        $stmt = $this->thisPDO->prepare("SELECT $table_c.*,  $table_e.*
        
        FROM $table_c

        INNER JOIN $table_e ON $table_c.branch_code = $table_e.branch_code
              
        ");
        $stmt->execute();

        return $stmt;
    }

    public function search_overdraft_lists(string $table_b, string $table_c, string $table_d, string $table_e): object
    {

        $stmt = $this->thisPDO->prepare("SELECT $table_d.*
        
        FROM $table_d
              
        ");
        $stmt->execute();

        return $stmt;
    }
}


