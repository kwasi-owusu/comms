<?php

require_once dirname(__DIR__, 2) . '/template/statics/head.php';

if (!isset($_SESSION["isLogin"])) {
    echo '<script>
			window.location = "home";
		</script>';
}

require_once dirname(__DIR__, 2) . '/reports/controller/BranchWiseReportCTRL.php';

$newInstanceOfBranchWiseReport = new BranchWiseReportCTRL('collateral_register', 'bonds_and_guarantee', 'loans', 'overdraft_register');


$bonds_and_guarantee_by_branch = $newInstanceOfBranchWiseReport->get_bonds_and_guarantee_records_by_branch();

$loans_list_by_branch = $newInstanceOfBranchWiseReport->get_loans_records_by_branch();

$overdraft_list_by_branch = $newInstanceOfBranchWiseReport->get_overdraft_records_by_branch();

################################################################ get client info################################

require_once dirname(__DIR__, 2) . '/reports/controller/CustomerExposerCTRL.php';

$newInstanceOfCustomerExposure = new CustomerExposerCTRL('collateral_register', 'bonds_and_guarantee', 'loans', 'overdraft_register', 'all_branches');
$bonds_and_guarantee_clients_list = $newInstanceOfCustomerExposure->get_bonds_and_guarantee_records();

?>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <!-- Dark Logo-->
                            <a href="javascript:void(0);" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="apps/template/statics/assets/images/logo.png" alt="" width="150">
                                </span>
                                <span class="logo-lg">
                                    <img src="apps/template/statics/assets/images/logo.png" alt="" width="150">
                                </span>
                            </a>
                            <!-- Light Logo-->
                            <a href="javascript:void(0);" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="apps/template/statics/assets/images/logo.png" alt="" width="150">
                                </span>
                                <span class="logo-lg">
                                    <img src="apps/template/statics/assets/images/logo.png" alt="" width="150">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>

                        <div class="app-search position-relative">
                            <h2>COLLATERAL REPORTING ANALYTICS SOLUTION</h2>
                        </div>

                    </div>

                    <div class="d-flex align-items-center">

                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                                <i class='bx bx-fullscreen fs-22'></i>
                            </button>
                        </div>

                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                                <i class='bx bx-moon fs-22'></i>
                            </button>
                        </div>


                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <h6 class="dropdown-header">Welcome <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?>!</h6>
                                <a class="dropdown-item" href="profile"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
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
                                        <h5 class="mb-3">Branch Facility Records</h5>
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
                                                                    <th scope="col" style="width: 10px;">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                                                        </div>
                                                                    </th>
                                                                    <th>Customer ID</th>
                                                                    <th>Branch Code</th>
                                                                    <th>Customer Name</th>
                                                                    <th>Account Number</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Currency</th>
                                                                    <th>More</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                                <?php
                                                                foreach ($bonds_and_guarantee_by_branch as $bdg) {
                                                                ?>
                                                                    <tr>
                                                                        <th scope="row">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input fs-15" type="checkbox" name="checkAll" value="option1">
                                                                            </div>
                                                                        </th>
                                                                        <td><?php echo isset($bdg['customer_id']) ? $bdg['customer_id'] : null; ?></td>
                                                                        <td><?php echo isset($bdg['brn']) ? $bdg['brn'] : null; ?></td>
                                                                        <td><?php echo isset($bdg['customer_name']) ? $bdg['customer_name'] : null; ?></td>
                                                                        <td><?php echo isset($bdg['account_number']) ? $bdg['account_number'] : null; ?></td>
                                                                        <td><?php echo isset($bdg['totalAmt']) ? number_format($bdg['totalAmt'], 2) : null; ?></td>
                                                                        <td><?php echo isset($bdg['ccy']) ? $bdg['ccy'] : null; ?></td>
                                                                        <td>
                                                                            <div class="dropdown d-inline-block">
                                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="ri-more-fill align-middle"></i>
                                                                                </button>
                                                                                <ul class="dropdown-menu dropdown-menu-end">

                                                                                    <li><a data-bs-toggle="modal" data-bs-target="#myModal" href="#!" class="dropdown-item edit-item-btn"><i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                                            Details
                                                                                        </a>
                                                                                    </li>

                                                                                    <li><a data-bs-toggle="modal" data-bs-target="#myModal" href="#!" class="dropdown-item edit-item-btn"><i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                                            Exposure Analysis
                                                                                        </a>
                                                                                    </li>

                                                                                    <li>
                                                                                        <a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                                            Lists of Collaterals
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </td>
                                                                    </tr>

                                                                <?php
                                                                }
                                                                ?>

                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="loans_tab" role="tabpanel">
                                                        <h4 style="text-decoration:underline;">Loans</h4>

                                                        <table id="buttons-datatables" class="display table buttons-datatables table-responsive" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" style="width: 10px;">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                                                        </div>
                                                                    </th>
                                                                    <th>Customer ID</th>
                                                                    <th>Branch Code</th>
                                                                    <th>Customer Name</th>
                                                                    <th>Loan Account Number</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Currency</th>
                                                                    <th>More</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                                <?php
                                                                foreach ($loans_list_by_branch as $lns) {
                                                                ?>
                                                                    <tr>
                                                                        <th scope="row">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input fs-15" type="checkbox" name="checkAll" value="option1">
                                                                            </div>
                                                                        </th>
                                                                        <td><?php echo isset($lns['customer_id']) ? $lns['customer_id'] : null; ?></td>
                                                                        <td><?php echo isset($lns['branch_code']) ? $lns['branch_code'] : null; ?></td>
                                                                        <td><?php echo isset($lns['customer_name']) ? $lns['customer_name'] : null; ?></td>
                                                                        <td><?php echo isset($lns['loan_account']) ? $lns['loan_account'] : null; ?></td>
                                                                        <td><?php echo isset($lns['totalAmt']) ? number_format($lns['totalAmt'], 2) : null; ?></td>
                                                                        <td><?php echo isset($lns['currency']) ? $lns['currency'] : null; ?></td>
                                                                        <td>
                                                                            <div class="dropdown d-inline-block">
                                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="ri-more-fill align-middle"></i>
                                                                                </button>
                                                                                <ul class="dropdown-menu dropdown-menu-end">

                                                                                    <li><a data-bs-toggle="modal" data-bs-target="#myModal" href="#!" class="dropdown-item edit-item-btn"><i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                                            Collateral Details
                                                                                        </a>
                                                                                    </li>

                                                                                    <li><a data-bs-toggle="modal" data-bs-target="#myModal" href="#!" class="dropdown-item edit-item-btn"><i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                                            Facility Type Details
                                                                                        </a>
                                                                                    </li>

                                                                                    <li>
                                                                                        <a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                                            Customer Details
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </td>
                                                                    </tr>

                                                                <?php
                                                                }
                                                                ?>

                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="overdraft_tab" role="tabpanel">
                                                        <h4 style="text-decoration: underline;">Overdraft</h4>

                                                        <table id="buttons-datatables" class="display table buttons-datatables table-responsive" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" style="width: 10px;">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                                                        </div>
                                                                    </th>
                                                                    <th>Customer ID</th>
                                                                    <th>Branch Code</th>
                                                                    <th>Customer Name</th>
                                                                    <th>Account Number</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Currency</th>
                                                                    <th>More</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                                <?php
                                                                foreach ($overdraft_list_by_branch as $odf) {
                                                                ?>
                                                                    <tr>
                                                                        <th scope="row">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input fs-15" type="checkbox" name="checkAll" value="option1">
                                                                            </div>
                                                                        </th>
                                                                        <td><?php echo isset($odf['customer_id']) ? $odf['customer_id'] : null; ?></td>
                                                                        <td><?php echo isset($odf['branch_code']) ? $odf['branch_code'] : null; ?></td>
                                                                        <td><?php echo isset($odf['customer_name']) ? $odf['customer_name'] : null; ?></td>
                                                                        <td><?php echo isset($odf['account_number']) ? $odf['account_number'] : null; ?></td>
                                                                        <td><?php echo isset($odf['totalAmt']) ? number_format($odf['totalAmt'], 2) : null; ?></td>
                                                                        <td><?php echo isset($odf['account_currency']) ? $odf['account_currency'] : null; ?></td>
                                                                        <td>
                                                                            <div class="dropdown d-inline-block">
                                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="ri-more-fill align-middle"></i>
                                                                                </button>
                                                                                <ul class="dropdown-menu dropdown-menu-end">

                                                                                    <li><a data-bs-toggle="modal" data-bs-target="#myModal" href="#!" class="dropdown-item edit-item-btn"><i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                                            Collateral Details
                                                                                        </a>
                                                                                    </li>

                                                                                    <li><a data-bs-toggle="modal" data-bs-target="#myModal" href="#!" class="dropdown-item edit-item-btn"><i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                                            Facility Type Details
                                                                                        </a>
                                                                                    </li>

                                                                                    <li>
                                                                                        <a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                                            Customer Details
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </td>
                                                                    </tr>

                                                                <?php
                                                                }
                                                                ?>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div><!-- end card-body -->
                                        </div><!-- end card -->
                                    </div>


                                </div>
                            </div>

                            <h4>Filter By Branch</h4>

                            <form action="CTRLFilterCustomerExposureByBondsAndGuarantee" method="post" name="bonds_and_guarantee_filter" class="form-horizontal form" id="bonds_and_guarantee_filter" autocomplete="off">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label for="client_list" class="form-label">Select Client</label>
                                        <select class="form-select mb-3" aria-label="Default select example" id="client" name="client">
                                            <option selected>Select a Branch </option>

                                            <?php

                                            foreach ($bonds_and_guarantee_clients_list as $bcl) {
                                            ?>
                                                <option value="<?php echo $bcl['customer_id']; ?>"><?php echo $bcl['customer_name']; ?></option>

                                            <?php
                                            }

                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="filter_action" class="form-label">Select Filter Action</label>
                                        <select class="form-select mb-3" aria-label="Default select example" name="filter_action" id="filter_action">
                                            <option selected>Select Action </option>
                                            <option value="1">Branch Bonds & Guarantee</option>
                                            <option value="2">Branch Loans</option>
                                            <option value="3">Branch Overdraft</option>
                                            <option value="4">Branch All Facilities</option>
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

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Branch Analysis</h4>
                                </div><!-- end card header -->
                                <div class="card-header p-0 border-0 bg-soft-light">

                                </div><!-- end card header -->
                                <div class="card-body">
                                    <div id="branch_filter_response_here">

                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->


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

    <script src="apps/dashboard/js/extra.js"></script>

</body>

</html>