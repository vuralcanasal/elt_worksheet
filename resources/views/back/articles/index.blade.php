@extends('back.layouts.master')
@section('title','Tüm İçerikler')
@section('content')
  <div class="card shadow mb-4">

    <div class="card-header py-3">

      <h6 class="m-0 font-weight-bold float-right text-primary"><strong>{{$articles->count()}} içerik bulundu.</strong>
        <a href="{{route('admin.trashed.article')}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Çöp Kutusu</a>
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
              <th>Aktif/Pasif</th>
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
                <input class="switch" articleID="{{$article->id}}" type="checkbox" @if($article->status==1) checked @endif data-toggle="toggle" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger">
              </td>

              <td>
                <a target="_blank" href='{{route('single',[$article->getCategory->slug,$article->slug])}}' title="Görüntüle" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                <a href='{{route('admin.articles.edit',$article->id)}}' title="Düzenle" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
                <a href="{{route('admin.delete.article',$article->id)}}" title="Sil" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                <a href="{{route('admin.file.article',$article->id)}}" title="Dosyalar" class="btn btn-sm btn-default"><i class="fa fa-file"></i></a>
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

@section('js')
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  <script>
  $(function() {
    $('.switch').change(function() {
      id=$(this)[0].getAttribute('articleID');
      statu=$(this).prop('checked');
      $.get("{{route('admin.switch')}}", {id:id,statu:statu}, function(data, status){});
    })
  })
</script>
@endsection
