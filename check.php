<?php
$list=array("diary","blackbord","document","borrow");//子域名
$users=array();
$users["meow"]="Meow";//用户
$isauthd = true;


if(in_array(explode("/",$_SERVER["PHP_SELF"],-1)[count(explode("/",$_SERVER["PHP_SELF"],-1))-1],$list)){//如果是子域名的话
        $togo="<script>document.location='../login.html'</script>";
}else{
        $togo="<script>document.location='login.html'</script>";
}
//$togo='<script>$(document).ready(function(){auth();});</script>';
function checkg(){//如果是页面调取的检查
global $togo,$users,$isauthd;
if(!empty($_COOKIE['uid']) and !empty($_COOKIE['pswd'])){
        if(!array_key_exists($_COOKIE['uid'],$users)){//用户不存在
                $isauthd=false;
                echo($togo);
        }else   if($_COOKIE['pswd']!=$users[$_COOKIE['uid']]){
                $isauthd=false;
                echo($togo);
        }
}else{
        $isauthd=false;
        echo($togo);
}
setcookie("NOW",date('Y-m-d',time()));
}
function checkc(){
        global $users,$isauthd;
    if(!empty($_COOKIE['uid']) and !empty($_COOKIE['pswd'])){//为空
        if(!array_key_exists($_COOKIE['uid'],$users)){//用户不存在
                header($_SERVER['SERVER_PROTOCOL'].' 401 Unauthorized');
                $isauthd=false;
                exit();
        }
        else if($_COOKIE['pswd']!=$users[$_COOKIE['uid']]){//用户密码不等
                header($_SERVER['SERVER_PROTOCOL'].' 401 Unauthorized');
                $isauthd=false;
                exit();
        }
      }else{
      header($_SERVER['SERVER_PROTOCOL'].' 401 Unauthorized');
      exit();
      }
}
