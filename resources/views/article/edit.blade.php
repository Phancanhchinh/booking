<!DOCTYPE html>
<html>
<head>
    <title></title>
    <base href="{{asset('')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" crossorigin="anonymous">
    <link href="assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">

</head>
<body>
    <h3 class="page-title">Articles</h3>
    {!! Form::open(['method' => 'POST','route' => ['article.update',$article->id]]) !!}
    {{-- ,'route' => [] --}}
    @csrf
    <div class="panel panel-default">
        <div class="panel-heading">
            Create
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('title', 'Title', ['class' => 'control-label']) !!}
                    {!! Form::text('title', $article->title, ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('title'))
                        <p class="help-block">
                            {{ $errors->first('title') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('article_text', 'Article Text', ['class' => 'control-label']) !!}
                    {!! Form::textarea('article_text', $article->article_text, ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('article_text'))
                        <p class="help-block">
                            {{ $errors->first('article_text') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('tag', trans('global.articles.fields.tag').'', ['class' => 'control-label']) !!}
					<button type="button" class="btn btn-primary btn-xs" id="selectbtn-tag">
					    {{ trans('global.app_select_all') }}
					</button>
					<button type="button" class="btn btn-primary btn-xs" id="deselectbtn-tag">
					    {{ trans('global.app_deselect_all') }}
					</button>

					{{--Form::select(name-option-selected,array) --}}
					{!! Form::select('tag[]', $tags, old('tag') ? old('tag') : $tag , ['class' => 'form-control select2', 'multiple' => 'multiple', 'id' => 'selectall-tag' ]) !!}
					<p class="help-block"></p>
					@if($errors->has('tag'))
					    <p class="help-block">
					        {{ $errors->first('tag') }}
					    </p>
					@endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit('Save article', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    
    
    <script src="assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/node_modules/popper/popper.min.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This is select2 -->
    <script src="assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    
    <script>
        $("#selectbtn-tag").click(function(){
            $("#selectall-tag > option").prop("selected","selected");
            $("#selectall-tag").trigger("change");
        });
        $("#deselectbtn-tag").click(function(){
            $("#selectall-tag > option").prop("selected","");
            $("#selectall-tag").trigger("change");
        });
        // select2
       jQuery(document).ready(function() {
            $(".select2").select2();
            
       });
    </script>
</body>
</html>