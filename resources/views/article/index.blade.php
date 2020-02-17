<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" crossorigin="anonymous">
	<div class="panel-body table-responsive">
    <a class="btn btn-success pull-right" href="{{route('article.create')}}">Create New</a>
    <table class="table table-bordered table-striped datatable">
        <thead>
            <tr>
                <th>Title</th>
                <th>Tags</th>
                <th> </th>
            </tr>
        </thead>
        
        <tbody>
            @if (count($articles) > 0)
                @foreach ($articles as $article)
                    <tr data-entry-id="{{ $article->id }}">
                        <td field-key='title'>{{ $article->title }}</td>
                        <td field-key='tag'>
                            @foreach ($article->tag as $singleTag)
                                <span class="label label-info label-many">{{ $singleTag->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="" class="btn btn-xs btn-primary">View</a>
                            <a href="{{route('article.edit',$article->id)}}" class="btn btn-xs btn-info">Edit</a>
                            {!! Form::open(array(
                                'style' => 'display: inline-block;',
                                'method' => 'DELETE',
                                'onsubmit' => 'return confirm("Are you sure?")',
                                'route' => ['article.destroy',$article->id]

                            ))!!} 
                            @csrf
                            {!! Form::submit('Delete', array('class' => 'btn btn-xs btn-danger')) !!}
                            {!! Form::close() !!}
                        </td>

                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8">@lang('global.app_no_entries_in_table')</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>