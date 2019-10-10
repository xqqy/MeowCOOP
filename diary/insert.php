<?php
require("../check.php");
checkc();
$con = new SQLite3("diary.db");
if (!$con){die("Could not connect!");}

  $fname="file/".date('Y-m-d',time()).".html" ;
  $f=fopen($fname,"w+b") or exit("不能打开文件");
  fwrite($f,$_POST['CODE']) or exit("不能写入文件");
  $result=$con->query('INSERT OR IGNORE INTO DIA (`PATH`,`NAME`) VALUES ("'.$fname.'","'.date('Y-m-d',time()).'")');
  if($result){echo "done";}else{echo "数据表更改失败";}
  $con->close();
  fclose($f);
  ?>