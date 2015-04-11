using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using LyncStream.QQR.Logic;

namespace LyncStream.QQR.Web.Models
{
    public class TestimonialViewModel
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

        #endregion

        #region Properties

        [Required]
        public string Quote { get; set; }

        [Required]
        public string Name { get; set; }

        [Required]
        public string CompanyName { get; set; }   

        #endregion

        #region Constructor

        public TestimonialViewModel() {}

        #endregion

        public List<TestimonialViewModel> CreateModel(string filePath)
        {
            var testimonials = QQRManager.GetTestimonials(filePath);
            var model = new List<TestimonialViewModel>();
            foreach (var testimonial in testimonials)
            {
                model.Add(new TestimonialViewModel { Quote = testimonial.Quote, Name = testimonial.Name, CompanyName = testimonial.CompanyName }); 
            }

            return model;
        }
    }
}