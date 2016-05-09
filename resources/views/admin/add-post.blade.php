@extends('layouts.admin-index')
@section('style')
	<link rel="stylesheet" type="text/css" href="{{url('bootstrap-tagsinput.css')}}">
	<style>
		label.error {
			color: red;
			display: block;
		}
	</style>
@endsection
@section('content')

<section class="content-header">
  <h1>
    Blank page
    <small>it all starts here</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li>
    <li class="active">Blank page</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <!-- <h3 class="box-title">Title</h3> -->
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
  	
		<form id="add-post" action="{{url('admin/add-post')}}" method="POST" role="form" enctype="multipart/form-data">
			<legend>ADD</legend>
			
			{{csrf_field()}}
			<div class="form-group">
				<label for="">Tiêu đề</label>
				@if ($errors->has('title'))
					<p style="color: red;">{{$errors->first('title')}}</p>
				@endif
				<input type="text" class="form-control" id="title" placeholder="Tiêu đề" name="title">
			</div>
			<div class="form-group">
				<label for="">Ảnh</label>
				@if ($errors->has('image'))
					<p style="color: red;">{{$errors->first('image')}}</p>
				@endif
				<input type="file" name="image" id="image">
			</div>
			<div class="form-group">
				<label for="">Tóm tắt</label>
				@if ($errors->has('description'))
					<p style="color: red;">{{$errors->first('description')}}</p>
				@endif
				<textarea name="description" class="form-control" id="description" cols="30" rows="5"></textarea>
			</div>
			<div class="form-group">
				<label for="">Nội dung</label>
				@if ($errors->has('content'))
					<p style="color: red;">{{$errors->first('content')}}</p>
				@endif
				<textarea name="content" class="form-control" id="content" cols="30" rows="5"></textarea>
			</div>
			<div class="form-group">
				<label for="">Tags</label>
				<select name="tags[]" id="tags" data-role="tagsinput" class="form-control" multiple></select>
			</div>
			<div class="form-group">
				<label for="">Status</label>
				<select name="status" class="form-control" id="status">
					<option value="1">Public</option>
					<option value="0">Private</option>
				</select>
			</div>

			
		
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>

    </div><!-- /.box-body -->
<!--     <div class="box-footer">
      Footer
    </div> --><!-- /.box-footer-->
  </div><!-- /.box -->

</section><!-- /.content -->

@endsection
@section('script')
    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
    <script src="{{url('bootstrap-tagsinput.js')}}"></script>
	<!-- script jquery validate -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.min.js"></script>
     <script>
      $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('content');

      });
    </script>
	<!-- validate bằng jquery -->
    <script>
    	$('#add-post').validate({
    		rules: {
    			title: {
    				required:true,
    			},
    			image: {
    				required:true,
    				accept: "image/*"
    			},
    			description: {
    				required:true,
    			},
    			//jquery validate cho ckeditor
    			content: {
	                required: function() 
	                {
		                CKEDITOR.instances.content.updateElement();
	                }
                }
            },
    		messages: {
    			title: {
    				required: "Tiêu đề không được trống",
    			},
    			image: {
    				required: "Ảnh không được trống",
    				accept: "Chỉ được phép chọn ảnh"
    			},
    			description: {
    				required: "Tóm tắt không được trống",
    			},
    			content: {
    				required: "Nội dung không được trống",
    			},
    			 /* use below section if required to place the error*/
                
    		},
    		errorPlacement: function(error, element) 
                {
                    if (element.attr("name") == "content") 
                   {
                    error.insertBefore("textarea#content");
                    } else {
                    error.insertBefore(element);
                    }
                },
    		submitHandle: function(form) {
    			$(form).submit();
    		}
    	});
    </script>
@endsection