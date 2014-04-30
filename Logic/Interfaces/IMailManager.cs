using System.Net.Mail;
using LyncStream.QQR.Common;

namespace LyncStream.QQR.Logic
{
    public interface IMailManager
    {
        bool SendMail(string companyName, string name, string fromAddress, string message);
        bool SendMail(Schedule schedule);
    }
}
