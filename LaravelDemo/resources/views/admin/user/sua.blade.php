@extends('admin.layouts.index')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User
                    <small>{{$user->name}}</small>
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
                <form action="admin/user/sua/{{$user->id}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label>Họ Tên</label>
                        <input class="form-control" value="{{$user->name}}" name="Ten" placeholder="Please Enter Name" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="{{$user->email}}" name="Email" placeholder="Please Enter Email" readonly="" />
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="changePassword" name="changePassword">
                        <label>Đổi Password</label>
                        <input type="Password" class="form-control password"  name="Password" placeholder="Please Enter Password" disabled="" />
                    </div>
                    <div class="form-group">
                        <label>Nhập lại Password</label>
                        <input type="Password" class="form-control password" name="PasswordAgain" placeholder="Please Enter Password Again" disabled="" />
                    </div>
                    
                    <div class="form-group">
                        <label>Quyền người dùng</label>
                        <label class="radio-inline">
                            <input
                                 name="Level" value="0" type="radio"
                                @if($user->quyen == 0) {{"checked"}}
                                @endif
                                >Thường
                        </label>
                        <label class="radio-inline">
                            <input
                                 name="Level" value="1" type="radio"
                                @if($user->quyen == 1) {{"checked"}}
                                @endif
                                >Admin
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Sửa</button>
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

@section('script')
<script type="text/javascript">
    
    // $(document).on('change','#changePassword',function(event){
    //     event.preventDefault();
    //     if('#changePassword')
    // });
    $(document).ready(function(){
        $('#changePassword').change(function(){
            if($(this).is(':checked')){
                $('.password').removeAttr('disabled');
            }
            else{
                $('.password').attr('disabled','');
            }
        });
    });
    
</script>
@endsection