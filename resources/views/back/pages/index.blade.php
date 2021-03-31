@extends('back.layouts.master')
@section('title','Tüm İçerikler')
@section('content')
  <div class="card shadow mb-4">

    <div class="card-header py-3">

      <h6 class="m-0 font-weight-bold float-right text-primary"><strong>{{$pages->count()}} içerik bulundu.</strong>

      </h6>

    </div>

    <div class="card-body">
      <div id="orderSuccess" style="display:none;" class="alert alert-success">
        Sıralama başarılı.
      </div>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Sırala</th>
              <th>Fotograf</th>
              <th>Başlık</th>
              <th>Aktif/Pasif</th>
              <th>İşlemler</th>
            </tr>
          </thead>

          <tbody id="orders">
          @foreach($pages as $page)

            <tr id="page_{{$page->id}}">
              <td class="text-center" style="width:3%"><i class="fa fa-arrows-alt handle fa-3x" style="cursor:move"></td>
              <td>
                <img src="{{asset($page->image)}}" width="200">
              </td>
              <td>{{$page->title}}</td>
              <td>
                <input class="switch" pageID="{{$page->id}}" type="checkbox" @if($page->status==1) checked @endif data-toggle="toggle" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger">
              </td>
              <td>
                <a target="_blank" href='{{route('page',$page->slug)}}' title="Görüntüle" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                <a href="{{route('admin.pages.edit',$page->id)}}" title="Düzenle" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
                <a href="{{route('admin.pages.delete',$page->id)}}" title="Sil" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
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
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.13.0/Sortable.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

  <script>
    $('#orders').sortable({
      handle:'.handle',
      update:function(){
        var elementOrder = $('#orders').sortable('serialize');
        $.get("{{route('admin.pages.orders')}}?"+elementOrder, function(data, status){
          
          $("#orderSuccess").show();
          setTimeout(function(){$("#orderSuccess").fadeOut();},1000);
        });
      }
    });
  </script>
  <script>
  $(function() {
    $('.switch').change(function() {
      id=$(this)[0].getAttribute('pageID');
      statu=$(this).prop('checked');
      $.get("{{route('admin.pages.switch')}}", {id:id,statu:statu}, function(data, status){});
    })
  })
</script>
@endsection
