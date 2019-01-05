<?php
class DatabaseInformation{
    public function DatabaseConnection(){
        $username = "root";
        $password = "";
        $database = "hnp2018";
        $hostname = "localhost";
        $Connection = new mysqli($hostname, $username, $password, $database);
        if($Connection->connect_error){
            die("Error: " . $Connection->connect_error);
        }
        return $Connection;
    }
}
# Data model for incoming information
class DataModel{
    public $Name;
    public $Barcode;
    public $MAC;
    public $IPv4;
    public $Subnet;
    public $Gateway;
    public $DNS;
    public $DNS1;
    public $DNS2;
    public $Processor;
    public $RAM;
    public $MOBO;
    public $HDDNumb;
    public $HDDSize;
    public $GPU;
    public $OS;
    public $Location;
    public $FD;
    public $Port;
    public $Programs;
}
# Data from desktop PC
class DataUpload{
    public function DesktopPC($DataModel)
    {
        $DatabaseInformation = new DatabaseInformation;
        $MySQLiQuerys = new MySQLiQuerys;
        $Connection = $DatabaseInformation->DatabaseConnection();
        $Result = "DesktopPC";
        if (!$Connection->query($MySQLiQuerys->UploadPC($DataModel))) {
            $Connection->query($MySQLiQuerys->DeletePC($DataModel->MAC));
            $Connection->query($MySQLiQuerys->UploadPC($DataModel));
        }
        if (!$Connection->query($MySQLiQuerys->UploadNetwork($DataModel))) {
            $Connection->query($MySQLiQuerys->DeleteNetwork($DataModel->MAC));
            $Connection->query($MySQLiQuerys->UploadNetwork($DataModel));
        }
        if(!$Connection->query($MySQLiQuerys->CreatePrograms($DataModel->MAC))){
            $Connection->query($MySQLiQuerys->DeletePrograms($DataModel->MAC));
            $Connection->query($MySQLiQuerys->CreatePrograms($DataModel->MAC));
        }
        $Connection->query($MySQLiQuerys->UploadProcessor($DataModel->Processor));
        return $Result;
    }
    public function DesktopPrograms($DataModel)
    {
        $DatabaseInformation = new DatabaseInformation;
        $MySQLiQuerys = new MySQLiQuerys;
        $Connection = $DatabaseInformation->DatabaseConnection();
        $Result = $Connection->query($MySQLiQuerys->UploadProgram($DataModel)) or die('Error: ' . mysqli_error($Connection));
        return $Result;
    }
}
# MySQLi querys
class MySQLiQuerys{
    public $TableBodyHome = 'SELECT barcode, ipv4, mac, name, os FROM pc ORDER BY barcode;';
    public $TableBodyNetwork = 'SELECT ip, mac FROM network ORDER BY ip;';
    public $TableBodyLocation = 'SELECT name, img FROM global_location;';
    public $TableBodyProcessors = "SELECT DISTINCT processor FROM pc;";

    public function UploadProcessor($var){
        return $Result = "INSERT INTO processor (name) VALUES ('{$var}');";
    }
    public function UploadNetwork($DataModel){
        $Result = "INSERT INTO network 
        ( fd, port, ip, subnet, gateway, dns1, dns2, mac) VALUES 
        ('{$DataModel->FD}', 
        '{$DataModel->Port}', 
        '{$DataModel->IPv4}', 
        '{$DataModel->Subnet}', 
        '{$DataModel->Gateway}', 
        '{$DataModel->DNS1}', 
        '{$DataModel->DNS2}', 
        '{$DataModel->MAC}');";

        return $Result;
    }
    public function DeleteNetwork($var){
        return $Result = "DELETE FROM network WHERE mac='{$var}'";
    }

    public function TableBodyProcessorsCount($var){
        return $Result = "SELECT COUNT(processor) FROM pc WHERE processor='{$var}';";
    }
    public function DetailsPC($var){
        $Result = "SELECT * FROM pc WHERE mac='{$var}';";
        return $Result;
    } 
    public function UploadPC($DataModel){
        $Result = "INSERT INTO pc 
        (name, barcode, mac, ipv4, subnet, gateway, dns1, dns2, processor, ram, motherboard, hddnumber, hddsize, gpu, os, locations, added_date) VALUES 
        ('{$DataModel->Name}', 
        '{$DataModel->Barcode}', 
        '{$DataModel->MAC}', 
        '{$DataModel->IPv4}', 
        '{$DataModel->Subnet}', 
        '{$DataModel->Gateway}', 
        '{$DataModel->DNS1}', 
        '{$DataModel->DNS2}', 
        '{$DataModel->Processor}', 
        '{$DataModel->RAM}', 
        '{$DataModel->MOBO}', 
        '{$DataModel->HDDNumb}', 
        '{$DataModel->HDDSize}', 
        '{$DataModel->GPU}', 
        '{$DataModel->OS}', 
        '{$DataModel->Location}', 
        CURRENT_TIMESTAMP);";

        return $Result;
    }
    public function EditPC($DataModel){
        $Result = "UPDATE pc SET 
        name='{$DataModel->Name}', 
        barcode='{$DataModel->Barcode}', 
        ipv4='{$DataModel->IPv4}', 
        subnet='{$DataModel->Subnet}', 
        gateway='{$DataModel->Gateway}', 
        dns1='{$DataModel->DNS1}', 
        dns2='{$DataModel->DNS2}', 
        processor='{$DataModel->Processor}', 
        ram='{$DataModel->RAM}', 
        motherboard='{$DataModel->MOBO}', 
        hddnumber='{$DataModel->HDDNumb}', 
        hddsize='{$DataModel->HDDSize}', 
        gpu='{$DataModel->GPU}', 
        os='{$DataModel->OS}', 
        locations='{$DataModel->Location}'
        WHERE mac='{$DataModel->MAC}';";
    }
    public function DeletePC($var){
        return $Result = "DELETE FROM pc WHERE mac='{$var}';";
    }
    public function SelectPC($var){
        return $Result = "SELECT * FROM pc WHERE mac='{$var}';";
    }
    public function SelectPrograms($var){
        return $Result = "SELECT 1 FROM {$var} LIMIT 1;";
    }
    public function DeletePrograms($var){
        return $Result = "DROP TABLE {$var};";
    }
    public function CreatePrograms($var){
        return $Result = "CREATE TABLE {$var} (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(1024) NOT NULL , valid INT(4) NOT NULL DEFAULT 1 , date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP);";
    }
    public function UploadProgram($DataModel){
        return $Result = "INSERT INTO {$DataModel->MAC} (name) VALUES ('{$DataModel->Programs}');";
    }
    public function UploadLocations($var1, $var2){
        return $Result = "INSERT INTO location (global,local) VALUES('{$var1}', '{$var2}');";
    }
}

class HTMLHeaderInformation{
    public $title = "Hardware, network and programs 2018";
    public $favicon = "http://www.efos.unios.hr/wp-content/themes/efos/favicon.ico";
    public $author = "Antonio Kožar";
    public $description = "Website for monitoring hardware, network and programs on PC's.";
}
class HTMLBodyInformation{
    public $headernav;
    public $footernav;
    public $tableheader;
    public $tablebody;
    public $location;
    public $details;
}
class Details{
    public function PC($mac){
        $DatabaseInformation = new DatabaseInformation;
        $MySQLiQuerys = new MySQLiQuerys;
        $TH = array("ID: ", "Name: ", "Barcode: ", "MAC: ", "IPv4: ", "Subnet mask: ", "Gateway: ", "Primary DNS: ", "Secundary DNS: ", "Processor: ", "RAM: ", "Motherboard: ", "HDD number: ", "HDD size: ", "GPU: ", "OS", "Location: ", "First registration date:", "Last update date: " );
        $var = "";
        $Connection = $DatabaseInformation->DatabaseConnection();
        $Result = $Connection->query($MySQLiQuerys->DetailsPC($mac));
        $Result = $Result->fetch_assoc();
        $counter = 0;
        foreach ($Result as $key) {
            $var .= "<tr><th>" . $TH[$counter] . "</th><td>" . $key . "</td></tr>";
            $counter++;
        }
        return $var;
    }
}
class Navbar{    
    public function Home(){
        $var = '
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="1">  
                    <button class="btn btn-secondary" type="submit">Home</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                    <input type="hidden" name="Location" value="2">  
                    <button class="btn btn-outline-secondary" type="submit">PC list</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="3">  
                    <button class="btn btn-outline-secondary" type="submit">Network</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="4">  
                    <button class="btn btn-outline-secondary" type="submit">Programs</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="5">  
                    <button class="btn btn-outline-secondary" type="submit">Hardware</button>
                </form>
                </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <input disabled class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button disabled class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>  ';
        return $var;
    }
    public function PCList(){
        $var = '
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="1">  
                    <button class="btn btn-outline-secondary" type="submit">Home</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                    <input type="hidden" name="Location" value="2">  
                    <button class="btn btn-secondary" type="submit">PC list</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="3">  
                    <button class="btn btn-outline-secondary" type="submit">Network</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="4">  
                    <button class="btn btn-outline-secondary" type="submit">Programs</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="5">  
                    <button class="btn btn-outline-secondary" type="submit">Hardware</button>
                </form>
                </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <input disabled class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button disabled class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>';
        return $var;
    }
    public function Network(){
        $var = '
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="1">  
                    <button class="btn btn-outline-secondary" type="submit">Home</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                    <input type="hidden" name="Location" value="2">  
                    <button class="btn btn-outline-secondary" type="submit">PC list</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="3">  
                    <button class="btn btn-secondary" type="submit">Network</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="4">  
                    <button class="btn btn-outline-secondary" type="submit">Programs</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="5">  
                    <button class="btn btn-outline-secondary" type="submit">Hardware</button>
                </form>
                </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <input disabled class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button disabled class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>';
        return $var;
    }
    public function Programs(){
        $var = '
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="1">  
                    <button class="btn btn-outline-secondary" type="submit">Home</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                    <input type="hidden" name="Location" value="2">  
                    <button class="btn btn-outline-secondary" type="submit">PC list</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="3">  
                    <button class="btn btn-outline-secondary" type="submit">Network</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="4">  
                    <button class="btn btn-secondary" type="submit">Programs</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="5">  
                    <button class="btn btn-outline-secondary" type="submit">Hardware</button>
                </form>
                </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <input disabled class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button disabled class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>';
        return $var;
    }
    public function Hardware(){
        $var = '
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="1">  
                    <button class="btn btn-outline-secondary" type="submit">Home</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                    <input type="hidden" name="Location" value="2">  
                    <button class="btn btn-outline-secondary" type="submit">PC list</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="3">  
                    <button class="btn btn-outline-secondary" type="submit">Network</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="4">  
                    <button class="btn btn-outline-secondary" type="submit">Programs</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="5">  
                    <button class="btn btn-secondary" type="submit">Hardware</button>
                </form>
                </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <input disabled class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button disabled class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>';
        return $var;
    }
    public function FooterNav(){
        $var = '
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="1">  
                    <button class="btn btn-outline-secondary" type="submit">Home</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                    <input type="hidden" name="Location" value="2">  
                    <button class="btn btn-outline-secondary" type="submit">PC list</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="3">  
                    <button class="btn btn-outline-secondary" type="submit">Network</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="4">  
                    <button class="btn btn-outline-secondary" type="submit">Programs</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="5">  
                    <button class="btn btn-outline-secondary" type="submit">Hardware</button>
                </form>
                </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <input disabled class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button disabled class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>';
        return $var;
    }

    public function Detail(){
        $var = '
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="1">  
                    <button class="btn btn-outline-secondary" type="submit">Home</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                    <input type="hidden" name="Location" value="2">  
                    <button class="btn btn-outline-secondary" type="submit">PC list</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="3">  
                    <button class="btn btn-outline-secondary" type="submit">Network</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="4">  
                    <button class="btn btn-outline-secondary" type="submit">Programs</button>
                </form>
                </li>
                <li class="nav-item">
                <form method="POST">
                <input type="hidden" name="Location" value="5">  
                    <button class="btn btn-outline-secondary" type="submit">Hardware</button>
                </form>
                </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <input disabled class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button disabled class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>';
        return $var;
    }
}
class FooterBar{
    public function Navbar(){
        $var = '
        <div class="btn-group" role="group" aria-label="Basic example">
        <form method="POST">
          <input type="hidden" name="Location" value="6">  
          <button class="btn btn-outline-secondary" type="submit">Locations</button>
        </form>
        <form method="POST">
          <input type="hidden" name="Location" value="7">  
          <button class="btn btn-outline-secondary" type="submit">Processor</button>
        </form>
        <form method="POST">
          <input type="hidden" name="Location" value="8">  
          <button class="btn btn-outline-secondary" type="submit">Users</button>
        </form>
        <form method="POST">
          <input type="hidden" name="Location" value="9">  
          <button class="btn btn-outline-secondary" type="submit">Manual input</button>
        </form>
        </div>
        ';
        return $var;
    }
    public function Locations(){
        $var = '
        <div class="btn-group" role="group" aria-label="Basic example">
        <form method="POST">
          <input type="hidden" name="Location" value="6">  
          <button class="btn btn-secondary" type="submit">Locations</button>
        </form>
        <form method="POST">
          <input type="hidden" name="Location" value="7">  
          <button class="btn btn-outline-secondary" type="submit">Processor</button>
        </form>
        <form method="POST">
          <input type="hidden" name="Location" value="8">  
          <button class="btn btn-outline-secondary" type="submit">Users</button>
        </form>
        <form method="POST">
          <input type="hidden" name="Location" value="9">  
          <button class="btn btn-outline-secondary" type="submit">Manual input</button>
        </form>
        </div>
        ';
        return $var;
    }
    public function Processor(){
        $var = '
        <div class="btn-group" role="group" aria-label="Basic example">
        <form method="POST">
          <input type="hidden" name="Location" value="6">  
          <button class="btn btn-outline-secondary" type="submit">Locations</button>
        </form>
        <form method="POST">
          <input type="hidden" name="Location" value="7">  
          <button class="btn btn-secondary" type="submit">Processor</button>
        </form>
        <form method="POST">
          <input type="hidden" name="Location" value="8">  
          <button class="btn btn-outline-secondary" type="submit">Users</button>
        </form>
        <form method="POST">
          <input type="hidden" name="Location" value="9">  
          <button class="btn btn-outline-secondary" type="submit">Manual input</button>
        </form>
        </div>
        ';
        return $var;
    }
    public function Users(){
        $var = '
        <div class="btn-group" role="group" aria-label="Basic example">
        <form method="POST">
          <input type="hidden" name="Location" value="6">  
          <button class="btn btn-outline-secondary" type="submit">Locations</button>
        </form>
        <form method="POST">
          <input type="hidden" name="Location" value="7">  
          <button class="btn btn-outline-secondary" type="submit">Processor</button>
        </form>
        <form method="POST">
          <input type="hidden" name="Location" value="8">  
          <button class="btn btn-secondary" type="submit">Users</button>
        </form>
        <form method="POST">
          <input type="hidden" name="Location" value="9">  
          <button class="btn btn-outline-secondary" type="submit">Manual input</button>
        </form>
        </div>
        ';
        return $var;
    }
    public function ManualInput(){
        $var = '
        <div class="btn-group" role="group" aria-label="Basic example">
        <form method="POST">
          <input type="hidden" name="Location" value="6">  
          <button class="btn btn-outline-secondary" type="submit">Locations</button>
        </form>
        <form method="POST">
          <input type="hidden" name="Location" value="7">  
          <button class="btn btn-outline-secondary" type="submit">Processor</button>
        </form>
        <form method="POST">
          <input type="hidden" name="Location" value="8">  
          <button class="btn btn-outline-secondary" type="submit">Users</button>
        </form>
        <form method="POST">
          <input type="hidden" name="Location" value="9">  
          <button class="btn btn-secondary" type="submit">Manual input</button>
        </form>
        </div>
        ';
        return $var;
    }
}

class TableHeader{
    public function Home(){
        # Table header
        $TH = array("Barcode", "IPv4", "MAC", "PC name", "OS", "Options");
        $var = '<tr>';
        foreach ($TH as $key) {
            $var .= '<th scope="col">' . $key . '</th>';
        }
        $var .= '</tr>';
        return $var;
    }
    public function PCList(){
        # Table header
        $TH = array("PC name", "IPv4", "Barcode", "Location", "Options");
        $var = '<tr>';
        foreach ($TH as $key) {
            $var .= '<th scope="col">' . $key . '</th>';
        }
        $var .= '</tr>';
        return $var;
    }
    public function Network(){
        # Table header
        $TH = array("#", "IPv4 adress", "Free", "PC name");
        $var = '<tr>';
        foreach ($TH as $key) {
            $var .= '<th scope="col">' . $key . '</th>';
        }
        $var .= '</tr>';
        return $var;
    }
    public function Programs(){
        # Table header
        $TH = array("#", "Program name", "Used", "Allowed");
        $var = '<tr>';
        foreach ($TH as $key) {
            $var .= '<th scope="col">' . $key . '</th>';
        }
        $var .= '</tr>';
        return $var;
    }
    public function Hardware(){
        # Table header
        $TH = array("#", "Hardware name", "Used");
        $var = '<tr>';
        foreach ($TH as $key) {
            $var .= '<th scope="col">' . $key . '</th>';
        }
        $var .= '</tr>';
        return $var;
    }
    public function Locations(){
        # Table header
        $TH = array("Location", "Map");
        $var = '<tr>';
        foreach ($TH as $key) {
            $var .= '<th scope="col">' . $key . '</th>';
        }
        $var .= '</tr>';
        return $var;
    }
    public function Processors(){
        # Table header
        $TH = array("Name", "Count");

        $var = '<tr>';
        foreach ($TH as $key) {
            $var .= '<th scope="col">' . $key . '</th>';
        }
        $var .= '</tr>';
        return $var;
    }
    public function Users(){
        # Table header
        $TH = array("#", "Name", "Lastname", "Email", "Phone");
        $var = '<tr>';
        foreach ($TH as $key) {
            $var .= '<th scope="col">' . $key . '</th>';
        }
        $var .= '</tr>';
        return $var;
    }
    public function ManualInput()
    {
        # code...
    }
}
class TableBody{
    public function Home(){
        $DatabaseInformation = new DatabaseInformation;
        $MySQLiQuerys = new MySQLiQuerys;
        $var = "";
        $Connection = $DatabaseInformation->DatabaseConnection();
        $Result = $Connection->query($MySQLiQuerys->TableBodyHome);
        $Result = $Result->fetch_all(MYSQLI_ASSOC);
        foreach ($Result as $Row) {
            $var .= '<tr>';            
            $var .= '<td>' . $Row['barcode'] . '</td>';
            $var .= '<td>' . $Row['ipv4'] . '</td>';
            $var .= '<td>' . $Row['mac'] . '</td>';
            $var .= '<td>' . $Row['name'] . '</td>';
            $var .= '<td>' . $Row['os'] . '</td>';   
            $var .= '<td><form method="POST">
            <input type="hidden" name="Details" value="' . $Row['mac'] . '">  
                <button class="btn btn-secondary btn-sm" type="submit">Details</button>
            </form></td>';                
            $var .= '</tr>';
        }
        return $var;

    }
    public function PCList(){
        # code...
    }
    public function Network(){
        $DatabaseInformation = new DatabaseInformation;
        $MySQLiQuerys = new MySQLiQuerys;
        $var = "";
        $Connection = $DatabaseInformation->DatabaseConnection();
        $Result = $Connection->query($MySQLiQuerys->TableBodyNetwork);
        $Result = $Result->fetch_all(MYSQLI_ASSOC);
        $counter = 1;
        foreach ($Result as $Row) {
            $var .= '<tr>';            
            $var .= '<td>' . $counter . '</td>';
            $var .= '<td>' . $Row['ip'] . '</td>';
            $var .= '<td>Not yet</td>';
            $var .= '<td>' . $Row['mac'] . '</td>';
            $var .= '</tr>';
            $counter++;
        }
        return $var;
    }
    public function Programs(){
        # code...
    }
    public function Hardware(){
        # code...
    }
    public function Locations(){
        $DatabaseInformation = new DatabaseInformation;
        $MySQLiQuerys = new MySQLiQuerys;
        $var = "";
        $Connection = $DatabaseInformation->DatabaseConnection();
        $Result = $Connection->query($MySQLiQuerys->TableBodyLocation);
        $Result = $Result->fetch_all(MYSQLI_ASSOC);
        foreach ($Result as $Row) {
            $var .= '<tr>';            
            $var .= '<th>' . $Row['name'] . '</th>';
            $var .= '<td><img src="data:image/jpeg;base64,' . base64_encode($Row['img']) . '"/></td>';
            $var .= '</tr>';
        }
        return $var;
    }
    public function Processors(){
        $DatabaseInformation = new DatabaseInformation;
        $MySQLiQuerys = new MySQLiQuerys;
        $var = "";
        $Connection = $DatabaseInformation->DatabaseConnection();
        $Result1 = $Connection->query($MySQLiQuerys->TableBodyProcessors);
        $Result1 = $Result1->fetch_all(MYSQLI_ASSOC);
        
        foreach ($Result1 as $Row) {
            $Result2 = $Connection->query($MySQLiQuerys->TableBodyProcessorsCount($Row['processor']));
            
            $var .= '<tr>';            
            $var .= '<th>' . $Row['processor'] . '</th>';
            $var .= '<td>' . $Result2->fetch_all(MYSQLI_NUM)[0][0] . '</td>';
            $var .= '</tr>';
               
        }
        return $var;
    }
    public function Users()
    {
        # code...
    }
    public function ManualInput()
    {
        # code...
    }
}

?>