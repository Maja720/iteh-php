<?php
    require '../broker.php';

    $broker=Broker::getBroker();

    $ulica=$_POST['ulica'];
    $kategorija=$_POST['kategorija'];
    $slika=$_FILES['slika'];
    $sprat=$_POST['sprat'];
    $kvadratura=$_POST['kvadratura'];
    $cena=$_POST['cena'];
    $broj=$_POST['broj'];
    $nazivSlike=$slika['name'];
    $lokacija = "../../img/".$nazivSlike;
    if(!move_uploaded_file($_FILES['slika']['tmp_name'],$lokacija)){
        $lokacija="";
      echo "Nije uspelo prebacivanje slike";
        exit;
    }else{
        
        $lokacija=substr($lokacija,4);
    }
    
    $rezultat=$broker->izmeni("insert into stan (cena,ulica,slika,kvadratura,kategorija,sprat,broj) values (".$cena.",".$ulica.",'".$lokacija."',".$kvadratura.",".$kategorija.",".$sprat.",".$broj.") ");
    if($rezultat['status']){
       echo '200';
    }else{
       echo $rezultat['error'];
    }
