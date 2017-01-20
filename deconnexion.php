<?php

setcookie("sid","",time()-1,null,null,false,true);
header("Location:index.php");
 ?>
