@extends('crud.base')
@extends('crud.menu')
@section('insert_head')
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@endsection
@yield('menu')
@section('content')
<style>
    body {
    background: #d7e4ed none repeat scroll 0 0;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-xs-12" align="center">
            <div style="margin-top:3%;width:90%;text-align:left;">
                <div style="margin-left:6%;margin-right:6%;width:auto;text-align:left;" class="success">
                    @if(Session::has('status_s'))
                    <div class="alert alert-success" id="success-alert" >
                        <ul>
                            <li>{{ Session::get('status_s') }}</li>
                        </ul>
                    </div>
                    <script type="text/javascript">setTimeout(function(){$("#success-alert").slideUp(500);},5000);</script>
                    @endif 
                </div>
                <div style="margin-left:6%;margin-right:6%;width:auto;text-align:left;" class="errors">
                    @if(Session::has('status_e'))
                    <div class="alert alert-danger">
                        <div>Please Correct The Following Errors :
                            <br>
                            <br>
                        </div>
                        <ul>
                            <li>{{ Session::get('status_e') }}</li>
                        </ul>
                    </div>
                    @endif 
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <div>Please Correct The Following Errors :
                            <br>
                            <br>
                        </div>
                        <ul>
                            @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                <form method="post" action="{{URL::to('crud-insert')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Post Name</label>
                        <input type="text" class="form-control" id="post_tid" name="post_t" placeholder="Post Title" value="{{ old('post_t') }}">
                    </div>
                    <div class="form-group">
                        <label>Post Description</label>
                        <textarea class="form-control" id="post_did" name="post_d" style="height:150px;" placeholder="Post Description">{{ old('post_d') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
    
     function login_window(url){
         console.log(url);
         window.open(url,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=800,height=500');
       }
    
         $("#chk_id").bind('click', function() {
    
             if (document.getElementById("chk_id").checked == true) {
                 $("#img_block").show();
             } else {
                 $("#img_block").hide();
             }
    
         })
    
    
     });
</script>
@endsection