<!-- LEFT SIDEBAR -->
<div id="sidebar-nav" class="sidebar">
    <div class="sidebar-scroll">
        <nav>
            <ul class="nav">
                <li><a href="{{ url('/') }}" class="active"><i class="lnr lnr-home"></i> <span>Trang chủ</span></a></li>
                <li>
                    <a href="#subPost" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Quản lý bài viết</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                    <div id="subPost" class="collapse ">
                        <ul class="nav">
                            <li><a href="{{ url('collab/article') }}" class="">Danh sách</a></li>
                            <li><a href="{{ url('collab/article/add') }}" class="">Thêm</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- END LEFT SIDEBAR -->
