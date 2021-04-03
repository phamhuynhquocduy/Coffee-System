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
          <div class="form-group">
          <?php
          $message = Session::get('message');
          if($message){
            echo $message;
            Session::put('message', null);
          }
          ?>
          </div>
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 10%">
                          Tên danh mục
                      </th>
                      <th style="width: 15%">
                          Tên sản phẩm
                      </th>
                      <th style="width: 10%">
                          Hình sản phẩm
                      </th>
                      <th style="width: 17%">
                          Mô tả
                      </th>
                      <th>
                          Giá
                      </th>
                      <th style="width: 7%" class="text-center">
                          Trạng thái
                      </th>
                      <th style="width: 20%">
                      </th>
                  </tr>
              </thead>
              <tbody>
              @foreach ($list_product as $list)
                  <tr>
                      <td>
                          {{$list->id}}
                      </td>
                      <td>
                      @foreach ($list_cate as $cate)
                        @if ($cate->id == $list->id_category)
                          <strong>{{$cate->name}}</strong>
                        @endif
                      @endforeach
                      </td>
                      <td>
                          <strong>
                              {{$list->name}}
                          </strong>
                      </td>
                      <td>
                          <img style="width: 50px; height:50px;" src="{{asset('public/save/images/product')}}/{{$list->image}}" alt="">
                      </td>
                      <td class="project_progress">
                          {{$list->description}}
                      </td>
                      <td class="project_progress">
                          <strong>
                          Giá: {{$list->price}} vnd 
                          </strong>
                      </td>
                      <td class="project-state">
                      @if ($list->status == 'Còn')
                          <span class="badge badge-success">{{$list->status}}</span>
                      @else
                          <span class="badge badge-danger">{{$list->status}}</span>
                      @endif
                      </td>
                      <td class="project-actions text-right">
                          
                          <a class="btn btn-info btn-sm" href="{{route('product.edit',$list->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Sửa
                          </a>
                          <a class="btn btn-danger btn-sm" href="{{route('product.destroy',$list->id)}}" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')">
                              <i class="fas fa-trash">
                              </i>
                              Xóa
                          </a>
                      </td>
                  </tr>
                  @endforeach
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection