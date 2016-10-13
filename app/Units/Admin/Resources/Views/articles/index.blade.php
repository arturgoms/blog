@extends('admin::layout')

@section('content')
    <div class="container">

        <h5>Artigos</h5>
        <div class="row">

            <div class="col s12 m10 l10 offset-l1">
                <table class="table bordered">

                    <thead>
                    <tr>
                        <th>Titulo</th>
                        <th>Subtitulo</th>
                        <th>Data</th>
                        <th>#</th>
                        <th>#</th>
                        <th>#</th>
                    </tr>

                    </thead>
                    <tbody>
                    @foreach($itens as $row)
                        <tr>
                            <td>{{$row->title}}</td>
                            <td>{{$row->subtitle}}</td>
                            <td>{{$row->created_at}}</td>
                            <td>
                                <span class="">Ativado</span>
                            </td>
                            <td>
                                <a href="{{route('admin.articles.edit', $row->id)}}">
                                    <span class=" ">Excluir</span>
                                </a>


                            </td>
                            <td>
                                <a href="{{route('admin.articles.edit', $row->id)}}">
                                    <span class="">Editar</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection