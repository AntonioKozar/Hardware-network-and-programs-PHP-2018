using Microsoft.Win32;
using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.IO;
using System.Management;
using System.Net;
using System.Net.NetworkInformation;

namespace HNP
{
    class Controler
    {
        public string MAC()
        {
            NetworkInterface[] NetworkAdapterList = NetworkInterface.GetAllNetworkInterfaces();
            string Result = "";
            foreach(NetworkInterface Adapter in NetworkAdapterList)
            {
                if(Adapter.NetworkInterfaceType.ToString() == "Ethernet")
                {
                    Result = Adapter.GetPhysicalAddress().ToString();
                }
            }
            return Result;
        }
        public string IPv4()
        {
            string Result = "";
            var HostNameList = Dns.GetHostEntry(Dns.GetHostName());
            foreach(var IP in HostNameList.AddressList)
            {
                if(IP.AddressFamily == System.Net.Sockets.AddressFamily.InterNetwork)
                {
                    Result = IP.ToString();
                }                
            }
            return Result;
        }
        public string Subnet(string Address)
        {
            string Result = "";
            foreach(NetworkInterface Adapter in NetworkInterface.GetAllNetworkInterfaces())
            {
                foreach(UnicastIPAddressInformation UIPAddressInformation in Adapter.GetIPProperties().UnicastAddresses)
                {
                    if (UIPAddressInformation.Address.AddressFamily == System.Net.Sockets.AddressFamily.InterNetwork & Address.Equals(UIPAddressInformation.Address.ToString()))
                    {
                        Result = UIPAddressInformation.IPv4Mask.ToString();
                    }
                }
            }
            return Result;
        }
        public IPAddressCollection DNS()
        {
            
            NetworkInterface[] NetworkAdapterList = NetworkInterface.GetAllNetworkInterfaces();
            foreach (NetworkInterface Adapter in NetworkAdapterList)
            {
                if (Adapter.NetworkInterfaceType.ToString() == "Ethernet")
                {
                    IPAddressCollection Result = Adapter.GetIPProperties().DnsAddresses;
                    return Result;
                }
            }
            throw new InvalidOperationException("DNS not found");
            
        }
        public string Gateway()
        {
            NetworkInterface[] NetworkAdapterList = NetworkInterface.GetAllNetworkInterfaces();
            string Result = "";
            foreach (NetworkInterface Adapter in NetworkAdapterList)
            {
                foreach (var GatewayAdress in Adapter.GetIPProperties().GatewayAddresses)
                {
                    if (GatewayAdress.Address.AddressFamily == System.Net.Sockets.AddressFamily.InterNetwork)
                    {
                        Result = GatewayAdress.Address.ToString();
                    }
                }
            }
            return Result;
        }
        public string Name()
        {
            string Result = Dns.GetHostName();
            return Result;
        }
        public string OS()
        {
            RegistryKey registryKey = Registry.LocalMachine.OpenSubKey("Software\\Microsoft\\Windows NT\\CurrentVersion");
            string Result = (string)registryKey.GetValue("ProductName") + " Version: " + (string)registryKey.GetValue("ReleaseId");
            return Result;
        }
        public List<String> Programs()
        {
            List<String> Result = new List<String>();
            RegistryKey registryKey = Registry.LocalMachine.OpenSubKey("SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Uninstall");
            foreach(string SubKeyName in registryKey.GetSubKeyNames())
            {
                RegistryKey SubKey = registryKey.OpenSubKey(SubKeyName);
                if(SubKey.GetValue("DisplayName") != null & SubKey.GetValue("Publisher") != null)
                {
                    Result.Add(SubKey.GetValue("Publisher").ToString() + " >>> " + SubKey.GetValue("DisplayName").ToString());
                }
                
            }
            Result.Sort();
            return Result;
        }
        public string Processor()
        {
            RegistryKey registryKey = Registry.LocalMachine.OpenSubKey("HARDWARE\\DESCRIPTION\\System\\CentralProcessor\\0");
            string Result = (string)registryKey.GetValue("ProcessorNameString");

            return Result;
        }
        public string MOBO()
        {
            RegistryKey registryKey = Registry.LocalMachine.OpenSubKey("HARDWARE\\DESCRIPTION\\System\\BIOS");
            string Result = (string)registryKey.GetValue("BaseBoardManufacturer") + " " + (string)registryKey.GetValue("BaseBoardProduct") + " BIOS: " + (string)registryKey.GetValue("BIOSVersion");
            return Result;
        }
        public string HDDSize()
        {
            long Value = 0;
            foreach(DriveInfo Drive in DriveInfo.GetDrives())
            {
                if(Drive.DriveType == DriveType.Fixed)
                {
                    Value += Drive.TotalSize;
                    
                }
            }            
            string Result = Value.ToString();
            return Result;
        }
        public string HDDNumb()
        {
            long Value = 0;
            foreach (DriveInfo Drive in DriveInfo.GetDrives())
            {
                if (Drive.DriveType == DriveType.Fixed)
                {
                    Value++;
                }
            }
            string Result = Value.ToString();
            return Result;
        }
        public string RAM()
        {
            UInt64 Value = 0;
            foreach (ManagementObject Element in new ManagementObjectSearcher("SELECT Capacity FROM Win32_PhysicalMemory").Get())
            {
                Value += Convert.ToUInt64(Element.Properties["Capacity"].Value);
            }
            string Result = Value.ToString();
            return Result;
        }
        public List<String> GPU()
        {
            List<String> Result = new List<String>();
            foreach (ManagementObject Element in new ManagementObjectSearcher("SELECT * FROM Win32_VideoController").Get())
            {
                Result.Add(Element["Name"].ToString());
            }
            return Result;
        }
        public byte[] SendDataPOST(Model DataModel)
        {
            WebClient Client = new WebClient();
            NameValueCollection Values = new NameValueCollection();
            HNPLocations URL = new HNPLocations();
            Values.Add("UploadData", "1");
            Values.Add("Name", DataModel.Name);
            Values.Add("Barcode", DataModel.Barcode);
            Values.Add("MAC", DataModel.MAC);
            Values.Add("IPv4", DataModel.IPv4);
            Values.Add("Subnet", DataModel.Subnet);
            Values.Add("Gateway", DataModel.Gateway);
            Values.Add("DNS1", DataModel.DNS1);
            Values.Add("DNS2", DataModel.DNS2);
            Values.Add("Processor", DataModel.Processor);
            Values.Add("RAM", DataModel.RAM);
            Values.Add("MOBO", DataModel.MOBO);
            Values.Add("HDDNumb", DataModel.HDDNumb);
            Values.Add("HDDSize", DataModel.HDDSize);
            Values.Add("OS", DataModel.OS);
            Values.Add("Location", DataModel.Location);
            Values.Add("FD", DataModel.FD);
            Values.Add("Port", DataModel.Port);

            byte[] responseArray = Client.UploadValues(URL.Upload, Values);
            return responseArray;
        }
    }
}
