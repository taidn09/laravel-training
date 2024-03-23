var theUserHandler = {};
theUserHandler.fullname = $("#fullname");
theUserHandler.phone = $("#phone");
theUserHandler.username = $("#username");
theUserHandler.password = $("#password");
theUserHandler.email = $("#email");
theUserHandler.modalGroupId = $("#modal-group-id");
theUserHandler.modalIsBlocked = $("#modal-is-blocked");
theUserHandler._token = $("input[name=_token");
theUserHandler.profile_img = $('.profile_img');
theUserHandler.sortField = 'fullname';
theUserHandler.sortType = 'desc';
theUserHandler.userTotalRecordsShowed = $(".user-total-records-showed");
theUserHandler.currentPage = 1
theUserHandler.filterGroupId = $("#filter-group-id");
theUserHandler.filterIsBlocked = $("#filter-is-blocked");
theUserHandler.keywords = $("#keywords");
theUserHandler.filterUserBtn = $('#filter-user');
const pagingUserFunctionName = 'pagingUserList'
$(document).on("ready", function () {
    $(".upload-group-user").each(function (index) {
        $(this).data("index", ++index);
        $(this).data("where", 'users');
    });
    theUserHandler.filter()
});

$(document).on('click', '#add-user', function(){
    theGlobal.resetForm('#user-form')
    theUserHandler.username.prop('disabled', false)
    $('#user-modal').modal('show')
})

// Sumit thêm hoặc sửa user
Validator({
    form: '#user-form',
    formGroupSelector: '.form-group',
    errorSelector: '.form-message',
    rules: [
        Validator.isRequired('#fullname', 'Vui lòng nhập tên nhân viên'),
        Validator.minLength('#username', 5 , 'Tài khoản tối thiểu 5 ký tự'),
        Validator.isPhone('#phone', 'Số điện thoại không hợp lệ'),
        Validator.isEmail('#email', 'Email không hợp lệ'),
        Validator.minLength('#password', 6, 'Mật khẩu tối thiểu 6 ký tự'),
    ],
    onSubmit: function (data) {
        data._token = theUserHandler._token.val();
        data.profile_img = $('#user-form').find('.upload-link').val();
        if(theUserHandler.isEditingUser === true ){
            data._method = 'PUT';
        }

        let formData = new FormData();
        for (const property in data) {
            formData.append(property, data[property]);
        }

        let config = {
            url: `${theGlobal.domain}admin/users/${ theUserHandler.isEditingUser === true ? `${theUserHandler.userIdEdited}/update` : 'store'}`,
            method:  'POST',
            data: formData
        };
        theGlobal.runAjax(config, function (response) {
            showToast(response.message, 'success')
            $('#user-modal').modal('hide')
            if(!theUserHandler.isEditingUser){
                theUserHandler.sortField = 'id';
                theUserHandler.sortType = 'desc';
            }
            theUserHandler.filter()
            theUserHandler.userIdEdited = null;
            theUserHandler.isEditingUser = null;
        });
    }
});

theUserHandler.filter = () => {
    let formData = new FormData();
    let limit = theUserHandler.userTotalRecordsShowed.val()
    formData.append("keywords", theUserHandler.keywords.val());
    formData.append("group_id", theUserHandler.filterGroupId.val());
    formData.append("is_blocked", theUserHandler.filterIsBlocked.val());
    formData.append("sortType", theUserHandler.sortType);
    formData.append("sortField", theUserHandler.sortField);
    formData.append("limit", limit);
    formData.append("_token", theUserHandler._token.val());
    let config = {
        url: theGlobal.domain + "admin/users?page=" + theUserHandler.currentPage,
        method: "POST",
        data: formData
    };

    theGlobal.runAjax(config, function (response) {
        $("#user-list").html(theUserHandler.render(response.data.users));
        let totalRecords = response.data.totalRecords
        let totalPage = Math.ceil(totalRecords / limit )
        $('#paging-user').html(renderPaging( totalPage, theUserHandler.currentPage, pagingUserFunctionName))
    });
};

theUserHandler.render = (users) => {
    let html = "";
    users.forEach((u, index) => {
        html += `  
        <tr>
            <td>${++index}</td>
            <td>${u.fullname}</td>
            <td>${u.phone}</td>
            <td>${u.email}</td>
            <td>${u.group_name ? u.group_name : 'Mặc định'}</td>
            <td>
                <span class="badge rounded-pill ${u.is_blocked == 0 ? 'bg-success' : 'bg-danger'}">${u.is_blocked == 0 ? 'Hoạt động' : 'Đã chặn'}</span>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-primary edit-item" data-id="${u.id}" title="Cập nhật người dùng"><i class='bx bxs-pencil' ></i></button>
                <button type="button" class="btn btn-sm btn-secondary block-item" data-id="${u.id}" data-blocked="${u.is_blocked}" data-fullname="${u.fullname}" title="${u.is_blocked ? 'Bỏ chặn' : 'Chặn'} người dùng">${u.is_blocked ? "<i class='bx bxs-lock-open-alt' ></i>" : "<i class='bx bxs-lock-alt'></i>"}</button>
                <button type="button" class="btn btn-sm btn-danger delete-item" data-id="${u.id}" data-fullname="${u.fullname}" title="Xóa người dùng"><i class='bx bxs-trash-alt' ></i></button>
            </td>
        </tr>
        `;
    });
    return html;
};

$(document).on("click", ".edit-item", function (e) {
    theGlobal.resetForm('#user-form')
    var id = $(this).data('id');
    let config = {
        url: theGlobal.domain + "admin/users/" + id,
        method: "GET",
    };

    theGlobal.runAjax(config, function (response) {
        const { fullname, email, phone, username, group_id, is_blocked, profile_img } = response.data.user
        // Cập nhật dữ liệu lên form
        theUserHandler.fullname.val(fullname)
        theUserHandler.email.val(email)
        theUserHandler.phone.val(phone)
        theUserHandler.username.val(username)
        theUserHandler.modalIsBlocked.val(is_blocked)
        theUserHandler.modalGroupId.val(group_id)
        theGlobal.displayImgs('#user-form', [profile_img])

        // Reset Dselect;
        // initDSelect(theUserHandler.modalIsBlocked)
        // initDSelect(theUserHandler.modalGroupId)

        // theUserHandler.username.prop('disabled', true)
        theUserHandler.password.addClass('updating')
        $('#user-modal').modal('show')
        theUserHandler.userIdEdited = id
        theUserHandler.isEditingUser = true
    });
});

$(document).on("click", ".delete-item", function (e) {
    let _this = $(this)
    theGlobal.confirmAction(null, `Bạn chắc chắn muốn xóa nhân viên ${toBold(_this.data('fullname'))}`, function(){
        const formData = new FormData()
        formData.append("_token", theUserHandler._token.val());
        formData.append("_method", 'DELETE');
        let config = {
            url: theGlobal.domain + "admin/users/" + _this.data('id'),
            method: "POST",
            data: formData
        };
        theGlobal.runAjax(config, function (response) {
            showToast(response.message, 'success');
            theUserHandler.filter()
        });
    })
});

$(document).on("click", ".block-item", function (e) {
    let _this = $(this)
    theGlobal.confirmAction(null, `Bạn chắc chắn muốn ${_this.data('blocked') == 1 ? 'bỏ chặn' : 'chặn'} người dùng ${toBold(_this.data('fullname'))}`, function(){
        const formData = new FormData()
        formData.append("is_blocked", _this.data('blocked') == 1 ? 0 : 1);
        formData.append("_token", theUserHandler._token.val());
        formData.append("_method", 'PUT');
        let config = {
            url: `${theGlobal.domain}admin/users/${_this.data('id')}/block`,
            method: "POST",
            data: formData
        };
        theGlobal.runAjax(config, function (response) {
            showToast(response.message, 'success');
            theUserHandler.filter()
        });
    })
});

function pagingUserList(page){
    theUserHandler.currentPage = page
    theUserHandler.filter()
}

$(document).on('click', '#user-list .sort', function(){
    theUserHandler.sortField = $(this).data('sortfield')
    if($(this).hasClass('active')){
        theUserHandler.sortType = 'desc'
        $(this).removeClass('active')
        $(this).find('i').removeClass('ri-arrow-up-s-fill');
        $(this).find('i').addClass('ri-arrow-down-s-fill');
    }else{
        theUserHandler.sortType = 'asc'
        $('.sort').removeClass('active')
        $('.sort').find('i').removeClass('ri-arrow-up-s-fill');
        $('.sort').find('i').addClass('ri-arrow-down-s-fill');
        $(this).addClass('active')
        $(this).find('i').addClass('ri-arrow-up-s-fill');
    }
    theUserHandler.filter();
})

theUserHandler.userTotalRecordsShowed.on('change', function(){
    let totalShowed = $(this).val();
    $(".user-total-records-showed").val(totalShowed);
    theUserHandler.filter()
})

theUserHandler.filterUserBtn.on('click', function(){
    theUserHandler.filter();
})

var theGroupHandler = {}
theGroupHandler._token = $("input[name=_token");
theGroupHandler.btnOpenModal = $('#open-group-modal')
theGroupHandler.mainModal = $('#group-modal');
theGroupHandler.groupName = $('#grou_name');
theGroupHandler.currentPage = 1
theGroupHandler.isEditingGroup = false
theGroupHandler.groupIdEdited = null

theGroupHandler.btnOpenModal.on('click', function(){
    // theGlobal.resetForm('#group-form');
    theGroupHandler.mainModal.modal('show')
    theGroupHandler.filter()
})

theGroupHandler.filter = () => {
    let formData = new FormData();
    formData.append("sortType", theUserHandler.sortType);
    formData.append("sortField", theUserHandler.sortField);
    formData.append("_token", theUserHandler._token.val());
    let config = {
        url: theGlobal.domain + "admin/groups?page=" + theGroupHandler.currentPage,
        method: "POST",
        data: formData
    };

    theGlobal.runAjax(config, function (response) {
        theUserHandler.modalGroupId.html(theGroupHandler.renderOptions(response.data.groups));
        theUserHandler.filterGroupId.html(theGroupHandler.renderOptions(response.data.groups, true));
        $("#group-list").html(theGroupHandler.render(response.data.groups));
    });
}

theGroupHandler.render = function (groups){
    let html = ''
    groups.forEach((group, index) => {
        html+=`<tr>
            <td>${++index}</td>
            <td>${group.name}</td>
            <td></td>
        </tr>`
    })
    return html
}

theGroupHandler.renderOptions = function (groups, all = false){
    let html = all ? '<option value="">Tất cả</option>' : ''
    html += '<option value="0">Mặc định</option>'
    groups.forEach(group => {
        html+=`<option value="${group.id}">${group.name}</option>>`
    })
    return html
}

Validator({
    form: '#group-form',
    formGroupSelector: '.form-group',
    errorSelector: '.form-message',
    rules: [
        Validator.isRequired('#group_name', 'Vui lòng nhập tên nhóm'),
    ],
    onSubmit: function (data) {
        data._token = theGroupHandler._token.val();
        if(theGroupHandler.isEditingGroup === true ){
            data._method = 'PUT';
        }

        let formData = new FormData();
        for (const property in data) {
            formData.append(property, data[property]);
        }

        let config = {
            url: `${theGlobal.domain}admin/groups/${ theUserHandler.isEditingGroup === true ? `${theUserHandler.groupIdEdited}/update` : 'store'}`,
            method:  'POST',
            data: formData
        };
        theGlobal.runAjax(config, function (response) {
            showToast(response.message, 'success')
            theGroupHandler.groupName.val('')
            theGroupHandler.filter()
            theGroupHandler.isEditingGroup = false
            theGroupHandler.groupIdEdited = null
        });
    }
});