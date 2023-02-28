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
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Client Tets Case Analysis</h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            
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
              



</body>

</html>