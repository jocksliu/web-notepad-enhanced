<?php
/* Minimalist Web Notepad | https://github.com/pereorga/minimalist-web-notepad */
/* 网络笔记本增强版! Web Notepad web-notepad-enhanced */
/* https://github.com/jocksliu/web-notepad-enhanced  */
/* 本项目源于原作者pereorga 的项目Minimalist Web Notepad上二次开发而来  本项目作者：jocksliu */
/* 原仓库地址 https://github.com/pereorga/minimalist-web-notepad */

/* 页面初始密码，自行部署请修改成自己的密码 */
$password = '123';
session_start();

if (isset($_POST['password'])) {
    if ($_POST['password'] === $password) {
        $_SESSION['authenticated'] = true;
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $error = '密码错误!';
    }
}

if (!isset($_SESSION['authenticated'])) {
    include 'login.php';
    exit;
}

if (isset($_GET['logout'])) {
    unset($_SESSION['authenticated']);
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

/* 网站域名，自行部署请修改成自己的域名 */
$base_url = 'https://itdog.in';

$save_path = '_tmp';

header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

if (!isset($_GET['note']) || !preg_match('/^[a-zA-Z0-9_-]+$/', $_GET['note']) || strlen($_GET['note']) > 64) {

    header("Location: $base_url/" . date('Y-m'));
    die;
}

$path = $save_path . '/' . $_GET['note'];

if (isset($_POST['text'])) {

    file_put_contents($path, $_POST['text']);

    if (!strlen($_POST['text'])) {
        unlink($path);
    }
    die;
}

if (isset($_GET['raw']) || strpos($_SERVER['HTTP_USER_AGENT'], 'curl') === 0 || strpos($_SERVER['HTTP_USER_AGENT'], 'Wget') === 0) {
    if (is_file($path)) {
        header('Content-type: text/plain');
        print file_get_contents($path);
    } else {
        header('HTTP/1.0 404 Not Found');
    }
    die;
}

function getNoteList($dir) {
    $files = array_diff(scandir($dir), array('.', '..'));
    $filteredFiles = [];

    foreach ($files as $file) {
        if (!in_array($file, array('.htaccess'))) {
            $filteredFiles[] = $file;
        }
    }

    usort($filteredFiles, function($a, $b) use ($dir) {
        return filemtime($dir . '/' . $b) - filemtime($dir . '/' . $a);
    });

    return $filteredFiles;
}


?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print $_GET['note']; ?>-记事本</title>
    <link rel="icon" href="<?php print $base_url; ?>/favicon.ico" sizes="any">
    <link rel="icon" href="<?php print $base_url; ?>/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="<?php print $base_url; ?>/styles.css">
<style>
    * {
        box-sizing: border-box;
    }
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }
.menu {
    position: fixed;
    left: 0;
    top: 0;
    bottom: 0;
    width: 240px;
    background-color: white;
    border-right: 1px solid #ccc;
    padding: 10px;
    overflow-y: auto;
    transition: width 0.5s;

}
.menu ul {
    list-style-type: none;
    padding: 0;
}
.menu ul li {
    cursor: pointer;
    padding: 5px 0;
    padding-left: 10px; 
}
.menu ul li:hover {
    text-decoration: underline;
}

.content {
    margin-left: 250px;
    padding: 10px;
    height: 100vh;
    width: calc(100% - 250px);
    transition: margin-left 0.5s, width 0.5s;
   cursor: text;
}
    textarea {
        width: 100%;
        height: 100%;
        border: none;
        outline: none;
        resize: none;
    }
}

ul.breadcrumb li a {
  color: green;
}
.active {
    background-color: #f1f1f1;
    font-weight: bold;
}

.submenu {
  display: block;
  list-style-type: none;
  padding-left: 20px;
}

.submenu li {
  padding: 5px 0;
}

.submenu li:hover {
  text-decoration: underline;
}

.expandable-menu {
  cursor: pointer;
  padding: 5px 0;
}
.expandable-menu:hover {
  text-decoration: underline;
}

@keyframes cool-gradient {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}
#toggle-menu {
    position: fixed;
    left: 50%; 
    bottom: 10px;
    transform: translateX(-50%);
    z-index: 1000;
    width: 50px;
    height: 50px;
    background: #007BFF;
    color: white;
    cursor: pointer;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 10px rgba(0,0,0,0.25);
    transition: background 0.3s;
}

#toggle-menu:hover {
    background: #0056b3;
}

    #my-menu {
        transition: width 0.5s;
    }

    #app {
        display: flex;
    }

li.readonly {
    color: lightgray;
}
</style>


<script>
document.addEventListener("keydown", function(event) {
  if (event.ctrlKey) {
    if (event.key === 's') {
      event.preventDefault();
      location.reload();
    }
  }
});

    function openNote(id) {
        window.location.href = '<?php echo $base_url; ?>/' + id;
    }

function toggleSubMenu() {
  const submenu = document.getElementById("submenu");
  if (submenu.style.display === "none") {
    submenu.style.display = "block";
  } else {
    submenu.style.display = "none";
  }
}

function updateNoteTitle() {
    const content = document.getElementById("content");
    const firstLine = content.value.split("\n")[0].substr(0, 12);
    const noteListItems = document.getElementById("noteList").getElementsByTagName("li");
    for (let i = 0; i < noteListItems.length; i++) {
        if (noteListItems[i].classList.contains("active")) {
            noteListItems[i].textContent = '【<?php echo $_GET["note"]; ?>】 ' + (firstLine || '<?php echo $_GET["note"]; ?>');
            break;
        }
    }
}
document.getElementById("content").addEventListener("input", updateNoteTitle);

</script>


</head>
<body>

    <button id="toggle-menu">收起/展开</button>
    <div class="wrapper" id=app>
        <div class="menu" id="my-menu">
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
        <li><a href="<?php echo $base_url; ?>/">笔记</a></li>
        <li><a href="<?php echo $base_url; ?>/png.php">图册</a></li>
        <li><a href="<?php echo $base_url; ?>/file.php">文件</a></li>
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
<button onclick="location.reload()" style="float: right;">刷新/保存</button>
<li><a href="<?php print $base_url . '/SJ-' . substr(str_shuffle('1234579'), -3); ?>">随机建一个</a></li>
<li><a href="https://github.com/jocksliu/web-notepad-enhanced">本项目Github地址</a></li>
<a href="/?logout">注销</a>



            </ul>
        </div>
        <div class="content">
            <textarea id="content"><?php
                if (is_file($path)) {
                    print htmlspecialchars(file_get_contents($path), ENT_QUOTES, 'UTF-8');
                }
            ?></textarea>
        </div>
    </div>
    <pre id="printable"></pre>
   <script>


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
 <script>
document.getElementById('content').addEventListener('dblclick', function(e) {
    const cursorPosition = e.target.selectionStart;
    const text = e.target.value;
    const textToCursor = text.substr(0, cursorPosition);
    const lastNewLine = textToCursor.lastIndexOf('\n') > -1 ? textToCursor.lastIndexOf('\n') : 0;
    const nextNewLine = text.indexOf('\n', cursorPosition);
    const lineText = text.substring(lastNewLine, nextNewLine > -1 ? nextNewLine : text.length).trim();
    navigator.clipboard.writeText(lineText);
});
</script>
    <script src="<?php print $base_url; ?>/script.js"></script>
</body>
</html>
