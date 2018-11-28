<?php
header("Location: index.php")
/*
include('model.php');
include('controler.php');

$DatabaseInformation = new DatabaseInformation;
$MySQLiQuerys = new MySQLiQuerys;
$Connection = $DatabaseInformation->DatabaseConnection();
$arrayKatovi = array("S0", "S1", "S2", "N0", "N1", "N2");
foreach ($arrayKatovi as $key => $value) {
    switch ($value) {
        case 'S0':
            for ($i=0; $i < 16; $i++) { 
                $Connection->query($MySQLiQuerys->UploadLocations($value,$i));
            }
            break;
        case 'S1':
            for ($i=0; $i < 8; $i++) { 
                $Connection->query($MySQLiQuerys->UploadLocations($value,$i));
            }
            break;
        case 'S2':
            for ($i=0; $i < 24; $i++) { 
                $Connection->query($MySQLiQuerys->UploadLocations($value,$i));
            }
            break;
        case 'N0':
            for ($i=0; $i < 8; $i++) { 
                $Connection->query($MySQLiQuerys->UploadLocations($value,$i));
            }
            break; 
        case 'N1':
            for ($i=0; $i < 8; $i++) { 
                $Connection->query($MySQLiQuerys->UploadLocations($value,$i));
            }
            break;  
        case 'N2':
            for ($i=0; $i < 8; $i++) { 
                $Connection->query($MySQLiQuerys->UploadLocations($value,$i));
            }
            break;                               
        default:
            # code...
            break;
    }
}
*/
?>