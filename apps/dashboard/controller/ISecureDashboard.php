<?php

interface ISecureDashboard{

    public function check_total_normal_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : int;
    public function check_sum_normal_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : object;

    public function check_total_olem_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : int;
    public function check_sum_olem_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : object;

    public function check_total_sub_standard_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : int;
    public function check_sum_sub_standard_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : object;

    public function check_total_doubtful_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : int;
    public function check_sum_doubtful_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : object;

    public function check_total_loss_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : int;
    public function check_sum_loss_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : object;

    public function check_total_bonds_and_guarantees(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : object;
    public function check_total_loans(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : object;
    public function check_total_overdraft(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : object;

    public function check_total_breached_overdraft(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : int;
    public function check_total_loan_principal_overdue(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : int;
    public function check_total_loan_penalty_overdue(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : int;
    public function check_total_loan_penalty_due(string $table_a, $table_b, $table_c, $table_d, $classification, $currency) : int;
    
    
    public function get_collateral_grouped_by_currency(string $table_a, $table_b, $table_c, $table_d, $classification, $currency);

    function loan_classification_grouped_by_collateral_category(string $table_a, $table_b, $table_c, $table_d, $classification, $currency);
}