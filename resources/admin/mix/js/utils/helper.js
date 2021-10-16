
export function notify(type, title, timeout = 5000) {
    switch (type) {
        case "info":
            Toast.fire({
                icon: 'info',
                title: title,
            })
            break;
        case "success":
            Toast.fire({
                icon: 'success',
                title: title,
            })
            break;
        case "warning":
            Toast.fire({
                icon: 'warning',
                title: title,
            })
            break;
        case "error":
            Toast.fire({
                icon: 'error',
                title: title,
            })
            break;
        default:
            Toast.fire({
                icon: 'success',
                title: title,
            })
            break;
    }
}

export function debounce(func, wait, immediate) {
    let timeout;
    return function() {
        const context = this;
        const args = arguments;
        const later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

export function reloadPage(milliseconds = 500) {
    setTimeout(function () {
        window.location.reload();
    }, milliseconds)
}

export function countSubstrings(str, searchValue) {
    let count = 0,
      i = 0;
    while (true) {
      const r = str.indexOf(searchValue, i);
      if (r !== -1) [count, i] = [count + 1, r + 1];
      else return count;
    }
};

export function getRoute (str, params) {
    let count = countSubstrings(str, '?')
    for (let i = 0; i <= count - 1; i++) {
        if (params[i] !== 'undefined') {
            str = str.replace('?', params[i])
        }
    }

    return str
}

export function validateImageUpload(fileInput) {
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i

    if(!allowedExtensions.exec(filePath)){
        notify('error', 'Vui lòng tải lên tệp có phần mở rộng: .jpeg/.jpg/.png/.gif')
        fileInput.value = ''
        return false;
    }

    return true
}

export function validateSizeFileUpload(file, maxSize = 10) {
    var FileSize = file.files[0].size / 1024 / 1024; // in MB
    if (FileSize > maxSize) {
        file.value = "";

        notify('error', `Vui lòng chọn kích cỡ ảnh không quá ${maxSize}Mb`)
        return false;
    } else {
        return true;
    }
}

export function imagesPreview(input, placeToInsertImagePreview) {
    var reader = new FileReader();
    reader.onload = function() {
        placeToInsertImagePreview.attr('src', reader.result)
    }
    reader.readAsDataURL(input.files[0]);
}

export function removeXss(input) {
    let div = document.createElement("div");
    div.innerHTML = input;
    let text =  div.textContent || div.innerText || "";
    return text;
}

export function onlyPermitNumber(e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
    // Allow: Ctrl+A
    (e.keyCode == 65 && e.ctrlKey === true) ||
    // Allow: home, end, left, right
    (e.keyCode >= 35 && e.keyCode <= 39)) {
    // let it happen, don't do anything
    return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode >
        105)) {
    e.preventDefault();
    }
}

export function getKeyCode(event) {
    let code

    if (event.key !== undefined) {
        code = event.key;
    } else if (event.keyIdentifier !== undefined) {
        code = event.keyIdentifier;
    } else if (event.keyCode !== undefined) {
        code = event.keyCode;
    }

    return code
}

