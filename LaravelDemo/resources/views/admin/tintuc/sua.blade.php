@extends('admin.layouts.index')

@section('content')
<style>
    .img_detail{
        width: 200px;
        height: 130px;
        margin-bottom: 20px;
        border: 1px solid blue;
    }
    .img{
        width: 130px;
        height: 130px;
        margin-bottom: 20px;
    }
    .icon_del{
        position: relative;
        top: -55px;
        left: 2px;
    }
    #insert{
        margin-top: 20px;
    }
</style>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tin Tức
                    <small>{{$tintuc->TieuDe}}</small>
                </h1>
            </div>
            @if(count($errors)> 0)
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            {{$error}}<br>
                        @endforeach

                    </div>
                @endif

                @if(session('thongbao'))
                    <div class="alert alert-success">
                        {{session('thongbao')}}

                    </div>
                @endif
            <!-- /.col-lg-12 -->
            <div class="col-lg-12" style="padding-bottom:120px">

                <form action="admin/tintuc/sua/{{$tintuc->id}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="col-md-7">
                    <div class="form-group">
                        <label>Thể loại</label>
                        <select class="form-control" name="TheLoai" id="TheLoai">
                            @foreach($theloai as $tl)
                                <option 
                                    @if($tintuc->loaitin->theloai->id == $tl->id) {{"selected"}}
                                    @endif
                                    value="{{$tl->id}}">{{$tl->Ten}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Loại Tin</label>
                        <select class="form-control" name="LoaiTin" id="LoaiTin">
                            @foreach($loaitin as $lt)
                                <option 
                                    @if($tintuc->loaitin->id == $lt->id) {{"selected"}}
                                    @endif
                                    value="{{$lt->id}}">{{$lt->Ten}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input class="form-control" name="TieuDe" value="{{$tintuc->TieuDe}}" placeholder="Please Enter Category Name" />
                    </div>
                    <div class="form-group">
                        <label>Tóm tắt</label>
                        <textarea id="demo" class=" form-control ckeditor" name="TomTat">{{$tintuc->TomTat}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Nội dung</label>
                        <textarea id="demo" class=" form-control ckeditor" name="NoiDung">{{$tintuc->NoiDung}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh</label>
                        <img class="img" src="upload/tintuc/{{$tintuc->Hinh}}" alt="Hình không tồn tại">
                        <input type="file" name="Hinh" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>Nổi bật</label>
                        <label class="radio-inline">
                            <input name="NoiBat" value="0"
                                @if($tintuc->NoiBat == 0) {{"checked"}}
                                @endif
                            type="radio">Không
                        </label>
                        <label class="radio-inline">
                            <input name="NoiBat" value="1"
                                @if($tintuc->NoiBat == 1) {{"checked"}}
                                @endif
                            type="radio">Có
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Sửa</button>
                    <button type="reset" class="btn btn-default">Làm mới</button>
                </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                        @foreach($images as $image)
                        <div class="form-group" id="{{$image->id}}">
                            <img class="img_detail" id="{{$image->id}}" src="upload/tintuc/detail/{{$image->image}}" alt="">
                            <a href="" class="btn btn-danger btn-circle icon_del"><i class="fa fa-times"></i></a>
                        </div>
                        @endforeach
                        <button type="button" id="addImage" class="btn btn-primary">Thêm ảnh</button>
                        <div id="insert"></div>
                    </div>
                <form>
            </div>
        </div>
        <!-- /.row -->
        {{-- list comment --}}
         <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tin Tức
                    <small>Danh Sách</small>
                </h1>
            </div>
            @if(session('thongbao'))
                    <div class="alert alert-success">
                        {{session('thongbao')}}

                    </div>
                @endif
            <!-- /.col-lg-12 -->
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Người dùng</th>
                        <th>Nội dung</th>
                        <th>Ngày đăng</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody id="comment">
                    @foreach($tintuc->comment as $cm)
                    <tr class="odd gradeX" align="center">
                        <td>{{$cm->id}}</td>
                        <td>{{$cm->user->name}}</td>
                        <td>{{$cm->NoiDung}}</td>
                        <td>{{$cm->created_at}}</td>
                
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a class="Xoa" id="{{$cm->id}}" href="admin/comment/xoa/{{$cm->id}}/{{$tintuc->id}}"> Xóa</a></td>
                        
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
        {{-- end row --}}
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

@endsection

@section('script')
    <script type="text/javascript">
        $(document).on("click",'.Xoa',function(event){ 
        /* Act on the event */
            event.preventDefault();
            var idComment = $(this).attr('id');
                // alert(idComment);
                $.get("admin/ajax/comment/" + idComment,function(data){
                    $("#comment").html(data);
                });
    });
        // $('.Xoa').click(function(event) {
        //     /* Act on the event */
        //     event.preventDefault();
        //     var idComment = $(this).attr('id');
        //         // alert(idComment);
        //         $.get("admin/ajax/comment/" + idComment,function(data){
        //             $("#comment").html(data);
        //         });
        //     });
        $(document).ready(function(){
            //load trang lần đầu

            $('#TheLoai').change(function(event) {
             /* Act on the event */
             var idTheLoai= $(this).val();
             $.get("admin/ajax/loaitin/" + idTheLoai,function(data){
                $("#LoaiTin").html(data);
            });
         });
        });

        $(document).on('click','#addImage',function(event) {
            event.preventDefault();
            $('#insert').append('<div class="form-group"><label>Image Detail</label><input type="file" name="fNewsDetail[]" ></div>')

        });
     

    </script>
@endsection