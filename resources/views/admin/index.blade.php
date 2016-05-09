@extends('layouts.admin-index')
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
  	
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Tiêu đề</th>
					<th>Ảnh</th>
					<!-- <th>Creator</th> -->
					<th>Ngày tạo</th>
					<th>Sửa</th>
					<th>Xóa</th>
				</tr>
			</thead>
			<tbody>
				@if ( count($posts)) @foreach ($posts as $post)
				<tr>
					<td>
						{{$post->title}}
					</td>
					<td>
						<img class="img-responsive" width="200" height="200" src="{{url($post->image)}}" alt="">
					</td>
					<td>
						{{date('d-m-Y',strtotime($post->created_ad))}}
					</td>
					<td>
						<button class="btn btn-xs btn-warning">Sửa</button>
					</td>
					<td>
						<button class="btn btn-xs btn-danger" onclick="deleteXoa(
						{{$post->id}})">Xóa</button>
					</td>
				</tr>
				@endforeach @endif
			</tbody>
		</table>

    </div><!-- /.box-body -->
<!--     <div class="box-footer">
      Footer
    </div> --><!-- /.box-footer-->
  </div><!-- /.box -->

</section><!-- /.content -->

@endsection

@section('script')
	
	<script>
		function deleteXoa(id) {
			swal({   
				title: "Are you sure?",   
				text: "You will not be able to recover this imaginary file!",  
				type: "warning",   
				showCancelButton: true,   
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "Yes, delete it!",   
				closeOnConfirm: false }, 
				function(){   
					$.ajaxSetup({
				        headers: {
				            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				        }
					});
					$.ajax({
						url:'admin/xoa/' + id,
						type:'delete',
						data:{
							id:id
						},
						success: function (data) {
							window.location.reload();
						}
					})
				});
		}
	</script>

@endsection