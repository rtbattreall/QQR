using System.Collections.Generic;
using LyncStream.QQR.Common;

namespace LyncStream.QQR.DataAccess
{
    public interface IQQRRepository
    {
        List<KeyValuePair<string, string>> SelectTurnAroundTimes();
        List<KeyValuePair<string, string>> SelectTrialLengths();
        List<KeyValuePair<string, string>> SelectStates();
        Testimonials SelectTestimonials(string filePath);
    }
}
