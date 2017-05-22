@extends('crud.base')
@extends('crud.menu')
@section('modify_head')
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="{{ URL::to('static/css/alertify.core.css')}}" >
<link rel="stylesheet" type="text/css" href="{{ URL::to('static/css/alertify.default.css')}}" >
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="{{ URL::to('static/js/alertify.js')}}"></script>
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
                    <div class="alert alert-danger" id="alert-danger" style="display:none;text-align:center;" >No Content</div>
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
                <div align="left" style="display:inline!important;">
                    <!-- <label>Select Year : </label> -->
                    <select name="year" id="year">
                        <option value="">--Select Year--</option>
                    </select>
                    <button class='btn-danger' onclick="bulk_del();" >Delete Selected</button>
                    <p><strong>*Showing Last 4 Years ( Dropdown )</strong></p>
                </div>
                <div class="selector-container" style="margin-top:2%;" >
                    <table id="selector-post" class="table table-striped" style="text-align:center;" >
                        <tr>
                            <th style="text-align:center;" >Select All&nbsp;<input type="checkbox" name="chkbox_all" id="chkbox_all" style="vertical-align:top;" /> </th>
                            <th style="text-align:center;" >Post Title</th>
                            <th style="text-align:center;" >Post Description</th>
                            <th style="text-align:center;" >Post Year (UTC)</th>
                            <th style="text-align:center;" >Action</th>
                        </tr>
                    </table>
                    <div id="loader" style="padding:10px;display:none;" align="center"><img alt="loader" src="{{ URL::to('static/img/loader.gif') }}" style="width:60px;height:60px;"><br>Loading</div>
                    <div align="center" id="load_more" style="cursor:pointer;" onclick="load_more();"><code>Load More</code></div>
                    <br>
                    <div class="alert alert-danger" id="alert-danger-load" style="display:none;text-align:center;" >No Content</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-modal-lg" tabindex="-1" role="dialog" id="modi_modal" aria-labelledby="ModificationModal">
    <div class="modal-dialog modal-lg" role="document"  >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="edit_post_id" >Edit Post</h4>
            </div>
            <div class="modal-body">
                <form id="modi_form" enctype="multipart/form-data" >
                    <div class="form-group">
                        <input type="hidden" id="post_id" name="post_id" />
                        <input type="hidden" id="post_image_url" name="post_image_url" />
                        <input type="hidden" id="post_year" name="post_year" />
                        <label for="post_title" class="control-label">Post Title :</label>
                        <input type="text" class="form-control" id="post_title" name="post_title" >
                    </div>
                    <div class="form-group">
                        <label for="post-description" class="control-label">Post Description :</label>
                        <textarea class="form-control" id="post_description" name="post_description" ></textarea>
                    </div>
                    <div class="form-group">
                        <div align="center" class="alert alert-success" id="alert-success-modi" style="display:none;">Post Updated Successfully !</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="modi_submit();" >Submit</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var dt = [];
    var d = new Date();
    var year = d.getFullYear();
    var page;
    var ajaxurl = '{{URL::to('crud-get')}}';
    dt.push(year);
    
    i=1;
    
    while(i<=4){
    	// console.log(i)
    	y = year - i
    	dt.push(y)
    	i++
    }
    
    // console.log(dt)
    
    $.each(dt, function(index, value) {
    	$('#year').append($('<option>').text(value).attr('value', value));
    });
    
    $("#year").change(function(){
    
    	year = $("#year").val();
    	
    	$('table tr').has('.checkbox').remove();
    
    	$.ajax({
    	
    	type:"POST",
    	url:ajaxurl+"?_token={{ csrf_token() }}&key=ajax-content&year="+year,
    	success:function(data){
    		if(data.data.length==0){
    			// console.log(data.data.length);
    			// alert("No Content !");
    			$("#alert-danger").show();
    			setTimeout(function(){$("#alert-danger").slideUp(500);},5000);
    		}
    		else if (data.data.length>0){
    
    			for(var i=0;i<data.data.length;i++){
    
    				title = data.data[i].title;
    				description = data.data[i].description;
    				year = moment.utc(data.data[i].created_on).format("ddd, Do MMM YYYY [at] HH:mm");
    				id = data.data[i].id;
    
    				checkbox = "<input type='checkbox' class='checkbox' name='chk[]' onclick='check_tag();' value='"+id+"' />";
    				action ="<button class='btn-danger' id='"+id+"'onclick='del_id(this.id);' >Delete</button> <button class='btn-primary' id='"+id+"'onclick='mod_id(this.id);' >Modify</button>";
    				$("#selector-post").append("<tr id='"+id+"' align='center' ><td>"+checkbox+"</td><td>"+title+"</td><td>"+description+"</td><td>"+year+"</td><td>"+action+"</td></tr>");
    
    			}
    
    			page = data.current_page;
    			// alert(page);
    
    		}
    	},
    	error:function(err){
    		alert("Error : "+err.statusText+" Has Occured !"),console.log(err);
    	}
    
    	})
    
    })
    
    
    var chkbox_all = document.getElementById("chkbox_all"); //select all checkbox
    var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items
    
    chkbox_all.addEventListener("change", function(e){
    		for (w = 0; w < checkboxes.length; w++) {
    			checkboxes[w].checked = chkbox_all.checked;
    		}
    	});
    
    function check_tag(){
    	for (var q = 0; q < checkboxes.length; q++) {
    		// alert('check_tag');
    	checkboxes[q].addEventListener('change', function(e){
    		if(this.checked == false){
    			chkbox_all.checked = false;
    			}
    		});
    	}
    }
    
    
    function del_id(id){
    
    // console.log(id);
    
    alertify.confirm("Are You Sure You Want To Permanently Delete The Records ?", function (e) {
    
    	if (e) {
    
    		$.ajax({
    	
    	type:"POST",
    	url:ajaxurl+"?_token={{ csrf_token() }}&key=ajax-delete&id="+id,
    	success:function(data){
    
    		$('table#selector-post tr#'+id).remove();
    		// console.log(data);
    		// console.log('table#selector-post tr#'+id);
    		alertify.success("Record Deletted Successfully");
    	},
    	error:function(err){
    		alert("Error : "+err.statusText+" Has Occured !"),console.log(err);
    	}
    
    });
    
    
    	} else {
    	alertify.error("Record Deletion Cancelled !");
    	}
    
    	});
    
    }
    
    
    function bulk_del(){
    
    
    alertify.confirm("Are You Sure You Want To Permanently Delete The Records ?", function (e) {
    
    	if (e) {
    
    	var bulk=[];
    	$('.checkbox:checked').each(function() {
    	  bulk.push($(this).val());
    	});
    
    	$.ajax({
    	
    	type:"POST",
    	data:{'bulk_id':bulk},
    	url:ajaxurl+"?_token={{ csrf_token() }}&key=ajax-delete",
    	success:function(data){
    		console.log(data);
    		$('table tr').has('.checkbox:checked').remove();
    	},
    	error:function(err){
    		alert("Error : "+err.statusText+" Has Occured !"),console.log(err);
    	}
    
    });
    
    
    	} else {
    	alertify.error("Record Deletion Cancelled !");
    	}
    
    });
    
    // console.log(bulk);
    
    }
    
    
    function mod_id(id){
    
    // console.log(id);
    
    $.ajax({
    	
    	type:"POST",
    	data:{'mod_id':id},
    	url:ajaxurl+"?_token={{ csrf_token() }}&key=ajax-modify",
    	success:function(data){
    		// console.log(data);
    		$("#post_id").val(data.data.id);
    		$("#post_title").val(data.data.title);
    		$("#post_description").val(data.data.description);
    		$("#post_year").val(moment.utc(data.data.modified_on).format("ddd, Do MMM YYYY [at] HH:mm"));
    		$('#modi_modal').modal('show');
    
    	},
    	error:function(err){
    		alert("Error : "+err.statusText+" Has Occured !"),console.log(err);
    	}
    
    });
    
    }
    
    
    function modi_submit(){
    
    var modi_form = new FormData($("#modi_form")[0]);
    // console.log(modi_form);
    
    $.ajax({
    	
    	type:"POST",
    	data:modi_form,
    	url:ajaxurl+"?_token={{ csrf_token() }}&key=ajax-modify-update",
    	cache: false,
    	contentType: false,
    	processData: false,
    	success:function(data){
    
    		$("#alert-success-modi").show();
    		
    			setTimeout(function(){
    				$("#alert-success-modi").slideUp(500);
    				$('#modi_modal').modal('hide');},
    			3000);
    
    			var m_id = $("#post_id").val();
    			var m_t = $("#post_title").val();
    			var m_d = $("#post_description").val();
    			var y_d = $("#post_year").val();
    			// console.log(y_d);
    			$('table#selector-post tr#'+m_id).remove();
    
    			$("#selector-post").append("<tr id='"+m_id+"' align='center' ><td>"+checkbox+"</td><td>"+m_t+"</td><td>"+m_d+"</td><td>"+y_d+"</td><td>"+action+"</td></tr>");
    
    			$("#modi_form")[0].reset();
    			
    			// console.log(data);
    		
    	},
    	error:function(err){
    		alert("Error : "+err.statusText+" Has Occured !"),console.log(err);
    	}
    
    });
    
    
    }
    
    
    
    function load_more(){
    
    $("#loader").css("display","block")
    
    if (page>=1){
    
    	year = $("#year").val();
    
    	if(page==1){
    		page +=1;
    		// alert(page);
    	}
    
    	$.ajax({
    	
    	type:"POST",
    	url:ajaxurl+"?_token={{ csrf_token() }}&key=ajax-content&year="+year+"&page="+page,
    	success:function(data){
    		if(data.data.length==0){
    			
    			// console.log(data.data.length);
    			// alert("No Content !");
    			
    			$("#alert-danger-load").show();
    			setTimeout(function(){$("#alert-danger-load").slideUp(500);},5000);
    			$("#loader").fadeOut();
    
    		}
    		else if (data.data.length>0){
    
    			for(var i=0;i<data.data.length;i++){
    
    				title = data.data[i].title;
    				description = data.data[i].description;
    				year = moment.utc(data.data[i].created_on).format("ddd, Do MMM YYYY [at] HH:mm");
    				id = data.data[i].id;
    				
    				checkbox = "<input type='checkbox' class='checkbox' name='chk[]' onclick='check_tag();' value='"+id+"' />";
    
    				action ="<button class='btn-danger' id='"+id+"'onclick='del_id(this.id);' >Delete</button> <button class='btn-primary' id='"+id+"'onclick='mod_id(this.id);' >Modify</button>";
    				$("#selector-post").append("<tr id='"+id+"' align='center' ><td>"+checkbox+"</td><td>"+title+"</td><td>"+description+"</td><td>"+year+"</td><td>"+action+"</td></tr>");
    
    			}
    
    			page +=1;
    			// alert(page);
    
    			$("#loader").fadeOut();
    
    		}
    	},
    	error:function(err){
    		alert("Error : "+err.statusText+" Has Occured !"),console.log(err);
    		$("#loader").fadeOut();
    	}
    
    	})
    
    }
    
    }
    
</script>
@endsection