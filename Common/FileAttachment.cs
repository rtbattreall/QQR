using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace LyncStream.QQR.Common
{
    public class FileAttachment
    {
        public Stream FileStream { get; set; }

        public string FileName { get; set; }

        public int ContentLength { get; set; }
    }
}