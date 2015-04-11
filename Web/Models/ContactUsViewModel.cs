using System.ComponentModel.DataAnnotations;
using LyncStream.QQR.Common;

namespace LyncStream.QQR.Web.Models
{
    public class ContactUsViewModel
    {
        #region Properties

        [Required]
        public string Message { get; set; }

        [Required]
        public string Name { get; set; }

        [Required]
        public string CompanyName { get; set; }

        [Required]
        [RegularExpression(@"^([0-9a-zA-Z]([-\.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$", ErrorMessage = "The email specified is not in a valid email format.")]
        public string Email { get; set; }

        public SystemMessage SystemMessage { get; set; }

        #endregion

        #region Constructor

        public ContactUsViewModel()
        {
            SystemMessage = new SystemMessage();
        }

        #endregion
    }
}