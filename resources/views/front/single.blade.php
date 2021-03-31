
@extends('front.layouts.master')
@section('title',$article->title)
@section('background',asset($article->image))

@section('content')
        <div class="col-md-9 mx-auto">

          @if ($article->image != NULL)
            <img src="{{asset($article->image)}}" height="300"/>
            <hr>
          @endif

          {!!$article->content!!}

          @if ($sheets->count()>0)
            <hr>
            Links:<br>
            @foreach($sheets as $sheet)
                <a href="{{route('filedownload',$sheet->id)}}">{{$sheet->name}}</a>
                <br>
            @endforeach
          @endif
        </div>


@include('front.widgets.categoryWidget')

@endsection
