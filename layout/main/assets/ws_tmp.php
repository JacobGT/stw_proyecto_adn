<?php

    try{
        $pdo = new PDO("mysql:host=localhost;dbname=syswebgr_db_yaPasenosInge", "syswebgr_admin", "uspg@admin123");
       

        $resultado = $pdo->query('SELECT * FROM tmp_datos');
        echo json_encode($resultado->fetchall(PDO::FETCH_ASSOC));
    }catch(PDOException $e){
        die("Connection error ToT: ". $e->getMessage());
    }
   
?>