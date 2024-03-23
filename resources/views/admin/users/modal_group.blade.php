<div class="modal fade" id="group-modal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Quản lý nhóm nhân viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    {{-- <div class="col-12">
                        <form id="group-form" class="row">
                            <div class="col-lg-6 col-md-12 col-12 form-group">
                                <label for="group_name" class="col-form-label">Thêm nhóm</label>
                                <div class="input-group mt-2">
                                    <input name="group_name" type="text" autocomplete="off" class="form-control" id="group_name" placeholder="Nhập tên nhóm">
                                    <button class="btn btn-success" type="submit" id="add-group">Hoàn thành</button>
                                </div>
                                <p class="group_name-err form-message text-danger"></p>
                            </div>
                        </form>
                    </div> --}}
                    <div class="col-12">
                        <table class="table w-100 bg-white">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên nhóm <a href="#" data-sortfield="name" class="sort"><i class="ri-arrow-down-s-fill"></i></a></th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="group-list">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
