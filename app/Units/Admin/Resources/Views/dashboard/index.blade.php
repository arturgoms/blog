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
                    <h6 class="flow-text center-align">Art. Publicados</h6>
                    <h4 class="center-align">12</h4>
                </div>
            </div>

            <div class="col s12 m4 l4">
                <div class="card-panel ">
                    <h6 class="flow-text center-align">Art. Pendentes</h6>
                    <h4 class="center-align">12</h4>
                </div>
            </div>

            <div class="col s12 m4 l4">
                <div class="card-panel ">
                    <h6 class="flow-text center-align">Art. Programados</h6>
                    <h4 class="center-align">12</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12 m4 l4">
                <div class="card-panel ">
                    <p class="center-align" style="margin-top: -20px">
                        <i class="material-icons medium" title="Caixa de Entrada">email</i></p>
                    <h4 class="center-align">20</h4>
                </div>
            </div>
        </div>
    </div>

@endsection