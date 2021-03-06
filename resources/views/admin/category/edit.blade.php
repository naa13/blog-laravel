@extends('admin.layout.index')

@section('content')

<!-- MAIN -->
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">Sửa Chuyên Mục</h3>
                </div>
                <div class="panel-body">
                    @if(count($errors) > 0)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                                <strong>Lỗi:</strong> {{ $error }} <br>
                            </div>
                        @endforeach
                    @endif
                    @if(session('message'))
                        <div class="alert alert-{{ session('status') }}">
                            <strong>{{ session('message') }}</strong>
                        </div>
                    @endif
                    <div class="row">
                        <form action="{{ url('admin/category/edit/'.$category->id) }}" method="POST" role="form">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="">Thuộc chuyên mục</label>
                                <select name="cat_id" id="inputCat_id" class="form-control" required="required">
                                    <option value="0">Gốc</option>
                                    @foreach($categories as $cat)
                                        @if($cat->id == $category->parent_id)
                                            <option value="{{ $cat->id }}" selected="">{{ $cat->name }}</option>
                                        @else
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Tên</label>
                                <input type="text" name="name" class="form-control" id="" placeholder="Tên chuyên mục" required="required" value="{{ $category->name }}">
                            </div>
                            <div class="form-group">
                                <label for="">Thứ tự hiển thị</label>
                                <input type="number" name="order" class="form-control" min="0" placeholder="Thứ tự" required="required" value="{{ $category->order }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Sửa</button>
                            <button type="reset" class="btn btn-primary">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END OVERVIEW -->
        </div>
    </div>
    <!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->

@endsection
