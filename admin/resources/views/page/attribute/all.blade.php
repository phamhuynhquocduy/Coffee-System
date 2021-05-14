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
                    <li class="breadcrumb-item active">Tất cả thuộc tính sản phẩm</li>
                </ol>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tất cả thuộc tính sản phẩm</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10%">ID</th>
                            <th style="width: 70%">Tên</th>
                            <th style="width: 20%">Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all as $value)
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->name_attr }}</td>
                            <td>
                                <a href="" class="btn btn-primary"><i class="fas fa-edit"></i> Sửa</a>
                                <a href="{{ route('attribute.delete', $value->id) }}" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa thuộc tính sản phẩm này không?')"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</section>
@endsection