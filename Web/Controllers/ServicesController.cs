﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace LyncStream.QQR.Web.Views
{
    public class ServicesController : Controller
    {
        // GET: Services
        public ActionResult Index()
        {
            return View("Services");
        }
        public ActionResult CourtReporting()
        {
            return View("CourtReporting");
        }
    }
}