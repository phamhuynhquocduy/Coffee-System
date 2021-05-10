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
                      <th style="width: 10%">
                          Tên danh mục
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
                      <th style="width: 5%">
                          Tình trạng
                      </th>
                      <th style="width: 20%">
                      </th>
                  </tr>
              </thead>
              <tbody>
              @foreach ($list_product as $pro)
                  <tr>
                      <td class="id">
                          {{$pro->id}}
                      </td>
                      <td>
                          <strong>
                          @foreach ($list_cate as $cate)
                            @if ($cate->id == $pro->id_category)
                              {{$cate->name}}
                            @endif
                          @endforeach
                          </strong>
                      </td>
                      <td>
                          <strong class="name_product">
                              {{$pro->name}}
                          </strong>
                      </td>
                      <td>
                      <img src="{{asset('/')}}{{$pro->image}}" style="width: 50px; height: 50px;" alt="">
                      </td>
                      <td class="project_progress">
                          {{$pro->description}}
                      </td>
                      <td class="project_progress">
                          {{$pro->price}}
                      </td>
                      <td class="project_progress">
                        @if ($pro->status == 'Còn')
                          <a href="{{ route('product.thumbs-down', $pro->id) }}">
                            <i class="fa fa-thumbs-up text-success" aria-hidden="true"></i>
                          </a>
                        @else
                          <a href="{{ route('product.thumbs-up', $pro->id) }}">
                            <i class="fa fa-thumbs-down text-danger" aria-hidden="true"></i>
                          </a>  
                        @endif
                      </td>
                      <td class="project-actions text-right">
                          <!-- <a class="btn btn-warning btn-sm" href="" >
                            <i class="fas fa-dice-d6"></i>
                              Thuộc tính
                          </a> -->
                          <!-- Button trigger modal -->
                          <button type="button" class="btn btn-warning btn-sm add" data-toggle="modal" data-id="{{ $pro->id }}"  data-target="#staticBackdrop1">
                            Topping
                          </button>
                          <button type="button" class="btn btn-secondary btn-sm add2" data-toggle="modal" data-id="{{ $pro->id }}" data-target="#staticBackdrop2">
                            Size
                          </button>
                          

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

          
          <!-- Modal Add Topping -->
          <div class="modal fade" id="staticBackdrop1" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">Thêm Topping</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="{{ route('product.save-attribute') }}" method="post">
                <div class="modal-body">
                  @csrf
                  <input type="hidden" name="id_attribute" value="1">
                  <div class="row">
                    <div class="col-6">
                      <label for="">Id sản phẩm</label>
                      <input type="text" id="id_product" name="id_product" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                      <label for="">Tên sản phẩm</label>
                      <input type="text" id="name_product" disabled="disabled" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <label for="">Tên topping</label>
                      <input type="text" name="topping" class="form-control">
                    </div>
                    <div class="col-6">
                      <label for="">Giá topping</label>
                      <input type="text" name="topping_price" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success">Thêm</button>
                </div>
                </form>
              </div>
            </div>
          </div>
          
          <!-- Modal Add Size -->
          <div class="modal fade" id="staticBackdrop2" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">Thêm Size</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="{{ route('product.save-attribute') }}" method="post">
                <div class="modal-body">
                @csrf
                  <input type="hidden" name="id_attribute" value="2">
                  <div class="row">
                    <div class="col-6">
                      <label for="">Id sản phẩm</label>
                      <input type="text" id="id_product1" name="id_product" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                      <label for="">Tên sản phẩm</label>
                      <input type="text" id="name_product1" disabled="disabled" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <label for="">Tên Size</label>
                      <input type="text" name="topping" class="form-control">
                    </div>
                    <div class="col-6">
                      <label for="">Giá Size</label>
                      <input type="text" name="topping_price" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success">Thêm</button>
                </div>
                </form>
              </div>
            </div>
          </div>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
    
@endsection