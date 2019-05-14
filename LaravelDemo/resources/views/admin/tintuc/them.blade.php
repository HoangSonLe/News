@extends('admin.layouts.index')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tin Tức
                    <small>Thêm</small>
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

                <form action="admin/tintuc/them" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="col-md-7">
                        <div class="form-group">
                            <label>Thể loại</label>
                            <select class="form-control" name="TheLoai" id="TheLoai">
                                @foreach($theloai as $tl)
                                <option value="{{$tl->id}}">{{$tl->Ten}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Loại Tin</label>
                            <select class="form-control" name="LoaiTin" id="LoaiTin">
                           {{--  @foreach($loaitin as $lt)
                                <option value="{{$lt->id}}">{{$lt->Ten}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input class="form-control" name="TieuDe" placeholder="Please Enter Category Name" / value="{!!old('TieuDe')!!}">
                        </div>
                        <div class="form-group">
                            <label>Tóm tắt</label>
                            <textarea id="demo" class=" form-control ckeditor" name="TomTat">{!!old('TomTat')!!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea id="demo" class=" form-control ckeditor" name="NoiDung">{!!old('NoiDung')!!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <input type="file" name="Hinh" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Nổi bật</label>
                            <label class="radio-inline">
                                <input name="NoiBat" value="0" checked="" type="radio">Không
                            </label>
                            <label class="radio-inline">
                                <input name="NoiBat" value="1" type="radio">Có
                            </label>
                        </div>
                        <button type="submit" class="btn btn-default">Thêm</button>
                        <button type="reset" class="btn btn-default">Làm mới</button>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                        @for($i=1 ;$i<=10; $i++)
                        <div class="form-group">
                            <label>Image Detail {!!$i!!}</label>
                            <input type="file" name="fNewsDetail[]" >
                        </div>
                        @endfor
                    </div>
                    <form>     
                    </div>
                </div>
                <!-- /.row -->
            </div>

            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

        @endsection

        @section('script')
        <script type="text/javascript">
            $(document).ready(function(){
            //load trang lần đầu
            var idTheLoai= $("#TheLoai").val();
            $.get("admin/ajax/loaitin/" + idTheLoai,function(data){
                $("#LoaiTin").html(data);
            });

            $('#TheLoai').change(function(event) {
             /* Act on the event */
             var idTheLoai= $(this).val();
             $.get("admin/ajax/loaitin/" + idTheLoai,function(data){
                $("#LoaiTin").html(data);
            });
         });
        });

    </script>
    @endsection