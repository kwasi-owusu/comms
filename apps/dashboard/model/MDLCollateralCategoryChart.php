<?php

require_once dirname(__DIR__) . '/controller/ICollateralCategoryChartInterface.php';

class MDLCollateralCategoryChart implements ICollateralCategoryChartInterface
{

    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO)
    {

        $this->newPDO       = $newPDO;
        $this->thisPDO      = $thisPDO;
    }

    public function calculate_values_for_legal_mortgage(string $table_a, array $classification, array $collateral_category): object
    {

        $stmt = $this->thisPDO->prepare("SELECT collateral_category, classification, collateral_type, collateral_value,
        
        (CASE WHEN classification = :norm THEN COUNT(collateral_value) END) AS 'NORMALCollateralValueForLegalMortgage',
        (CASE WHEN classification = :olem THEN COUNT(collateral_value) END) AS 'OLEMCollateralValueForLegalMortgage',
        (CASE WHEN classification = :loss THEN COUNT(collateral_value) END) AS 'LOSSCollateralValueForLegalMortgage',
        (CASE WHEN classification = :doubt THEN COUNT(collateral_value) END) AS 'DOUBTCollateralValueForLegalMortgage',
        (CASE WHEN classification = :sub THEN COUNT(collateral_value) END) AS 'SUBTCollateralValueForLegalMortgage'

        FROM $table_a

        WHERE collateral_category = :legal
        ");

        $stmt->bindParam(':norm', $classification['NORM'], PDO::PARAM_STR);
        $stmt->bindParam(':olem', $classification['OLEM'], PDO::PARAM_STR);
        $stmt->bindParam(':loss', $classification['LOSS'], PDO::PARAM_STR);
        $stmt->bindParam(':doubt', $classification['DOUBT'], PDO::PARAM_STR);
        $stmt->bindParam(':sub', $classification['SUB'], PDO::PARAM_STR);

        $stmt->bindParam(':legal', $collateral_category['LegalMortgage'], PDO::PARAM_STR);

        $stmt->execute();

        return $stmt;
    }

    public function calculate_values_for_plants_machines(string $table_a, array $classification, array $collateral_category): object
    {

        $stmt = $this->thisPDO->prepare("SELECT collateral_id, collateral_category, classification, collateral_type, collateral_value, 

        (CASE WHEN classification = :norm THEN COUNT(collateral_id) END) AS 'NORMALCollateralValueForPlantsAndMachinery',
        (CASE WHEN classification = :olem THEN COUNT(collateral_id) END) AS 'OLEMCollateralValueForPlantsAndMachinery',
        (CASE WHEN classification = :loss THEN COUNT(collateral_id) END) AS 'LOSSCollateralValueForPlantsAndMachinery',
        (CASE WHEN classification = :doubt THEN COUNT(collateral_id) END) AS 'DOUBTCollateralValueForPlantsAndMachinery',
        (CASE WHEN classification = :sub THEN COUNT(collateral_id) END) AS 'SUBTCollateralValueForPlantsAndMachinery'
        
        FROM $table_a 
        
        WHERE collateral_category = :plant
        ");

        $stmt->bindParam(':norm', $classification['NORM'], PDO::PARAM_STR);
        $stmt->bindParam(':olem', $classification['OLEM'], PDO::PARAM_STR);
        $stmt->bindParam(':loss', $classification['LOSS'], PDO::PARAM_STR);
        $stmt->bindParam(':doubt', $classification['DOUBT'], PDO::PARAM_STR);
        $stmt->bindParam(':sub', $classification['SUB'], PDO::PARAM_STR);

        $stmt->bindParam(':plant', $collateral_category['PlantsAndMachinery'], PDO::PARAM_STR);

        $stmt->execute();

        return $stmt;
    }

    public function calculate_values_for_board_guarantee(string $table_a, array $classification, array $collateral_category): object
    {

        $stmt = $this->thisPDO->prepare("SELECT collateral_id, collateral_category, classification, collateral_type, collateral_value, 

        (CASE WHEN classification = :norm THEN COUNT(collateral_id) END) AS 'NORMALCollateralValueForBoardGuarantee',
        (CASE WHEN classification = :olem THEN COUNT(collateral_id) END) AS 'OLEMCollateralValueForBoardGuarantee',
        (CASE WHEN classification = :loss THEN COUNT(collateral_id) END) AS 'LOSSCollateralValueForBoardGuarantee',
        (CASE WHEN classification = :doubt THEN COUNT(collateral_id) END) AS 'DOUBTCollateralValueForBoardGuarantee',
        (CASE WHEN classification = :sub THEN COUNT(collateral_id) END) AS 'SUBTCollateralValueBoardGuarantee'
        
        FROM $table_a 
        
        WHERE collateral_category = :board
        ");

        $stmt->bindParam(':norm', $classification['NORM'], PDO::PARAM_STR);
        $stmt->bindParam(':olem', $classification['OLEM'], PDO::PARAM_STR);
        $stmt->bindParam(':loss', $classification['LOSS'], PDO::PARAM_STR);
        $stmt->bindParam(':doubt', $classification['DOUBT'], PDO::PARAM_STR);
        $stmt->bindParam(':sub', $classification['SUB'], PDO::PARAM_STR);

        $stmt->bindParam(':board', $collateral_category['BoardGuarantees'], PDO::PARAM_STR);

        $stmt->execute();

        return $stmt;
    }

    public function calculate_values_for_inventory(string $table_a, array $classification, array $collateral_category): object
    {

        $stmt = $this->thisPDO->prepare("SELECT collateral_id, collateral_category, classification, collateral_type, collateral_value, 

        (CASE WHEN classification = :norm THEN COUNT(collateral_id) END) AS 'NORMALCollateralValueForInventory',
        (CASE WHEN classification = :olem THEN COUNT(collateral_id) END) AS 'OLEMCollateralValueForInventory',
        (CASE WHEN classification = :loss THEN COUNT(collateral_id) END) AS 'LOSSCollateralValueForInventory',
        (CASE WHEN classification = :doubt THEN COUNT(collateral_id) END) AS 'DOUBTCollateralValueForInventory',
        (CASE WHEN classification = :sub THEN COUNT(collateral_id) END) AS 'SUBTCollateralValueForInventory'
        
        FROM $table_a 
        
        WHERE collateral_category = :inventory
        ");

        $stmt->bindParam(':norm', $classification['NORM'], PDO::PARAM_STR);
        $stmt->bindParam(':olem', $classification['OLEM'], PDO::PARAM_STR);
        $stmt->bindParam(':loss', $classification['LOSS'], PDO::PARAM_STR);
        $stmt->bindParam(':doubt', $classification['DOUBT'], PDO::PARAM_STR);
        $stmt->bindParam(':sub', $classification['SUB'], PDO::PARAM_STR);

        $stmt->bindParam(':inventory', $collateral_category['Inventory'], PDO::PARAM_STR);

        $stmt->execute();

        return $stmt;
    }
}
