<?php
    
if($_SERVER['HTTP_HOST']=='localhost'){
    define('HOST', 'localhost');
    define('USER','root');
    define('PASSWORD','');
    define('DB_NAME','db_uspgcoders');
    define('BASE_URL','http://localhost/(STW)_proyecto_adn/');
}else{
    define('BASE_URL','https://www.aduana.yapasenosinge.syswebgroup.online/');
    define('HOST', 'localhost');
    define('USER','syswebgr_admin');
    define('PASSWORD','uspg@admin123');
    define('DB_NAME','syswebgr_db_yaPasenosInge');   
}
?>