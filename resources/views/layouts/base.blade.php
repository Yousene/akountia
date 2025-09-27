<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta name="description"
        content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google." />
    <meta name="keywords"
        content="materialize, admin template, dashboard template, flat admin template, responsive admin template, eCommerce dashboard, analytic dashboard" />
    <meta name="author" content="ThemeSelect" />
    <title>
        Tawssil
    </title>
    <link rel="apple-touch-icon" href="/assets/images/favicon/apple-touch-icon-152x152.png" />
    <link rel="shortcut icon" type="image/x-icon" href="/assets/images/favicon/favicon-32x32.png" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/vendors/vendors.min.css" />
    <!-- END: VENDOR CSS-->
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/css/themes/vertical-dark-menu-template/materialize.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/themes/vertical-dark-menu-template/style.css" />

    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/css/custom/custom.css" />

    <link rel="stylesheet" type="text/css" href="/assets/vendors/hover-effects/media-hover-effects.css">

    <link rel="stylesheet" type="text/css" href="/assets/vendors/data-tables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="/assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/vendors/data-tables/css/dataTables.checkboxes.css">
    <link rel="stylesheet" type="text/css" href="/assets/vendors/fullcalendar/css/fullcalendar.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/vendors/fullcalendar/daygrid/daygrid.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/vendors/fullcalendar/timegrid/timegrid.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/pages/app-calendar.min.css">


    <link rel="stylesheet" href="/assets/vendors/select2/select2.min.css" type="text/css">
    <link rel="stylesheet" href="/assets/vendors/select2/select2-materialize.css" type="text/css">

    <!-- END: Custom CSS-->

    @yield('css')
</head>
<!-- END: Head-->

<style>
.sidenav li>a>i.material-icons,
.sidenav li a.collapsible-header>i.material-icons {
    font-size: 24px;
}

input[type=number] {
    height: 30px;
    line-height: 30px;
    font-size: 16px;
    padding: 0 8px;
}

input[type=number]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    cursor: pointer;
    display: block;
    width: 8px;
    color: #333;
    text-align: center;
    position: relative;

}

input[type=number]::-webkit-inner-spin-button {
    opacity: 1;
    background: #eee url('/assets/images/icon/YYySO.png') no-repeat 50% 50%;
    width: 14px;
    height: 14px;
    padding: 4px;
    position: relative;
    right: 4px;
    border-radius: 28px;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
    border-color: rgb(25 145 145) transparent transparent;
}
</style>

<body class="
            vertical-layout
            page-header-light
            vertical-menu-collapsible vertical-dark-menu
            preload-transitions
            2-columns
        " data-open="click" data-menu="vertical-dark-menu" data-col="2-columns">

    <!-- END: Header-->
    <ul class="display-none" id="default-search-main">
        <li class="auto-suggestion-title">
            <a class="collection-item" href="#">
                <h6 class="search-title">FILES</h6>
            </a>
        </li>
        <li class="auto-suggestion">
            <a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar">
                            <img src="/assets/images/icon/pdf-image.png" width="24" height="30" alt="sample image" />
                        </div>
                        <div class="member-info display-flex flex-column">
                            <span class="black-text">Two new item submitted</span><small class="grey-text">Marketing
                                Manager</small>
                        </div>
                    </div>
                    <div class="status">
                        <small class="grey-text">17kb</small>
                    </div>
                </div>
            </a>
        </li>
        <li class="auto-suggestion">
            <a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar">
                            <img src="/assets/images/icon/doc-image.png" width="24" height="30" alt="sample image" />
                        </div>
                        <div class="member-info display-flex flex-column">
                            <span class="black-text">52 Doc file Generator</span><small class="grey-text">FontEnd
                                Developer</small>
                        </div>
                    </div>
                    <div class="status">
                        <small class="grey-text">550kb</small>
                    </div>
                </div>
            </a>
        </li>
        <li class="auto-suggestion">
            <a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar">
                            <img src="/assets/images/icon/xls-image.png" width="24" height="30" alt="sample image" />
                        </div>
                        <div class="member-info display-flex flex-column">
                            <span class="black-text">25 Xls File Uploaded</span><small class="grey-text">Digital
                                Marketing Manager</small>
                        </div>
                    </div>
                    <div class="status">
                        <small class="grey-text">20kb</small>
                    </div>
                </div>
            </a>
        </li>
        <li class="auto-suggestion">
            <a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar">
                            <img src="/assets/images/icon/jpg-image.png" width="24" height="30" alt="sample image" />
                        </div>
                        <div class="member-info display-flex flex-column">
                            <span class="black-text">Anna Strong</span><small class="grey-text">Web Designer</small>
                        </div>
                    </div>
                    <div class="status">
                        <small class="grey-text">37kb</small>
                    </div>
                </div>
            </a>
        </li>
        <li class="auto-suggestion-title">
            <a class="collection-item" href="#">
                <h6 class="search-title">MEMBERS</h6>
            </a>
        </li>
        <li class="auto-suggestion">
            <a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar">
                            <img class="circle" src="/assets/images/avatar/avatar-7.png" width="30"
                                alt="sample image" />
                        </div>
                        <div class="member-info display-flex flex-column">
                            <span class="black-text">John Doe</span><small class="grey-text">UI designer</small>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <li class="auto-suggestion">
            <a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar">
                            <img class="circle" src="/assets/images/avatar/avatar-8.png" width="30"
                                alt="sample image" />
                        </div>
                        <div class="member-info display-flex flex-column">
                            <span class="black-text">Michal Clark</span><small class="grey-text">FontEnd
                                Developer</small>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <li class="auto-suggestion">
            <a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar">
                            <img class="circle" src="/assets/images/avatar/avatar-10.png" width="30"
                                alt="sample image" />
                        </div>
                        <div class="member-info display-flex flex-column">
                            <span class="black-text">Milena Gibson</span><small class="grey-text">Digital
                                Marketing</small>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <li class="auto-suggestion">
            <a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar">
                            <img class="circle" src="/assets/images/avatar/avatar-12.png" width="30"
                                alt="sample image" />
                        </div>
                        <div class="member-info display-flex flex-column">
                            <span class="black-text">Anna Strong</span><small class="grey-text">Web Designer</small>
                        </div>
                    </div>
                </div>
            </a>
        </li>
    </ul>
    <ul class="display-none" id="page-search-title">
        <li class="auto-suggestion-title">
            <a class="collection-item" href="#">
                <h6 class="search-title">PAGES</h6>
            </a>
        </li>
    </ul>
    <ul class="display-none" id="search-not-found">
        <li class="auto-suggestion">
            <a class="collection-item display-flex align-items-center" href="#"><span
                    class="material-icons">error_outline</span><span class="member-info">No results found.</span></a>
        </li>
    </ul>


    <!-- BEGIN: Page Main-->
    <div id="main" style="padding-left:0px;">
        @yield('content')
    </div>
    <!-- END: Page Main-->

    <!-- BEGIN: Footer-->


    <!-- END: Footer-->
    <!-- BEGIN VENDOR JS-->
    <script src="/assets/js/vendors.min.js"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="/assets/vendors/chartjs/chart.min.js"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN THEME  JS-->
    <script src="/assets/js/plugins.js"></script>
    <script src="/assets/js/search.js"></script>
    <script src="/assets/js/custom/custom-script.js"></script>

    <script src="/assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <script src="/assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/vendors/data-tables/js/datatables.checkboxes.min.js"></script>

    <script src="/assets/vendors/select2/select2.full.min.js"></script>

    <script src="/assets/js/vue3.prod.js"></script>


    <!-- END THEME  JS-->

    <!-- BEGIN PAGE LEVEL JS
     -->
    <!-- END PAGE LEVEL JS-->


    <script>
    $(document).ready(function() {

        $('.timepicker').timepicker({
            twelveHour: false,
            showClearBtn: true,
            autoClose: true,
            showView: 'hours',
            i18n: {
                months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août',
                    'Septembre', 'Octobre', 'Novembre', 'Décembre'
                ],

                monthsShort: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jui', 'Jui', 'Aoû', 'Sep', 'Oct',
                    'Nov', 'Déc'
                ],
                weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                today: 'Aujourd\'hui',
                cancel: 'Annuler',
                done: 'OK',
                clear: 'Effacer'
            }
        });
        $('.datepicker').datepicker({
            firstDay: true,
            format: 'yyyy-mm-dd',
            clear: 'effacer',
            formatSubmit: 'yyyy/mm/dd',
            showClearBtn: true,
            autoClose: true,
            i18n: {
                months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août',
                    'Septembre', 'Octobre', 'Novembre', 'Décembre'
                ],
                monthsShort: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jui', 'Jui', 'Aoû', 'Sep', 'Oct',
                    'Nov', 'Déc'
                ],
                weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                today: 'Aujourd\'hui',
                cancel: 'Annuler',
                done: 'OK',
                clear: 'Effacer'
            }
        });
        $(".select2").select2({
            dropdownAutoWidth: true,
            width: '100%'
        });

        const App = {
            mounted() {
                this.loadData();
                $('.tooltipped').tooltip();
            },
            methods: {
                loadData() {
                    if ($("#list-datatable").length > 0) {
                        $("#list-datatable").DataTable({
                            "aaSorting": [
                                [0, "desc"]
                            ],
                            "language": {
                                url: '/assets/vendors/data-tables/i18n/fr_fr.json'
                            }
                        });
                    };

                },
            },
        }

        Vue.createApp(App).mount('#app');

    });
    </script>

    @yield('js')

</body>

</html>