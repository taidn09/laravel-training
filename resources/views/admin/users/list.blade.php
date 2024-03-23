@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-body pt-3">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="form-group">
                            <select name="group_id" id="filter-group-id" class="mt-2 form-select">
                                <option value="">Tất cả nhóm</option>
                                <option value="0">Mặc định</option>
                                @foreach ($userGroups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="form-group">
                            <select name="is_blocked" id="filter-is-blocked" class="mt-2 form-select">
                                <option value="">Tất cả trạng thái</option>
                                <option value="0">Hoạt động</option>
                                <option value="1">Đã chặn</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="input-group mt-2">
                            <input type="search" id="keywords" class="form-control"
                                placeholder="Họ tên / Điện thoại / Email">
                            <button class="btn btn-primary" type="button" id="filter-user"><i class='bx bxs-show'></i> Xem</button>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <button type="button" class="mt-2 btn btn-primary w-100" id="add-user"><i class='bx bx-plus'></i> Thêm
                            nhân viên</button>
                    </div> 
                    <div class="col-lg-3 col-md-6 col-12">
                        <button type="button" class="mt-2 btn btn-primary w-100" id="open-group-modal"><i class='bx bxs-group'></i> Quản lý nhóm</button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-lg-2 col-md-3 col-4">
                        <div class="d-flex flex-lg-row flex-md-row flex-column align-items-lg-center align-items-md-center align-items-start gap-1">
                            <span>Hiển thị: </span>
                            <select name="" id=""
                                class="total-records-showed user-total-records-showed form-select">
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="500">500</option>
                                <option value="1000">1000</option>
                            </select>
                        </div>
                    </div>
                </div>
                <table class="table w-100 bg-white">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Họ tên <a href="#" data-sortfield="fullname" class="sort"><i class="ri-arrow-down-s-fill"></i></a></th>
                            <th scope="col">Số điện thoại <a href="#" data-sortfield="phone" class="sort"><i class="ri-arrow-down-s-fill"></i></a></th>
                            <th scope="col">Email <a href="#" data-sortfield="email" class="sort"><i class="ri-arrow-down-s-fill"></i></a></th>
                            <th scope="col">Nhóm <a href="#" data-sortfield="group_name" class="sort"><i class="ri-arrow-down-s-fill"></i></a></th>
                            <th scope="col">Trạng thái <a href="#" data-sortfield="is_blocked" class="sort"><i class="ri-arrow-down-s-fill"></i></a></th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="user-list">
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-lg-10 col-md-9 col-8">
                        <div id="paging-user"></div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-4">
                        <div class="d-flex flex-md-row flex-column align-items-lg-center align-items-md-center align-items-start gap-1">
                            <span>Hiển thị: </span>
                            <select name="" id=""
                                class="total-records-showed user-total-records-showed form-select">
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="500">500</option>
                                <option value="1000">1000</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin.users.modal_user')
    @include('admin.users.modal_group')
@endsection
@section('js')
    <script src="{{ asset('/assets/admin/js/user_list.js') }}"></script>
@endsection
