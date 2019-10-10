<?php
require("../check.php");
checkc();
$con = new SQLite3("diary.db");
if (!$con){die("Could not connect!");}

if($_POST['CODE']==""){
  $con->query('DELETE FROM `DIA` WHERE PATH ="'.$_COOKIE['DATE'].'"') or exit("不能更改数据库");
  unlink($_COOKIE['DATE']);
  die("deld");
}
  $fname=$_COOKIE['DATE'];
  $f=fopen($fname,"w+b") or exit("不能打开文件");
  fwrite($f,$_POST['CODE']) or exit("不能写入文件");
  fclose($f);
  echo "done";
  ?>