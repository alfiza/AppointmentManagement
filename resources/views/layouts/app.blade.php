<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AppointmentManager') }}</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> -->

    <!-- timepicker -->
    <link rel="stylesheet" href="{{ asset('include/ui-1.10.0/ui-lightness/jquery-ui-1.10.0.custom.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('js_css/jquery.ui.timepicker.css?v=0.3.3') }}" type="text/css" />
    <script type="text/javascript" src="{{ asset('include/jquery-1.9.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('include/ui-1.10.0/jquery.ui.core.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('include/ui-1.10.0/jquery.ui.widget.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('include/ui-1.10.0/jquery.ui.tabs.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('include/ui-1.10.0/jquery.ui.position.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js_css/jquery.ui.timepicker.js?v=0.3.3') }}"></script>
    <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
    <!-- /timepicker -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>.modal-dialog{left: 0% !important;} #info_div{z-index: 1060;}
    .validate_td{border:2.5px solid red;}
    .ui-timepicker{font-size:10px}
    
</style>
<body>
    <div class="modal" id="info_div" tabindex="-1" role="dialog" aria-labelledby="info_div_title" aria-hidden="true"  data-backdrop="static"  aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="info_div_title">Info</h5>
                <span class='btn btn-danger a-btn-slide-text glyphicon glyphicon-remove' aria-hidden='true' onClick="$('#info_div').hide()"></span>
            </div>
            <div class="modal-body">
                <span id="info_msg"></span>
            </div>
            <div class="modal-footer">
                <button type="button" id="info_popup_btn" class="btn btn-secondary" onClick="$('#info_div').hide()">Ok</button>
            </div>
            </div>
        </div>
    </div>  
    <div class="modal" id="delete_confirm_div" tabindex="-1" role="dialog" aria-labelledby="delete_div_title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete_div_title">Delete Confirmation</h5>
                <span class='btn btn-danger a-btn-slide-text glyphicon glyphicon-remove' aria-hidden='true' onClick="$('#delete_confirm_div').hide()"></span>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete appointment details of <span id="module_title"></span> ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" id='delete-btn-conf'>Yes</button>
                <button type="button" class="btn btn-secondary" onClick="$('#delete_confirm_div').hide()">No</button>
            </div>
            </div>
        </div>
    </div>  
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                
                <a class="navbar-brand" href="{{ url('/') }}">Dashboard</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

</body>
</html>
