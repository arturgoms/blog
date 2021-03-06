@extends('admin::layout')

<style>
    .dashboard .card-panel {
        height: 120px;
    }
</style>

@section('content')
    <div class="container dashboard">
        <div class="row">
            <div class="col s12 m4 l4">
                <div class="card-panel ">
                    <div class="col l3">
                        <p class="" style="">
                            <i class="material-icons medium green-text" title="Visitantes de Hoje">trending_up</i>
                        </p>
                    </div>
                    <div class="col l8">
                        <h6 class="center-align">Visitantes de Hoje</h6>
                        <h4 class="center-align"><strong>{{$visitors['day']}}</strong></h4>
                    </div>

                </div>
            </div>

            <div class="col s12 m4 l4">
                <div class="card-panel ">
                    <div class="col l3">
                        <p class="" style="">
                            <i class="material-icons medium orange-text" title="Visitantes Mês">trending_up</i>
                        </p>
                    </div>
                    <div class="col l8">
                        <h6 class="center-align">Visitantes no Mês</h6>
                        <h4 class="center-align"><strong>{{$visitors['month']}}</strong></h4>
                    </div>

                </div>
            </div>
            <div class="col s12 m4 l4">
                <div class="card-panel ">
                    <div class="col l3">
                        <p class="" style="">
                            <i class="material-icons medium red-text" title="Visitantes Totais">trending_up</i>
                        </p>
                    </div>
                    <div class="col l8">
                        <h6 class="center-align">Visitantes Totais</h6>
                        <h4 class="center-align"><strong>{{$visitors['all']}}</strong></h4>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12 l6">
                <div id='browserChart'></div>

                <script>
                    var chartBrowser = c3.generate({
                        bindto: '#browserChart',
                        data: {
                            columns: [],
                            type: 'pie',
                            onclick: function (d, i) {
                                console.log("onclick", d.value);
                            },
                        },
                        pie: {
                            label: {
                                format: function (value, ratio, id) {
                                    return d3.format('')(value);
                                }
                            }
                        }
                    });

                    var dataBrowserJson = {!! $browsers !!};
                    var browsersData = [];

                    dataBrowserJson.forEach(function (element, index, array) {
                        browsersData.push([
                            element.browser,
                            element.sessions
                        ]);
                    });
                    chartBrowser.load({
                        columns: browsersData,
                    });
                </script>
            </div>
            <div class="col s12 l6">
                <div id='referrersChart'></div>

                <script>

                    var chartReferrer = c3.generate({
                        bindto: '#referrersChart',
                        data: {
                            columns: {},
                            type: 'pie',
                            onclick: function (d, i) {
                                console.log("onclick", d.value);
                            }
                        },
                        pie: {
                            label: {
                                format: function (value, ratio, id) {
                                    return d3.format('')(value);
                                }
                            }
                        }
                    });

                    var dataReferrersJson = {!! $referrers !!};
                    var referrersData = [];

                    dataReferrersJson.forEach(function (element, index, array) {
                        referrersData.push([
                            element.url,
                            element.pageViews
                        ]);
                    });
                    chartReferrer.load({
                        columns: referrersData,
                    });
                </script>
            </div>
        </div>
    </div>

@endsection