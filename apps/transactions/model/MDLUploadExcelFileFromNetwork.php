<?php

require_once dirname(__DIR__, 2) . '/template/statics/assets/vendor/autoload.php';

require_once dirname(__DIR__) . '/controller/ISecureExcelUploadInterface.php';

class MDLUploadExcelFileFromNetwork implements ISecureExcelUploadInterface
{

    public function uploadCollateralFileMDL(array $dta, string $table_a, string $table_b, string $table_c, string $table_d)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $Reader     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadSheet        = $Reader->load($dta['excelFile']);


        $collateral_register                = $spreadSheet->getSheetByName('Collaterals');
        $collateral_sheetToArray            = $collateral_register->toArray();
       
        $truncate_table_a = $thisPDO->prepare("TRUNCATE TABLE $table_a");
        $truncate_table_a->execute();



        $collateral_query = "INSERT INTO $table_a (
        collateral_code, account_number, branch_code, branch_name, liability_number, collateral_category, 
        lendable_margin, charge_type, seniority_of_claim, customer_name, collateral_type,
        collateral_value, limit_contribution, collateral_haircut, collateral_status, facility_disbursement_date, 
        facility_expiry_date, interest_rate, facility_disbursement_amt, book_balance, facility_type, classification, insurance_name, 
        insurance_no, insurance_owner, insurance_type, collateral_description, collateral_currency, start_date, end_date, revision_date, 
        revaluation_date, agency_code, agency_name, valuation_amount, valuation_date, initial_valuation, credit_remarks) 
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $a = 0;

        foreach ($collateral_register->getRowIterator() as  $row) {
            // (C1) FETCH DATA FROM WORKSHEET
            $cellIterator_a = $row->getCellIterator();
            $cellIterator_a->setIterateOnlyExistingCells(false);

            $data = [];
            foreach ($cellIterator_a as $cell) {
                if (
                    $cell->getValue() != "Collateral Code" && $cell->getValue() != "Account Number" && $cell->getValue() != "Branch Code" 
                    && $cell->getValue() != "Branch Name" && $cell->getValue() != "Liability No"
                    && $cell->getValue() != "Collateral Category" && $cell->getValue() != "Lendable Margin" && $cell->getValue() != "Charge Type"
                    && $cell->getValue() != "Seniority Of Claim" && $cell->getValue() != "Customer Name" &&  $cell->getValue() != "Collateral Type" 
                    && $cell->getValue() != "Collateral Value" && $cell->getValue() != "Limit Contribution"
                    && $cell->getValue() != "Collateral Haircut" && $cell->getValue() != "Status" && $cell->getValue() != "Facility Disbursement Date" 
                    && $cell->getValue() != "Facility Expiry Date" && $cell->getValue() != "Interest Rate"
                    && $cell->getValue() != "Facility Disbursement Amt" && $cell->getValue() != "Book Balance" && $cell->getValue() != "Facility Type"
                    && $cell->getValue() != "Classification" && $cell->getValue() != "Insurance Name" && $cell->getValue() != "Insurance No" 
                    && $cell->getValue() != "Insurance Owner" && $cell->getValue() != "Insurance Type" && $cell->getValue() != "Collateral Description"
                    && $cell->getValue() != "Collateral Currency" && $cell->getValue() != "Start Date" && $cell->getValue() != "End Date"
                    && $cell->getValue() != "Revision Date" && $cell->getValue() != "Revaluation Date" && $cell->getValue() != "Agency Code" 
                    && $cell->getValue() != "Agency Name" && $cell->getValue() != "Valuation Amount" && $cell->getValue() != "Valuation Date"
                    && $cell->getValue() != "Initial Valuation" && $cell->getValue() != "Credit Remarks"
                ) {
                    $data[] = $cell->getValue();
                }
            }
            try {
                if ($a != 0) {
                    $stmt = $thisPDO->prepare($collateral_query);
                    $stmt->execute($data);
                }

                $a++;
            } catch (Exception $ex) {
                echo "$table_a ". $ex->getMessage() . "<br>";
            }
            $stmt = null;
        }

        return $stmt;
    }

    public function upload_bonds_and_guaranteeFileMDL(array $dta, string $table_a, string $table_b, string $table_c, string $table_d) 
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $Reader     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadSheet        = $Reader->load($dta['excelFile']);
       
        $bonds_and_guarantee                = $spreadSheet->getSheetByName('Bonds and Guarantees');
        $bonds_sheetToArray                 = $bonds_and_guarantee->toArray();
       

        $truncate_table_b = $thisPDO->prepare("TRUNCATE TABLE $table_b");
        $truncate_table_b->execute();



        $bonds_and_guarantee_query = "INSERT INTO $table_b (sn, brn, customer_name, account_number, customer_id, collateral_type, 
            collateral_description, collateral_amt, gtee_type, cof_ref_no, beneficiary, ccy, amount, amount_in_gh, eff_date, expiry_date, 
            proc_fee, fac_fee, comm_rate, total_comm_amt, col_prd
            ) 
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $b = 0;

        foreach ($bonds_and_guarantee->getRowIterator() as  $row) {
            // (C1) FETCH DATA FROM WORKSHEET
            $cellIterator_b = $row->getCellIterator();
            $cellIterator_b->setIterateOnlyExistingCells(false);

            $data_b = [];
            foreach ($cellIterator_b as $cell_b) {
                if (
                    $cell_b->getValue() != "SN" && $cell_b->getValue() != "BRN" && $cell_b->getValue() != "APPLICANT NAME" && $cell_b->getValue() != "A/C NO."
                    && $cell_b->getValue() != "CUST ID." && $cell_b->getValue() != "COLL TYPE" && $cell_b->getValue() != "COLL_DESC" 
                    && $cell_b->getValue() != "COLL AMT" && $cell_b->getValue() != "GTEE TYPE" && $cell_b->getValue() != "CONT REF NO"
                    && $cell_b->getValue() != "BENEFICIARY" &&  $cell_b->getValue() != "CCY" && $cell_b->getValue() != "AMOUNT"
                    && $cell_b->getValue() != "AMT (GHS)" && $cell_b->getValue() != "EFF DATE" && $cell_b->getValue() != "EXPIRY DATE" 
                    && $cell_b->getValue() != "PROC FEE" && $cell_b->getValue() != "FAC FEE" && $cell_b->getValue() != "COMM RATE"
                    && $cell_b->getValue() != "TOTAL COMM AMT" && $cell_b->getValue() != "COL. PRD"
                ) {
                    $data_b[] = $cell_b->getValue();
                }
            }
            try {
                if ($b != 0) {
                    $stmt = $thisPDO->prepare($bonds_and_guarantee_query);
                    $stmt->execute($data_b);
                }

                $b++;
            } catch (Exception $ex) {
                echo "$table_b " .$ex->getMessage() . "<br>";
            }
            $stmt = null;
        }
        return $stmt;
    }

    public function upload_loans_FileMDL(array $dta, string $table_a, string $table_b, string $table_c, string $table_d)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $Reader     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadSheet        = $Reader->load($dta['excelFile']);
        

        $loans                              = $spreadSheet->getSheetByName('Loans');
        $loand_sheetToArray                 = $loans->toArray();

        $truncate_table_c = $thisPDO->prepare("TRUNCATE TABLE $table_c");
        $truncate_table_c->execute();


        $loans_query = "INSERT INTO $table_c (
        branch_code, product_code, product_description, customer_id, loan_account, alt_account_number, funding_account, customer_name, 
        currency, sanction_amount, disbursed_amount, installment_amount, account_opening_date, maturity_date, classification, interest_rate, 
        total_outstanding_principal, pricipal_overdue, pricipal_not_due, principal_due, mint_overdue, mint_due, total_penal_overdue, total_penal_due, 
        book_balance, branch_description, last_sched_paid, days_in_arears, status_change_mode, ghana_card_tin) 
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $c = 0;

        foreach ($loans->getRowIterator() as  $row) {
            // (C1) FETCH DATA FROM WORKSHEET
            $cellIterator_c = $row->getCellIterator();
            $cellIterator_c->setIterateOnlyExistingCells(false);

            $data_c = [];
            foreach ($cellIterator_c as $cell_c) {
                if (
                    $cell_c->getValue() != 'BRANCH' && $cell_c->getValue() != 'PRODUCT' && $cell_c->getValue() != 'PROD_DESC' 
                    && $cell_c->getValue() != 'CUSTOMER_ID' && $cell_c->getValue() != 'LOAN_AC' && $cell_c->getValue() != 'ALT_ACC_NO' 
                    && $cell_c->getValue() != 'FUNDING_AC' && $cell_c->getValue() != 'CUST_NAME' && $cell_c->getValue() != 'CURRENCY' 
                    && $cell_c->getValue() != 'SANCTION_AMT' &&  $cell_c->getValue() != 'DISBURSED_AMT' && $cell_c->getValue() != 'INSTMNT_AMOUNT' 
                    && $cell_c->getValue() != 'AC_OPEN_DT' && $cell_c->getValue() != 'MATURITY_DT' && $cell_c->getValue() != 'CLASSIFICATION' 
                    && $cell_c->getValue() != 'INT_RATE' && $cell_c->getValue() != 'TOTAL_OUTSTANDING_PRIN' && $cell_c->getValue() != 'PRIN_OVERDUE' 
                    && $cell_c->getValue() != 'PRIN_NOT_DUE' && $cell_c->getValue() != 'PRIN_DUE' && $cell_c->getValue() != 'MINT_OVERDUE' 
                    && $cell_c->getValue() != 'MINT_DUE' && $cell_c->getValue() != 'TOT_PENAL_OVERDUE' && $cell_c->getValue() != 'TOT_PENAL_DUE' 
                    && $cell_c->getValue() != 'BOOK_BAL' && $cell_c->getValue() != 'BRANCH_DESC' && $cell_c->getValue() != 'LAST_SCH_PAID' 
                    && $cell_c->getValue() != 'DAYS_IN_AREARS' && $cell_c->getValue() != 'STATUS_CHANGE_MODE' && $cell_c->getValue() != 'GHANACARD_TIN'
                ) {
                    $data_c[] = $cell_c->getValue();
                }
            }
            try {
                if ($c != 0) {
                    $stmt = $thisPDO->prepare($loans_query);
                    $stmt->execute($data_c);
                }

                $c++;
            } catch (Exception $ex) {
                echo "$table_c " .$ex->getMessage() . "<br>";
            }
            $stmt = null;
        }

        return $stmt;
    }


    public function upload_overdraft_FileMDL(array $dta, string $table_a, string $table_b, string $table_c, string $table_d)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $Reader     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadSheet        = $Reader->load($dta['excelFile']);

       
        $overdraft_register                 = $spreadSheet->getSheetByName('Overdrafts');
        $overdraft_sheetToArray             = $overdraft_register->toArray();


        $truncate_table_d = $thisPDO->prepare("TRUNCATE TABLE  $table_d");
        $truncate_table_d->execute();

        
        $overdraft_query = "INSERT INTO $table_d (account_number, customer_name, customer_id, customer_type, record_stat, auth_stat, tod_limit, 
        overdraft_eff_rate, customer_category, account_currency, available_balance, curr_bal, codde, line_start_date, line_expiry_date, approved_facility, 
        advice_unadvice, facilities, interest_amount, principal_amt, provision_amt, provision_rate, account_status, overdraft_since, od_date, 
        od_breach_days, od_breach_date, od_prod, breach_status, breach_date, breach_days, mat_breach_days, amount_at_breach, select_fn_get_txn_desc, 
        ghana_card_tin) 
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $d = 0;

        foreach ($overdraft_register->getRowIterator() as  $row) {
            // (C1) FETCH DATA FROM WORKSHEET
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $data_d = [];
            foreach ($cellIterator as $cell) {
                if (
                    $cell->getValue() != 'ACCOUNT_NUMBER' && $cell->getValue() != 'ACCOUNT_DESCRIPTION' && $cell->getValue() != 'CUSTOMER_NUMBER' 
                    && $cell->getValue() != 'CUSTOMER_TYPE' && $cell->getValue() != 'RECORD_STAT' && $cell->getValue() != 'AUTH_STAT' 
                    && $cell->getValue() != 'TOD_LIMIT' && $cell->getValue() != 'OVERDRAFT_EFF_RATE' && $cell->getValue() != 'CUSTOMER_CATEGORY' 
                    && $cell->getValue() != 'ACCOUNT_CURRENCY' &&  $cell->getValue() != 'AVAILABLE_BAL' && $cell->getValue() != 'CURR_BAL' 
                    && $cell->getValue() != 'CODDE' && $cell->getValue() != 'LINE_START_DT' && $cell->getValue() != 'APPROVED_FACILITY' 
                    && $cell->getValue() != 'ADVICE_UNADVICE' && $cell->getValue() != 'FACILITIES' && $cell->getValue() != 'LINE_EXPIRY_DT' 
                    && $cell->getValue() != 'PROVISION_AMT' && $cell->getValue() != 'INTEREST_AMT' && $cell->getValue() != 'PRINCIPAL_AMT' 
                    && $cell->getValue() != 'PROVISION_RATE' && $cell->getValue() != 'ACCOUNT_STATUS' && $cell->getValue() != 'OVERDRAFT_SINCE' 
                    && $cell->getValue() != 'OD_DATE' && $cell->getValue() != 'OD_BREACH_DAYS' && $cell->getValue() != 'OD_BREACH_DATE' 
                    && $cell->getValue() != 'OD_PROD' && $cell->getValue() != 'BREACH_STATUS' && $cell->getValue() != 'BREACH_DATE' 
                    && $cell->getValue() != 'BREACH_DAYS' && $cell->getValue() != 'MAT_BREACH_DAYS' && $cell->getValue() != 'AMT_AT_BREACH' 
                    && $cell->getValue() != '(SELECTFN_GET_TXN_DESC(A.TRN_REF_NO,A.MODULE,A.TRN_CODE,A.EVENT_SR_NO,A.AMOUNT_TAG,A.CUST_GL)DESCRTNFROMACVW_ALL_AC_ENTRIESAWHER' 
                    && $cell->getValue() != 'GHANACARD_TIN'
                ) {
                    $data_d[] = $cell->getValue();
                }
            }
            try {
                if ($d != 0) {
                    $stmt = $thisPDO->prepare($overdraft_query);
                    $stmt->execute($data_d);
                }

                $d++;
            } catch (Exception $ex) {
                echo "$table_d ". $ex->getMessage() . "<br>";
            }
            $stmt = null;
        }

        return $stmt;
    }
}
