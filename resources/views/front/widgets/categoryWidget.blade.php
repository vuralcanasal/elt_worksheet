@isset($categories)
<div class="col-md-3">
    <div class_"card">
      <div class="card-header">
          Kategori
      </div>
      <div class="list-group">
          @foreach($categories as $category)
            <li class="list-group-item">
              <a href="{{route('category',$category->slug)}}">{{$category->name}}</a>
            </li>
        @endforeach

      </div>
      <br>
      <div class="list-group">
      <img src="/static/sme_logo.jpg">
    </div>

    </div>
</div>
@endif
