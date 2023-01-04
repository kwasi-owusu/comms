<?php
!isset($_SESSION) ? session_start() : null;

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!doctype html>

<html lang="en" data-layout="horizontal" data-layout-style="" data-layout-position="fixed" data-topbar="light">

<head>

    <meta charset="utf-8" />
    <title>Bsystems - Collateral Reporting Analytics Solution</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Agency Banking System" name="description" />
    <meta content="Bsystems Limited" name="author" />
    <meta http-equiv="refresh" content="1500; url=logout" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="apps/template/statics/assets/images/favicon.png">

    <!-- plugin css -->
    <link href="apps/template/statics/assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="apps/template/statics/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="apps/template/statics/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="apps/template/statics/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="apps/template/statics/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="apps/template/statics/assets/css/custom.min.css" rel="stylesheet" type="text/css" />

    <link href="apps/template/statics/assets/loaders/custom-loader.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="apps/template/statics/assets/toast/css/jquery.toast.css" />

    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" />

    <style>
        tfoot input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }
    </style>
</head>