function showToast(message, status) {
    var template =  {
        error : `<i class="bi bi-exclamation-circle-fill"></i>`,
        warning : `<i class="bi bi-exclamation-triangle-fill"></i>`,
        success : `<i class="bi bi-check-circle-fill"></i>`,
    }

    var toast = document.createElement('div')
    toast.classList.add('toast')
    toast.classList.add('show')
    toast.classList.add(status)
    toast.innerHTML = template[status] + `<span class="messages">${message}</span>`
    var toastList = document.getElementById('toasts')
    toastList.appendChild(toast)
    setTimeout(() => {
        toast.style.animation = 'toastHide var(--t) forwards'
    }, 5500)
    setTimeout(() => {
        toast.remove()
    }, 6000)
}