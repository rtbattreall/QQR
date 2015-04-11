using System.Collections.Generic;
using LyncStream.QQR.Common;
using LyncStream.QQR.DataAccess;

namespace LyncStream.QQR.Logic
{
    public class QQRManager : IQQRManager
    {
        #region Memebers

        private IQQRRepository _qqrRepository;
        public IQQRRepository QQRRepository
        {
            get { return _qqrRepository ?? (_qqrRepository = new QQRRepository()); }
            set { _qqrRepository = value; }
        }

        #endregion

        public List<KeyValuePair<string, string>> GetTurnAroundTimes()
        {
            return QQRRepository.SelectTurnAroundTimes();
        }

        public List<KeyValuePair<string, string>> GetTrialLengths()
        {
            return QQRRepository.SelectTrialLengths();
        }

        public List<KeyValuePair<string, string>> GetStates()
        {
            return QQRRepository.SelectStates();
        }

        public List<Testimonial> GetTestimonials(string filePath)
        {
            var test = QQRRepository.SelectTestimonials(filePath);
            return QQRRepository.SelectTestimonials(filePath).TestimonialList;
        }
    }
}
