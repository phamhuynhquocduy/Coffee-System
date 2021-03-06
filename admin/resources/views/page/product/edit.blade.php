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
              <li class="breadcrumb-item active">Cập nhật sản phẩm</li>
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
              <h3 class="card-title">Cập nhật sản phẩm</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
            @foreach ($edit_pro as $edit)
              <form action="{{route('product.update', $edit->id)}}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
                <div class="form-group">
                  <label for="inputProjectLeader">Danh mục sản phẩm</label>
                  <select name="inputCategory" class="select form-control custom-select" required>
                    @foreach ($list_cate as $cate)
                      @if ($cate->id == $edit->id_category)
                      <option value="{{$cate->id}}">{{$cate->name}}</option>
                      @endif
                    @endforeach
                    @foreach ($list_cate as $list)
                    <option value="{{$list->id}}">{{$list->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="inputName">Tên sản phẩm</label>
                  <input type="text" value="{{$edit->name}}" name="inputName"  maxlength="100" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="inputDescription">Mô tả sản phẩm</label>
                  <textarea name="inputDescription" class="form-control" rows="4" required>{{$edit->description}}</textarea>
                </div>
                <div class="form-group">
                  <img src="{{asset('/')}}{{$edit->image}}" style="witdh: 80px; height: 80px;" alt="" > <br>
                  <label for="inputClientCompany">Hình ảnh sản phẩm</label>
                  <input type="file" name="inputImage" class="form-control">
                </div>
                <div class="form-group">
                  <label for="inputProjectLeader">Giá tiền sản phẩm</label>
                  <input type="text" value="{{$edit->price}}" name="inputPrice" class="form-control" required>
                </div>

                {{-- attribute-product --}}
                @foreach ($attrs as $attr)
                  <div class="form-group">
                    <input type="hidden" value="{{ $attr->id }}">
                    <label for="attr-{{ $loop->index }}">{{ $attr->name_attr }}</label>
                    <div class="row">
                      <div class="col-md-6"><input type="text" name="attr_name[{{ $attr->id }}]" id="attr-name-{{ $loop->index }}" class="form-control" value="@if(!empty($edit->attrs[$loop->index]->pivot->name_attr_value)) {{$edit->attrs[$loop->index]->pivot->name_attr_value}} @endif"></div>
                      <div class="col-md-6"><input type="text" name="attr_price[{{ $attr->id }}]" id="attr-price-{{ $loop->index }}" class="form-control" value="@if(!empty($edit->attrs[$loop->index]->pivot->price_attr_value)) {{$edit->attrs[$loop->index]->pivot->price_attr_value}} @endif"></div>
                    </div>
                  </div>
                @endforeach
                {{-- // attribute-product --}}
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
          <input type="submit" value="Cập nhật sản phẩm" class="btn btn-success float-right">
        </div>
        <div class="col-1"></div>
      </div>
      </form>
      @endforeach
    </section>
    <!-- /.content -->
@endsection