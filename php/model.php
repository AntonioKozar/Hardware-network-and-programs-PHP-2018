<?php
class DatabaseInformation{
    public function DatabaseConnection()
    {
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

class MySQLiQuerys{
    public $TableBodyHome = 'SELECT barcode, ipv4, mac, name, os FROM pc ORDER BY barcode;';
    public $TableBodyNetwork = 'SELECT ip, mac FROM network ORDER BY ip;';
    public function DetailsPC($var)
    {
        $Result = "SELECT * FROM pc WHERE mac='{$var}';";
        return $Result;
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
    public function PC($mac)
    {
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
    public function PCList()
    {
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
    public function Programs()
    {
        # code...
    }
    public function Hardware()
    {
        # code...
    }
}

?>