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
              <li class="breadcrumb-item active">Tất cả tài khoản</li>
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
          <h3 class="card-title">Tất cả tài khoản</h3>

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
                      <th style="width: 20%">
                          Tên tài khoản
                      </th>
                      <th style="width: 25%">
                          Username
                      </th>
                      <th>
                          Email
                      </th>
                      <th style="width: 20%">
                      </th>
                  </tr>
              </thead>
              <tbody>
              @foreach ($customer as $cus)
                  <tr>
                      <td>
                          {{$cus->id}}
                      </td>
                      <td>
                          <strong>
                              {{$cus->name}}
                          </strong>
                      </td>
                      <td>
                        <strong>
                            {{ $cus->username }}
                        </strong>
                      </td>
                      <td class="project_progress">
                          {{ $cus->email }}
                      </td>
                      <td class="project-actions text-right">
                          
                          <a class="btn btn-info btn-sm" href="{{route('customer.edit',$cus->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Sửa
                          </a>
                          <a class="btn btn-danger btn-sm" href="{{route('customer.destroy',$cus->id)}}" onclick="return confirm('Bạn có chắc muốn xóa tài khoản này không?')">
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
              <div class="col-sm-4">{{$customer->links('pagination::bootstrap-4')}}</div>
              <div class="col-sm-3"></div>
              
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection