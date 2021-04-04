@extends('admin')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sản phẩm</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Trang chủ</a></li>
              <li class="breadcrumb-item active">Tất cả sản phẩm</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Tất cả sản phẩm</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="row">
            <div class="col-sm-12">
              <div class="col-sm-1"></div>
              <div class="col-sm-11">
              <?php
              $message = Session::get('message');
              if($message){
                echo $message;
                Session::put('message', null);
              }
              ?>
              </div>
            </div>
          </div>
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 15%">
                          Tên sản phẩm
                      </th>
                      <th style="width: 15%">
                          Hình ảnh sản phẩm
                      </th>
                      <th>
                          Mô tả sản phẩm
                      </th>
                      <th style="width: 15%">
                          Giá sản phẩm
                      </th>
                      <th style="width: 20%">
                      </th>
                  </tr>
              </thead>
              <tbody>
              @foreach ($list_product as $pro)
                  <tr>
                      <td>
                          {{$pro->id}}
                      </td>
                      <td>
                          <strong>
                              {{$pro->name}}
                          </strong>
                      </td>
                      <td>
                      <img src="{{asset('{{$pro->image}}')}}" style="width: 50px; height: 50px;" alt="">
                      </td>
                      <td class="project_progress">
                          {{$pro->description}}
                      </td>
                      <td class="project_progress">
                          {{$pro->price}}
                      </td>
                      <td class="project-actions text-right">
                          
                          <a class="btn btn-info btn-sm" href="{{route('product.edit',$pro->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Sửa
                          </a>
                          <a class="btn btn-danger btn-sm" href="{{route('product.destroy',$pro->id)}}" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')">
                              <i class="fas fa-trash">
                              </i>
                              Xóa
                          </a>
                      </td>
                  </tr>
              @endforeach
              </tbody>
          </table>
          <br><br>
          <div class="row col-lg-12 text-center">
              <div class="col-sm-5"></div>
              <div class="col-sm-4">{{$list_product->links('pagination::bootstrap-4')}}</div>
              <div class="col-sm-3"></div>
              
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection