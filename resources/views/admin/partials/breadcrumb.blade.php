<div class="pagetitle">
    <h1>{{$title ? $title : ''}}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active">{{$title ? $title : ''}}</li>
        </ol>
    </nav>
</div><!-- End Page Title -->