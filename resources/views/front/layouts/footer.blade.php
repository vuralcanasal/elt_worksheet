</div>
</div>

<hr>

<!-- Footer -->
<footer>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <ul class="list-inline text-center">
          @php
            $socials=['facebook','instagram','linkedin','twitter','email'];
          @endphp
          @foreach ($socials as $social)
            @if($config->$social!=null)
              @if($social=='email')
                <li class="list-inline-item">
                  <a target="_blank" href="{{route('contact')}}">
                    <span class="fa-stack fa-lg">
                      <i class="fas fa-circle fa-stack-2x"></i>
                      <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                    </span>
                  </a>
                </li>
              @else
              <li class="list-inline-item">
                <a target="_blank" href="{{$config->$social}}">
                  <span class="fa-stack fa-lg">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="fab fa-{{$social}} fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
            @endif
            @endif
          @endforeach
          
        </ul>
        <p class="copyright text-muted">Copyright &copy; {{$config->title}} - {{date('Y')}}</p>
      </div>
    </div>
  </div>
</footer>

<!-- Bootstrap core JavaScript -->
<script src="{{asset('front')}}/vendor/jquery/jquery.min.js"></script>
<script src="{{asset('front')}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Custom scripts for this template -->
<script src="{{asset('front')}}/js/clean-blog.min.js"></script>

</body>

</html>
