
@section('menu')

    <div class="container" style="margin-top:1%;" >

    <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/">Sample | CRUD Operation</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="{{URL::to('crud-add-menu')}}">Add Post</a></li>
      <li><a href="{{URL::to('/')}}">Modify / Delete Post</a></li>
    </ul>
  </div>
</nav>

</div>

    
@endsection