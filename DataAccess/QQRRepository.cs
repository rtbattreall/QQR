using System.Collections.Generic;
using System.IO;
using System.Xml.Serialization;
using LyncStream.QQR.Common;

namespace LyncStream.QQR.DataAccess
{
    public class QQRRepository : IQQRRepository
    {
        public List<KeyValuePair<string, string>> SelectTurnAroundTimes()
        {
            return new List<KeyValuePair<string, string>>()
            {
                new KeyValuePair<string, string>("Make selection", ""),
                new KeyValuePair<string, string>("Regular (7-10 days)", "Regular (7-10 days)"),
                new KeyValuePair<string, string>("Expedited (3 days)", "Expedited (3 days)"),
                new KeyValuePair<string, string>("Daily Copy (next day)", "Daily Copy (next day)"),
                new KeyValuePair<string, string>("Rushed (same day)", "Rushed (same day)")
            };
        }

        public List<KeyValuePair<string, string>> SelectTrialLengths()
        {
            return new List<KeyValuePair<string, string>>()
            {
                new KeyValuePair<string, string>("Make selection", ""),
                new KeyValuePair<string, string>("Less than 1 hour", "Less than 1 hour"),
                new KeyValuePair<string, string>("1 hour", "1 hour"),
                new KeyValuePair<string, string>("2 hour", "2 hour"),
                new KeyValuePair<string, string>("3 hours", "3 hours"),
                new KeyValuePair<string, string>("4 hours", "4 hours"),
                new KeyValuePair<string, string>("5 hours", "5 hours"),
                new KeyValuePair<string, string>("6 hours", "6 hours"),
                new KeyValuePair<string, string>("7+ hours", "7+ hours")
            };
        }

        public List<KeyValuePair<string, string>> SelectStates()
        {
            return new List<KeyValuePair<string, string>>()
            {
                new KeyValuePair<string, string>("Select a State", ""),
                new KeyValuePair<string, string>("Alabama", "AL"),
                new KeyValuePair<string, string>("Alaska", "AK"),
                new KeyValuePair<string, string>("Arizona", "AZ"),
                new KeyValuePair<string, string>("Arkansas", "AR"),
                new KeyValuePair<string, string>("California", "CA"),
                new KeyValuePair<string, string>("Colorado", "CO"),
                new KeyValuePair<string, string>("Connecticut", "CT"),
                new KeyValuePair<string, string>("Delaware", "DE"),
                new KeyValuePair<string, string>("District Of Columbia", "DC"),
                new KeyValuePair<string, string>("Florida", "FL"),
                new KeyValuePair<string, string>("Georgia", "GA"),
                new KeyValuePair<string, string>("Hawaii", "HI"),
                new KeyValuePair<string, string>("Idaho", "ID"),
                new KeyValuePair<string, string>("Illinois", "IL"),
                new KeyValuePair<string, string>("Indiana", "IN"),
                new KeyValuePair<string, string>("Iowa", "IA"),
                new KeyValuePair<string, string>("Kansas", "KS"),
                new KeyValuePair<string, string>("Kentucky", "KY"),
                new KeyValuePair<string, string>("Louisiana", "LA"),
                new KeyValuePair<string, string>("Maine", "ME"),
                new KeyValuePair<string, string>("Maryland", "MD"),
                new KeyValuePair<string, string>("Massachusetts", "MA"),
                new KeyValuePair<string, string>("Michigan", "MI"),
                new KeyValuePair<string, string>("Minnesota", "MN"),
                new KeyValuePair<string, string>("Mississippi", "MS"),
                new KeyValuePair<string, string>("Missouri", "MO"),
                new KeyValuePair<string, string>("Montana", "MT"),
                new KeyValuePair<string, string>("Nebraska", "NE"),
                new KeyValuePair<string, string>("Nevada", "NV"),
                new KeyValuePair<string, string>("New Hampshire", "NH"),
                new KeyValuePair<string, string>("New Jersey", "NJ"),
                new KeyValuePair<string, string>("New Mexico", "NM"),
                new KeyValuePair<string, string>("New York", "NY"),
                new KeyValuePair<string, string>("North Carolina", "NC"),
                new KeyValuePair<string, string>("North Dakota", "ND"),
                new KeyValuePair<string, string>("Ohio", "OH"),
                new KeyValuePair<string, string>("Oklahoma", "OK"),
                new KeyValuePair<string, string>("Oregon", "OR"),
                new KeyValuePair<string, string>("Pennsylvania", "PN"),
                new KeyValuePair<string, string>("Rhode Island", "RI"),
                new KeyValuePair<string, string>("South Carolina", "SC"),
                new KeyValuePair<string, string>("South Dakota", "SD"),
                new KeyValuePair<string, string>("Tennessee", "TN"),
                new KeyValuePair<string, string>("Texas", "TX"),
                new KeyValuePair<string, string>("Utah", "UT"),
                new KeyValuePair<string, string>("Vermont", "VT"),
                new KeyValuePair<string, string>("Virginia", "VA"),
                new KeyValuePair<string, string>("Washington", "WA"),
                new KeyValuePair<string, string>("West Virginia", "WV"),
                new KeyValuePair<string, string>("Wisconsin", "WI"),
                new KeyValuePair<string, string>("Wyoming", "WY")                              
            };
        }

        public Testimonials SelectTestimonials(string filePath)
        {
            var serializer = new XmlSerializer(typeof(Testimonials));
            using (var fileStream = new FileStream(filePath, FileMode.Open))
            {
                return (Testimonials)serializer.Deserialize(fileStream);
            }
        }
    }
}
