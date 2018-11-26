<?php
function ConstructorHome($Location, $mac)
{
    $HTMLBodyInformation = new HTMLBodyInformation;
    $Navbar = new Navbar;
    $TableHeader = new TableHeader;
    $TableBody = new TableBody;
    $Details = new Details;

    if($mac == "1"){    
        switch ($Location) {
            case '1':
            # Site Location
                $HTMLBodyInformation->location = "Home";
            # Navbar
                $HTMLBodyInformation->headernav = $Navbar->Home();
            # Table header
                $HTMLBodyInformation->tableheader = $TableHeader->Home();
            # Table body
                $HTMLBodyInformation->tablebody = $TableBody->Home();
                break;
            case '2':
            # Site Location
                $HTMLBodyInformation->location = "PC List";
            # Navbar
                $HTMLBodyInformation->headernav = $Navbar->PCList();
            # Table header
                $HTMLBodyInformation->tableheader = $TableHeader->PCList();
            # Table body
                $HTMLBodyInformation->tablebody = $TableBody->PCList();
                break;
            case '3':
                # Site Location
                $HTMLBodyInformation->location = "Network";
            # Navbar
                $HTMLBodyInformation->headernav = $Navbar->Network();
            # Table header
                $HTMLBodyInformation->tableheader = $TableHeader->Network();
            # Table body
                $HTMLBodyInformation->tablebody = $TableBody->Network();
                break;
            case '4':
                # Site Location
                $HTMLBodyInformation->location = "Programs";
            # Navbar
                $HTMLBodyInformation->headernav = $Navbar->Programs();
            # Table header
                $HTMLBodyInformation->tableheader = $TableHeader->Programs();
            # Table body
                $HTMLBodyInformation->tablebody = $TableBody->Programs();
                break;
            case '5':
                # Site Location
                $HTMLBodyInformation->location = "Hardware";
            # Navbar
                $HTMLBodyInformation->headernav = $Navbar->Hardware();
            # Table header
                $HTMLBodyInformation->tableheader = $TableHeader->Hardware();
            # Table body
                $HTMLBodyInformation->tablebody = $TableBody->Hardware();
                break;
            default:
                $HTMLBodyInformation->location = header("Location: index.php");
                break;
        }
    }
    else {
        # Details
        $HTMLBodyInformation->tablebody = $Details->PC($mac);
        # Site Location
        $HTMLBodyInformation->location = "Details for: " . $mac;
        # Navbar
        $HTMLBodyInformation->headernav = $Navbar->Detail();
    }
    return $HTMLBodyInformation;
}
?>