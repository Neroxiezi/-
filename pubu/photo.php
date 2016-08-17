<?php
    //模拟数据库取数据
    $arr=array();
    $handler=opendir('./uploads');
        while($file=readdir($handler)){
            if($file=='.' ||$file=='..'){
                continue;
            }
            //echo $file;
            $arr[]=$file;
        }
    closedir($handler);
    
    echo json_encode($arr);
?>
