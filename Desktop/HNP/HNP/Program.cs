using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading;
using System.Threading.Tasks;

namespace HNP
{
    class Program
    {
        static void Main(string[] args)
        {
            Model DataModel = new Model();
            Controler DataControler = new Controler();
            // User input
            Console.WriteLine("Location:");
            DataModel.Location = Console.ReadLine();
            Console.WriteLine("FD:");
            DataModel.FD = Console.ReadLine();
            Console.WriteLine("Port:");
            DataModel.Port = Console.ReadLine();
            Console.WriteLine("Barcode:");
            DataModel.Barcode = Console.ReadLine();

            //DataModel.Location = "S2-19";
            //DataModel.FD = "5";
            //DataModel.Port = "47";
            //DataModel.Barcode = "12134";

            // Network information
            DataModel.MAC = DataControler.MAC();
            DataModel.IPv4 = DataControler.IPv4();
            DataModel.Subnet = DataControler.Subnet(DataModel.IPv4);
            DataModel.DNS = DataControler.DNS();
            DataModel.DNS1 = DataModel.DNS[0].ToString();
            DataModel.DNS2 = DataModel.DNS[1].ToString();
            DataModel.Gateway = DataControler.Gateway();

            // PC information
            DataModel.Name = DataControler.Name();
            DataModel.OS = DataControler.OS();
            DataModel.Programs = DataControler.Programs();
            DataModel.Processor = DataControler.Processor();
            DataModel.MOBO = DataControler.MOBO();
            DataModel.HDDSize = DataControler.HDDSize();
            DataModel.HDDNumb = DataControler.HDDNumb();
            DataModel.RAM = DataControler.RAM();
            DataModel.GPU = DataControler.GPU();

            Console.WriteLine("\nData collected\n------------------------------------------------------------\nNETWORK DATA:\n\tIP:\t\t\t{0}\n\tSubnet Mask:\t\t{1}\n\tDefault Gateway:\t{2}\n\tDNS Server 1:\t\t{3}\n\tDNS Server 2:\t\t{4}\n\tFD:\t\t\t{5}\n\tPort:\t\t\t{6}\n----------------------------------------", DataModel.IPv4, DataModel.Subnet, DataModel.Gateway, DataModel.DNS1, DataModel.DNS2, DataModel.FD, DataModel.Port);
            Console.WriteLine("HARDWARE DATA:\n\tBarcode:\t\t{0}\n\tMAC:\t\t\t{1}\n\tProcessor:\t\t{2}\n\tRAM:\t\t\t{3}\n\tMotherboard:\t\t{4}\n\tHDD number:\t\t{5}\n\tHDD total size:\t\t{6}\n\tGPU:\t\t\t{7}\n\tOS:\t\t\t{8}\n----------------------------------------", DataModel.Barcode, DataModel.MAC, DataModel.Processor, DataModel.RAM, DataModel.MOBO, DataModel.HDDNumb, DataModel.HDDSize, DataModel.GPU[0].ToString(), DataModel.OS);
                       
            // Upload information PC
            byte[] responseArrayPC = DataControler.SendDataPOST(DataModel);

            // Decode and display the response.
            Console.WriteLine("\nResponse received was :\n{0}", Encoding.ASCII.GetString(responseArrayPC));

            // Upload information Programs
            ModelPrograms ProgramsModel = new ModelPrograms();
            ProgramsModel.MAC = DataModel.MAC;

            int counter = 0;
            using (var progress = new ProgressBar())
            {
                foreach (string key in DataModel.Programs)
                {
                    ProgramsModel.Program = key;
                    byte[] responseArrayPrograms = DataControler.SendDataPOSTPrograms(ProgramsModel);
                    if(Encoding.ASCII.GetString(responseArrayPrograms) == "")
                    {
                        progress.Report((double)counter / DataModel.Programs.Count);
                        Thread.Sleep(20);
                    }
                    else
                    {
                        Console.WriteLine("\nResponse received was :\n{0}", Encoding.ASCII.GetString(responseArrayPrograms));
                    }
                    counter++;
                }
            }
            Console.WriteLine("Done.");


            // Decode and display the response.
            Console.ReadKey();
        }
    }
}
