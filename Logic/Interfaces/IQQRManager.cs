using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace LyncStream.QQR.Logic
{
    public interface IQQRManager
    {
        List<KeyValuePair<string, string>> GetTurnAroundTimes();
        List<KeyValuePair<string, string>> GetTrialLengths();
        List<KeyValuePair<string, string>> GetStates();
    }
}
