using System.Net.Mail;

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
                smtpClient.UseDefaultCredentials = false;
                smtpClient.Credentials = new System.Net.NetworkCredential(Properties.Settings.Default.UserName, Properties.Settings.Default.Password);
                smtpClient.EnableSsl = Properties.Settings.Default.EnableSSL;
                smtpClient.DeliveryMethod = SmtpDeliveryMethod.Network;
            }
            else
            {
                smtpClient = new SmtpClient();
            }

            smtpClient.Send(mailMessage);

            return true;
        }
    }
}
