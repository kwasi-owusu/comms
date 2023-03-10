<?php

require_once dirname(__DIR__, 2) . '/template/statics/head.php';

if (!isset($_SESSION["isLogin"])) {
    echo '<script>
			window.location = "home";
		</script>';
}

require_once dirname(__DIR__, 2) . '/reports/controller/CustomerExposerCTRL.php';

$newInstanceOfCustomerExposure = new CustomerExposerCTRL('collateral_register', 'bonds_and_guarantee', 'loans', 'overdraft_register', 'all_branches');

$client_exposure_lists = $newInstanceOfCustomerExposure->get_customer_exposure();

$bonds_and_guarantee_list = $newInstanceOfCustomerExposure->get_bonds_and_guarantee_records();

$loans_list = $newInstanceOfCustomerExposure->get_loans_records();

$overdraft_list = $newInstanceOfCustomerExposure->get_overdraft_records();


require_once dirname(__DIR__, 2) . '/reports/controller/CollateralCTRL.php';

$instanceOfCollateralCTRL = new CollateralCTRL('collateral_register', 'bonds_and_guarantee', 'loans', 'overdraft_register');

$collateral_lists = $instanceOfCollateralCTRL->lists_of_collaterals();

################################################################ get client info################################
$collateral_records_clients_list = $newInstanceOfCustomerExposure->get_collateral_records();

$newInstanceForCollateralByDistinctLiability = new CustomerExposerCTRL('collateral_register', 'bonds_and_guarantee', 'loans', 'overdraft_register', 'all_branches');
$collateralByLiabilityNumber = $newInstanceForCollateralByDistinctLiability->get_collateral_records();



##################################### for collateral grouping #################################
require_once dirname(__DIR__, 2) . '/reports/controller/CollateralGroupingCTRL.php';
$instanceOfCollateralGroupingCTRL   = new CollateralGroupingCTRL('collateral_register');

$group_collateral_by_currency       = $instanceOfCollateralGroupingCTRL->collateral_grouping_by_currency();

$group_collateral_by_category       = $instanceOfCollateralGroupingCTRL->collateral_grouping_by_category();

$group_collateral_by_type           = $instanceOfCollateralGroupingCTRL->collateral_grouping_by_type();

$group_collateral_by_classification = $instanceOfCollateralGroupingCTRL->collateral_grouping_by_classification();


?>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php
        require_once dirname(__DIR__, 2) . '/template/statics/header.phtml';
        ?>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="admin" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="apps/template/assets/images/logo.png" alt="">
                    </span>
                    <span class="logo-lg">
                        <img src="apps/template/assets/images/logo.png" alt="">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="admin" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="apps/template/assets/images/logo.png" alt="">
                    </span>
                    <span class="logo-lg">
                        <img src="apps/template/assets/images/logo.png" alt="">
                    </span>
                </a>

                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <?php

                require_once dirname(__DIR__, 2) . '/template/statics/menu.php';
                ?>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">


                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="col-xxl-12">
                                        <h5 class="mb-3">Customer Exposure Records</h5>
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <div class="flex-shrink-0 ms-2">
                                                    <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" data-bs-toggle="tab" href="#bonds_and_guarantee_tab" role="tab">
                                                                Bonds & Guarantees
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="tab" href="#loans_tab" role="tab">
                                                                Loans
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="tab" href="#overdraft_tab" role="tab">
                                                                Overdraft
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <!-- Tab panes -->
                                                <div class="tab-content text-muted">
                                                    <div class="tab-pane active" id="bonds_and_guarantee_tab" role="tabpanel">
                                                        <h4 style="text-decoration:underline;">Bonds & Guarantee</h4>
                                                        <table id="buttons-datatables" class="display table buttons-datatables table-responsive" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Customer ID</th>
                                                                    <th>Branch</th>
                                                                    <th>Customer Name</th>
                                                                    <th>Account Number</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Currency</th>
                                                                    <!--<th>More</th>-->
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                                <?php
                                                                foreach ($bonds_and_guarantee_list as $bdg) {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo isset($bdg['customer_id']) ? $bdg['customer_id'] : null; ?></td>
                                                                        <td><?php echo isset($bdg['branch_name']) ? $bdg['branch_name'] : null; ?></td>
                                                                        <td><?php echo isset($bdg['customer_name']) ? $bdg['customer_name'] : null; ?></td>
                                                                        <td><?php echo isset($bdg['account_number']) ? $bdg['account_number'] : null; ?></td>
                                                                        <td><?php echo isset($bdg['totalAmt']) ? number_format($bdg['totalAmt'], 2) : null; ?></td>
                                                                        <td><?php echo isset($bdg['ccy']) ? $bdg['ccy'] : null; ?></td>
                                                                    </tr>

                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>Customer ID</th>
                                                                    <th>Branch</th>
                                                                    <th>Customer Name</th>
                                                                    <th>Account Number</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Currency</th>
                                                                    <!--<th></th>-->
                                                                </tr>
                                                            </tfoot>
                                                        </table>

                                                    </div>

                                                    <div class="tab-pane" id="loans_tab" role="tabpanel">
                                                        <h4 style="text-decoration:underline;">Loans</h4>

                                                        <table id="buttons-datatables" class="display table buttons-datatables table-responsive" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Customer ID</th>
                                                                    <th>Customer Name</th>
                                                                    <th>Loan Account Number</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Currency</th>
                                                                    <th>Branch</th>
                                                                    <!--<th>More</th>-->
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                                <?php
                                                                foreach ($loans_list as $lns) {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo isset($lns['customer_id']) ? $lns['customer_id'] : null; ?></td>
                                                                        <td><?php echo isset($lns['customer_name']) ? $lns['customer_name'] : null; ?></td>
                                                                        <td><?php echo isset($lns['loan_account']) ? $lns['loan_account'] : null; ?></td>
                                                                        <td><?php echo isset($lns['totalAmt']) ? number_format($lns['totalAmt'], 2) : null; ?></td>
                                                                        <td><?php echo isset($lns['currency']) ? $lns['currency'] : null; ?></td>
                                                                        <td><?php echo isset($lns['branch_name']) ? $lns['branch_name'] : null; ?></td>
                                                                    </tr>

                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>

                                                            <tfoot>
                                                                <tr>
                                                                    <th>Customer ID</th>
                                                                    <th>Customer Name</th>
                                                                    <th>Loan Account Number</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Currency</th>
                                                                    <th>Branch</th>
                                                                    <!--<th></th>-->
                                                                </tr>
                                                            </tfoot>
                                                            </tbody>

                                                        </table>

                                                    </div>
                                                    <div class="tab-pane" id="overdraft_tab" role="tabpanel">
                                                        <h4 style="text-decoration: underline;">Overdraft</h4>
                                                        <table id="buttons-datatables" class="display table buttons-datatables table-responsive" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Customer ID</th>
                                                                    <th>Customer Name</th>
                                                                    <th>Account Number</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Currency</th>
                                                                    <!--<th>More</th>-->
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                                <?php
                                                                foreach ($overdraft_list as $odf) {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo isset($odf['customer_id']) ? $odf['customer_id'] : null; ?></td>
                                                                        <td><?php echo isset($odf['customer_name']) ? $odf['customer_name'] : null; ?></td>
                                                                        <td><?php echo isset($odf['account_number']) ? $odf['account_number'] : null; ?></td>
                                                                        <td><?php echo isset($odf['totalAmt']) ? number_format($odf['totalAmt'], 2) : null; ?></td>
                                                                        <td><?php echo isset($odf['account_currency']) ? $odf['account_currency'] : null; ?></td>
                                                                        <td>
                                                                    </tr>

                                                                <?php
                                                                }
                                                                ?>

                                                            </tbody>

                                                            <tfoot>
                                                                <tr>
                                                                    <th>Customer ID</th>
                                                                    <th>Customer Name</th>
                                                                    <th>Account Number</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Currency</th>
                                                                    <!--<th></th>-->
                                                                </tr>
                                                            </tfoot>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div><!-- end card-body -->
                                        </div><!-- end card -->
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Collateral List By Clients</h4>
                                </div><!-- end card header -->
                                <div class="card-body">

                                    <table id="buttons-datatables" class="collateral_distinct_list display table buttons-datatables table-responsive" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Liability Number</th>
                                                <th>Customer Name</th>
                                                <th>More</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            foreach ($collateralByLiabilityNumber as $cll) {
                                            ?>

                                                <tr>
                                                    <td><?php echo $cll['liability_number']; ?></td>
                                                    <td><?php echo $cll['customer_name']; ?></td>
                                                    <td>
                                                        <div class="dropdown d-inline-block">
                                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-fill align-middle"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">

                                                                <li>
                                                                    <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:(0);" data-grp="currency" data-id="<?php echo $cll['liability_number']; ?>" onclick="collateral_by_currency(this)" class="dropdown-item edit-item-btn">
                                                                        <i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                        Group Client Collateral By Currency
                                                                    </a>

                                                                    <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:(0);" data-grp="category" data-id="<?php echo $cll['liability_number']; ?>" onclick="collateral_by_category(this)" class="dropdown-item edit-item-btn">
                                                                        <i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                        Group Client Collateral By Category
                                                                    </a>


                                                                    <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:(0);" data-grp="type" data-id="<?php echo $cll['liability_number']; ?>" onclick="collateral_by_type(this)" class="dropdown-item edit-item-btn">
                                                                        <i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                        Group Client Collateral By Collateral Type
                                                                    </a>


                                                                    <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:(0);" data-grp="classification" data-id="<?php echo $cll['liability_number']; ?>" onclick="collateral_by_classification(this)" class="dropdown-item edit-item-btn">
                                                                        <i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                        Group Client Collateral By Classification
                                                                    </a>

                                                                </li>


                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>

                                            <?php
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="modal_content_here">

                                        </div>
                                        <div class="modal-footer">
                                            <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-xxl-12">
                                        <h5 class="mb-3">Client Collateral Groupings</h5>
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <div class="flex-shrink-0 ms-2">
                                                    <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" data-bs-toggle="tab" href="#collateral_by_currency" role="tab">
                                                                Group Client By Collateral Currency
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="tab" href="#collateral_by_classification" role="tab">
                                                                Group Client By Collateral Classification
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="tab" href="#collateral_by_category" role="tab">
                                                                Group Client By Collateral Category
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="tab" href="#collateral_by_type" role="tab">
                                                                Group Client By Collateral Type
                                                            </a>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <!-- Tab panes -->
                                                <div class="tab-content text-muted">
                                                    <div class="tab-pane active" id="collateral_by_currency" role="tabpanel">
                                                        <h4 style="text-decoration:underline;">Group Client By Collateral Currency</h4>
                                                        <table id="buttons-datatables" class="collateral_grouping display table buttons-datatables table-responsive" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Currency</th>
                                                                    <th>Classification</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Total Count</th>
                                                                    <!--<th>More</th>-->
                                                                </tr>
                                                            </thead>

                                                            <tbody>

                                                                <?php
                                                                foreach ($group_collateral_by_currency as $cr) {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $cr['collateral_currency']; ?></td>
                                                                        <td><?php echo $cr['classification']; ?></td>
                                                                        <td><?php echo number_format($cr['sumCollateralValue'], 2); ?></td>
                                                                        <td><?php echo $cr['totalCollaterals']; ?></td>
                                                                    </tr>

                                                                <?php
                                                                }

                                                                ?>

                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="tab-pane" id="collateral_by_classification" role="tabpanel">
                                                        <h4 style="text-decoration:underline;">Group Client By Collateral Classification</h4>

                                                        <table id="buttons-datatables" class="collateral_grouping display table buttons-datatables table-responsive" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Classification</th>
                                                                    <th>Currency</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Total Count</th>
                                                                    <!--<th>More</th>-->
                                                                </tr>
                                                            </thead>

                                                            <tbody>


                                                                <?php
                                                                foreach ($group_collateral_by_classification as $cl) {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $cl['classification']; ?></td>
                                                                        <td><?php echo $cl['collateral_currency']; ?></td>
                                                                        <td><?php echo number_format($cl['sumCollateralValue'], 2); ?></td>
                                                                        <td><?php echo $cl['totalCollaterals']; ?></td>
                                                                    </tr>
                                                                <?php

                                                                }

                                                                ?>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                    <div class="tab-pane" id="collateral_by_category" role="tabpanel">
                                                        <h4 style="text-decoration: underline;">Group Client By Collateral Category</h4>
                                                        <table id="buttons-datatables" class="collateral_grouping display table buttons-datatables table-responsive" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Collateral Category</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Currency</th>
                                                                    <th>Total Count</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>


                                                                <?php
                                                                foreach ($group_collateral_by_category as $ctg) {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $ctg['collateral_category']; ?></td>
                                                                        <td><?php echo number_format($ctg['sumCollateralValue'], 2); ?></td>
                                                                        <td><?php echo $ctg['collateral_currency']; ?></td>
                                                                        <td><?php echo $ctg['totalCollaterals']; ?></td>
                                                                    </tr>
                                                                <?php

                                                                }

                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="tab-pane" id="collateral_by_type" role="tabpanel">
                                                        <h4 style="text-decoration: underline;">Group Client By Collateral Type</h4>
                                                        <table id="buttons-datatables" class="collateral_grouping display table buttons-datatables table-responsive" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Collateral Type</th>
                                                                    <th>Currency</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Total Count</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>


                                                                <?php
                                                                foreach ($group_collateral_by_type as $ctp) {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $ctp['collateral_type']; ?></td>
                                                                        <td><?php echo $ctp['collateral_currency']; ?></td>
                                                                        <td><?php echo number_format($ctp['sumCollateralValue'], 2); ?></td>
                                                                        <td><?php echo $ctp['totalCollaterals']; ?></td>
                                                                    </tr>
                                                                <?php

                                                                }

                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div><!-- end card-body -->
                                        </div><!-- end card -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Filter Client's Facilities</h4>
                                </div><!-- end card header -->
                                <div class="card-body">

                                    <form action="CustomerExposureFilterCTRL" method="post" name="bonds_and_guarantee_filter" class="form-horizontal form" id="bonds_and_guarantee_filter" autocomplete="off">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <label for="client_list" class="form-label">Select Client</label>
                                                <select class="form-select mb-3" aria-label="Default select example" id="select_client" name="select_client">
                                                    <option selected>Select a Client </option>

                                                    <?php

                                                    foreach ($collateral_records_clients_list as $bcl) {
                                                    ?>
                                                        <option value="<?php echo $bcl['liability_number']; ?>"><?php echo $bcl['customer_name']; ?></option>

                                                    <?php
                                                    }

                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-lg-3">
                                                <label for="filter_action" class="form-label">Select Filter Action</label>
                                                <select class="form-select mb-3" aria-label="Default select example" name="filter_action" id="filter_action">
                                                    <option selected>Select Action </option>
                                                    <option value="1">Exposure By Bonds & Guarantee</option>
                                                    <option value="2">Exposure By Loans</option>
                                                    <option value="3">Exposure By Overdraft</option>
                                                    <option value="4">Exposure By All Facilities</option>
                                                    <option value="5">Exposure By Collaterals</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="filter_date" class="form-label">Select Start Date</label>
                                                <input class="form-control" type="date" id="bonds_start_date" name="bonds_start_date" value="<?php echo Date('Y-01-01'); ?>" />
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="filter_end_date" class="form-label">Select End Date</label>
                                                <input class="form-control" type="date" id="bonds_end_date" name="bonds_end_date" value="<?php echo Date('Y-m-d'); ?>" />
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="filter_end_date" class="form-label"></label>
                                                <button class="btn btn-danger w-100" style="padding-top: 18px;" type="submit" id="filterBtn" name="filterBtn">Filter</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Lists of Customer Collateral Exposure</h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <table data-id="table_response_body_here" id="exposure_by_collateral_table" class="display table table-responsive" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Code</th>
                                                        <th>Acc. No</th>
                                                        <th>Branch</th>
                                                        <th>Value</th>
                                                        <th>Curr</th>
                                                        <th>Classification</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Value of Customer Facility Exposure by Currency</h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <table data-id="table_response_body_here" id="exposure_by_facility_table" class="display table table-responsive" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Customer Name</th>
                                                        <th>Total Amount</th>
                                                        <th>Currency</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <! </div>
                                    <!-- end card -->
                            </div><!-- end col -->

                        </div><!-- end row -->

                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Value of Collateral Exposure by Currency</h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12">

                                            <table data-id="collateral_value_body_here" id="" class="display table table-responsive" style="width:30%">
                                                <thead>
                                                    <tr>
                                                        <th>Total Number</th>
                                                        <th>Sum Value</th>
                                                        <th>Currency</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="exposure_by_collateral_currency_table">

                                                </tbody>

                                            </table>
                                            </table>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                    </div>

                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                <?php
                require_once dirname(__DIR__, 2) . '/template/statics/footer.php';
                ?>
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->


        <!--start back-to-top-->
        <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->
        <?php
        require_once dirname(__DIR__, 2) . '/template/statics/footer_script.php';
        ?>

        <script src="apps/reports/js/extra.js"></script>

        <script>
            $(document).ready(function() {
                $('.collateral_distinct_list').DataTable({
                    dom: "Bfrtip",

                    buttons: ["copy", "csv", "excel", "print"],

                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function(row) {
                                    var data = row.data();
                                    return 'Details for ' + data[0] + ' ' + data[1];
                                }
                            }),
                            renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                                tableClass: 'table'
                            })
                        }
                    }
                });
            });

            document.addEventListener("DOMContentLoaded", function() {
                new DataTable("#ajax-datatables", {
                    ajax: "apps/template/statics/assets/json/datatable.json"
                });
            });

            $(".collateral_distinct_list tfoot th").each(function() {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            });
        </script>

        <script>
            $(document).ready(function() {
                $('#overdraft_table_lists').DataTable({
                    dom: "Bfrtip",

                    buttons: ["copy", "csv", "excel", "print"],

                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function(row) {
                                    var data = row.data();
                                    return 'Details for ' + data[0] + ' ' + data[1];
                                }
                            }),
                            renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                                tableClass: 'table'
                            })
                        }
                    }
                });
            });


            $("#overdraft_table_lists tfoot th").each(function() {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            });
        </script>


        <script>
            $(document).ready(function() {
                $('.collateral_grouping').DataTable({
                    dom: "Bfrtip",

                    buttons: ["copy", "csv", "excel", "print"],

                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function(row) {
                                    var data = row.data();
                                    return 'Details for ' + data[0] + ' ' + data[1];
                                }
                            }),
                            renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                                tableClass: 'table'
                            })
                        }
                    }
                });
            });


            $(".collateral_grouping tfoot th").each(function() {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            });
        </script>



</body>

</html>