@extends('admin')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tài khoản khách hàng</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Trang chủ</a></li>
              <li class="breadcrumb-item active">Cập nhật tài khoản khách hàng</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Cập nhật tài khoản khách hàng</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
              <?php
              $message = Session::get('message');
              if($message){
                echo $message;
                Session::put('message', null);
              }
              ?>
              </div>
              @foreach ($edit_customer as $edit)
              <form action="{{route('customer.update', $edit->id)}}" method="POST">
                {{csrf_field()}}
                <div class="form-group">
                  <label for="inputName">Tên khách hàng</label>
                  <input type="text" name="name" value="{{$edit->name}}" class="form-control" placeholder="Tên khách hàng ..." maxlength="50" required>
                </div>
                <div class="form-group">
                  <label for="inputDescription">Tài khoản</label>
                  <input type="text" name="username" value="{{$edit->username}}" class="form-control" placeholder="Tên tài khoản ..." maxlength="50" required>
                </div>
                <div class="form-group">
                  <label for="inputDescription">Mật khẩu mới</label>
                  <input type="password" name="password" placeholder="Mật khẩu ..." class="form-control" maxlength="50">
                </div>
                <div class="form-group">
                  <label for="inputDescription">Email</label>
                  <input type="email" name="email" value="{{$edit->email}}" placeholder="Email ..." class="form-control" maxlength="100" required>
                </div>
                <div class="form-group">
                  <label for="inputDescription">Số điện thoại</label>
                  <input type="text" name="phone" value="{{$edit->phone}}" placeholder="Số điện thoại ..." class="form-control" pattern="[0]{1}[0-9]{9}" minlength="10" maxlength="10" required>
                </div>
                <div class="form-group">
                  <label for="inputDescription">Địa chỉ</label>
                  <input type="text" name="address" value="{{$edit->address}}" placeholder="Địa chỉ ..." class="form-control" maxlength="200" required>
                </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-1"></div>
      </div>
      <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
          <input type="submit" value="Cập nhật tài khoản" class="btn btn-success float-right">
        </div>
        <div class="col-1"></div>
      </div>
      </form>
      @endforeach
    </section>
    <!-- /.content -->
@endsection