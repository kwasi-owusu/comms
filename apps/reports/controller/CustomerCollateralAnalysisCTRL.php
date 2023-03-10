<?php

!isset($_SESSION) ? session_start() : null;

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
require_once dirname(__DIR__) . '/model/MDLCustomerCollateralAnalysis.php';


class CustomerCollateralAnalysisCTRL extends MDLCustomerCollateralAnalysis
{

    private string $table_a;



    public function __construct($table_a)
    {

        $this->table_a = $table_a;
    }


    public function customer_collateral_analysis($customer_id, $selection_by)
    {

        // $customer_id = isset($_REQUEST['customer_id']) ? strip_tags(trim($_POST['customer_id'])) : null;
        // $selection_by = isset($_REQUEST['group_by']) ? strip_tags(trim($_POST['group_by'])) : null;

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfMDLCustomerCollateralAnalysis = new MDLCustomerCollateralAnalysis($newPDO, $thisPDO);


        if ($selection_by == "currency") {
            $get_collateral_by_currency_method = $instanceOfMDLCustomerCollateralAnalysis->collateral_by_currency($this->table_a, $customer_id);

            $records_array = array();

            while ($row = $get_collateral_by_currency_method->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $collateral_grouped_by_currency = array(
                    'collateral_code' => $row['collateral_code'],
                    'account_number'    => $row['account_number'],
                    'totalCollaterals' => $row['totalCollaterals'],
                    'liability_number' => $row['liability_number'],
                    'collateral_category' => $row['collateral_category'],
                    'customer_name' => $row['customer_name'],
                    'sumCollateralValue' => $row['sumCollateralValue'],
                    'classification' => $row['classification'],
                    'collateral_currency' => $row['collateral_currency'],

                );

                array_push($records_array, $collateral_grouped_by_currency);
            }


        } else if ($selection_by == "category") {
            $get_collateral_by_category_method = $instanceOfMDLCustomerCollateralAnalysis->collateral_by_category($this->table_a, $customer_id);
            
            $records_array = array();

            while ($row = $get_collateral_by_category_method->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $collateral_grouped_by_category = array(
                    'collateral_code' => $row['collateral_code'],
                    'account_number'    => $row['account_number'],
                    'totalCollaterals' => $row['totalCollaterals'],
                    'liability_number' => $row['liability_number'],
                    'collateral_category' => $row['collateral_category'],
                    'customer_name' => $row['customer_name'],
                    'sumCollateralValue' => $row['sumCollateralValue'],
                    'classification' => $row['classification'],
                    'collateral_currency' => $row['collateral_currency'],

                );

                array_push($records_array, $collateral_grouped_by_category);
            }

        } else if ($selection_by == "type") {
            $get_collateral_by_type_method = $instanceOfMDLCustomerCollateralAnalysis->collateral_by_type($this->table_a, $customer_id);

            $records_array = array();

            while ($row = $get_collateral_by_type_method->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $collateral_grouped_by_type = array(
                    'collateral_code' => $row['collateral_code'],
                    'account_number'    => $row['account_number'],
                    'totalCollaterals' => $row['totalCollaterals'],
                    'liability_number' => $row['liability_number'],
                    'collateral_category' => $row['collateral_category'],
                    'customer_name' => $row['customer_name'],
                    'sumCollateralValue' => $row['sumCollateralValue'],
                    'classification' => $row['classification'],
                    'collateral_currency' => $row['collateral_currency'],
                    'collateral_type' => $row['collateral_type']

                );

                array_push($records_array, $collateral_grouped_by_type);
            }

            
        } else if ($selection_by == "classification") {
            $get_collateral_by_classification_method = $instanceOfMDLCustomerCollateralAnalysis->collateral_by_classification($this->table_a, $customer_id);

            $records_array = array();

            while ($row = $get_collateral_by_classification_method->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $collateral_grouped_by_classification = array(
                    'collateral_code' => $row['collateral_code'],
                    'account_number'    => $row['account_number'],
                    'totalCollaterals' => $row['totalCollaterals'],
                    'liability_number' => $row['liability_number'],
                    'collateral_category' => $row['collateral_category'],
                    'customer_name' => $row['customer_name'],
                    'sumCollateralValue' => $row['sumCollateralValue'],
                    'classification' => $row['classification'],
                    'collateral_currency' => $row['collateral_currency'],

                );

                array_push($records_array, $collateral_grouped_by_classification);
            }

        }

        $response_msg = array(
            'records_array' => $records_array
        );

        //$resp =  json_encode($response_msg);
        return $response_msg;
    }
}

// $callClass = new CustomerCollateralAnalysisCTRL('collateral_register');
// $callMethod = $callClass->customer_collateral_analysis();
