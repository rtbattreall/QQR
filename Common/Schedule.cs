using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace LyncStream.QQR.Common
{
    public class Schedule
    {
        #region Properties

        public string AttorneyName { get; set; }

        public string PhoneNumber { get; set; }

        public string ContactName { get; set; }

        public string Email { get; set; }

        public string DepoDateTime { get; set; }

        public string PlaceofTrial { get; set; }

        public string Address { get; set; }

        public string City { get; set; }

        public string State { get; set; }

        public string Video { get; set; }

        public string EstimatedTime { get; set; }

        public string Case { get; set; }

        public string Docket { get; set; }

        public string TurnaroundTime { get; set; }

        public string CaseComments { get; set; }

        public string DeliveryComments { get; set; }

        public FileAttachment FileAttachment { get; set; }

        #endregion
    }
}
