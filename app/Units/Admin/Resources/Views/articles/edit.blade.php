@extends('admin::layout')

@section('content')
    <div class="container">

        <h5>Editar Artigo</h5>

        <div class="row">
            <form class="col l12" role="form" method="POST" href="#" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PUT">

                <div class="row">
                    <div class="input-field col l6">

                        <label for="title" class="active">Title</label>

                        <input type="text" id="title" name="title" value="{{$item->title}}">

                        @if ($errors->has('title'))
                            <strong>{{ $errors->first('title') }}</strong>
                        @endif

                    </div>

                    <div class="row">
                        <div class="input-field col l6">
                            <select name="state">
                                <option value="1">Preview</option>
                                <option value="3" {{$item->state == 3 ? 'selected' : ''}}>Publicado</option>
                                <option value="0">Não Publicado</option>
                            </select>
                            <label class="active">Status</label>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="input-field col l6">

                        <label for="url" class="active">Url</label>

                        <input type="url" id="url" name="url" value="{{$item->url}}">

                        @if ($errors->has('url'))
                            <strong>{{ $errors->first('url') }}</strong>
                        @endif

                    </div>
                    <div class="file-field input-field col l6">

                        <input type="file" name="image" id="image">
                        <label for="image" class="active">Imagem</label>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="input-field col l12">

                        <textarea id="subtitle" class="materialize-textarea"
                                  name="subtitle">{{$item->subtitle}}</textarea>
                        <label for="subtitle" class="active">Subtitle</label>

                        @if ($errors->has('subtitle'))
                            <strong>{{ $errors->first('subtitle') }}</strong>
                        @endif

                    </div>
                </div>

                <div class="row">
                    <div class="col l6 tags">
                        <label for="chips" class="active">Tags</label>
                        <div class="chips"></div>
                    </div>

                    <div class="col l6">
                        @foreach($item->tags as $tag)
                            <div class="chip">
                                {{$tag->tag}}
                                <i class="close material-icons removeTag" data-id="{{$tag->id}}">close</i>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        @foreach($item->images as $image)
                            <div class="col s12 m7 l2">
                                <div class="card">
                                    <div class="card-image">
                                        <img src="{{$image->image_url}}" name="{{$image->image_name}}"
                                             title="{{$image->image_name}}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col l12">
                    <textarea id="editor" name="text">{{$item->text}}</textarea>

                    <script>
                        var editor = new SimpleMDE({
                            element: document.getElementById("editor"),
                            spellChecker: false,
                        });


                    </script>
                </div>

                <div class="row">
                    <div class="input-field col l12 ">
                        <button id="submit" type="submit" class="waves-effect waves-light btn right">
                            <i class="material-icons right">cloud</i>Salvar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="modalImages" class="modal">
        <div class="modal-content">
            <h5>Upload de Fotos</h5>
            <form action="" enctype="multipart/form-data">
                <div class="file-field input-field">
                    <div class="btn">
                        <span>Imagem</span>
                        <input type="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
                <div class="input-field">
                    <button class="btn green" type="submit">Enviar</button>
                </div>
            </form>
        </div>

    </div>
    @include('admin::articles._includes.btn-floating', [
  'btns' => [
              [
                  'href' => route('admin.articles.index') ,
                  'icon' => 'comment',
                  'color' => 'blue'
              ],
              [
                  'href' => route('admin.articles.create') ,
                  'icon' => 'save',
                  'color' => 'green'
              ],
              [
                  'href' => route('admin.articles.shedule') ,
                  'icon' => 'alarm_on',
                  'color' => 'red'
              ],
              [
                  'href' => route('admin.articles.images', ['id' => $item->id]),
                  'icon' => 'picture_in_picture',
                  'color'=> 'yellow'
              ]
          ]
  ])

    <script>
        $(document).ready(function () {
            $('select').material_select();
            $('.chips').material_chip();
            $('.chips').on('chip.add', function (e, chip) {
                console.log(chip);

                $('.tags').append(
                        '<input type="hidden" id="tags" name="tags[]" value="' + chip.tag + '">'
                );
            });

            $('.modal-trigger').leanModal({
                starting_top: '100%'
            });

            $('.removeTag').click(function () {
                removeTag($(this).attr('data-id'))
            })

            function removeTag(tag_id) {
                $.ajax({
                    url: '/articles/' + {{$item->id}} +'/tags',
                    method: 'POST',
                    data: {
                        '_token': window.Laravel.csrfToken,
                        '_method': 'PUT',
                        'tag_id': tag_id
                    },
                    success: function (data) {
                        Materialize.toast('Tag removida', 1000);

                    }
                });
            }


        });
    </script>

@endsection