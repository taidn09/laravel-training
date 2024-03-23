const theGlobal = {};
theGlobal.domain = window.location.origin + '/';
theGlobal.pathToUploads = theGlobal.domain + 'assets/uploads/';
theGlobal.uploadHolder = theGlobal.pathToUploads + "img/upload-holder.jpg";
theGlobal.mainSpinner = $("#main-spinner");

theGlobal.showSpinner = () => {
    theGlobal.mainSpinner.css('opacity', '1');
    theGlobal.mainSpinner.css('visibility', 'visible');
};
theGlobal.hideSpinner = () => {
    theGlobal.mainSpinner.css('opacity', '0');
    theGlobal.mainSpinner.css('visibility', 'hidden');
};

/**
 * Begin upload hình ảnh
 */
$(document).on("click", ".upload-container", function (e) {
    $(this).siblings(`.upload-input`).trigger("click");
});

$(document).on("change", ".upload-input", function (e) {
    let containerGroup = $(this).closest(".upload-group");
    let where = containerGroup.data('where');
    let file = $(this).prop("files")[0];
    if (file) {
        theGlobal.runAjaxUpload(file, where, function (response) {
            containerGroup.find(".upload-img").attr("src", theGlobal.pathToUploads + response.data.link);
            containerGroup.find(".upload-link").val(response.data.link);
            theGlobal.showUploadControls(
                containerGroup,
                containerGroup.siblings(".upload-group").length > 0
            );
        });
    }
});

theGlobal.showUploadControls = (containerGroup, isMovable = false) => {
    // Hiển thị Controls
    let controlsHtml = `<span class="control bg-danger delete"><i class='bx bxs-trash-alt'></i></span>`;
    let container = containerGroup.find(".upload-container");
    if (isMovable) {
        controlsHtml = `<span class="control bg-secondary up"><i class='bx bx-caret-up' ></i></span>
                        <span class="control bg-secondary down"><i class='bx bx-caret-down' ></i></span> 
                        ${controlsHtml}`;
    }
    container.find('.upload-img').after(`
        <div class="controls">
            ${controlsHtml}
        </div>
    `);
};

// Wrap của tất cả các container upload cần clear dữ liệu
theGlobal.emptyUploadContainerGroup = (wrap) => {
    $(wrap).find('.upload-group').html(`
    <div class="upload-container">
        <img src="${theGlobal.uploadHolder}" alt=""
            class="upload-img">
    </div>
    <input type="file" class="upload-input" hidden
        accept="image/png,image/x-png,image/gif,image/jpeg,image/webp">
    <input type="text" class="upload-link" hidden value="">`)
}

$(document).on("click", ".upload-container .delete", function (e) {
    e.stopPropagation();
    let containerGroup = $(this).closest(".upload-group");
    containerGroup.find(".upload-img").attr("src", theGlobal.uploadHolder);
    containerGroup.find(".upload-link").val('');
    console.log( containerGroup.find(".upload-link").val());
    containerGroup.find(".controls").remove();
});

$(document).on("click", ".upload-container .up", function (e) {
    e.stopPropagation();
    theGlobal.handleChangePosition($(this), 'up')
});

$(document).on("click", ".upload-container .down", function (e) {
    e.stopPropagation();
    theGlobal.handleChangePosition($(this), 'down')

});

theGlobal.handleChangePosition = function (_this, type) {
    let currentUploadGroup = _this.closest(`.upload-group`)
    let currentUploadLink = currentUploadGroup.find(".upload-link").val();

    let totalGroup = currentUploadGroup.siblings('.upload-group').length + 1;

    let currentIndex = currentUploadGroup.data('index')
    if(!isNaN(currentIndex) && ( (type == 'up' && currentIndex > 1) || (type == 'down' && currentIndex < totalGroup))){
        let newIndex = type == 'up' ? currentIndex - 1 : currentIndex + 1;

        let newUploadGroup = currentUploadGroup.siblings(`.upload-group[data-index=${newIndex}]`).eq(0)
        let newUploadLink = newUploadGroup.find(".upload-link").val();

        newUploadGroup.find(".upload-img").attr("src", currentUploadLink);
        newUploadGroup.find(".upload-link").val(currentUploadLink);
        newUploadGroup.find(".controls").remove();
        if(currentUploadLink != ''){
            theGlobal.showUploadControls(newUploadGroup , true )
        }

        currentUploadGroup.find(".upload-img").attr("src", newUploadLink);
        currentUploadGroup.find(".upload-link").val(newUploadLink);
        currentUploadGroup.find(".controls").remove();
        if(newUploadLink == ''){
            currentUploadGroup.find(".upload-img").attr("src", theGlobal.uploadHolder);
            currentUploadGroup.find(".upload-link").val('');
        }else{
            theGlobal.showUploadControls(currentUploadGroup , true )
        }
    }
}
/**
 * End upload hình ảnh
 */

// Khởi tạo d-select

const initDSelect = (jqueryObject) => {
    dselect(jqueryObject[0], {
        search: jqueryObject.hasClass('search'),
        maxHeight: jqueryObject.attr("max-height") ?? + "px",
    });
}

$(".d-select").each(function () {
    initDSelect($(this))
});

theGlobal.runAjaxUpload = (file, where, callback) => {
    let formData = new FormData();
    formData.append("file", file);
    formData.append("where", where);
    formData.append("_token", $("input[name=_token]").eq(0).val());

    let config = {
        url: theGlobal.domain + "upload",
        method: "POST",
        data: formData,
        async: true,
        global: true,
    };
    theGlobal.runAjax(config, (response) => {
        callback(response)
    });
};

theGlobal.runAjax = ({ url, method, data, async, global }, callback) => {
    theGlobal.showSpinner()
    $.ajax({
        type: method ?? 'POST',
        url,
        data: data ?? '',
        processData: false,
        contentType: false,
        async : async ?? true,
        cache: false,
        global: global ?? true,
    })
        .done(function (response) {
            response = typeof response == 'string' ? JSON.parse(response) : response
            if (response.status && response.status == true) {
                theGlobal.hideSpinner()
                callback(response);
            }else {
                // Xử lý hiện message khi dữ liệu đầu vào không hợp lệ
                if(response.errors){
                    for (const errField in response.errors) {
                        $(`.${errField}-err`).html(response.errors[errField])
                    }
                }
                theGlobal.hideSpinner()
                showToast(response.message, "error");
            }
        })
        .fail(function () {
            theGlobal.hideSpinner()
            showToast('Có lỗi xảy ra', 'error');
        });
};

/**
 * Begin Xử lý modal (form)
 */
theGlobal.confirmAction = (title = null, bodyContent = null, callback) => {
    if(title) $('#modal-confirm-action .modal-title').html(title)
    if(bodyContent) $('#modal-confirm-action .modal-body').html(bodyContent)
    $('#modal-confirm-action .done').off('click').on('click', function(){
        $('#modal-confirm-action').modal('hide')
        callback()
    })
    $('#modal-confirm-action').modal('show')
}

theGlobal.resetForm = function(formId){
    $(formId).get(0).reset()
    $(formId).find('input.password').removeClass('updating')
    $(formId).find('.form-message').html('')
    theGlobal.emptyUploadContainerGroup(formId)
}

theGlobal.displayImgs = function(formId, imgs){
    let form = $(formId);
    imgs.forEach((img, index) => {
        form.find('.upload-img').eq(index).attr('src', theGlobal.pathToUploads + img)
        form.find('.upload-link').eq(index).val(img)
        theGlobal.showUploadControls(form, imgs.length > 1)
    })

}

/**
 * End xử lý modal (form)
 */

/**
 * Begin Validate
 */
const isEmpty = (value) => value.trim() === ''
const isPhone = (value) => /((09|03|07|08|05)+([0-9]{8})\b)/g.test(value)
const isEmail = (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)
const isMinValid = (value, min) => value.trim().length >= min
const isMaxValid = (value, max) => value.trim().length <= max
/**
 * End validate
 */

/**
 * Helper
 */

const upperCase = (text) => text.toUpperCase();
const upperCaseFirst = (text) => text[0].toUpperCase() + text.substring(1, text.length);
const lowerCase = (text) => text.toLowerCase();
const toBold = (text) => `<b>${text}</b>`;
const toItalic = (text) => `<i>${text}</i>`;
const toUnderLine = (text) => `<u>${text}</u>`;
const renderPaging = (totalPage, currentPage, functionName) => { // Chưa xong
    let htmlPaging = '';
    if(totalPage <= 1) return htmlPaging;
    if(currentPage > 1){
        htmlPaging+=`<li class="page-item" onclick="${functionName}(${currentPage - 1})"><span class="page-link">Trang trước</span></li>`
    }
    for (let index = 1; index <= totalPage; index++) {
            htmlPaging+=`<li class="page-item ${index == currentPage ? 'active' : ''}" onclick="${functionName}(${index})"><span class="page-link">${index}</span></li>`
    }
    if(currentPage < totalPage){
        htmlPaging+=`<li class="page-item" onclick="${functionName}(${currentPage + 1})"><span class="page-link">Trang sau</span></li>`
    }
    return `<nav aria-label="Page navigation">
                <ul class="pagination">${htmlPaging}</ul></nav>`
}
/**
 * End Helper
 */