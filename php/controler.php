<?php
function ConstructorHome($Location, $mac)
{
    $HTMLBodyInformation = new HTMLBodyInformation;
    $Navbar = new Navbar;
    $FooterBar = new FooterBar;
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
            # FooterBar
                $HTMLBodyInformation->footernav = $FooterBar->Navbar();
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
            # FooterBar
                $HTMLBodyInformation->footernav = $FooterBar->Navbar();
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
            # FooterBar
                $HTMLBodyInformation->footernav = $FooterBar->Navbar();
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
            # FooterBar
                $HTMLBodyInformation->footernav = $FooterBar->Navbar();
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
            # FooterBar
                $HTMLBodyInformation->footernav = $FooterBar->Navbar();
            # Table header
                $HTMLBodyInformation->tableheader = $TableHeader->Hardware();
            # Table body
                $HTMLBodyInformation->tablebody = $TableBody->Hardware();
                break;
                case '6':
            # Site Location
                $HTMLBodyInformation->location = "Locations";
            # Navbar
                $HTMLBodyInformation->headernav = $Navbar->FooterNav();
            # FooterBar
                $HTMLBodyInformation->footernav = $FooterBar->Locations();
            # Table header
                $HTMLBodyInformation->tableheader = $TableHeader->Locations();
            # Table body
                $HTMLBodyInformation->tablebody = $TableBody->Locations();
                break;
                case '7':
            # Site Location
                $HTMLBodyInformation->location = "Processor";
            # Navbar
                $HTMLBodyInformation->headernav = $Navbar->FooterNav();
            # FooterBar
                $HTMLBodyInformation->footernav = $FooterBar->Processor();
            # Table header
                $HTMLBodyInformation->tableheader = $TableHeader->Processors();
            # Table body
                $HTMLBodyInformation->tablebody = $TableBody->Processors();
                break;
                case '8':
            # Site Location
                $HTMLBodyInformation->location = "Users";
            # Navbar
                $HTMLBodyInformation->headernav = $Navbar->FooterNav();
            # FooterBar
                $HTMLBodyInformation->footernav = $FooterBar->Users();
            # Table header
                $HTMLBodyInformation->tableheader = $TableHeader->Users();
            # Table body
                $HTMLBodyInformation->tablebody = $TableBody->Users();
                break;
                case '9':
            # Site Location
                $HTMLBodyInformation->location = "Manual input";
            # Navbar
                $HTMLBodyInformation->headernav = $Navbar->FooterNav();
            # FooterBar
                $HTMLBodyInformation->footernav = $FooterBar->ManualInput();
            # Table header
                $HTMLBodyInformation->tableheader = $TableHeader->ManualInput();
            # Table body
                $HTMLBodyInformation->tablebody = $TableBody->ManualInput();
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
        # FooterBar
        $HTMLBodyInformation->footernav = $FooterBar->Navbar();
    }
    return $HTMLBodyInformation;
}
?>