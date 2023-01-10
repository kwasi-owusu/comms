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


    //     ---------------------------
    // |  Stores |  Data  |  Qty |
    // ---------------------------
    // |    HM   | Sales  |  15  |
    // |    RD   | Sales  |  10  |
    // |    HM   | Return |   4  |
    // |    RD   | Return |   2  |



    // select fr.store,
    // SUM(case when fr.data = 'Sales' then fr.qty end) as Sales,
    // SUM(case when fr.data = 'Return' then fr.qty end) as Returns
    // from full_report fr
    // group by fr.store;


    //     --------------------------
    // | Store | Sales | Return |
    // --------------------------
    // |   HM  |   15   |   4   |
    // |   RD  |   10   |   2   |



    public function calculate_values_for_legal_mortgage(string $table_a, array $classification, array $collateral_category): object
    {

        $stmt = $this->thisPDO->prepare("SELECT c.collateral_category,
        
        COUNT(CASE WHEN c.classification = :norm THEN c.collateral_id END) AS NORMALCollateralValueForLegalMortgage,
        COUNT(CASE WHEN c.classification = :olem THEN c.collateral_id END) AS OLEMCollateralValueForLegalMortgage,
        COUNT(CASE WHEN c.classification = :loss THEN c.collateral_id END) AS LOSSCollateralValueForLegalMortgage,
        COUNT(CASE WHEN c.classification = :doubt THEN c.collateral_id END) AS DOUBTCollateralValueForLegalMortgage,
        COUNT(CASE WHEN c.classification = :sub THEN c.collateral_id END) AS SUBTCollateralValueForLegalMortgage

        FROM $table_a c

        WHERE c.collateral_category = :legal
        
        ");

        $stmt->bindParam(':norm', $classification['nrm'], PDO::PARAM_STR);
        $stmt->bindParam(':olem', $classification['olm'], PDO::PARAM_STR);
        $stmt->bindParam(':loss', $classification['lss'], PDO::PARAM_STR);
        $stmt->bindParam(':doubt', $classification['dbt'], PDO::PARAM_STR);
        $stmt->bindParam(':sub', $classification['sbt'], PDO::PARAM_STR);

        $stmt->bindParam(':legal', $collateral_category['LegalMortgage'], PDO::PARAM_STR);

        $stmt->execute();

        return $stmt;
    }

    public function calculate_values_for_plants_machines(string $table_a, array $classification, array $collateral_category): object
    {

        $stmt = $this->thisPDO->prepare("SELECT collateral_id, collateral_category, classification, collateral_type, collateral_value, 
        
        COUNT(CASE WHEN classification = :norm THEN collateral_id END) AS NORMALCollateralValueForPlantsAndMachinery,
        COUNT(CASE WHEN classification = :olem THEN collateral_id END) AS OLEMCollateralValueForPlantsAndMachinery,
        COUNT(CASE WHEN classification = :loss THEN collateral_id END) AS LOSSCollateralValueForPlantsAndMachinery,
        COUNT(CASE WHEN classification = :doubt THEN collateral_id END) AS DOUBTCollateralValueForPlantsAndMachinery,
        COUNT(CASE WHEN classification = :sub THEN collateral_id END) AS SUBTCollateralValueForPlantsAndMachinery

                
        FROM $table_a 
        
        WHERE collateral_category = :plant
        ");

        $stmt->bindParam(':norm', $classification['nrm'], PDO::PARAM_STR);
        $stmt->bindParam(':olem', $classification['olm'], PDO::PARAM_STR);
        $stmt->bindParam(':loss', $classification['lss'], PDO::PARAM_STR);
        $stmt->bindParam(':doubt', $classification['dbt'], PDO::PARAM_STR);
        $stmt->bindParam(':sub', $classification['sbt'], PDO::PARAM_STR);

        $stmt->bindParam(':plant', $collateral_category['PlantsAndMachinery'], PDO::PARAM_STR);

        $stmt->execute();

        return $stmt;
    }

    public function calculate_values_for_board_guarantee(string $table_a, array $classification, array $collateral_category): object
    {

        $stmt = $this->thisPDO->prepare("SELECT collateral_id, collateral_category, classification, collateral_type, collateral_value, 
        
        COUNT(CASE WHEN classification = :norm THEN collateral_id END) AS NORMALCollateralValueForBoardGuarantee,
        COUNT(CASE WHEN classification = :olem THEN collateral_id END) AS OLEMCollateralValueForBoardGuarantee,
        COUNT(CASE WHEN classification = :loss THEN collateral_id END) AS LOSSCollateralValueForBoardGuarantee,
        COUNT(CASE WHEN classification = :doubt THEN collateral_id END) AS DOUBTCollateralValueForBoardGuarantee,
        COUNT(CASE WHEN classification = :sub THEN collateral_id END) AS SUBTCollateralValueBoardGuarantee
        
        
        FROM $table_a 
        
        WHERE collateral_category = :board
        ");

        $stmt->bindParam(':norm', $classification['nrm'], PDO::PARAM_STR);
        $stmt->bindParam(':olem', $classification['olm'], PDO::PARAM_STR);
        $stmt->bindParam(':loss', $classification['lss'], PDO::PARAM_STR);
        $stmt->bindParam(':doubt', $classification['dbt'], PDO::PARAM_STR);
        $stmt->bindParam(':sub', $classification['sbt'], PDO::PARAM_STR);

        $stmt->bindParam(':board', $collateral_category['BoardGuarantees'], PDO::PARAM_STR);

        $stmt->execute();

        return $stmt;
    }

    public function calculate_values_for_inventory(string $table_a, array $classification, array $collateral_category): object
    {

        $stmt = $this->thisPDO->prepare("SELECT collateral_id, collateral_category, classification, collateral_type, collateral_value, 
        
        COUNT(CASE WHEN classification = :norm THEN collateral_id END) AS NORMALCollateralValueForInventory,
        COUNT(CASE WHEN classification = :olem THEN collateral_id END) AS OLEMCollateralValueForInventory,
        COUNT(CASE WHEN classification = :loss THEN collateral_id END) AS LOSSCollateralValueForInventory,
        COUNT(CASE WHEN classification = :doubt THEN collateral_id END) AS DOUBTCollateralValueForInventory,
        COUNT(CASE WHEN classification = :sub THEN collateral_id END) AS SUBTCollateralValueForInventory
                
        FROM $table_a 
        
        WHERE collateral_category = :inventory
        ");

        $stmt->bindParam(':norm', $classification['nrm'], PDO::PARAM_STR);
        $stmt->bindParam(':olem', $classification['olm'], PDO::PARAM_STR);
        $stmt->bindParam(':loss', $classification['lss'], PDO::PARAM_STR);
        $stmt->bindParam(':doubt', $classification['dbt'], PDO::PARAM_STR);
        $stmt->bindParam(':sub', $classification['sbt'], PDO::PARAM_STR);

        $stmt->bindParam(':inventory', $collateral_category['Inventory'], PDO::PARAM_STR);

        $stmt->execute();

        return $stmt;
    }
}
