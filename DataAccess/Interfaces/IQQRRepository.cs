using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace LyncStream.QQR.DataAccess
{
    public interface IQQRRepository
    {
        List<KeyValuePair<string, string>> SelectTurnAroundTimes();
        List<KeyValuePair<string, string>> SelectTrialLengths();
        List<KeyValuePair<string, string>> SelectStates();
    }
}
