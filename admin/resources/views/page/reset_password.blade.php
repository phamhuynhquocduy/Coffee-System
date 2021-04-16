<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Admin | Coffee System</title>

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
  <div class="row">
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-header text-center">
        <h4><strong>Đặt lại mật khẩu</strong></h4>
      </div>
      <div class="card-body">
        <div class="row"> 
          <?php
          $message = session()->get('message');
          if($message){
            echo $message;
            session()->put('message', null);
          }
          ?>
        </div>
        <div class="row col-md-12">
          @foreach ($reset as $r)
          <form action="{{ route('post-reset-password-api', $r->token) }}" method="post">
            {{ csrf_field() }}
              <p class="text-center">{{ $r->email }}</p>
              <div>
                <input type="password" name="password" class="form-control" placeholder="New password ... ">
              </div>
              <br>
              <div>
                <input type="password" name="re_password" class="form-control" placeholder="Re new password ... "> <br>
              </div>
            <div class="row">
              <!-- /.btn -->
                <button type="submit" class="btn btn-primary btn-block">Đổi mật khẩu</button>
              <!-- /.btn -->
            </div>
          </form>
          @endforeach
        </div>
      </div>
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
