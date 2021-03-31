@extends('back.layouts.master')
@section('title','Çöp Kutun')
@section('content')
  <div class="card shadow mb-4">

    <div class="card-header py-3">

      <h6 class="m-0 font-weight-bold float-right text-primary"><strong>{{$articles->count()}} içerik bulundu.</strong>
        <a href="{{route('admin.articles.index')}}" class="btn btn-primary btn-sm">İçerikler</a>
      </h6>

    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Fotograf</th>
              <th>Başlık</th>
              <th>Kategori</th>
              <th>Oluşturlma Tarihi</th>
              <th>İşlemler</th>
            </tr>
          </thead>
          <tbody>

          @foreach($articles as $article)

            <tr>
              <td>
                <img src="{{asset($article->image)}}" width="200">
              </td>
              <td>{{$article->title}}</td>
              <td>{{$article->getCategory->name}}</td>
              <td>{{$article->created_at->diffForHumans()}}</td>

              <td>
                <a href='{{route('admin.recover.article',$article->id)}}' title="Geri Yükle" class="btn btn-sm btn-primary"><i class="fa fa-recycle"></i></a>
                <a href="{{route('admin.hdelete.article',$article->id)}}" title="Sil" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
              </td>

            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection
@section('css')
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
