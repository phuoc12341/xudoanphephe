
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

