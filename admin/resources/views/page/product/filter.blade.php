@extends('admin')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Thuộc tính sản phẩm</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Trang chủ</a></li>
              <li class="breadcrumb-item active">Thuộc tính sản phẩm</li>
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
          <h3 class="card-title">Thuộc tính sản phẩm</h3>
          </div>
          <div class="card-body">
              <form action="{{ route('post-filter') }}" method="get">
                  <div class="row">
                    <!-- @csrf -->
                    <div class="col-md-5">
                        <label for="">Tên sản phẩm</label>
                        <select name="id_product" id="id_product" class="form-control">
                            @foreach ($product as $key)
                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="">Tên thuộc tính</label>
                        <select name="id_attribute" id="id_attribute" class="form-control">
                            @foreach ($attribute as $key)
                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <br>
                        <button type="submit" class="btn btn-primary btn-block">Filter</button>
                    </div>
                  </div>
              </form>
            </div>
        </div>
        <div class="card">
        <div class="card-header">
          <h4>Kết quả Filter</h4> 
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
            <?php
            $message = Session::get('message');
            if($message)
            {
              echo $message;
              Session::put('message', null);
            }
            ?>
            </div>
          </div>
          <div class="row">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Tên sản phẩm</th>
                  <th>Thuộc tính</th>
                  <th>Tên thuộc tính</th>
                  <th>Giá</th>
                  <th>Chức năng</th>
                </tr>
              </thead>
              <tbody>
              @if (!empty($result))
                @foreach ($result as $key)
                <tr>
                    <td>{{ $key->id }}</td>
                    @foreach ($product as $keyy)
                    @if ($key->id_product == $keyy->id)
                    <td>{{ $keyy->name }}</td>
                    @endif
                    @endforeach
                    @foreach ($attribute as $keyyy)
                    @if ($key->id_attribute == $keyyy->id)
                    <td>{{ $keyyy->name }}</td>
                    @endif
                    @endforeach
                    <td>{{ $key->name }}</td>
                    <td>{{ $key->price }}</td>
                    <td>
                      <button class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> Sửa</button>
                      <a href="{{ route('delete-attribute', $key->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                    </td>
                </tr>
                @endforeach
              @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
@endsection