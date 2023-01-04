<?php

class MDLModalSearchForAdmin{
    
    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO){

        $this->newPDO       = new ConnectDatabase();
        $this->thisPDO      = $this->newPDO->Connect();
    }

    public function search_bonds_for_facility_details(string $table_b, string $table_c, string $table_d, string $table_e, string $customer_id): object{

        $stmt = $this->thisPDO->prepare("SELECT $table_b.bonds_and_guarantee_id, $table_b.account_number, $table_b.brn, $table_b.customer_name, 
        $table_b.customer_id, $table_b.amount, $table_b.ccy, 'Bonds & Guarantee' AS facility_type,
        $table_e.* 
        
        FROM $table_b 

        INNER JOIN $table_e ON $table_b.brn = $table_e.branch_code
        WHERE $table_b.customer_id = :acn");
        $stmt->bindValue(':acn',$customer_id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }
    
    //select brand, name, "10" as age from cars...

    public function search_loans_for_facility_details(string $table_b, string $table_c, string $table_d, string $table_e, string $customer_id): object{

        $stmt = $this->thisPDO->prepare("SELECT $table_c.loan_id, $table_c.loan_account, $table_c.branch_code, $table_c.customer_name, $table_c.customer_id, 
        $table_c.disbursed_amount, $table_c.currency, 'Loans' AS facility_type, $table_e.*
        FROM $table_c 
        INNER JOIN $table_e ON $table_c.branch_code = $table_e.branch_code
        WHERE $table_c.customer_id = :acn");
        $stmt->bindValue(':acn',$customer_id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }

    public function search_overdraft_for_facility_details(string $table_b, string $table_c, string $table_d, string $table_e, string $customer_id): object{

        $stmt = $this->thisPDO->prepare("SELECT $table_d.overdraft_id, $table_d.account_number, 'None' AS branch_name, $table_d.customer_name, 
        $table_d.customer_id, $table_d.approved_facility, $table_d.account_currency, 'Overdraft' AS facility_type
        
        FROM $table_d 
        
        WHERE $table_d.customer_id = :acn");
        $stmt->bindValue(':acn',$customer_id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }
   
}
