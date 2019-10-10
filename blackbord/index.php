<!DOCTYPE html>
<html lang="zh">

<head>
    <title>喵喵协作系统</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../libs/bootstrap.min.css">
    <script src="../libs/jquery.min.js"></script>
    <script src="../libs/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../index.css">
    <script src="../summernote/summernote.js"></script>
    <script src="../summernote/lang/summernote-zh-CN.js"></script>
    <script src="../libs/cookie.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" href="../summernote/summernote.css">
</head>

<?php
require("../check.php");
checkg();
?>

<body onload="ready()">
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
                        <a href="#" id="write" onclick="edit()">修改内容</a>
                    </li>
                    <li class="active" id="upli">
                    </li>
                    <li>
                        <a href="../document">文件中心</a>
                    </li>
                    <li>
                        <a href="../diary">喵日志</a>
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

        $myfile = fopen("now.html", "r") or die("Unable to open file!");
        echo fread($myfile, filesize("now.html"));
        fclose($myfile);

        ?>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:90%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
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