@extends('back.layouts.master')
@section('title','Dosyalar')
@section('content')
  <div class="row">
    <div class="col-md-4">
      <div class="card shadow mp-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{$article->title}}</h6>
        </div>
        <div class="card-body">
          <form method="post" action="{{route('admin.article.filecreate')}}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
              <label> Dosya Adı </label>
              <input type="text" name="name" class="form-control" required></input>
            </div>

            <div class="form-group">
              <label> Dosya </label>
              <input type="file" name="sheet" class="form-control" required></input>
            </div>

            <div class="form-group">
              <input type="hidden" name="article" class="form-control" value="{{$article->id}}" required></input>
            </div>


            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-block">Ekle</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="card shadow mp-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tüm Dosyalar</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Dosya Adı</th>
                  <th>Sil</th>
                </tr>
              </thead>
              <tbody>

              @foreach($files as $file)

                <tr>

                  <td>{{$file->name}}</td>

                  <td>
                    <a fileID="{{$file->id}}"  fileName="{{$file->name}}" class="btn btn-sm btn-danger remove-click" title="Sil"><i class="fa fa-times text-white"></i></a>
                  </td>

                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- The Modal -->
<div class="modal" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Dosya Sil</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div id='body' class="modal-body">
        <div class='alert alert-danger' id="fileAlert"></div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
        <form method="post" action="{{route('admin.article.filedelete')}}">
          @csrf
          <input type="hidden" name="id" id="deleteId"/>
          <button id="deleteButton" type="submit" class="btn btn-success" >Sil</button>
        </form>
      </div>
    </form>
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
    $('.remove-click').click(function(){
      id=$(this)[0].getAttribute('fileID');
      name=$(this)[0].getAttribute('fileName');

      $('#deleteButton').show();
      $('#deleteId').val(id);
      $('#fileAlert').html('');
      $('#body').hide();
      $('#fileAlert').html('Bu dosyayı silmek istediğinize emin misiniz ??');
      $('#body').show();
      
      $('#deleteModal').modal();
    });

  })
</script>
@endsection
