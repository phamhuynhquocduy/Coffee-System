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
              <li class="breadcrumb-item active">Thêm sản phẩm</li>
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
              <h3 class="card-title">Thêm sản phẩm</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="inputProjectLeader">Danh mục sản phẩm</label>
                  <select name="inputCategory" class="form-control custom-select">
                    <option selected disabled>Chọn một</option>
                    <option>Cà phê</option>
                    <option>Sinh tố</option>
                    <option>Nước ép</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="inputName">Tên sản phẩm</label>
                  <input type="text" name="inputName" class="form-control">
                </div>
                <div class="form-group">
                  <label for="inputDescription">Mô tả sản phẩm</label>
                  <textarea name="inputDescription" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                  <label for="inputClientCompany">Hình ảnh sản phẩm</label>
                  <input type="file" name="inputImage" class="form-control">
                </div>
                <div class="form-group">
                  <label for="inputProjectLeader">Giá tiền sản phẩm</label>
                  <input type="text" name="inputPrice" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="inputProjectLeader">Giảm giá</label>
                  <input type="number" class="form-control" name="inputSale" max="100" min="0">
                </div>
                <div class="form-group">
                  <label for="inputStatus">Trạng thái sản phẩm</label>
                  <select name="inputStatus" class="form-control custom-select">
                    <option selected disabled>Chọn một</option>
                    <option>Còn</option>
                    <option>Hết</option>
                  </select>
                </div>
              </form>
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
          <input type="submit" value="Thêm sản phẩm" class="btn btn-success float-right">
        </div>
        <div class="col-1"></div>
      </div>
    </section>
    <!-- /.content -->
@endsection