using System.Collections.Generic;
using LyncStream.QQR.Common;

namespace LyncStream.QQR.Logic
{
    public interface IQQRManager
    {
        List<KeyValuePair<string, string>> GetTurnAroundTimes();
        List<KeyValuePair<string, string>> GetTrialLengths();
        List<KeyValuePair<string, string>> GetStates();
        List<Testimonial> GetTestimonials(string filePath);
    }
}
