@extends('back.layouts.master')
@section('title','İçerik Oluştur')
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
      <form method='post' action="{{route('admin.articles.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label> İçerik Başlığı </label>
          <input type="text" name="title" class="form-control" value="{{ old('title') }}" required></input>
        </div>

        <div class="form-group">
          <label> İçerik Kategorisi </label>
          <select class="form-control" name="category" required>
            <option value="">Seçim yapınız</option>
            @foreach ($categories as $category)
              <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label> İçerik Başlık Fotoğrafı</label>
          <input type="file" name="image" class="form-control" required></input>
        </div>

        <div class="form-group">
          <label> İçerik Metni </label>
          <textarea id="editor" name="content" class="form-control" rows="4"  required> {{old('content')}} </textarea>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block">İçeriği Oluştur</button>
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
