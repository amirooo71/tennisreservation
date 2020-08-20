<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" direction="rtl" dir="rtl" style="direction: rtl">

<head>
    <meta charset="utf-8"/>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Updates and statistics">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}"/>

    <link href="{{asset('assets/plugins/global/plugins.bundle.rtl.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('assets/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body class="kt-page--loading-enabled kt-page--loading">

@include('partials._page-loader')

<div id="app" style="overflow: hidden;">

    <span class="btn btn-bold btn-sm btn-font-sm  btn-label-danger"
          style="position: absolute;">{{\Hekmatinasser\Verta\Verta::parse($date)->formatWord('l')}}</span>

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__body vh-100 tns-bg-darker-white">
            <table class="table table-bordered table-hover tns-bg-white booking-tbl" id="bookings-data-tbl">
                <thead>
                <tr>
                    <th scope="col" class="text-center tns-col-sticky">ساعت</th>
                    @foreach($courts as $court)
                        <th scope="col" class="text-center">{{$court->name}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($openingHours as $hour)
                    <tr is="bookings" :courts="{{$courts}}"
                        :hour="{{json_encode($hour)}}"
                        :date="{{json_encode($date)}}"></tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <booking-float-buttons :date="{{json_encode($date)}}"></booking-float-buttons>
    <booking-modal></booking-modal>
    <booking-manage-modal></booking-manage-modal>
    <slide-panel></slide-panel>
</div>

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

<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/app.js') }}"></script>

<script>
    $(document).ready(function () {
        window.table = $('#bookings-data-tbl').DataTable({
            scrollX: true,
            paginate: false,
            scrollY: window.innerHeight - 190 + "px",
            scrollCollapse: true,
            language: {
                "sEmptyTable": "هیچ داده‌ای در جدول وجود ندارد",
                "sInfo": "نمایش _START_ تا _END_ از _TOTAL_ ردیف",
                "sInfoEmpty": "نمایش 0 تا 0 از 0 ردیف",
                "sInfoFiltered": "(فیلتر شده از _MAX_ ردیف)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "نمایش _MENU_ ردیف",
                "sLoadingRecords": "در حال بارگزاری...",
                "sProcessing": "در حال پردازش...",
                "sSearch": "جستجو:",
                "sZeroRecords": "رکوردی با این مشخصات پیدا نشد",
                "oPaginate": {
                    "sFirst": "برگه‌ی نخست",
                    "sLast": "برگه‌ی آخر",
                    "sNext": "بعدی",
                    "sPrevious": "قبلی"
                },
                "oAria": {
                    "sSortAscending": ": فعال سازی نمایش به صورت صعودی",
                    "sSortDescending": ": فعال سازی نمایش به صورت نزولی"
                }
            },

        });
    });

</script>

</body>
</html>