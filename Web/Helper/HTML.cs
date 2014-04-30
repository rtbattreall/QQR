using System.Text;
using System.Web.Mvc;

namespace LyncStream.QQR.Web.Helpers
{
    public static class HTML
    {
        private const string script = "<script src=\"{0}\" type=\"text/javascript\"></script>";

        public static string Scripts(this HtmlHelper helper)
        {
            UrlHelper urlHelper = new UrlHelper(helper.ViewContext.RequestContext, helper.RouteCollection);

            StringBuilder scripts = new StringBuilder();

            //Third party scripts
            scripts.Append(string.Format(script, urlHelper.Content("~/js/jquery-1.9.0.min.js")));
            scripts.Append(string.Format(script, urlHelper.Content("~/js/jquery-ui-1.10.0.custom.min.js")));
            scripts.Append(string.Format(script, urlHelper.Content("~/js/jquery.dataTables.min.js")));
            scripts.Append(string.Format(script, urlHelper.Content("~/js/jquery.json-2.3.min.js")));
            scripts.Append(string.Format(script, urlHelper.Content("~/js/jquery.validate.min.js")));
            scripts.Append(string.Format(script, urlHelper.Content("~/js/jquery.validate.unobtrusive.min.js")));
            return scripts.ToString();
        }
    }
}