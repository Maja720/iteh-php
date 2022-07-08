<?php
    require '../broker.php';
    $broker=Broker::getBroker();
   
    $naziv=$_POST['naziv'];
    if(!preg_match('/^[a-zA-Z\s]*$/',$naziv)){
        echo json_encode([
            'status'=>false,
            'error'=>'Naziv se sme sastojati samo iz slova'
        ]);
    }else{
        $rezultat=$broker->izmeni("insert into ulica(naziv) values ('".$naziv."') ");
       echo json_encode($rezultat);
    }
       


?>