<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>AdminLTE</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?=public_path()?>css/admin/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?=public_path()?>css/admin/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?=public_path()?>css/admin/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <!--  link href="<?=public_path()?>css/admin/morris/morris.css" rel="stylesheet" type="text/css" /-->
        <!-- jvectormap -->
        <link href="<?=public_path()?>css/admin/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- fullCalendar -->
        <link href="<?=public_path()?>css/admin/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
		<!-- datatable -->
        <link href="<?=public_path()?>css/admin/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?=public_path()?>css/admin/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?=public_path()?>css/admin/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

		<?php if ($this->router->fetch_class() == "deal") { ?>
			<link href="<?=public_path()?>css/admin/tagedit/jquery.tagedit.css" rel="stylesheet" type="text/css" />
		<?php } ?>

		<?php if (in_array($this->router->fetch_method(), array("add","edit"))) { ?>
			<link href="<?=public_path()?>css/admin/validation/validationEngine.css" rel="stylesheet" type="text/css" />
		<?php }?>

        <!-- Theme style -->
        <link href="<?=public_path()?>css/admin/AdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
