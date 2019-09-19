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
                    <h3 class="panel-title">Quản Lý Chuyên Mục</h3>
                </div>
                <div class="panel-body">
                    @if(session('message'))
                    <div class="alert alert-{{ session('status') }}">
                        <strong>{{ session('message') }}</strong>
                    </div>
                    @endif
                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Trạng thái</th>
                                    <th>Thứ tự</th>
                                    <th>Thuộc chuyên mục</th>
                                    <th><i class="fa-2x fa fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    @if($category->visibility == 0)
                                    <td>Ẩn</td>
                                    @else
                                    <td>Hiện</td>
                                    @endif
                                    <td>{{ $category->order }}</td>
                                    @if($category->parent_id == 0)
                                    <td>Gốc</td>
                                    @else
                                    <td>{{$category->parent[0]->name}}</td>
                                    @endif
                                    <td>
                                        <a href="{{ url('admin/category/edit/'.$category->id) }}"><i class="fa-2x fa fa-pencil"></i></a>
                                        <a href="{{ url('admin/category/delete/'.$category->id) }}"><i class="fa-2x fa fa-close"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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

@section('script')

<script>
    $('table').DataTable(
    {
        "language": {
            "lengthMenu": "Hiển thị _MENU_",
            "zeroRecords": "Không tìm thấy",
            "info": "Hiển thị trang _PAGE_/_PAGES_",
            "infoEmpty": "Không có dữ liệu",
            "emptyTable": "Không có dữ liệu",
            "infoFiltered": "(tìm kiếm trong tất cả _MAX_ mục)",
            "sSearch": "Tìm kiếm",
            "processing": "Đang tải!",
            "paginate": {
                "first": "Đầu",
                "last": "Cuối",
                "next": "Sau",
                "previous": "Trước"
            }
        }
    });
</script>
<script>
    CKEDITOR.replace( 'summary', {
        extraPlugins: 'easyimage',
        removePlugins: 'image',
        cloudServices_tokenUrl: '',
        cloudServices_uploadUrl: ''
    });
    CKEDITOR.replace( 'content', {
        extraPlugins: 'easyimage',
        removePlugins: 'image',
        cloudServices_tokenUrl: '',
        cloudServices_uploadUrl: ''
    });
</script>

@endsection
