<!DOCTYPE html>
<html>
<head>
    <META content="IE=11.0000" http-equiv="X-UA-Compatible">
    <meta charset="UTF-8">
    <base href="<?php echo BASE_HREF; ?>"/>
    <title><?php echo APP_TITLE; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="assets/_layout/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="assets/_layout/plugins/animate/animate.css">
    <link href="assets/_layout/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>
    <!-- font Awesome -->
    <link href="assets/_layout/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <!-- Ionicons -->
    <link href="assets/_layout/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <script src="assets/_layout/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="assets/_layout/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Daterange picker -->
    <link href="assets/_layout/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="assets/_layout/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css"/>
    <!-- DATA TABLES -->
    <!--        <link href="assets/_layout/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" /> -->
    <link href="assets/_layout/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="assets/_layout/plugins/bootstrap-select/css/bootstrap-select.min.css">

    <!-- SISENSE
    <script type="text/javascript" src="http://192.168.133.133:8081/js/sisense.js"></script>
    <script src="https://d3js.org/d3.v4.min.js"></script>-->
    <!-- Theme style -->
    <link href="assets/_layout/css/AdminLTE.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="assets/_layout/css/daterangepicker/daterangepicker.css">
    <!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="assets/_layout/js/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="assets/_layout/js/plugins/fullcalendar/fullcalendar.print.css" media="print">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="assets/_layout/css/jquery-ui.css">
    <script src="assets/_layout/js/jquery-1.10.2.js"></script>

    <!--<script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>-->
    <style>
        #myModal .modal-dialog {
            width: 70%;
        }

        .back-to-top {
            cursor: pointer;
            position: fixed;
            bottom: 20px;
            left: 20px;
            display: none;
        }
    </style>
    <style type="text/css">
        .bootstrap-tagsinput {
            width: 100%;
        }

        .label {
            line-height: 2 !important;
        }
    </style>
    <script type="text/javascript">
        $(window).load(function () {
            $(".loader").fadeOut("slow");
        })
    </script>
</head>