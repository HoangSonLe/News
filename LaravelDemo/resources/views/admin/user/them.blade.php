@extends('admin.layouts.index')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User
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
            <div class="col-lg-7" style="padding-bottom:120px">
                <form action="admin/user/them" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label>Họ Tên</label>
                        <input class="form-control" name="Ten" placeholder="Please Enter Name" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="Email" placeholder="Please Enter Email" />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="Password" class="form-control" name="Password" placeholder="Please Enter Password" />
                    </div>
                    <div class="form-group">
                        <label>Nhập lại Password</label>
                        <input type="Password" class="form-control" name="PasswordAgain" placeholder="Please Enter Password Again" />
                    </div>
                    
                    <div class="form-group">
                        <label>Quyền người dùng</label>
                        <label class="radio-inline">
                            <input name="Level" value="0" checked="" type="radio">Thường
                        </label>
                        <label class="radio-inline">
                            <input name="Level" value="1" type="radio">Admin
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Thêm</button>
                    <button type="reset" class="btn btn-default">Làm mới</button>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>

<!-- /#page-wrapper -->

@endsection