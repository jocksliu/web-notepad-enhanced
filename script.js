/* 网络笔记本增强版! Web Notepad web-notepad-enhanced */
/* https://github.com/jocksliu/web-notepad-enhanced  */
/* 本项目源于原作者pereorga 的项目Minimalist Web Notepad上二次开发而来  本项目作者：jocksliu */
/* 原仓库地址 https://github.com/pereorga/minimalist-web-notepad */
document.addEventListener("keydown", function(event) {
    if (event.ctrlKey) {
        if (event.key === 's') {
            event.preventDefault();
            location.reload();
        }
    }
});

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

        /* script1 */

/* script2 */

function isMobile() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

window.onload = function() {
    if (isMobile()) {
        var menu = document.querySelector('.menu');
        menu.classList.add('collapsed');
    }

    // 在页面加载时应用存储的背景色
    var storedBackgroundColor = localStorage.getItem('selectedBackgroundColor');
    if (storedBackgroundColor) {
        document.getElementById('content').style.backgroundColor = storedBackgroundColor;
        document.getElementById('backgroundColorSelector').value = storedBackgroundColor;
    }
}

/* script3 */

// document.getElementById('content').addEventListener('dblclick', function(e) {
//     const cursorPosition = e.target.selectionStart;
//     const text = e.target.value;
//     const textToCursor = text.substr(0, cursorPosition);
//     const lastNewLine = textToCursor.lastIndexOf('\n') > -1 ? textToCursor.lastIndexOf('\n') : 0;
//     const nextNewLine = text.indexOf('\n', cursorPosition);
//     const lineText = text.substring(lastNewLine, nextNewLine > -1 ? nextNewLine : text.length).trim();
    
//     copyToClipboard(lineText);
//     showMessage('copy!');
// });

function showMessage(message) {
    const messageBox = document.getElementById('message-box');
    messageBox.textContent = message;
    messageBox.classList.add('show');
    
    setTimeout(function() {
        messageBox.classList.remove('show');
    }, 2000);
}

document.getElementById('content').addEventListener('dblclick', function(e) {
    // 记录当前的选区
    const selection = window.getSelection();
    const range = selection.rangeCount > 0 ? selection.getRangeAt(0) : null;
    
    const cursorPosition = e.target.selectionStart;
    const text = e.target.value;
    const textToCursor = text.substr(0, cursorPosition);
    const lastNewLine = textToCursor.lastIndexOf('\n') > -1 ? textToCursor.lastIndexOf('\n') : 0;
    const nextNewLine = text.indexOf('\n', cursorPosition);
    let lineText = text.substring(lastNewLine, nextNewLine > -1 ? nextNewLine : text.length).trim();
    
    // 过滤规范的格式符号
    lineText = filterText(lineText);
    
    copyToClipboard(lineText);
    showMessage('已复制!');
    
    // 立即恢复选区
    if (range) {
        selection.removeAllRanges();
        selection.addRange(range);
    } else {
        e.target.selectionStart = cursorPosition;
        e.target.selectionEnd = cursorPosition;
    }
    
    e.target.focus();
});

function filterText(text) {
    // 过滤有序列表
    text = text.replace(/^\d+\.\s*/, '');
    // 过滤无序列表
    text = text.replace(/^●\s*/, '');
    // 过滤尖括号及其内容
    const bracketMatch = text.match(/^(\s*)<([^>]*)>/);
    if (bracketMatch) {
        text = bracketMatch[2];
    }
    return text;
}

document.getElementById('content').addEventListener('click', function(e) {
    if (e.ctrlKey) {
        const cursorPosition = e.target.selectionStart;
        const text = e.target.value;
        const textToCursor = text.substr(0, cursorPosition);
        const lastNewLine = textToCursor.lastIndexOf('\n') > -1 ? textToCursor.lastIndexOf('\n') : 0;
        const nextNewLine = text.indexOf('\n', cursorPosition);
        const lineText = text.substring(lastNewLine, nextNewLine > -1 ? nextNewLine : text.length).trim();

        // 使用正则表达式匹配网页链接
        const urlRegex = /https?:\/\/[^\s]+/g;
        const urls = lineText.match(urlRegex);

        if (urls && urls.length > 0) { // 如果在该行中检测到网页链接
            urls.forEach(url => {
                window.open(url, '_blank'); // 打开每个检测到的链接
            });
        }
    }
});


function copyToClipboard(text) {
    const tempElement = document.createElement('textarea');
    tempElement.value = text;
    document.body.appendChild(tempElement);
    
    tempElement.select();
    tempElement.setSelectionRange(0, 99999);
    
    document.execCommand('copy');
    
    document.body.removeChild(tempElement);
}

function showMessage(message) {
    const messageBox = document.getElementById('message-box');
    messageBox.textContent = message;
    messageBox.classList.add('show');
    
    setTimeout(function() {
        messageBox.classList.remove('show');
    }, 2000);
}

function adjustContentPosition() {
    var menu = document.querySelector('.menu');
    var content = document.querySelector('.content');

    if (menu.classList.contains('collapsed')) {
        content.style.marginLeft = '10px';
    } else {
        content.style.marginLeft = '250px';
    }
}

// 当用户选择新的背景色时,存储选择的颜色并应用它
document.getElementById('backgroundColorSelector').addEventListener('change', function() {
    var selectedBackgroundColor = this.value;
    document.getElementById('content').style.backgroundColor = selectedBackgroundColor;
    localStorage.setItem('selectedBackgroundColor', selectedBackgroundColor);
});

function autoNumberList(event) {
    var content = document.getElementById('content');
    var currentLine = content.value.substr(0, content.selectionStart).split('\n').pop();

    // 定义支持的列表类型和对应的前缀
    var listTypes = [
        {
            type: 'ordered',
            prefixes: [
                /^\s*\d+\.\s/
            ]
        },
        {
            type: 'unordered',
            prefixes: [
                /^\s*●\s/  // 匹配以 '●' 加一个空格开头的无序列表项
            ],
            bullet: '● '  // 使用 '●' 加一个空格作为无序列表项的标记
        }
    ];

    // 检查当前行是否以任意支持的列表前缀开头
    var currentListType = listTypes.find(function(listType) {
        return listType.prefixes.some(function(prefix) {
            return prefix.test(currentLine);
        });
    });

    if (currentListType && event.key === 'Enter') {
        event.preventDefault();

        // 获取当前行的缩进
        var indentation = currentLine.match(/^\s*/)[0];

        var newLine;

        if (currentListType.type === 'ordered') {
            // 有序列表,自动填充下一个序号
            var currentNumber = currentLine.match(/\d+/);
            var newNumber = currentNumber ? parseInt(currentNumber[0], 10) + 1 : 1;
            newLine = '\n' + indentation + newNumber + '. ';
        } else {
            // 无序列表,使用 '●' 加一个空格作为列表项标记
            newLine = '\n' + indentation + currentListType.bullet;
        }

        // 在当前光标位置插入新行
        content.setRangeText(newLine, content.selectionStart, content.selectionStart, 'end');
    }
}

document.getElementById('content').addEventListener('keydown', autoNumberList);


function renderText() {
    const content = document.getElementById('content');
    const text = content.value;
    const lines = text.split('\n');

    let renderedText = '';

    for (let i = 0; i < lines.length; i++) {
        let line = lines[i];

        // 检查颜色标记
        const colorRegex = /\[color:(\w+)\]/;
        const colorMatch = line.match(colorRegex);

        if (colorMatch) {
            const color = colorMatch[1];
            line = line.replace(colorRegex, '').replace(/\[\/color\]/, '');
            renderedText += `<span style="color: ${color}">${line}</span>`;
        } else {
            renderedText += line;
        }

        // 如果不是最后一行,添加换行符
        if (i < lines.length - 1) {
            renderedText += '\n';
        }
    }

    content.value = renderedText;
}

// 添加事件监听器,以保持子菜单打开状态
const dropdowns = document.querySelectorAll('.dropdown');
dropdowns.forEach(dropdown => {
  dropdown.addEventListener('mouseleave', () => {
    const dropdownContent = dropdown.querySelector('.dropdown-content');
    setTimeout(() => {
      dropdownContent.style.display = 'none';
    }, 200); // 延迟 200 毫秒关闭子菜单,以防止快速移出移入时菜单闪烁
  });
});


function formatText(formatter) {
    const content = document.getElementById('content');
    const selectedText = content.value.substring(content.selectionStart, content.selectionEnd);

    if (document.queryCommandSupported('insertText')) {
        document.execCommand('insertText', false, formatter(selectedText));
    } else {
        const range = document.getSelection().getRangeAt(0);
        range.deleteContents();
        const newTextNode = document.createTextNode(formatter(selectedText));
        range.insertNode(newTextNode);
        range.selectNodeContents(newTextNode);
        range.collapse(false);
        const selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
    }

    content.focus();
}

function getStringWidth(str) {
    const containsChinese = /[\u4e00-\u9fa5]/.test(str);
    if (containsChinese) {
        return str.split('').reduce((sum, char) => {
            return sum + (isNaN(parseInt(char, 10)) ? 1 : 0.5);
        }, 0);
    } else {
        return str.length;
    }
}

function insertTitle1() {
    formatText(selectedText => {
        const titleWidth = getStringWidth(selectedText);
        const boxWidth = titleWidth + 6; 

        const topLine = '╔' + '═'.repeat(boxWidth) + '╗';
        const middleLine = '║' + ' '.repeat(Math.floor((boxWidth - titleWidth) / 2)) + selectedText + ' '.repeat(Math.ceil((boxWidth - titleWidth) / 2)) + '║';
        const bottomLine = '╚' + '═'.repeat(boxWidth) + '╝';

        return `${topLine}\n${middleLine}\n${bottomLine}`;
    });
}

// Other functions remain the same
function insertTitle2() {
    formatText(selectedText => `-----【${selectedText}】-----`);
}

function insertOrderedList() {
    formatText(selectedText => selectedText.split('\n').map((item, index) => `    ${index + 1}. ${item}`).join('\n'));
}

function insertUnorderedList() {
    formatText(selectedText => selectedText.split('\n').map(item => `    ● ${item}`).join('\n'));
}

function insertCodeBlock() {
    formatText(selectedText => `# -  -    -        -                 -                 -#
${selectedText}
# -  -    -        -                 -                 -#
`);
}

function insertLink() {
    formatText(selectedText => `    < ${selectedText} >`);
}

function insertHorizontalLine1() {
    const content = document.getElementById('content');
    const cursorPosition = content.selectionStart;
    const horizontalLine = '------------------------';

    if (document.queryCommandSupported('insertText')) {
        document.execCommand('insertText', false, horizontalLine);
    } else {
        const range = document.getSelection().getRangeAt(0);
        const newTextNode = document.createTextNode(horizontalLine);
        range.insertNode(newTextNode);
        range.setStartAfter(newTextNode);
        range.collapse(true);
        const selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
    }

    content.focus();
}

function insertHorizontalLine2() {
    const content = document.getElementById('content');
    const cursorPosition = content.selectionStart;
    const horizontalLine = '==============';

    if (document.queryCommandSupported('insertText')) {
        document.execCommand('insertText', false, horizontalLine);
    } else {
        const range = document.getSelection().getRangeAt(0);
        const newTextNode = document.createTextNode(horizontalLine);
        range.insertNode(newTextNode);
        range.setStartAfter(newTextNode);
        range.collapse(true);
        const selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
    }

    content.focus();
}


function insertHorizontalLine3() {
    const content = document.getElementById('content');
    const cursorPosition = content.selectionStart;
    const horizontalLine = '*********************';

    if (document.queryCommandSupported('insertText')) {
        document.execCommand('insertText', false, horizontalLine);
    } else {
        const range = document.getSelection().getRangeAt(0);
        const newTextNode = document.createTextNode(horizontalLine);
        range.insertNode(newTextNode);
        range.setStartAfter(newTextNode);
        range.collapse(true);
        const selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
    }

    content.focus();
}

function insertHorizontalLine4() {
    const content = document.getElementById('content');
    const cursorPosition = content.selectionStart;
    const horizontalLine = '++++++++++++++';

    if (document.queryCommandSupported('insertText')) {
        document.execCommand('insertText', false, horizontalLine);
    } else {
        const range = document.getSelection().getRangeAt(0);
        const newTextNode = document.createTextNode(horizontalLine);
        range.insertNode(newTextNode);
        range.setStartAfter(newTextNode);
        range.collapse(true);
        const selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
    }

    content.focus();
}

//清除格式
//清除格式
function clearFormatting() {
  const content = document.getElementById('content');
  const selectedText = content.value.substring(content.selectionStart, content.selectionEnd);

  // 移除标题格式
  const cleanedText = selectedText.replace(/^_+\n(.*?)\n\*+$/gm, '$1') // 移除 insertTitle1 生成的标题格式
                                   .replace(/-----\【(.*?)\】-----/g, '$1') // 移除 insertTitle2 生成的标题格式
                                   .replace(/^╔═+╗\n║\s*(.*?)\s*║\n╚═+╝$/gm, '$1') // 移除新增的标题格式

                                   // 移除列表格式
                                   .replace(/^(    ●? )/gm, '') // 移除无序列表项前的缩进和符号
                                   .replace(/^(    \d+\. )/gm, '') // 移除有序列表项前的缩进和编号

                                   // 移除代码块格式
                                   .replace(/^# -  -    -        -                 -                 -#\n([\s\S]*?)\n# -  -    -        -                 -                 -#$/gm, '$1')

                                   // 移除链接格式
                                   .replace(/^(    < )(.*?)( >)$/gm, '$2')

                                   // 压缩连续的空白行为单个空行
                                   .replace(/\n\s+\n/g, '\n\n')
                                   .trim(); // 去除首尾空白

  // 创建一个新的文本节点,只包含纯文本
  const newTextNode = document.createTextNode(cleanedText);

  if (document.queryCommandSupported('insertText')) {
    document.execCommand('insertText', false, newTextNode.nodeValue);
  } else {
    const range = document.getSelection().getRangeAt(0);
    range.deleteContents();
    range.insertNode(newTextNode);
    range.selectNodeContents(newTextNode);
    range.collapse(false);
    const selection = window.getSelection();
    selection.removeAllRanges();
    selection.addRange(range);
  }

  content.focus();
}

// const textarea = document.getElementById('content');

textarea.addEventListener('keydown', (event) => {
    if (event.key === 'Tab') {
        event.preventDefault();

        const spaces = '    ';

        formatText(selectedText => {
            if (selectedText.trim() === '') {
                return spaces;
            } else {
                const lines = selectedText.split('\n');
                const indentedLines = lines.map(line => spaces + line);
                return indentedLines.join('\n');
            }
        });
    }
});

textarea.addEventListener('keydown', (event) => {
    if (event.ctrlKey && event.key === '\[') {
        event.preventDefault();

        formatText(selectedText => {
            if (selectedText.trim() === '') {
                return ''; // 如果没有选中文本,则不做任何操作
            } else {
                const lines = selectedText.split('\n');
                const unindentedLines = lines.map(line => line.replace(/^\s+/, '')); // 删除每行开头的空白字符
                return unindentedLines.join('\n');
            }
        });
    }
});

textarea.addEventListener('keydown', (event) => {
    if (event.ctrlKey && event.key === '/') {
        event.preventDefault();

        formatText(selectedText => {
            if (selectedText.trim() === '') {
                return '// ';
            } else {
                const lines = selectedText.split('\n');
                const processedLines = lines.map(line => {
                    const trimmedLine = line.trim();
                    if (trimmedLine.startsWith('//') || trimmedLine.startsWith('#')) {
                        return trimmedLine.replace(/^(\/\/|#)\s?/, ''); // 删除注释符号
                    } else {
                        return '// ' + trimmedLine; // 添加注释符号
                    }
                });
                return processedLines.join('\n');
            }
        });
    }
});
