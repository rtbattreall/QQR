using System.Net.Mail;

namespace LyncStream.QQR.DataAccess
{
    public interface IMailRepository
    {
        bool SendMail(MailMessage mailMessage);
    }
}
