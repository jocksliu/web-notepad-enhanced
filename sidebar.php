<?php
/* 网络笔记本增强版! Web Notepad web-notepad-enhanced */
/* https://github.com/jocksliu/web-notepad-enhanced  */
/* 本项目源于原作者pereorga 的项目Minimalist Web Notepad上二次开发而来  本项目作者：jocksliu */
/* 原仓库地址 https://github.com/pereorga/minimalist-web-notepad */
$noteList = getNoteList($save_path);
foreach ($noteList as $noteId) {
    $activeClass = $noteId == $_GET['note'] ? ' active' : '';
    $isReadOnly = !is_writable($save_path . '/' . $noteId);
    $readOnlyClass = $isReadOnly ? ' readonly' : '';
    $readOnlyTitle = $isReadOnly ? 'title="这是一个只读文件"' : '';
    $noteContent = file_get_contents($save_path . '/' . $noteId);
    $noteTitle = substr(strtok($noteContent, PHP_EOL), 0, 12) ?: $noteId;
    echo "<li class='" . $activeClass . $readOnlyClass . "' " . $readOnlyTitle . " onclick='openNote(\"" . htmlspecialchars($noteId, ENT_QUOTES, 'UTF-8') . "\")'>【" . htmlspecialchars($noteId, ENT_QUOTES, 'UTF-8') . "】" . htmlspecialchars($noteTitle, ENT_QUOTES, 'UTF-8') . "</li>";
}
?>

<style>
.breadcrumb {
    list-style: none;
    padding: 10px;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center; 
    background-color: #f1f1f1;
    border-radius: 5px;
}

.breadcrumb li {
    display: inline-block;
    margin: 0 3px;
}

.breadcrumb li a {
    text-decoration: none;
    color: #333;
    font-size: 15px;
    padding: 3px 6px;
    border-radius: 3px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.breadcrumb li a:hover {
    background-color: #007bff;
    color: #fff;
}

.breadcrumb li a:active {
    background-color: #0056b3;
    color: #fff;
}

.breadcrumb li a:focus {
    outline: none;
}

.floating-notice {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: #f1f1f1;
    padding: 18px;
    text-align: center;
    font-size: 16px;
    color: red;
}

</style>

<script>
function openNote(id) {
    window.location.href = '<?php echo $base_url; ?>/' + id;
}

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

</script>


    <button id="toggle-menu">收起/展开</button>
    <div class="wrapper" id=app>
        <div class="menu" id="my-menu">
<h5 class="cool-title" style="text-align: center;">记事本</h5>
    <style>
        .breadcrumb {
            list-style: none;
            padding: 10px;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center; 
            background-color: #f1f1f1;
            border-radius: 5px;
        }

        .breadcrumb li {
            display: inline-block;
            margin: 0 3px;
        }

        .breadcrumb li a {
            text-decoration: none;
            color: #333;
            font-size: 15px;
            padding: 3px 6px;
            border-radius: 3px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .breadcrumb li a:hover {
            background-color: #007bff;
            color: #fff;
        }

        .breadcrumb li a:active {
            background-color: #0056b3;
            color: #fff;
        }

        .breadcrumb li a:focus {
            outline: none;
        }

        .floating-notice {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #f1f1f1;
            padding: 18px;
            text-align: center;
            font-size: 16px;
            color: red;
        }
    </style>
    <ul class="breadcrumb">
        <li><a href="https://www.muv.cc/">笔记</a></li>
        <li><a href="https://www.muv.cc/png.php">图册</a></li>
        <li><a href="https://www.muv.cc/file.php">文件</a></li>
    </ul>

            <ul id="noteList">
<?php
$noteList = getNoteList($save_path);
foreach ($noteList as $noteId) {
    $activeClass = $noteId == $_GET['note'] ? ' active' : '';
    $isReadOnly = !is_writable($save_path . '/' . $noteId);
    $readOnlyClass = $isReadOnly ? ' readonly' : '';
    $readOnlyTitle = $isReadOnly ? 'title="这是一个只读文件"' : '';
    $noteContent = file_get_contents($save_path . '/' . $noteId);
    $noteTitle = substr(strtok($noteContent, PHP_EOL), 0, 12) ?: $noteId;
    echo "<li class='" . $activeClass . $readOnlyClass . "' " . $readOnlyTitle . " onclick='openNote(\"" . htmlspecialchars($noteId, ENT_QUOTES, 'UTF-8') . "\")'>【" . htmlspecialchars($noteId, ENT_QUOTES, 'UTF-8') . "】" . htmlspecialchars($noteTitle, ENT_QUOTES, 'UTF-8') . "</li>";
}

?>
<button onclick="location.reload()" style="float: right;">保存</button>
<li><a href="<?php print $base_url . '/' . substr(str_shuffle('1234579'), -5); ?>">随机建一个</a></li>
<li><a href="https://www.qingyunl.com/login?action=productdetails&id=14924" target="_blank">管理</a></li>

            </ul>
        </div>
