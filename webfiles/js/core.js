function ajaxPost(url, data, onSuccess) {
    const params = typeof data == 'string' ? data : Object.keys(data).map(
        function (k) {
            return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
        }
    ).join('&');

    const xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    xhr.open('POST', url);
    xhr.onreadystatechange = function () {
        if (xhr.readyState > 3 && xhr.status == 200) {
            onSuccess(xhr.responseText);
        }
    };
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);

    return xhr;
}

function gimme(selector) {
    return document.querySelector(selector);
}

function gimmeAll(selector) {
    return document.querySelectorAll(selector);
}


function onChangeLanguage(btn) {
    document.cookie = `helixlang=${btn.innerHTML.toLowerCase()}; `;
    window.location.reload();
}

function isEmailValid(email) {
    const regExp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return regExp.test(String(email).toLowerCase());
}


function onConfirm(confirmQuestion,
                   confirmTitle = 'Confirm',
                   confirmButtonNoTxt = 'No',
                   confirmButtonYesTxt = 'Yes',
                   arg) {

    gimme('#confirm-modal-title').innerHTML = confirmTitle;
    gimme('#confirm-modal-text').innerHTML = confirmQuestion;

    gimme('#confirm-modal-yes-btn').innerHTML = confirmButtonYesTxt;
    gimme('#confirm-modal-yes-btn').dataset.postId = arg;
    gimme('#confirm-modal-no-btn').innerHTML = confirmButtonNoTxt;

    gimme('#confirm-modal-trigger').click();
}

function onNotify(notifyText, notifyTitle = 'Notice') {

    gimme('#info-modal-title').innerHTML = notifyTitle;
    gimme('#info-modal-text').innerHTML = notifyText;
    gimme('#info-modal-trigger').click();
}

function onError(errorText, errorTitle = 'Error') {

    gimme('#error-modal-title').innerHTML = errorTitle;
    gimme('#error-modal-text').innerHTML = errorText;
    gimme('#error-modal-trigger').click();
}