<div class="modal fade" id="user-modal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <form id="user-form" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Quản lý nhân viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="upload-group upload-group-user">
                            <div class="upload-container">
                                <img src="{{ asset('assets/uploads/img/upload-holder.jpg') }}" alt=""
                                    class="upload-img">
                            </div>
                            <input type="file" class="upload-input" hidden
                                accept="image/png,image/x-png,image/gif,image/jpeg,image/webp">
                            <input type="text" name="profile_img" class="upload-link" hidden value="">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="fullname" class="col-form-label">Tên nhân viên</label>
                            <input name="fullname" type="text" autocomplete="off" class="form-control" id="fullname">
                            <p class="fullname-err form-message text-danger"></p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="username" class="col-form-label">Tài khoản đăng nhập</label>
                            <input name="username" type="text" autocomplete="off" class="form-control" id="username">
                            <p class="username-err form-message text-danger"></p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="password" class="col-form-label">Mật khẩu</label>
                            <input name="password" type="password" class="form-control" id="password" autocomplete="current-password">
                            <p class="password-err form-message text-danger"></p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="phone" class="col-form-label">Số điện thoại</label>
                            <input name="phone" type="text" autocomplete="off" class="form-control" id="phone">
                            <p class="phone-err form-message text-danger"></p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email</label>
                            <input name="email" type="text" autocomplete="off" class="form-control" id="email"">
                            <p class="email-err form-message text-danger"></p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="modal-group-id" class="col-form-label">Nhóm</label>
                            <select name="group_id" id="modal-group-id" class="form-select">
                                ư
                                @foreach ($userGroups as $group)
                                    <option value="{{$group->id}}">{{$group->name}}</option>
                                @endforeach
                            </select>
                            <p class="form-message text-danger"></p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="modal-is-blocked" class="col-form-label">Trạng thái</label>
                            <select name="is_blocked" id="modal-is-blocked" class="form-select">
                                <option value="0">Hoạt động</option>
                                <option value="1">Đã chặn</option>
                            </select>
                            <p class="form-message text-danger"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-success" id="done">Hoàn tất</button>
            </div>
        </form>
    </div>
</div>
