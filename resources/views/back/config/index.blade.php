@extends('back.layouts.master')
@section('title','Ayarlar')
@section('content')
  <div class="card shadow mb-4">

    <div class="card-header py-3">  </div>

    <div class="card-body">

        <form method="post" action="{{route('admin.config.update')}}" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Başlık</label>
                <input type="text" name="title" required class="form-control" value="{{$config->title}}"/>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Aktif</label>
                <select class="form-control" name="active">
                  <option @if($config->active==1) selected @endif value="1">
                    Açık
                  </option>
                  <option @if($config->active==0) selected @endif value="0">
                    Kapalı
                  </option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Logo</label>
                <a href="{{route('admin.config.logo')}}" title="Logo" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                <input type="file" name="logo" class="form-control" />
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>FavIcon</label>
                <a href="{{route('admin.config.favicon')}}" title="FavIcon" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                <input type="file" name="favicon" class="form-control"/><br>

              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Facebook</label>
                <input type="text" name="facebook" class="form-control" value="{{$config->facebook}}"/>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Instagram</label>
                <input type="text" name="instagram" class="form-control" value="{{$config->instagram}}"/>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>LinkedIn</label>
                <input type="text" name="linkedin" class="form-control" value="{{$config->linkedin}}"/>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Twitter</label>
                <input type="text" name="twitter" class="form-control" value="{{$config->twitter}}"/>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label>E-mail</label>
              <input type="text" name="email" class="form-control" value="{{$config->email}}"/>
            </div>
          </div>
        </div>

          <div class="form-group">
            <button type="submit" class="btn btn-block btn-md btn-success">Güncelle</button>
          </div>

        </form>
      </div>


@endsection
