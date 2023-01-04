<?php

class MDLCustomerExposer
{

    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO)
    {

        $this->newPDO       = new ConnectDatabase();
        $this->thisPDO      = $this->newPDO->Connect();
    }

    public function bonds_and_guarantee_records(string $table_a, string $table_b, string $table_c, string $table_d, string $table_e): array
    {
        $stmt = $this->thisPDO->prepare("SELECT DISTINCT(customer_id), bonds_and_guarantee_id, brn, customer_name, account_number, 
        ccy, SUM(amount) AS totalAmt,$table_e.* 
        FROM $table_b 
        INNER JOIN $table_e ON $table_b.brn = $table_e.branch_code
        GROUP BY ccy
        ");
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function loans_records(string $table_a, string $table_b, string $table_c, string $table_d, string $table_e): array
    {
        $stmt = $this->thisPDO->prepare("SELECT DISTINCT(customer_id), loan_id, $table_c.branch_code, customer_name, loan_account, 
        currency, SUM(disbursed_amount) AS totalAmt, $table_e.*  
        FROM $table_c 
        INNER JOIN $table_e ON $table_c.branch_code = $table_e.branch_code
        GROUP BY currency
        ");
        $stmt->execute();

        return $stmt->fetchAll();
    }


    public function overdraft_records(string $table_a, string $table_b, string $table_c, string $table_d, string $table_e): array
    {
        $stmt = $this->thisPDO->prepare("SELECT DISTINCT(customer_id), overdraft_id, customer_name, account_number, 
        account_currency, SUM(approved_facility) AS totalAmt
        FROM $table_d 
        GROUP BY account_currency
        ");
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function collateral_records(string $table_a, string $table_b, string $table_c, string $table_d, string $table_e): array
    {
        $stmt = $this->thisPDO->prepare("SELECT DISTINCT(liability_number), customer_name
        FROM $table_a
        ");
        $stmt->execute();

        return $stmt->fetchAll();
    }


    public function customer_exposure_analysis(string $table_a, string $table_b, string $table_c, string $table_d, string $table_e): array
    {
        $stmt = $this->thisPDO->prepare("SELECT $table_b.*, $table_c.*, $table_d.*,
        
        CASE WHEN $table_b.customer_id = NULL THEN 'No Bonds and Guarantees'
        WHEN $table_c.customer_id = NULL THEN 'No Loans Available'
        WHEN $table_d.customer_id = NULL THEN 'No Overdrafts Available'

        ELSE 'Unknown'

        END AS customerID
        
        FROM $table_b
        
        INNER JOIN $table_c ON $table_b.customer_id = $table_c.customer_id
        INNER JOIN $table_d ON $table_b.customer_id = $table_d.customer_id
        
        ");
        $stmt->execute();

        return $stmt->fetchAll();
    }


    public function customer_exposure_details(string $table_a, string $table_b, string $table_c, string $table_d, int $customer_id): array
    {
        $stmt = $this->thisPDO->prepare("SELECT $table_b.*, $table_c.*, $table_d.*,
        
        CASE WHEN $table_b.customer_id = NULL THEN 'No Bonds and Guarantees'
        WHEN $table_c.customer_id = NULL THEN 'No Loans Available'
        WHEN $table_d.customer_id = NULL THEN 'No Overdrafts Available'

        ELSE 'Unknown'

        END AS customerID

        FROM $table_b
        
        INNER JOIN $table_c ON $table_b.customer_id = $table_c.customer_id
        INNER JOIN $table_d ON $table_b.customer_id = $table_d.customer_id
        
        ");
        $stmt->execute();

        return $stmt->fetchAll();
    }


    public function getFacilityCollateral($table_a, $account_number): object
    {

        $stmt = $this->thisPDO->prepare("SELECT * FROM $table_a WHERE account_number = :acn");
        $stmt->bindValue(':acn', $account_number);
        $stmt->execute();

        return $stmt;
    }
}
