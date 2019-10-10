<!DOCTYPE html>
<html lang="zh">

<head>
    <title>喵喵协作系统</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="../libs/bootstrap.min.css">
    <script src="../libs/jquery.min.js"></script>
    <script src="../libs/bootstrap.min.js"></script>
    <script src="../summernote/summernote.js"></script>
    <script src="../summernote/lang/summernote-zh-CN.js"></script>
    <script src="../libs/cookie.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" href="../summernote/summernote.css">
    <?php
require("../check.php");
checkg();
?>
</head>

<body>

    <nav class="navbar navbar-top navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">喵喵协作系统</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">喵喵协作系统</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="#" id="write" onclick="choose()">书写日志</a>
                    </li>
                    <li class="active" id="upli">
                    </li>
                    <li>
                        <a href="../document">文件中心</a>
                    </li>
                    <li>
                        <a href="../blackbord">小黑板</a>
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

    <div id="warn" class="container">
        <?php if (!empty($_GET['success'])) {
            echo '<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        &times;
                    </button>
                ' . $_GET['success'] . '
                    </div>';
        }
        if (!empty($_GET['error'])) {
            echo '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert"aria-hidden="true">
                    &times;
                    </button>
                ' . $_GET['error'] . '
                </div>';
        }
        if (!empty($_GET['info'])) {
            echo '<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert"aria-hidden="true">
                    &times;
                    </button>
                ' . $_GET['info'] . '
                </div>';
        }
        if (!empty($_GET['warning'])) {
            echo '<div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert"aria-hidden="true">
                    &times;
                    </button>
                ' . $_GET['warning'] . '
                </div>';
        }
        ?>
    </div>

    <div class="container">
        <?php

        class METRO
        {
            var $atid;
            var $name;
            var $info; //设置每个磁铁的标题和信息

            function OUT()
            {
                if ($this->name == date('Y-m-d', time())) {
                    echo "<script>setcookie('DATE','" . date('Y-m-d', time()) . "',1);setcookie('PATH','" . $this->path . "',1);</script>";
                }
                echo '<div class="col-md-4 column">
                                    <h2>' . $this->name . '</h2>
                                    <p>
                                        <a class="btn" href=javascript:look("' . $this->path . '")>查看 >></a>
                                        <a class="btn" onclick=javascript:edit("' . $this->path . '")>修改 >></a>
                                    </p>
                             </div>';
            }

            function __construct($row)
            {
                $this->path = $row['PATH'];
                $this->name = $row['NAME'];
            }
        }

        $con = new SQLite3("diary.db"); //connect mysql
        if (!$con) {
            die("Could not connect!");
        }

        $con->query(
            'CREATE TABLE IF NOT EXISTS `DIA` (
                    `NAME` varchar(255) NOT NULL ,
                    `PATH` varchar(255) PRIMARY KEY NOT NULL 
                  )'
        );

        $sql = "SELECT * FROM `DIA`";
        $result = $con->query($sql);

        if ($result) {
            // 输出数据
            echo '<div class="row clearfix">';
            $t = 0;
            while ($row =  $result->fetchArray(SQLITE3_ASSOC)) {
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
            echo "没有结果";
        }
        ?>

        <div class="modal fade" id="meowModal" tabindex="-1" role="dialog" aria-labelledby="meowModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:90%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="meowModalLabel">
                            喵
                        </h4>
                    </div>
                    <div class="modal-body" id="code">
                        <div id='summernote'></div>
                    </div>
                    <div class="modal-footer" id="button">
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->

</body>

</html>
