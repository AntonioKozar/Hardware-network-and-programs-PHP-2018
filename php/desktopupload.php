<?php

if(isset($_POST['UploadData']) and $_POST['UploadData'] == 1 ){
    include('model.php');
    include('controler.php');
    $DataModel = new DataModel;
    $DataUpload = new DataUpload;

    $DataModel->Name = $_POST['Name'];
    $DataModel->Barcode = $_POST['Barcode'];
    $DataModel->MAC = $_POST['MAC'];
    $DataModel->IPv4 = $_POST['IPv4'];
    $DataModel->Subnet = $_POST['Subnet'];
    $DataModel->Gateway = $_POST['Gateway'];
    $DataModel->DNS1 = $_POST['DNS1'];
    $DataModel->DNS2 = $_POST['DNS2'];
    $DataModel->Processor = $_POST['Processor'];
    $DataModel->RAM = $_POST['RAM'];
    $DataModel->MOBO = $_POST['MOBO'];
    $DataModel->HDDNumb = $_POST['HDDNumb'];
    $DataModel->HDDSize = $_POST['HDDSize'];
    $DataModel->OS = $_POST['OS'];
    $DataModel->Location = $_POST['Location'];
    $DataModel->FD = $_POST['FD'];
    $DataModel->Port = $_POST['Port'];
    $DataUpload->DesktopPC($DataModel);

}




?>
