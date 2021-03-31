@extends('back.layouts.master')
@section('title',$page->title.' sayfayı güncelle')
@section('content')
  <div class="card shadow mb-4">

    <div class="card-header py-3">

    </div>

    <div class="card-body">
      @if($errors->any())
        <div class="alert alert-danger">
          @foreach ($errors->all() as $error)
            {{$error}}
          @endforeach
        </div>
      @endif
      <form method='post' action="{{route('admin.pages.edit.post',$page->id)}}" enctype="multipart/form-data">

        @csrf
        <div class="form-group">
          <label> Sayfa Başlığı </label>
          <input type="text" name="title" class="form-control" value="{{$page->title}}" required></input>
        </div>


        <div class="form-group">
          <label> Sayfa Fotoğrafı </label><br/>
          <img src="{{asset($page->image)}}" class="rounded" width="300"/>
          <input type="file" name="image" class="form-control" ></input>
        </div>


        <div class="form-group">
          <label> Sayfa Metni </label>
          <textarea id="editor" name="content" class="form-control" rows="4">{!!$page->content!!}</textarea>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block">Sayfayı Güncelle</button>
        </div>

      </form>
    </div>
  </div>

@endsection
@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('js')
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script>
    $(document).ready(function() {
    $('#editor').summernote(
      {
        'height':300
      }
    );
    });
  </script>

@endsection
