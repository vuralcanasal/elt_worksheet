
@extends('front.layouts.master')
@section('title','İletişim')
@section('background','front/img/contact-bg.jpg')

@section('content')

<div class="container" style="text-align: center">
  <p>
  Bize ulaşmanın en kolay yollarını aşağıdaki linklerde bulabilirsiniz.
  </p>
</div>
  @if($config->email!=NULL)

    <div class="container" style="text-align: center">

      <p>
      E-posta Adresimiz: {{$config->email}}
      </p>
    </div>
  @endif
  

</div>
<br>

@endsection
