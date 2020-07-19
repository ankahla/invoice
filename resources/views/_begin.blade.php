<!DOCTYPE html>
<html lang="fr">
<head>
	<title>{{ trans('invoice.app_name') }}</title>
	<meta charset="utf-8">
    <link rel="icon" href="public/img/favicon.ico" type="image/x-icon" />
	<!-- META -->
	<meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- END META -->

	<!-- FONTS -->
	<link href='http://fonts.googleapis.com/css?family=Dosis:400,500,600' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
	<!-- END FONTS -->

@section('stylesheets')
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/select2/select2.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/select2/select2-bootstrap.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datepicker/css/datepicker.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/timepicker/css/bootstrap-timepicker.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap-fileinput/css/fileinput.min.css') }}">

	<link rel="stylesheet" type="text/css" href="{{ asset('css/design.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/website.css') }}">
	<!-- END CSS -->
@show
</head>
<body>