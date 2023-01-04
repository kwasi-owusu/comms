<?php

class MDLBranchWiseReport{

    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO)
    {

        $this->newPDO       = new ConnectDatabase();
        $this->thisPDO      = $this->newPDO->Connect();
    }

    public function bonds_and_guarantee_records_by_branch(string $table_a, string $table_b, string $table_c, string $table_d): array
    {
        $stmt = $this->thisPDO->prepare("SELECT DISTINCT(ccy), customer_id, bonds_and_guarantee_id, brn, customer_name, account_number, 
        SUM(amount) AS totalAmt 
        FROM $table_b GROUP BY brn
        ");
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function loans_records_by_branch(string $table_a, string $table_b, string $table_c, string $table_d): array
    {
        $stmt = $this->thisPDO->prepare("SELECT DISTINCT(currency), customer_id, loan_id, branch_code, customer_name, loan_account, 
        SUM(disbursed_amount) AS totalAmt 
        FROM $table_c GROUP BY branch_code
        ");
        $stmt->execute();

        return $stmt->fetchAll();
    }


    public function overdraft_records_by_branch(string $table_a, string $table_b, string $table_c, string $table_d): array
    {
        $stmt = $this->thisPDO->prepare("SELECT DISTINCT(customer_id), overdraft_id, customer_name, account_number, 
        account_currency, SUM(approved_facility) AS totalAmt 
        FROM $table_d GROUP BY account_currency
        ");
        $stmt->execute();

        return $stmt->fetchAll();
    }
}