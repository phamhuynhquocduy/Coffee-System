@extends('admin')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Danh mục sản phẩm</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Trang chủ</a></li>
              <li class="breadcrumb-item active">Thêm danh mục sản phẩm</li>
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
              <h3 class="card-title">Thêm danh mục sản phẩm</h3>

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
              @foreach ($edit_cate as $edit)
                  <form action="{{route('category.update',$edit->id)}}" method="POST"  enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                      <label for="inputName">Tên danh mục</label>
                      <input type="text" value="{{$edit->name}}" name="inputName" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="inputDescription">Mô tả danh mục</label>
                      <textarea name="inputDescription" class="form-control" rows="4">{{$edit->description}}</textarea>
                    </div>
                    <div class="form-group">
                      <img src="{{asset('public/save/images/category')}}/{{$edit->image}}" style="width: 80px; height: 80px;" alt=""> <br>
                      <label for="inputDescription">Hình ảnh danh mục</label>
                      <input type="file" class="form-control" name="inputImage" id="">
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
              <input type="submit" value="Cập nhật danh mục" class="btn btn-success float-right">
            </div>
            <div class="col-1"></div>
          </div>
          </form>
              @endforeach
    </section>
    <!-- /.content -->
@endsection