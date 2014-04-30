using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using LyncStream.QQR.Common;
using LyncStream.QQR.Logic;

namespace LyncStream.QQR.Web.Models
{
    public class ScheduleViewModel
    {
        #region Members
        private IQQRManager _qqrManager;
        public IQQRManager QQRManager
        {
            get
            {
                return (_qqrManager == null ? _qqrManager = new QQRManager() : _qqrManager);
            }
        }

        [Required]
        public string AttorneyName { get; set; }

        [Required]
        [RegularExpression(@"^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$", ErrorMessage="The phone number specified is in an invalid format. Try format (555)555-5555.")]
        public string PhoneNumber { get; set; }

        [Required]
        public string ContactName { get; set; }

        [Required]
        [RegularExpression(@"^([0-9a-zA-Z]([-\.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$", ErrorMessage = "The email specified is not in a valid email format.")]
        public string Email { get; set; }

        [Required]
        public string DepoDateTime { get; set; }

        [Required]
        public string PlaceofTrial { get; set; }

        [Required]
        public string Address { get; set; }

        [Required]
        public string City { get; set; }

        [Required]
        public string StateValue { get; set; }

        [Required]
        public List<KeyValuePair<string, string>> State { get; set; }

        public string Video { get; set; }

        [Required]
        public string EstimatedTimeValue { get; set; }

        [Required]
        public List<KeyValuePair<string, string>> EstimatedTime { get; set; }        

        [Required]
        public string TurnaroundTimeValue { get; set; }

        [Required]
        public List<KeyValuePair<string, string>> TurnaroundTime { get; set; }

        public string DeliveryComments { get; set; }

        public string File { get; set; }

        public SystemMessage SystemMessage { get; set; }

        #endregion

        #region Constructor

        public ScheduleViewModel()
        {
            SystemMessage = new SystemMessage();
            TurnaroundTime = QQRManager.GetTurnAroundTimes();
            EstimatedTime = QQRManager.GetTrialLengths();
            State = QQRManager.GetStates();
        }

        #endregion
    }
}