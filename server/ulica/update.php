<?php
    require '../broker.php';
    $broker=Broker::getBroker();
   
    $naziv=$_POST['naziv'];
    $id=$_POST['id'];
    if(!preg_match('/^[a-zA-Z\s]*$/',$naziv)){
        echo json_encode([
            'status'=>false,
            'error'=>'Naziv se sme sastojati samo iz slova'
        ]);
        exit;
    }
    else{
        $rezultat=$broker->izmeni("update ulica set naziv='".$naziv."' where id=".$id);
       echo json_encode($rezultat);
    }
