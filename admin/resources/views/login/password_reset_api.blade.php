<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Customer | Coffee System</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('public/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('public/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-header text-center">
      <h4><strong>Quên mật khẩu</strong></h4>
    </div>
    <div class="card-body login-card-body">
      <div class="row">
        <div class="col-md-12">
          <?php
            $message = Session::get('message');
            if($message){
              echo $message;
              Session::put('message', null);
            }
          ?>
        </div>
      </div>
      <form action="{{ route('post-send-mail-api') }}" method="post">
        {{ csrf_field() }}
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email ... ">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-email"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.btn -->
            <button type="submit" class="btn btn-primary btn-block">Gửi mail xác nhận</button>
          <!-- /.btn -->
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('public/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('public/dist/js/adminlte.min.js')}}"></script>
</body>
</html>
