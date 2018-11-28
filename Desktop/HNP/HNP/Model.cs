using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.NetworkInformation;
using System.Text;
using System.Threading.Tasks;

namespace HNP
{
    class Model
    {
        public string Name { get; set; }
        public string Barcode { get; set; }
        public string MAC { get; set; }
        public string IPv4 { get; set; }
        public string Subnet { get; set; }
        public string Gateway { get; set; }
        public IPAddressCollection DNS { get; set; }
        public string DNS1 { get; set; }
        public string DNS2 { get; set; }
        public string Processor { get; set; }
        public string RAM { get; set; }
        public string MOBO { get; set; }
        public string HDDNumb { get; set; }
        public string HDDSize { get; set; }
        public string OS { get; set; }
        public string Location { get; set; }
        public string FD { get; set; }
        public string Port { get; set; }
        public List<String> GPU { get; set; }
        public List<String> Programs { get; set; }
    }
    class ModelPrograms
    {
        public string Program { get; set; }
        public string MAC { get; set; }
    }
    class HNPLocations
    {
        public string Upload = "http://localhost/Hardware-network-and-programs-PHP-2018/php/desktopupload.php";
    }
}
