<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google.">
    <meta name="keywords"
        content="materialize, admin template, dashboard template, flat admin template, responsive admin template, eCommerce dashboard, analytic dashboard">
    <meta name="author" content="ThemeSelect">
    <title>GOTAWSIL</title>
    <link rel="apple-touch-icon" href="/assets/images/favicon/apple-touch-icon-152x152.png">
    <link rel="shortcut icon" type="image/x-icon" href="/assets/images/favicon/favicon-32x32.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/vendors/vendors.min.css">
    <!-- END: VENDOR CSS-->
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/css/themes/horizontal-menu-template/materialize.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/themes/horizontal-menu-template/style.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/layouts/style-horizontal.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/pages/dashboard.css">


    <link rel="stylesheet" type="text/css" href="/assets/vendors/fullcalendar/css/fullcalendar.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/vendors/fullcalendar/daygrid/daygrid.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/vendors/fullcalendar/timegrid/timegrid.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/pages/app-calendar.min.css">
    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/css/custom/custom.css">
    <!-- END: Custom CSS-->


    <link rel="stylesheet" type="text/css" href="/assets/vendors/data-tables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="/assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/vendors/data-tables/css/dataTables.checkboxes.css">
    <link rel="stylesheet" href="/assets/vendors/select2/select2.min.css" type="text/css">
    <link rel="stylesheet" href="/assets/vendors/select2/select2-materialize.css" type="text/css">

</head>
<!-- END: Head-->
<style>
    #breadcrumbs-wrapper {

        top: -0.7px;

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
        background: #eee url('/assets/images/icon/YYySO_client.png') no-repeat 50% 50%;
        width: 14px;
        height: 14px;
        padding: 4px;
        position: relative;
        right: 4px;
        border-radius: 28px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: rgb(200 21 55) transparent transparent;
    }

    .activate {
        background-color: grey !important;

    }

    .activate span,
    .activate .material-icons {
        color: white !important;
    }

    .sidenav li a {
        font-size: 18px;
        font-weight: 800;
        margin-top: 10px;
    }

    .sidenav li a .material-icons {
        color: #c81537 !important;
        font-size: 30px !important;
    }

    @media only screen and (max-width: 600px) {
        .navbar .nav-wrapper .dropdown-content {
            left: 50% !important;
        }
    }
</style>

<body class="horizontal-layout page-header-light horizontal-menu preload-transitions 2-columns   " data-open="click"
    data-menu="horizontal-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <header class="page-topbar" id="header">
        <div class="navbar navbar-fixed">
            <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-dark"
                style="background: linear-gradient(45deg, #c81537, #7e1529) !important;">
                <div class="nav-wrapper">
                    <ul class="left">
                        <li>
                            <h1 class="logo-wrapper"><a class="brand-logo darken-1 hide-on-small-only"
                                    href="javascript:void(0)"><img src="/assets/images/logo/logo_GoTawsil_vertical.png"
                                        alt="materialize logo"></a></h1>
                        </li>
                    </ul>
                    <div class="header-search-wrapper hide-on-med-and-down"><i class="material-icons">search</i>
                        <form action="{{ route('expedition_list') }}">
                            <input class="header-search-input z-depth-2" type="text" name="exp" placeholder="Recherche"
                                data-search="template-list" />
                        </form>
                        <ul class="search-list collection display-none"></ul>
                    </div>
                    <ul class="navbar-list right valign-wrapper">
                        <li class="dropdown-language"><a class="waves-effect waves-block waves-light translation-button"
                                href="javascript:void(0);" data-target="translation-dropdown"><span
                                    class="flag-icon flag-icon-fr"></span></a></li>
                        <li class="hide-on-med-and-down"><a
                                class="waves-effect waves-block waves-light toggle-fullscreen"
                                href="javascript:void(0);"><i class="material-icons">settings_overscan</i></a></li>
                        <li class="hide-on-large-only"><a class="waves-effect waves-block waves-light search-button"
                                href="javascript:void(0);"><i class="material-icons">search </i></a></li>
                        <li> <a class="waves-effect waves-block waves-light search-button"
                                href="{{ route('reclamation_list') }}"><i class="material-icons tooltipped"
                                    data-position="bottom" data-tooltip="Reclamations">notifications<small
                                        class="notification-badge"><span id="new_reclamationClient">0</small></i></a>
                        </li>
                        <li>

                            <a class="
            waves-effect waves-block waves-light
            profile-button
        "
                                href="javascript:void(0);" data-target="profile-dropdown"
                                style="margin-bottom: 10px;"><span class="avatar-status avatar-online"><img
                                        src="{{ Auth::user()->photo ? '/uploads/photos/' . Auth::user()->photo : '/uploads/photos/default.png' }}"
                                        alt="avatar" /><i></i></span></a>

                        </li>
                    </ul>
                    <!-- translation-button-->
                    <ul class="dropdown-content" id="translation-dropdown">
                        <li class="dropdown-item"><a class="grey-text text-darken-1" href="#!"
                                data-language="fr"><i class="flag-icon flag-icon-fr"></i> Français</a></li>
                    </ul>
                    <!-- notifications-dropdown-->
                    <ul class="dropdown-content" id="notifications-dropdown">
                        <li>
                            <h6>NOTIFICATIONS<span class="new badge">5</span></h6>
                        </li>
                        <li class="divider"></li>
                        <li><a class="black-text" href="#!"><span
                                    class="material-icons icon-bg-circle cyan small">add_shopping_cart</span> A new
                                order has been placed!</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">2 hours
                                ago</time>
                        </li>
                        <li><a class="black-text" href="#!"><span
                                    class="material-icons icon-bg-circle red small">stars</span> Completed the task</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">3 days
                                ago</time>
                        </li>
                        <li><a class="black-text" href="#!"><span
                                    class="material-icons icon-bg-circle teal small">settings</span> Settings
                                updated</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">4 days
                                ago</time>
                        </li>
                        <li><a class="black-text" href="#!"><span
                                    class="material-icons icon-bg-circle deep-orange small">today</span> Director
                                meeting started</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">6 days
                                ago</time>
                        </li>
                        <li><a class="black-text" href="#!"><span
                                    class="material-icons icon-bg-circle amber small">trending_up</span> Generate
                                monthly report</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">1 week
                                ago</time>
                        </li>
                    </ul>
                    <!-- profile-dropdown-->
                    <ul class="dropdown-content" id="profile-dropdown" style="width: 260px !important;">

                        <li><a class="grey-text text-darken-1" href="{{ route('user.profil') }}"><i
                                    class="material-icons"></i>

                                <i class="material-icons">person_outline</i> Mon profil</a></li>

                        <li><a class="grey-text text-darken-1" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="material-icons">keyboard_tab</i>
                                Se déconnecter</a></li>





                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>




                    </ul>
                </div>
                <nav class="display-none search-sm">
                    <div class="nav-wrapper">
                        <form id="navbarForm">
                            <div class="input-field search-input-sm">
                                <input class="search-box-sm" type="search" required="" id="search"
                                    placeholder="Explore Materialize" data-search="template-list">
                                <label class="label-icon" for="search"><i
                                        class="material-icons search-sm-icon">search</i></label><i
                                    class="material-icons search-sm-close">close</i>
                                <ul class="search-list collection search-list-sm display-none"></ul>
                            </div>
                        </form>
                    </div>
                </nav>
            </nav>
            <!-- BEGIN: Horizontal nav start-->
            <nav class="white hide-on-med-and-down" id="horizontal-nav">
                <div class="nav-wrapper">
                    <ul class="left hide-on-med-and-down" id="ul-horizontal-nav" data-menu="menu-navigation">
                        <li><a id="dashboard" href="{{ route('Dashboard_Client') }}"><i
                                    class="material-icons">dashboard</i><span>Tableau de bord</span></a>

                        </li>
                        <li><a id="saisie" href="{{ route('expedition_insert') }}"><i
                                    class="material-icons">add_circle</i><span>Saisie Expédition</span></a>

                        </li>
                        <li><a id="ramassage" href="{{ route('bon_list_ram') }}"><i
                                    class="material-icons">directions_car</i><span>Ramassage</span></a>

                        </li>
                        <li><a id="bon_ramassage" href="{{ route('client_ram_bon') }}"><i
                                    class="material-icons">book</i><span>Bon Ramassage</span></a>

                        </li>
                        <li><a id="expeditions" href="{{ route('expedition_list') }}"><i
                                    class="material-icons">list</i><span>Mes expéditions</span></a>

                        </li>

                        <li><a id="remboursement" href="{{ route('remboursement_list') }}"><i
                                    class="material-icons">monetization_on</i><span>Remboursement</span></a>

                        </li>
                        {{-- <li><a class="dropdown-menu" href="Javascript:void(0)" data-target="CssDropdown"><i
                                    class="material-icons">settings_backup_restore</i><span><span class="dropdown-title"
                                        data-i18n="CSS">Retour BL</span><i
                                        class="material-icons right">keyboard_arrow_down</i></span></a>
                            <ul class="dropdown-content dropdown-horizontal-list" id="CssDropdown">
                            </ul>
                        </li> --}}

                        <li><a id="factures" href="{{ route('facture_list_client') }}"><i
                                    class="material-icons">receipt</i><span>Factures</span></a>

                        </li>



                        <li><a id="reclamation" href="{{ route('reclamation_list') }}"><i
                                    class="material-icons">record_voice_over</i><span>Réclamation</span></a>

                        </li>
                        <li><a id="calendrie" href="{{ route('user_calendar') }}"><i
                                    class="material-icons">date_range</i><span>Calendrier</span></a>
                            {{-- <ul class="dropdown-content dropdown-horizontal-list" id="calendarform"> --}}
                            {{-- <a href="{{route('user_calendar')}}">
                        <li>List</li></a> --}}
                            {{-- </ul> --}}
                        </li>
                    </ul>
                </div>
                <!-- END: Horizontal nav start-->
            </nav>
        </div>
    </header>
    <!-- END: Header-->
    <ul class="display-none" id="default-search-main">
        <li class="auto-suggestion-title"><a class="collection-item" href="#">
                <h6 class="search-title">FILES</h6>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img src="/assets/images/icon/pdf-image.png" width="24"
                                height="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">Two new item
                                submitted</span><small class="grey-text">Marketing Manager</small></div>
                    </div>
                    <div class="status"><small class="grey-text">17kb</small></div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img src="/assets/images/icon/doc-image.png" width="24"
                                height="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">52 Doc file
                                Generator</span><small class="grey-text">FontEnd Developer</small></div>
                    </div>
                    <div class="status"><small class="grey-text">550kb</small></div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img src="/assets/images/icon/xls-image.png" width="24"
                                height="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">25 Xls File
                                Uploaded</span><small class="grey-text">Digital Marketing Manager</small></div>
                    </div>
                    <div class="status"><small class="grey-text">20kb</small></div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img src="/assets/images/icon/jpg-image.png" width="24"
                                height="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">Anna
                                Strong</span><small class="grey-text">Web Designer</small></div>
                    </div>
                    <div class="status"><small class="grey-text">37kb</small></div>
                </div>
            </a></li>
        <li class="auto-suggestion-title"><a class="collection-item" href="#">
                <h6 class="search-title">MEMBERS</h6>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img class="circle" src="/assets/images/avatar/avatar-7.png"
                                width="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">John
                                Doe</span><small class="grey-text">UI designer</small></div>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img class="circle" src="/assets/images/avatar/avatar-8.png"
                                width="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">Michal
                                Clark</span><small class="grey-text">FontEnd Developer</small></div>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img class="circle" src="/assets/images/avatar/avatar-10.png"
                                width="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">Milena
                                Gibson</span><small class="grey-text">Digital Marketing</small></div>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img class="circle" src="/assets/images/avatar/avatar-12.png"
                                width="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">Anna
                                Strong</span><small class="grey-text">Web Designer</small></div>
                    </div>
                </div>
            </a></li>
    </ul>
    <ul class="display-none" id="page-search-title">
        <li class="auto-suggestion-title"><a class="collection-item" href="#">
                <h6 class="search-title">PAGES</h6>
            </a></li>
    </ul>
    <ul class="display-none" id="search-not-found">
        <li class="auto-suggestion"><a class="collection-item display-flex align-items-center" href="#"><span
                    class="material-icons">error_outline</span><span class="member-info">No results found.</span></a>
        </li>
    </ul>



    <!-- BEGIN: SideNav-->
    <aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-fixed hide-on-large-only">
        <div class="brand-sidebar sidenav-light"></div>

        <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed hide-on-large-only menu-shadow"
            id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
            <h5 style="margin:16px;margin-block:25px;color:#1991ce!important"><a  href="{{ route('user.profil') }}"><i class="material-icons left"
                    style="font-size: 30px!important">account_circle</i>{{ Auth::user()->ClientDetail->libelle }}
                </a></h5>
            <hr>
            <li class="bold"><a class="waves-effect waves-cyan" href="{{ route('Dashboard_Client') }}"><i
                        class="material-icons">settings_input_svideo</i>Dashboard</a>
            </li>
            <li class="bold"><a class="waves-effect waves-cyan" href="{{ route('expedition_insert') }}"><i
                        class="material-icons">add_circle</i>Saisie Expédition</a>
            </li>
            <li class="bold"><a class="waves-effect waves-cyan" href="{{ route('bon_list_ram') }}"><i
                        class="material-icons">directions_car</i>Ramassage</a>
            </li>
            <li class="bold"><a class="waves-effect waves-cyan" href="{{ route('client_ram_bon') }}"><i
                        class="material-icons">book</i>Bon Ramassage</a>
            </li>
            <li class="bold"><a class="waves-effect waves-cyan" href="{{ route('expedition_list') }}"><i
                        class="material-icons">list</i>Mes Expéditions</a>
            </li>
            <li class="bold"><a class="waves-effect waves-cyan" href="{{ route('remboursement_list') }}"><i
                        class="material-icons">monetization_on</i>Remboursement</a>
            </li>
            <li class="bold"><a class="waves-effect waves-cyan" href="{{ route('facture_list_client') }}"><i
                        class="material-icons">receipt</i>Factures</a>
            </li>
            <li class="bold"><a class="waves-effect waves-cyan" href="{{ route('reclamation_list') }}"><i
                        class="material-icons">record_voice_over</i>Réclamation</a>
            </li>
            <li class="bold" style="margin-bottom: 15px;"><a class="waves-effect waves-cyan" href="{{ route('user_calendar') }}"><i
                        class="material-icons">date_range</i>Calendrier</a>
            </li>

            <hr>
            <li class="bold"><a class="waves-effect waves-cyan" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();"><i
                        class="material-icons ">exit_to_app</i>Se déconnecter</a>
            </li>

        </ul>
        <div class="navigation-background"></div><a
            class="sidenav-trigger btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#"
            data-target="slide-out"><i class="material-icons">menu</i></a>
    </aside>
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        @yield('content')
    </div>
    <!-- END: Page Main-->

    <!-- BEGIN: Footer-->

    <footer class="page-footer footer footer-static footer-dark gradient-shadow navbar-border navbar-shadow">
        <div class="footer-copyright">
            <div class="container"><span>&copy; <?php echo date('Y'); ?> <a href="javascript:void()">GO TAWSSIL</a> All
                    rights reserved.</span><span class="right hide-on-small-only">Design and Developed by <a
                        href="javascript:void()">GO TAWSSIL</a></span></div>
        </div>
    </footer>

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

    <script src="/assets/js/scripts/dashboard-ecommerce.js"></script>
    <script>
        $(document).ready(function() {

            $.get("/new-reclamation-client-count", function(data, status) {
                $('#new_reclamationClient').html(JSON.parse(data).newRec);
            });
            setInterval(function() {
                $.get("/new-reclamation-client-count", function(data, status) {
                    $('#new_reclamationClient').html(JSON.parse(data).newRec);
                });
            }, 5000);

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
