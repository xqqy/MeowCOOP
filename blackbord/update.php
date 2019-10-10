<?php
require("../check.php");
checkc();
rename("now.html","older/".date('Y-m-d H:i:s',time()).".html");
  $fname="now.html" ;
  $f=fopen($fname,"w+b") or exit("不能打开文件");
  fwrite($f,$_POST['CODE']) or exit("不能写入文件");
  fclose($f);
  ?>