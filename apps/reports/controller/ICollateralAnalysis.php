<?php

interface ICollateralAnalysis{

    public function collateral_by_currency(string $table_a, int $customer_id): object;
    public function collateral_by_category(string $table_a, int $customer_id): object;
    public function collateral_by_type(string $table_a, int $customer_id): object;
    public function collateral_by_classification(string $table_a, int $customer_id): object;
}