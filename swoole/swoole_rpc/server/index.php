<?php
    /**
     * Created By ${pROJECT_NAME}.
     * User: pfinal
     * Date: 2019/7/31
     * Time: 下午1:50
     * ----------------------------------------
     *
     */
    define('SERVER_PATH', str_replace('\\', '/', __DIR__.'/server'));
    define('APP_PATH', str_replace('\\', '/', __DIR__.'/controller'));
    require_once SERVER_PATH."/core/Common.php";
    require_once SERVER_PATH."/core/HandlerException.php";
    spl_autoload_register(
        function ($className) {
            $classPath = SERVER_PATH."/core/".$className.".php";
            if (is_file($classPath)) {
                require_once "{$classPath}";
            }
        }
    );
    $sw = new Core();
    $sw::run();
