<?php
/* 网络笔记本增强版! Web Notepad web-notepad-enhanced */
/* https://github.com/jocksliu/web-notepad-enhanced  */
/* 本项目源于原作者pereorga 的项目Minimalist Web Notepad上二次开发而来  本项目作者：jocksliu */
/* 原仓库地址 https://github.com/pereorga/minimalist-web-notepad */

/* 在这个版本中，密码使用了哈希值，增加了安全性，建议搜索在线php哈希生成工具直接生成密码的哈希值，然后填入哈希内容 */
/* 推荐的在线生成哈希值网站：https://uutool.cn/php-password/  或者 https://toolkk.com/tools/php-password-hash 或者其他自行百度谷歌 */
/* 将这个密码改成自己的登录密码的哈希值，当前哈希值对应的密码是123 */
$hashed_password = '$2y$10$AaYc8IsPTupunq16p6pU/ebzAQu7PEZSrhncp5ygwt7gXePBh5H/6';

$session_time = 3600; // 3600秒

if (isset($_POST['remember_me'])) {
    $session_time = 604800; // 604800秒
}

ini_set('session.gc_maxlifetime', $session_time);
session_set_cookie_params($session_time);

session_start();

if (isset($_POST['password'])) {
    if (password_verify($_POST['password'], $hashed_password)) {
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
    session_unset();
    session_destroy();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    header('Location: login.php');
    exit;
}


/* 将域名改成自己的部署域名，否则将自动跳转到Demo域名 */
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


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print $_GET['note']; ?>-记事本</title>
    <link rel="icon" href="<?php print $base_url; ?>/favicon.ico" sizes="any">
    <link rel="icon" href="<?php print $base_url; ?>/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="<?php print $base_url; ?>/styles.css">
    <style>
        /* styles1 */
    </style>


    <script>
        /* script1 */
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
                /* styles2 */
            </style>
            <ul class="breadcrumb">
                <li><a href=<?php $base_url ?> />笔记</a></li>
                <li><a href=<?php $base_url ?>/png.php>图册</a></li>
                <li><a href=<?php $base_url ?>"/file.php">文件</a></li>
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
        /* script2 */
    </script>

    <script>
        /* script3 */
    </script>
    <script src="<?php print $base_url; ?>/script.js"></script>
</body>

</html>
