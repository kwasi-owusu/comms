<?php

!isset($_SESSION) ? session_start() : null;

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
require_once dirname(__DIR__) . '/model/MDLCollateralCategoryChart.php';


class CTRLCollateralCategoryChart
{

    private string $table_a;

    public function __construct($table_a)
    {

        $this->table_a = $table_a;
    }

    public function collateralCategoryChart()
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfMDLCollateralCategoryChart = new MDLCollateralCategoryChart($newPDO, $thisPDO);

        $classification = array(
            'NORM' => 'NORM',
            'OLEM' => 'OLEM',
            'SUB' => 'SUB',
            'DOUBT' => 'DOUBT',
            'LOSS' => 'LOSS'
        );

        $collateral_category = array(
            'LegalMortgage' => 'LEGAL MORTGAGE',
            'PlantsAndMachinery' => 'PLANTS AND MACHINE',
            'BoardGuarantees' => 'BOARD GUARANTEE',
            'Inventory' => 'INVENTORY'

        );

        //for legal mortgage loans
        $legal_mortgage     = $instanceOfMDLCollateralCategoryChart->calculate_values_for_legal_mortgage($this->table_a, $classification, $collateral_category);
        $fetch_legal_loan   = $legal_mortgage->fetch(PDO::FETCH_ASSOC);

        $normal_legal_loans = isset($fetch_legal_loan['NORMALCollateralValueForLegalMortgage']) ? $fetch_legal_loan['NORMALCollateralValueForLegalMortgage'] : 0;
        $olem_legal_loans   = isset($fetch_legal_loan['OLEMCollateralValueForLegalMortgage']) ? $fetch_legal_loan['OLEMCollateralValueForLegalMortgage'] : 0;
        $loss_legal_loans   = isset($fetch_legal_loan['LOSSCollateralValueForLegalMortgage']) ? $fetch_legal_loan['LOSSCollateralValueForLegalMortgage'] : 0;
        $doubt_legal_loans  = isset($fetch_legal_loan['DOUBTCollateralValueForLegalMortgage']) ? $fetch_legal_loan['DOUBTCollateralValueForLegalMortgage'] : 0;
        $sub_legal_loans    = isset($fetch_legal_loan['SUBTCollateralValueForLegalMortgage']) ? $fetch_legal_loan['SUBTCollateralValueForLegalMortgage'] : 0;

        $legal_mortgage_array = array(

            'normal_legal_loan' => $normal_legal_loans,
            'olem_legal_loans' => $olem_legal_loans,
            'loss_legal_loans' => $loss_legal_loans,
            'doubt_legal_loans' => $doubt_legal_loans,
            'sub_legal_loans' => $sub_legal_loans
        );



        // for plants and machines
        $plants_and_machines        = $instanceOfMDLCollateralCategoryChart->calculate_values_for_plants_machines($this->table_a, $classification, $collateral_category);
        $fetch_plant_loan           = $plants_and_machines->fetch(PDO::FETCH_ASSOC);
        $normal_plant_loans         = isset($fetch_plant_loan['NORMALCollateralValueForPlantsAndMachinery']) ? $fetch_plant_loan['NORMALCollateralValueForPlantsAndMachinery'] : 0;
        $olem_plant_loans           = isset($fetch_plant_loan['OLEMCollateralValueForPlantsAndMachinery']) ? $fetch_plant_loan['OLEMCollateralValueForPlantsAndMachinery'] : 0;
        $loss_plant_loans           = isset($fetch_plant_loan['LOSSCollateralValueForPlantsAndMachinery']) ? $fetch_plant_loan['LOSSCollateralValueForPlantsAndMachinery'] : 0;
        $doubt_plant_loans          = isset($fetch_plant_loan['DOUBTCollateralValueForPlantsAndMachinery']) ? $fetch_plant_loan['DOUBTCollateralValueForPlantsAndMachinery'] : 0;
        $sub_plant_loans            = isset($fetch_plant_loan['SUBTCollateralValueForPlantsAndMachinery']) ? $fetch_plant_loan['SUBTCollateralValueForPlantsAndMachinery'] : 0;

        $plants_and_machines_array = array(
            'normal_plant_loans' => $normal_plant_loans,
            'olem_plant_loans' => $olem_plant_loans,
            'olem_plant_loans' => $olem_plant_loans,
            'loss_plant_loans' => $loss_plant_loans,
            'doubt_plant_loans' => $doubt_plant_loans,
            'sub_plant_loans' => $sub_plant_loans
        );


        // for Board guarantees loans
        $board_guarantees           = $instanceOfMDLCollateralCategoryChart->calculate_values_for_board_guarantee($this->table_a, $classification, $collateral_category);
        $fetch_board_loan           = $board_guarantees->fetch(PDO::FETCH_ASSOC);
        $normal_board_loans         = isset($fetch_board_loan['NORMALCollateralValueForBoardGuarantee']) ? $fetch_board_loan['NORMALCollateralValueForBoardGuarantee'] : 0;
        $olem_board_loans           = isset($fetch_board_loan['OLEMCollateralValueForBoardGuarantee']) ? $fetch_board_loan['OLEMCollateralValueForBoardGuarantee'] : 0;
        $loss_board_loans           = isset($fetch_board_loan['LOSSCollateralValueForBoardGuarantee']) ? $fetch_board_loan['LOSSCollateralValueForBoardGuarantee'] : 0;
        $doubt_board_loans          = isset($fetch_board_loan['DOUBTCollateralValueForBoardGuarantee']) ? $fetch_board_loan['DOUBTCollateralValueForBoardGuarantee'] : 0;
        $sub_board_loans            = isset($fetch_board_loan['SUBTCollateralValueBoardGuarantee']) ? $fetch_board_loan['SUBTCollateralValueBoardGuarantee'] : 0;

        $boards_and_guarantee_array = array(
            'normal_board_loans' => $normal_board_loans,
            'ole_board_loans' => $olem_board_loans,
            'loss_board_loans' => $loss_board_loans,
            'doubt_board_loans' => $doubt_board_loans,
            'sub_board_loans' => $sub_board_loans
        );


        // for inventory
        $inventory           = $instanceOfMDLCollateralCategoryChart->calculate_values_for_inventory($this->table_a, $classification, $collateral_category);
        $fetch_inventory     = $inventory->fetch(PDO::FETCH_ASSOC);
        $normal_inventory_loans  = isset($fetch_inventory['NORMALCollateralValueForInventory']) ? $fetch_inventory['NORMALCollateralValueForInventory'] : 0;
        $olem_inventory_loans    = isset($fetch_inventory['OLEMCollateralValueForInventory']) ? $fetch_inventory['OLEMCollateralValueForInventory'] : 0;
        $loss_inventory_loans    = isset($fetch_inventory['LOSSCollateralValueForInventory'] )? $fetch_inventory['LOSSCollateralValueForInventory'] : 0;
        $doubt_inventory_loans   = isset($fetch_inventory['DOUBTCollateralValueForInventory']) ? $fetch_inventory['DOUBTCollateralValueForInventory'] : 0;
        $sub_inventory_loans     = isset($fetch_inventory['SUBTCollateralValueForInventory']) ? $fetch_inventory['SUBTCollateralValueForInventory'] : 0;

        $inventory_array = array(
            'normal_inventory_loans' => $normal_inventory_loans,
            'olem_inventory_loans' => $olem_inventory_loans,
            'loss_inventory_loans' => $loss_inventory_loans,
            'doubt_inventory_loans' => $doubt_inventory_loans,
            'sub_inventory_loans' => $sub_inventory_loans
        );

        //group by classification
        $all_normal_array = array();
        array_push($all_normal_array, $normal_legal_loans);
        array_push($all_normal_array, $normal_plant_loans);
        array_push($all_normal_array, $normal_board_loans);
        array_push($all_normal_array, $normal_inventory_loans);
                

        $all_olem_array = array();
        array_push($all_olem_array, $olem_legal_loans);
        array_push($all_olem_array, $olem_plant_loans);
        array_push($all_olem_array, $olem_board_loans);
        array_push($all_olem_array, $olem_inventory_loans);

        
        $all_sub_array = array();
        array_push($all_sub_array, $sub_legal_loans);
        array_push($all_sub_array, $sub_plant_loans);
        array_push($all_sub_array, $sub_board_loans);
        array_push($all_sub_array, $sub_inventory_loans);


        $all_doubt_array = array();
        array_push($all_doubt_array, $doubt_legal_loans);
        array_push($all_doubt_array, $doubt_plant_loans);
        array_push($all_doubt_array, $doubt_board_loans);
        array_push($all_doubt_array, $doubt_inventory_loans);
        

        $all_loss_array = array();
        array_push($all_loss_array, $loss_legal_loans);
        array_push($all_loss_array, $loss_plant_loans);
        array_push($all_loss_array, $loss_board_loans);
        array_push($all_loss_array, $loss_inventory_loans);
        

        $chart_values_array = array();

        $response_msg = array(
            'legal_mortgage_array' => $legal_mortgage_array,
            'plants_and_machines_array' => $plants_and_machines_array,
            'boards_and_guarantee_array' => $boards_and_guarantee_array,
            'inventory_array' => $inventory_array,
            'all_normal_array' => $all_normal_array,
            'all_olem_array' => $all_olem_array,
            'all_sub_array' => $all_sub_array,
            'all_doubt_array' => $all_doubt_array,
            'all_loss_array' => $all_loss_array
        );


        $resp =  json_encode($response_msg);
        echo $resp;
    }
}

$callClass      = new CTRLCollateralCategoryChart('collateral_register');
$callMethod     = $callClass->collateralCategoryChart();