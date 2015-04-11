using LyncStream.QQR.Common;
using LyncStream.QQR.Logic;
using LyncStream.QQR.Web;
using LyncStream.QQR.Web.Models;
using System;
using System.IO;
using System.Web;
using System.Web.Mvc;

namespace LyncStream.QQR.Web.Controllers
{
    [ExceptionHandler]
    public class HomeController : Controller
    {
        #region Members

        private IMailManager _mailManager;
        public IMailManager MailManager
        {
            get { return _mailManager ?? (_mailManager = new MailManager()); }
            set { _mailManager = value; }
        }

        #endregion


        public ActionResult Index()
        {
            return View();
        }

        public ActionResult Services()
        {
            return View();
        }

        public ActionResult Testimonial()
        {
            var model = new TestimonialViewModel();
            return View(model.CreateModel(Server.MapPath("~/App_Data/Testimonials.xml")));
        }

        public ActionResult ScheduleDepo()
        {
            return View(new ScheduleViewModel());
        }

        [HttpPost]
        public ActionResult ScheduleDepo(ScheduleViewModel model, HttpPostedFileBase file)
        {
            if (ModelState.IsValid)
            {
                try
                {
                    var schedule = new Schedule()
                    {
                        AttorneyName = model.AttorneyName,          //0
                        PhoneNumber = model.PhoneNumber,            //1
                        ContactName = model.ContactName,            //2
                        Email = model.Email,                        //3
                        DepoDateTime = model.DepoDateTime,          //4
                        PlaceofTrial = model.PlaceofTrial,          //5
                        Address = model.Address,                    //6
                        City = model.City,                          //7
                        State = model.StateValue,                   //8
                        Video = model.Video,                        //9
                        EstimatedTime = model.EstimatedTimeValue,   //10
                        TurnaroundTime = model.TurnaroundTimeValue, //11
                        DeliveryComments = model.DeliveryComments   //12
                    };

                    if (file != null)
                    {
                        schedule.FileAttachment = new FileAttachment()
                        {
                            FileStream = file.InputStream,
                            FileName = file.FileName,
                            ContentLength = file.ContentLength
                        };
                    }

                    MailManager.SendMail(schedule);
                }
                catch
                {
                    model.SystemMessage.Message = @"There was a problem scheduling your depo.  Please try again.";
                    model.SystemMessage.MessageType = SystemMessageType.Error;
                    return View(model);
                }
            }

            model = new ScheduleViewModel();
            model.SystemMessage.Message = @"Your request to schedule a deposition has been sent.";
            model.SystemMessage.MessageType = SystemMessageType.Information;
            return View(model);
        }

        public ActionResult ContactUs()
        {
            return View(new ContactUsViewModel());
        }

        [HttpPost]
        public ActionResult ContactUs(ContactUsViewModel model)
        {
            if (ModelState.IsValid)
            {
                try
                {
                    MailManager.SendMail(model.CompanyName, model.Name, model.Email, model.Message);
                }
                catch(Exception ex)
                {
                    model.SystemMessage.Message = ex.Message;                    
                    model.SystemMessage.MessageType = SystemMessageType.Error;
                    return View(model);
                }
            }

            model = new ContactUsViewModel();
            model.SystemMessage.Message = "Your request to be contacted has been sent.";
            model.SystemMessage.MessageType = SystemMessageType.Information;
            return View(model);
        }
    }
}
