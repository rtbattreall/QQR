using LyncStream.QQR.Common;
using LyncStream.QQR.DataAccess;
using System;
using System.IO;
using System.Net.Mail;


namespace LyncStream.QQR.Logic
{
    public class MailManager : IMailManager
    {
        #region Members

        private IMailRepository _mailRepository;
        public IMailRepository MailRepository
        {
            get { return _mailRepository ?? (_mailRepository = new MailRepository()); }
            set { _mailRepository = value; }
        }

        #endregion

        #region Public Methods

        public bool SendMail(string companyName, string name, string fromAddress, string message)
        {
            #region Valdiation

            ValidateArgument(typeof(String), name, "The name specified cannot be empty or null.");
            ValidateArgument(typeof(String), fromAddress, "The from address specified cannot be empty or null.");
            ValidateArgument(typeof(String), message, "The message specified cannot be empty or null.");

            #endregion

            var mailMessage = new MailMessage
            {
                From = new MailAddress(Properties.Settings.Default.ContactFromAddress),
                Subject = Properties.Settings.Default.ContactSubject,
                Body = string.Format(Properties.Settings.Default.ContactBody, name, companyName, fromAddress, message),
                IsBodyHtml = true
            };

            mailMessage.To.Add(Properties.Settings.Default.ContactToAddress);

            return MailRepository.SendMail(mailMessage);
        }

        public bool SendMail(Schedule schedule)
        {
            #region Valdiation
            if (schedule == null)
            {
                throw new ArgumentException("The schedule passed in cannot be null.");
            }

            ValidateArgument(typeof(String), schedule.ContactName, "The contact name specified cannot be empty or null.");
            ValidateArgument(typeof(String), schedule.Email, "The from address specified cannot be empty or null.");

            #endregion

            var mailMessage = new MailMessage()
            {
                From = new MailAddress(Properties.Settings.Default.ScheduleFromAddress),
                Subject = Properties.Settings.Default.ScheduleSubject,
                IsBodyHtml = true
            };

            string hasFile = "No";
            if (schedule.FileAttachment != null
               && schedule.FileAttachment.ContentLength > 0)
            {
                hasFile = "Yes";
                AddAttachment(schedule.FileAttachment, mailMessage);
            }

            mailMessage.Body = string.Format(@Properties.Settings.Default.ScheduleBody
                                    , schedule.ContactName
                                    , schedule.AttorneyName
                                    , schedule.PhoneNumber
                                    , schedule.Email
                                    , schedule.TurnaroundTime
                                    , schedule.DeliveryComments
                                    , schedule.DepoDateTime
                                    , schedule.EstimatedTime
                                    , schedule.PlaceofTrial
                                    , schedule.Address
                                    , schedule.City
                                    , schedule.State
                                    , schedule.Video
                                    , hasFile);

            mailMessage.To.Add(Properties.Settings.Default.ScheduleToAddress);

            return MailRepository.SendMail(mailMessage);
        }

        #endregion

        #region Private Methods

        private void AddAttachment(FileAttachment fileAttachment, MailMessage mailMessage)
        {
            if (fileAttachment.ContentLength > 0)
            {
                mailMessage.Attachments.Add(new Attachment(fileAttachment.FileStream, fileAttachment.FileName));
            }
        }

        private void ValidateArgument(Type type, object value, string message)
        {
            if (type == typeof(String))
            {
                if (value == null
                    || string.IsNullOrWhiteSpace(value.ToString()))
                {
                    throw new ArgumentException(message);
                }
            }
        }

        #endregion
    }
}
