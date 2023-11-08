/* 网络笔记本增强版! Web Notepad web-notepad-enhanced */
/* https://github.com/jocksliu/web-notepad-enhanced  */
/* 本项目源于原作者pereorga 的项目Minimalist Web Notepad上二次开发而来  本项目作者：jocksliu */
/* 原仓库地址 https://github.com/pereorga/minimalist-web-notepad */

function uploadContent() {
    if (content !== textarea.value) {
        var temp = textarea.value;
        var request = new XMLHttpRequest();
        request.open('POST', window.location.href, true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        request.onload = function() {
            if (request.readyState === 4) {

                content = temp;
                setTimeout(uploadContent, 1000);
            }
        }
        request.onerror = function() {

            setTimeout(uploadContent, 1000);
        }
        request.send('text=' + encodeURIComponent(temp));

        printable.removeChild(printable.firstChild);
        printable.appendChild(document.createTextNode(temp));
    } else {

        setTimeout(uploadContent, 1000);
    }
}

var textarea = document.getElementById('content');
var printable = document.getElementById('printable');
var content = textarea.value;

printable.appendChild(document.createTextNode(content));

textarea.focus();
uploadContent();


/* script2 */
document.querySelector('#toggle-menu').addEventListener('click', function() {
    toggleMenu();
});

function isMobile() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

function toggleMenu() {
    var menu = document.querySelector('.menu');
    var content = document.querySelector('.content');

    if (menu.style.width === '240px') {
        menu.style.width = '0';
        content.style.marginLeft = '10px';
        content.style.width = 'calc(100% - 10px)';
    } else {
        menu.style.width = '240px';
        content.style.marginLeft = '250px';
        content.style.width = 'calc(100% - 250px)';
    }
}

window.onload = function() {
    if (isMobile()) {
        var menu = document.querySelector('.menu');
        var content = document.querySelector('.content');
        menu.style.width = '0';
        content.style.marginLeft = '10px';
        content.style.width = 'calc(100% - 10px)';
    }
}

/* script3 */
document.getElementById('content').addEventListener('dblclick', function(e) {
    const cursorPosition = e.target.selectionStart;
    const text = e.target.value;
    const textToCursor = text.substr(0, cursorPosition);
    const lastNewLine = textToCursor.lastIndexOf('\n') > -1 ? textToCursor.lastIndexOf('\n') : 0;
    const nextNewLine = text.indexOf('\n', cursorPosition);
    const lineText = text.substring(lastNewLine, nextNewLine > -1 ? nextNewLine : text.length).trim();
    navigator.clipboard.writeText(lineText);
});
