@extends('admin')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Thuộc tính sản phẩm</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Trang chủ</a></li>
              <li class="breadcrumb-item"><a href="{{route('product.create')}}">Thêm sản phẩm</a></li>
              <li class="breadcrumb-item active">Thêm thuộc tính sản phẩm</li>
            </ol>
          </div>
        </div>
    </div>
    <section class="content">
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-10">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Thêm thuộc tính sản phẩm</h3>
  
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
                <form action="{{route('attribute.post-create')}}" method="post">
                {{ csrf_field() }}
                  <div class="form-group">
                    <label for="inputName">Tên thuộc tính</label>
                    <input type="text" name="name_attr" class="form-control"  maxlength="100" required>
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
            <a href="{{ route('attribute.index') }}" class="btn btn-primary float-left">Tất cả thuộc tính</a>
            <input type="submit" value="Thêm" class="btn btn-success float-right">
          </div>
          <div class="col-1"></div>
        </div>
        </form>
      </section>
@endsection