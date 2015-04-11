using System.Collections.Generic;
using System.Xml.Serialization;

namespace LyncStream.QQR.Common
{
    [XmlRoot("Testimonials")]
    public class Testimonials
    {
        [XmlElement("Testimonial")]
        public List<Testimonial> TestimonialList { get; set; }
    }

    public class Testimonial
    {
        [XmlElement("Quote")]
        public string Quote { get; set; }

        [XmlElement("Name")]        
        public string Name { get; set; }

        [XmlElement("CompanyName")]         
        public string CompanyName { get; set; }
    }
}
