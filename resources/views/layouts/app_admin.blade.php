<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" direction="rtl" dir="rtl" style="direction: rtl">

<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Updates and statistics">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--begin::Page Vendors Styles(used by this page) -->
    <link href="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet"
          type="text/css"/>

    {{--Custom--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet"
          type="text/css"/>


    <!--end::Page Vendors Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{asset('assets/plugins/global/plugins.bundle.rtl.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css"/>

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{asset('assets/css/skins/header/base/light.rtl.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/skins/header/menu/light.rtl.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/skins/brand/dark.rtl.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/skins/aside/dark.rtl.css')}}" rel="stylesheet" type="text/css"/>

    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}"/>

    <!-- Scripts -->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<!-- end::Head -->

<!-- begin::Body -->
<body class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-aside--enabled kt-aside--fixed kt-page--loading">

@include('partials._page-loader')

<!-- begin:: Page -->

@include('partials.header._base-mobile')

<div id="app">

    <div class="kt-grid kt-grid--hor kt-grid--root">

        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

            @include('partials.aside._base')

            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

                @include('partials.header._base')

                <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                    <!-- begin:: Content -->
                    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

                        @include('components.flash')

                        @yield('content')

                    </div>

                </div>

                @include('partials._footer')

            </div>

        </div>

    </div>

</div>
<!-- end:: Page -->

@include('partials.topbar.offcanvas._search')

@include('partials.topbar.offcanvas._notifications')

@include('partials._quick-panel')

@include('partials._scrolltop')

@include('partials._toolbar')

@include('partials._demo-panel')

@include('partials._chat')

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": [
                    "#c5cbe3",
                    "#a1a8c3",
                    "#3d4465",
                    "#3e4466"
                ],
                "shape": [
                    "#f0f3ff",
                    "#d9dffa",
                    "#afb4d4",
                    "#646c9a"
                ]
            }
        }
    };
</script>


<!--begin::Global Theme Bundle(used by all pages) -->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}" type="text/javascript"></script>
<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->
<script src="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this page) -->
<script src="{{asset('assets/js/pages/dashboard.js')}}" type="text/javascript"></script>

<!--end::Page Scripts -->


<script src="{{asset('assets/js/pages/crud/forms/widgets/bootstrap-timepicker.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>


<script src="{{ asset('js/app.js') }}"></script>


<script>
    $(document).ready(function () {
        $('#datatbl').DataTable({
            paginate: false,
            responsive: true,
            language: {
                "sEmptyTable": "?????? ??????????????? ???? ???????? ???????? ??????????",
                "sInfo": "?????????? _START_ ???? _END_ ???? _TOTAL_ ????????",
                "sInfoEmpty": "?????????? 0 ???? 0 ???? 0 ????????",
                "sInfoFiltered": "(?????????? ?????? ???? _MAX_ ????????)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "?????????? _MENU_ ????????",
                "sLoadingRecords": "???? ?????? ????????????????...",
                "sProcessing": "???? ?????? ????????????...",
                "sSearch": "??????????:",
                "sZeroRecords": "???????????? ???? ?????? ???????????? ???????? ??????",
                "oPaginate": {
                    "sFirst": "????????????? ????????",
                    "sLast": "????????????? ??????",
                    "sNext": "????????",
                    "sPrevious": "????????"
                },
                "oAria": {
                    "sSortAscending": ": ???????? ???????? ?????????? ???? ???????? ??????????",
                    "sSortDescending": ": ???????? ???????? ?????????? ???? ???????? ??????????"
                }
            },
        });
        $('.bs-select').selectpicker({
            selectAllText: '???????????? ??????',
            deselectAllText: '?????? ???????? ??????',
        });
    });
</script>


</body>

<!-- end::Body -->
</html>
