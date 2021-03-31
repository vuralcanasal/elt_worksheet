@if(count($articles)>0)
@foreach($articles as $article)
  <div class="post-preview">
    <a href="{{route('single',[$article->getCategory->slug,$article->slug])}}">
      <h2 class="post-title">
      {!!$article->title!!}
      </h2>
      <img src="../{{$article->image}}"  width="300"/>
      <p class="post-subtitle">
        {!!str_limit($article->content,150)!!}
      </p>
    </a>
    <p class="post-meta">
      <a href="#">{{$article->getCategory->name}}</a>
      <span class="float-right">{{$article->created_at->diffforHumans()}}</span></p>
  </div>
  @if(!$loop->last)
    <hr>
  @endif
@endforeach
{{$articles->links("pagination::bootstrap-4")}}
@else
  <div class="alert alert-danger">
    <h1>Bu kategoriye ait bilgi bulunamadı</h1>
  </div>

@endif
