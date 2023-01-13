<?php
require_once dirname(__DIR__) . '/controller/ICollateralGrouping.php';

class MDLCollateralGrouping implements ICollateralGrouping{

    public function group_collateral_by_currency(string $table_a, string $group_by_val): object{

    }
    public function group_collateral_by_category(string $table_a, int $group_by_val): object{
        
    }
    public function group_collateral_by_type(string $table_a, int $group_by_val): object{

    }
    public function group_collateral_by_classification(string $table_a, int $group_by_val): object{

    }
}