<?php

require_once dirname(__DIR__, 2) . '/template/statics/head.php';

if (!isset($_SESSION["isLogin"])) {
    echo '<script>
			window.location = "home";
		</script>';
}

require_once dirname(__DIR__, 2) . '/auth/controller/AuthEnums.php';
require_once dirname(__DIR__, 2) . '/auth/controller/CTRLSecureLogin.php';

$page_name          = AuthEnums::login_page_name->value;
$hash_key           = AuthEnums::secure_form_cors_hash->value;


$create_token       = new CTRLSecureLogin();
$login_token        = $create_token->is_login_hash_valid($page_name, $hash_key);
$_SESSION['login_tkn'] = $login_token;


require_once dirname(__DIR__, 2) . '/reports/controller/CollateralCTRL.php';

$instanceOfCollateralCTRL = new CollateralCTRL('collateral_register', 'bonds_and_guarantee', 'loans', 'overdraft_register');

$collateral_lists = $instanceOfCollateralCTRL->lists_of_collaterals();


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
                        <div class="col-xxl-6">
                            <div class="d-flex flex-column h-100">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <h4 class="fw-medium text-muted mb-0" style="font-weight: bolder;">Normal Collateral</h4>
                                                        <h2 class="mt-4 ff-secondary fw-semibold" id="total_normal_loans"></h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <div class="dropdown d-inline-block">
                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-fill align-middle"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">

                                                                    <li>
                                                                        <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:(0);" data-id="1" onclick="collateral_status_list(this)" class="dropdown-item edit-item-btn">
                                                                            <i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                            View Lists
                                                                        </a>
                                                                    </li>

                                                                    <li>
                                                                        <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:(0);" data-id="1" onclick="collateral_status_by_branch(this)" class="dropdown-item edit-item-btn">
                                                                            <i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                            Distribution By Branch
                                                                        </a>
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    <div class="col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <h4 class="fw-medium text-muted mb-0" style="font-weight: bolder;">OLEM Collateral </h4>
                                                        <h2 class="mt-4 ff-secondary fw-semibold" id="total_olem_loans"></h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <div class="dropdown d-inline-block">
                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-fill align-middle"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">

                                                                    <li>
                                                                        <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:(0);" data-id="2" onclick="collateral_status_list(this)" class="dropdown-item edit-item-btn">
                                                                            <i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                            View Lists
                                                                        </a>
                                                                    </li>

                                                                    <li>
                                                                        <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:(0);" data-id="2" onclick="collateral_status_by_branch(this)" class="dropdown-item edit-item-btn">
                                                                            <i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                            Distribution By Branch
                                                                        </a>
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
                                </div> <!-- end row-->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <h4 style="font-weight: bolder;" class="fw-medium text-muted mb-0">Sub Standard Collateral</h4>
                                                        <h2 class="mt-4 ff-secondary fw-semibold" id="total_total_sub_standard_loans"></h2>
                                                        </h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <div class="dropdown d-inline-block">
                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-fill align-middle"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">

                                                                    <li>
                                                                        <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:(0);" data-id="3" onclick="collateral_status_list(this)" class="dropdown-item edit-item-btn">
                                                                            <i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                            View Lists
                                                                        </a>
                                                                    </li>

                                                                    <li>
                                                                        <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:(0);" data-id="3" onclick="collateral_status_by_branch(this)" class="dropdown-item edit-item-btn">
                                                                            <i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                            Distribution By Branch
                                                                        </a>
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    <div class="col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <h4 style="font-weight: bolder;" class="fw-medium text-muted mb-0">Doubtful Collateral</h4>
                                                        <h2 class="mt-4 ff-secondary fw-semibold" id="total_doubtful_loans"></h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <div class="dropdown d-inline-block">
                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-fill align-middle"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">

                                                                    <li>
                                                                        <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:(0);" data-id="4" onclick="collateral_status_list(this)" class="dropdown-item edit-item-btn">
                                                                            <i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                            View Lists
                                                                        </a>
                                                                    </li>

                                                                    <li>
                                                                        <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:(0);" data-id="4" onclick="collateral_status_by_branch(this)" class="dropdown-item edit-item-btn">
                                                                            <i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                            Distribution By Branch
                                                                        </a>
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
                                </div>
                            </div>
                        </div> <!-- end col-->

                        <div class="col-xxl-6">
                            <div class="d-flex flex-column h-100">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <h4 style="font-weight: bolder;" class="fw-medium text-muted mb-0">Loss Collateral</h4>
                                                        <h2 class="mt-4 ff-secondary fw-semibold" style="color: #092;" id="total_loss_loans"></h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <div>
                                                                <div class="avatar-sm flex-shrink-0">
                                                                    <div class="dropdown d-inline-block">
                                                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <i class="ri-more-fill align-middle"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu dropdown-menu-end">

                                                                            <li>
                                                                                <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:(0);" data-id="5" onclick="collateral_status_list(this)" class="dropdown-item edit-item-btn">
                                                                                    <i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                                    View Lists
                                                                                </a>
                                                                            </li>

                                                                            <li>
                                                                                <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:(0);" data-id="5" onclick="collateral_status_by_branch(this)" class="dropdown-item edit-item-btn">
                                                                                    <i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                                    Distribution By Branch
                                                                                </a>
                                                                                </a>
                                                                            </li>

                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    <div class="col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <h4 style="font-weight: bolder;" class="fw-medium text-muted mb-0">Total Bonds & Guarantee </h4>
                                                        <h2 class="mt-4 ff-secondary fw-semibold" style="color: #d70900;" id="total_bonds_and_guarantees"></h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <div>
                                                                <div class="avatar-sm flex-shrink-0">
                                                                    <div class="dropdown d-inline-block">
                                                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <i class="ri-more-fill align-middle"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu dropdown-menu-end">

                                                                            <li>
                                                                                <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:(0);" data-id="1" onclick="facility_filter_list(this)" class="dropdown-item edit-item-btn">
                                                                                    <i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                                    View Lists
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
                                </div> <!-- end row-->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <h4 style="font-weight: bolder;" class="fw-medium text-muted mb-0">Total Loans</h4>
                                                        <h2 class="mt-4 ff-secondary fw-semibold" style="color: #d70900;" id="total_loans"></h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <div>
                                                                <div class="avatar-sm flex-shrink-0">
                                                                    <div class="dropdown d-inline-block">
                                                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <i class="ri-more-fill align-middle"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu dropdown-menu-end">

                                                                            <li>
                                                                                <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:(0);" data-id="2" onclick="facility_filter_list(this)" class="dropdown-item edit-item-btn">
                                                                                    <i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                                    View Lists
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    <div class="col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <h4 style="font-weight: bolder;" class="fw-medium text-muted mb-0">Total Overdraft</h4>
                                                        <h2 class="mt-4 ff-secondary fw-semibold" style="color: #092;" id="total_overdraft"></h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <div>
                                                                <div class="avatar-sm flex-shrink-0">
                                                                    <div class="dropdown d-inline-block">
                                                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <i class="ri-more-fill align-middle"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu dropdown-menu-end">

                                                                            <li>
                                                                                <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:(0);" data-id="3" onclick="facility_filter_list(this)" class="dropdown-item edit-item-btn">
                                                                                    <i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                                    View Lists
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div> <!-- end row-->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Count of Collateral By Currency</h4>
                                </div><!-- end card header -->
                                <div class="card-header p-0 border-0 bg-soft-light">
                                    <div class="row g-0 text-center" id="collateral_data_row">


                                        <!--end col-->
                                    </div>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <div>
                                        <div id="audiences_metrics_charts" class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Loan Classification by Collateral Category </h4>
                                    <span id="test_response"></span>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div id="column_group_labels" data-colors='["--vz-danger", "--vz-primary", "--vz-success"]' class="apex-charts" dir="ltr"></div>
                                </div><!-- end card-body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                    </div><!-- end row -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Current Lists of Collaterals</h5>
                                </div>
                                <div class="card-body">
                                    <table id="buttons-datatables" class="display table buttons-datatables btn-tables table-responsive" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Collateral Code</th>
                                                <th>Facility Type</th>
                                                <th>Facility Disbursement Amt</th>
                                                <th>Classification</th>
                                                <th>Collateral Description</th>
                                                <th>Collateral Currency</th>
                                                <th>Collateral Value</th>
                                                <th>Branch</th>
                                                <th>More</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            foreach ($collateral_lists as $cll) {
                                            ?>

                                                <tr>
                                                    <td><?php echo $cll['collateral_code']; ?></td>
                                                    <td><?php echo $cll['facility_type']; ?></td>
                                                    <td><?php echo $cll['facility_disbursement_amt']; ?></td>
                                                    <td><?php echo $cll['classification']; ?></td>
                                                    <td><?php echo $cll['collateral_description']; ?></td>
                                                    <td><?php echo $cll['collateral_currency']; ?></td>
                                                    <td><?php echo $cll['collateral_value']; ?></td>
                                                    <td><?php echo $cll['branch_name']; ?></td>
                                                    <td>
                                                        <div class="dropdown d-inline-block">
                                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-fill align-middle"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">

                                                                <li>
                                                                    <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:(0);" data-id="<?php echo $cll['liability_number']; ?>" onclick="facility_details(this)" class="dropdown-item edit-item-btn">
                                                                        <i class="ri-home-fill align-bottom me-2 text-muted"></i>
                                                                        Facility Details
                                                                    </a>
                                                                </li>

                                                                <!--<li>
                                                                    <a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                        Customer Details
                                                                    </a>
                                                                </li>
                                            -->
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>

                                            <?php
                                            }
                                            ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Collateral Code</th>
                                                <th>Facility Type</th>
                                                <th>Facility Disbursement Amt</th>
                                                <th>Classification</th>
                                                <th>Collateral Description</th>
                                                <th>Collateral Currency</th>
                                                <th>Collateral Value</th>
                                                <th>Branch</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

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

    <script src="apps/template/statics/assets/js/pages/apexcharts-column.init.js"></script>
    <script src="apps/template/statics/assets/js/pages/apexcharts-new_pie.js"></script>

    <script src="apps/dashboard/js/extra.js"></script>

</body>

</html>