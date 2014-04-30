using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace LyncStream.QQR.Common
{
    public enum SystemMessageType
    {
        Information,
        Warning,
        Error
    }

    public class SystemMessage
    {
        public string Message { get; set; }

        public SystemMessageType MessageType { get; set; }
    }
}
