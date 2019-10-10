<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" name="viewport" id="viewport" content="width=device-width">
    <title>喵喵协作系统</title>
    <link rel="stylesheet" href="../libs/bootstrap.min.css">
    <script src="../libs/jquery.min.js"></script>
    <script src="../libs/bootstrap.min.js"></script>
    <script type="text/javascript" src="bower_components/crypto-js/crypto-js.js"></script>
    <link rel="stylesheet" href="index.css">
    <script type="text/javascript" src="index.js"></script>
</head>

<?php
require("../check.php");
checkg();
/*$isauthd = true;
if (!empty($_COOKIE['uid']) and !empty($_COOKIE['pswd'])) {
    if ($_COOKIE['uid'] != "123" or $_COOKIE["pswd"] != "321") {
        echo ('<script>$(document).ready(function(){auth();});</script>');
        $isauthd = false;
    }
} else {
    echo ('<script>$(document).ready(function(){auth();});</script>');
    $isauthd = false;
}*/
?>


<body>
    <nav class="navbar navbar-top navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">切换导航</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">喵喵协作系统</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="#" onclick="upload()" title="文件上传中" id="upinfobu" data-container="body" data-toggle="popover" data-placement="bottom" data-content='<div id="infos"></div><div class="progress" id="progress">
	                        <div class="progress-bar" id="upimg"  role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
		                        <span class="sr-only" id="load"></span>
	                        </div>
                          </div>' data-html="1" data-trigger="manual">上传文件</a>
                        <div id="formd"></div>
                    </li>
                    <li>
                        <a href="../diary/index.php">喵日志</a>
                    </li>
                    <li>
                        <a href="../blackbord/index.php">小黑板</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="../logout.html">
                            <span class="glyphicon glyphicon-log-out"></span>登出
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="warn" class="container"></div>
    <div class="container">
        <?php
        class METRO
        {
            var $atid;
            var $name;
            var $info; //设置每个磁铁的标题和信息
            function OUT()
            {
                echo '<div class="col-md-4 column">
                                    <h2>' . $this->name . '</h2>
                                    <p>文件大小：' . $this->info . '</p>
                                    <p>
                                        <a class="btn" href="api/down.php?filename=' . urlencode($this->path) . '&trueFilename=' . urlencode($this->name) . '">下载 >></a>
                                        <a class="btn" onclick=javascript:del("' . $this->path . '")>删除 ></a>
                                    </p>
                             </div>';
            }
            function __construct($row)
            {
                $this->path = $row['PATH'];
                $this->name = $row['FILENAME'];
                $this->info = $row['INFO'];
            }
        }
        $con = new SQLite3("api/doc.db"); //connect mysql
        if (!$con) {
            die("Could not connect!");
        }
        $con->query('CREATE TABLE IF NOT EXISTS "DOC" (
                    `FILENAME`	varchar(255) NOT NULL,
                    `PATH`	varchar(255) NOT NULL,
                    `INFO`	varchar(255) NOT NULL DEFAULT "没有解释的文件",
                    `HASH`	varchar(255) NOT NULL,
                    PRIMARY KEY(`HASH`)
                )');
        $con->query('CREATE TABLE IF NOT EXISTS "UNDONE" (
                    `FILENAME`	TEXT NOT NULL,
                    `HASH`	TEXT NOT NULL,
                    `PKGNUM`	INTEGER NOT NULL,
                    PRIMARY KEY(`HASH`)
                )');
        $sql = "SELECT * FROM `DOC`";
        $result = $con->query($sql);
        if ($result and $isauthd) {
            // 输出数据
            echo '<div class="row clearfix">';
            $t = 0;
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                if ($t < 3) {
                    $now = new METRO($row);
                    $now->OUT();
                } else {
                    echo '</div><div class="row clearfix">';
                    $now = new METRO($row);
                    $now->OUT();
                }
            }
            echo '</div>';
        } else {
            echo "数据库错误或未登录";
        }
        ?>
    </div>
</body>
<script>
    document.getElementById("formd").innerHTML = '<form enctype="multipart/form-data" action="file.php" method="post">' +
        '<input type="file" id="filei" onchange="upfile()" style="display:none;width:1px;height:1px"/></form>';

    function upload() {
        document.getElementById("filei").click();
    }

    function del(path) {
        var xhr = new XMLHttpRequest();
        var data = new FormData();
        data.append("PATH", path);
        xhr.open("POST", "api/del.php", true);
        xhr.send(data);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    if (xhr.responseText == 'done') {
                        document.location = "index.php?success=删除成功"
                    } else if (xhr.status == 401) {
                        auth();
                    } else {
                        document.location = "index.php?error=" + xhr.responseText;
                    }
                } else {
                    document.location = "index.php?error=" + "网络错误" + xhr.status
                }
            }
        }
    }

    <?php
    if (!empty($_GET['success'])) {
        echo "successing('" . $_GET["success"] . "')";
    }
    if (!empty($_GET['error'])) {
        echo "successing('" . $_GET["error"] . "')";
    }
    ?>
</script>


</html>