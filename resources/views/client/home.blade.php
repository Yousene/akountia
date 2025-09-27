@extends($layout)

<style>
td,
th {

    border-radius: 0px !important;
}


.table-fill {
    background: white;
    border-radius: 3px;
    border-collapse: collapse;
    height: 320px;
    margin: auto;

    padding: 5px;
    width: 100%;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    animation: float 5s infinite;
}

.table-fill th {
    color: #fff;
    ;
    background: #c81537;
    border-bottom: 4px solid #9ea7af;
    border-right: 1px solid #fff;
    font-size: 23px;
    font-weight: 100;
    padding: 24px;
    text-align: left;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    vertical-align: middle;
}

.table-fill th:first-child {
    border-top-left-radius: 3px;
}

.table-fill th:last-child {
    border-top-right-radius: 3px;
    border-right: none;
}

.table-fill tr {
    border-top: 1px solid #C1C3D1;
    border-bottom-: 1px solid #C1C3D1;
    color: #666B85;
    font-size: 16px;
    font-weight: normal;
    text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
}

.table-fill tr:hover td {
    background: #1991ce;
    color: #FFFFFF;
    border-top: 1px solid #fff;
}

.table-fill tr:first-child {
    border-top: none;
}

.table-fill tr:last-child {
    border-bottom: none;
}

.table-fill tr:nth-child(odd) td {
    background: #EBEBEB;
}

.table-fill tr:nth-child(odd):hover td {
    background: #1991ce;
}

.table-fill tr:last-child td:first-child {
    border-bottom-left-radius: 3px;
}

.table-fill tr:last-child td:last-child {
    border-bottom-right-radius: 3px;
}

.table-fill td {
    background: #FFFFFF;
    padding: 20px;
    text-align: left;
    vertical-align: middle;
    font-weight: 300;
    font-size: 18px;
    text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
    border-right: 1px solid #C1C3D1;
}

.table-fill td:last-child {
    border-right: 0px;
}


</style>
@section('content')
<div class="row">
    <div class="col s12">
        <div class="container">

            <div class="section">
                {{-- <div class="card-alert card cyan lighten-5" style="margin-inline: 5px;">
                    <div class="card-content cyan-text darken-1">
                        <span class="card-title cyan-text darken-1">Promotions</span>
                        @foreach($promotions as $promotion)
                        <p class="black-text">
                            <span style="font-weight: 900">{{$promotion->libelle}} : </span>
                            {{$promotion->description}}
                        </p>
                        @endforeach
                    </div>
                    <button type="button" class="close cyan-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div> --}}

                <!--card stats start-->
                <div id="card-stats" class="pt-0">

                    <div class="row">

                        <div class="col s12 m6 l6 xl4">
                            <div
                                class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text animate fadeLeft">
                                <div class="padding-4">
                                    <div class="row">
                                        <div class="col s7 m7">
                                            <i class="material-icons background-round mt-5">add_shopping_cart</i>
                                            <p>Envois de ce mois</p>
                                        </div>
                                        <div class="col s5 m5 right-align">
                                            <h5 class="mb-0 white-text">{{$epx_cemois}}</h5>
                                            <p class="no-margin">Colis</p>
                                            {{--                                                <p>6,00,00</p>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6 l6 xl4">
                            <div
                                class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text animate fadeLeft">
                                <div class="padding-4">
                                    <div class="row">
                                        <div class="col s7 m7">
                                            <i class="material-icons background-round mt-5">assignment_return</i>
                                            <p>Retours de ce mois</p>
                                        </div>
                                        <div class="col s5 m5 right-align">
                                            <h5 class="mb-0 white-text">{{$Expedition_retours}}</h5>
                                            <p class="no-margin">Colis</p>
                                            {{--                                                <p>1,12,900</p>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6 l6 xl4">
                            <div
                                class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text animate fadeRight">
                                <div class="padding-4">
                                    <div class="row">
                                        <div class="col s7 m7">
                                            <i class="material-icons background-round mt-5">timeline</i>
                                            <p>Taux de retour du mois</p>
                                        </div>
                                        <div class="col s5 m5 right-align">
                                            <h5 class="mb-0 white-text">{{$taux_retour}} %</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6 l6 xl4">
                            <div
                                class="card gradient-45deg-green-teal gradient-shadow min-height-100 white-text animate fadeRight">
                                <div class="padding-4">
                                    <div class="row">
                                        <div class="col s7 m7">
                                            <i class="material-icons background-round mt-5">shopping_cart</i>
                                            <p>Colis en cours</p>
                                        </div>
                                        <div class="col s5 m5 right-align">
                                            <h5 class="mb-0 white-text">{{$expedition_encours}}</h5>
                                            <p class="no-margin">Colis</p>
                                            {{--                                                <p>$25,000</p>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6 l6 xl4">
                            <div
                                class="card gradient-45deg-purple-deep-purple gradient-shadow min-height-100 white-text animate fadeRight">
                                <div class="padding-4">
                                    <div class="row">
                                        <div class="col s7 m7">
                                            <i class="material-icons background-round mt-5">report_problem</i>
                                            <p>Réclamations en cours</p>
                                        </div>
                                        <div class="col s5 m5 right-align">
                                            <h5 class="mb-0 white-text">{{$Reclamation_encours}}</h5>
                                            <p class="no-margin">Réclamations</p>
                                            {{--                                                <p>3,42,230</p>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6 l6 xl4">
                            <div
                                class="card gradient-45deg-indigo-light-blue gradient-shadow min-height-100 white-text animate fadeRight">
                                <div class="padding-4">
                                    <div class="row">
                                        <div class="col s7 m7">
                                            <i class="material-icons background-round mt-5">attach_money</i>
                                            <p>Total Remboursement du jour</p>
                                        </div>
                                        <div class="col s5 m5 right-align">
                                            <h5 class="mb-0 white-text">0</h5>
                                            <p class="no-margin">Colis</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--card stats end-->
            <!--yearly & weekly revenue chart start-->
            {{-- <div id="sales-chart">
                    <div class="row">
                        <div class="col s12 m6 l6">

                            <div id="revenue-chart" class="card animate fadeUp">
                                <div class="card-content">
                                    <h4 class="header mt-0">
                                        Réalisations en 10 derniers jours
                                        <span class="purple-text small text-darken-1 ml-1">
                                            <i class="material-icons">keyboard_arrow_up</i>
                                            10.58 %</span>
                                        <a class="waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow right">Details</a>
                                    </h4>
                                    <div class="row">
                                        <div class="col s12">
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>Jours</th>
                                                    <th>Colis</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>8 Février</td>
                                                    <td>2</td>
                                                </tr>
                                                <tr>
                                                    <td>9 Février</td>
                                                    <td>9</td>
                                                </tr>
                                                <tr>
                                                    <td>15 Février</td>
                                                    <td>1</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                        <div class="col s12 m6 l6">
                            <div id="weekly-earning" class="card animate fadeUp">
                                <div class="card-content">
                                    <h4 class="header mt-0">
                                        Réalisations mensuel
                                        <span class="purple-text small text-darken-1 ml-1">
                                            <i class="material-icons">keyboard_arrow_up</i>
                                            15.58 %</span>
                                        <a class="waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow right">Details</a>
                                    </h4>
                                    <div class="row">
                                        <div class="col s12">
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>Mois</th>
                                                    <th>Colis</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>December 2021</td>
                                                    <td>4</td>
                                                </tr>
                                                <tr>
                                                    <td>Janvier 2022</td>
                                                    <td>15</td>
                                                </tr>
                                                <tr>
                                                    <td>Février 2022</td>
                                                    <td>10</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div> --}}

            <div id="sales-chart">
                <div class="row" style="margin-block-end: 30px;">
                    <div class="col s12 m8 l6">
                        <h4 class="header mt-0">
                            Evolution des colis </h4>

                        <canvas id="Rmensuel"></canvas>

                    </div>
                    <div class="col s12 m4 l6">
                        <div class="card-content">
                            <h4 class="header m-0">
                                Les colis non livrée ({{$exp_non_livree->count()}})</span>
                            </h4>
                            <table class="table-fill" style="margin-top: 30px!important;">
                                <thead>
                                    <tr>
                                        <th>N° Exp</th>
                                        <th>Destinataire</th>
                                        <th>Fond</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($exp_non_livree as $exp)
                                    <tr>
                                        <td>
                                            <span class="grey badge"
                                                style="font-size: 20px">{{$exp->num_expedition}}</span>
                                        </td>
                                        <td>{{$exp->destinataire}}
                                            <p>
                                                {{$exp->telephone}} - {{$exp->agenceDetail->libelle}}
                                            </p>
                                        </td>
                                        <td>{{number_format($exp->fond, 2)}} Dhs</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>


            </div>


            <!--yearly & weekly revenue chart end-->


            <!--end container-->
        </div>

    </div>
    <div class="content-overlay"></div>
    @if(count($promotions) > 0)
    <!-- Intro -->
    <div id="intro">
        <div class="row">
            <div class="col s12">
                <div id="img-modal" class="modal white">
                    <div class="modal-content">
                        <div class="bg-img-div"></div>
                        <p class="modal-header right modal-close">
                            Masquer <span class="right"><i class="material-icons right-align">clear</i></span>
                        </p>
                        <div class="carousel carousel-slider center intro-carousel">
                            <div class="carousel-fixed-item center middle-indicator">
                                <div class="left">
                                    <button
                                        class="movePrevCarousel middle-indicator-text btn btn-flat purple-text waves-effect waves-light btn-prev">
                                        <i class="material-icons">navigate_before</i> <span
                                            class="hide-on-small-only">Précedent</span>
                                    </button>
                                </div>
                                <div class="right">
                                    <button
                                        class=" moveNextCarousel middle-indicator-text btn btn-flat purple-text waves-effect waves-light btn-next">
                                        <span class="hide-on-small-only">Suivant</span> <i
                                            class="material-icons">navigate_next</i>
                                    </button>
                                </div>
                            </div>
                            @foreach($promotions as $promotion)
                            <div class="carousel-item slide-{{$promotion->id}}">
                                <img src="/assets/images/gallery/intro-slide-1.png" alt=""
                                    class="responsive-img animated fadeInUp slide-1-img">
                                <h5 class="intro-step-title mt-7 center animated fadeInUp">{{$promotion->libelle}}</h5>
                                <p class="intro-step-text mt-5 animated fadeInUp">{{$promotion->description}}</p>
                                <a href="{{route('promotion_seen',['id' => $promotion->id])}}" class="btn indigo">
                                    Bien lis</a>
                            </div>

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Intro -->
    @endif

</div>
</div>
@stop

@section('js')
<script src="/assets/js/scripts/dashboard-ecommerce.js"></script>
@if(count($promotions) > 0)
<script src="/assets/js/scripts/intro.js"></script>

<link rel="stylesheet" type="text/css" href="/assets/css/pages/intro.css">
@endif


<script>
//realisation mensuels chart
const labels = {!! $data_date !!};

const data = {
    labels: labels,
    datasets: [{
        label: "Nombre d'expedition",
        backgroundColor: '#1991ce',
        borderColor: 'rgb(191, 191, 191)',
        data: {!! $count_exp !!},
    }]
};

const config = {
    type: 'bar',
    data: data,
    options: {}
};


//Evolution Chiffrechart
//   const labelsEvolutionChiffre = [
//     '3/21',
//     '4/21',
//     '5/21',
//     '6/21',
//     '7/21',
//     '8/21',
//     '9/21',
//     '10/21',
//     '11/21',
//     '12/21',
//     '1/22',
//     '2/22',
//   ];

//   const dataEvolutionChiffre = {
//     labels: labelsEvolutionChiffre,
//     datasets: [{
//       label: 'C.A en Dh',
//     //   backgroundColor: '#ff5252 ',
//       borderColor: '#ff5252',
//       data: [320004, 330004, 320004, 370004, 330004, 350004, 370004,250004,550004,550004,650004,750004],
//     },{
//       label: 'CA Encaissé Dh',
//     //   backgroundColor: '#42a5f5 ',
//       borderColor: '#00bcd4',
//       data: [320004, 350004, 370004, 340004, 370004, 360004, 310004,360004,330004,390004,340004,320004],
//     }
//     ]
//   };

//   const configEvolutionChiffre = {
//     type: 'line',
//     data: dataEvolutionChiffre,
//     options: {

//     }
//   };

// //Taux de retour
// const labelsTauxretour = [
//     'Taux de retour',
//   ];

//   const dataTauxretour = {
//     labels: labelsTauxretour,
//     datasets: [{

//      backgroundColor: ['rgba(255, 99, 132, 0.5)','rgba(54, 162, 235, 0.2)'],
//       borderColor: ['rgba(255,99,132,1)','rgba(54, 162, 235, 1)'],
//       data: [19.5,80],
//     }
//     ]
//   };

//   const configTauxretour = {
//     type: 'pie',
//     data: dataTauxretour,
//     options: {

//     }
//   };
</script>
<script>
    document.getElementById("dashboard").classList.add("activate");
const Rmensuel = new Chart(
    document.getElementById('Rmensuel'),
    config
);

/*const EvolutionChiffre = new Chart(
    document.getElementById('EvolutionChiffre'),
    configEvolutionChiffre
);
const Tauxretour = new Chart(
    document.getElementById('Tauxretour'),
    configTauxretour
);*/
</script>

@stop
