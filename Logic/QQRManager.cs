using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
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
    }
}
