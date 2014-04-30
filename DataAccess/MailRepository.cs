using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Mail;
using System.Text;
using System.Threading.Tasks;

namespace LyncStream.QQR.DataAccess
{
    public class MailRepository : IMailRepository
    {
        public bool SendMail(MailMessage mailMessage)
        {
            SmtpClient smtpClient = null;                      
            if (Properties.Settings.Default.UseCredentials)
            {
                smtpClient = new SmtpClient(Properties.Settings.Default.SmtpServer, Properties.Settings.Default.PortNumber);
                smtpClient.UseDefaultCredentials = true;
                smtpClient.Credentials = new System.Net.NetworkCredential(Properties.Settings.Default.UserName, Properties.Settings.Default.Password);
                smtpClient.EnableSsl = false;
                smtpClient.DeliveryMethod = SmtpDeliveryMethod.Network;
            }
            else
            {
                smtpClient = new SmtpClient(Properties.Settings.Default.SmtpServer);
            }

            smtpClient.Send(mailMessage);

            return true;
        }
    }
}
