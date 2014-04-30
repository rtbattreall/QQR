using System;
using System.Net;
using System.Web;
using System.Web.Mvc;

namespace LyncStream.QQR.Web
{
    [AttributeUsage(AttributeTargets.Method | AttributeTargets.Class)]
    public class ExceptionHandler : ActionFilterAttribute, IExceptionFilter
    {
        public enum JsonResultType
        {
            Success,
            Warning,
            Error
        }

        public void OnException(ExceptionContext filterContext)
        {
            //Do not handle Error If CustomError is TurnedOff i.e In development
            if (filterContext.HttpContext.IsCustomErrorEnabled == false
                    && filterContext.HttpContext.Request.IsAjaxRequest() == false)
            {
                return;
            }

            //Set flag that Exception was handled
            filterContext.ExceptionHandled = true;

            //Log Exception If its not ArgumentException or ArgumentNullException
            //LogException(filterContext);

            //Handle Ajax Request
            filterContext.Result = filterContext.HttpContext.Request.IsAjaxRequest() ? AjaxError(filterContext) : NonAjaxError(filterContext);
        }

        #region Support Methods

        /// <summary>
        /// Method that redirects to Default Error Page on Error
        /// </summary>
        /// <param name="filterContext">ExceptionContext</param>
        /// <returns>Error View</returns>
        public static ActionResult NonAjaxError(ExceptionContext filterContext)
        {
            var errorInfo = new HandleErrorInfo(filterContext.Exception,
                                                                    filterContext.RouteData.Values["controller"].ToString(),
                                                                    filterContext.RouteData.Values["action"].ToString());


            //Check for invalid parameter for action & reset the message as Lost
            if (errorInfo.Exception.Message.Contains("The parameters dictionary contains a null entry for parameter") == true)
            {
                errorInfo = new HandleErrorInfo(new Exception("Requested page is not found or Invalid URL"),
                                                                    errorInfo.ControllerName,
                                                                    errorInfo.ActionName);
            }

            var viewResult = new ViewResult { ViewName = "Error", ViewData = new ViewDataDictionary(errorInfo) };
            return viewResult;
        }

        /// <summary>
        /// Method that handles the Ajax Errors
        /// </summary>
        /// <param name="filterContext">ExceptionContext</param>
        /// <returns>JsonResult</returns>
        public static JsonResult AjaxError(ExceptionContext filterContext)
        {
            //Set the response status code to 500
            filterContext.HttpContext.Response.StatusCode = (int)HttpStatusCode.InternalServerError;

            //Needed for IIS7.0
            filterContext.HttpContext.Response.TrySkipIisCustomErrors = true;

            return new JsonResult
            {
                Data = new { Type = JsonResultType.Error.ToString(), filterContext.Exception.Message, ExceptionType = filterContext.Exception.GetType().Name },
                ContentEncoding = System.Text.Encoding.UTF8,
                JsonRequestBehavior = JsonRequestBehavior.AllowGet
            };
        }       

        /// <summary>
        /// Methods that handles Warning & Set the Status code to Error
        /// </summary>
        /// <param name="message">Warning Message</param>
        /// <returns>JsonResult</returns>
        public static JsonResult SendWarning(string message)
        {
            //Set the response status code to 500
            HttpContext.Current.Response.StatusCode = (int)HttpStatusCode.InternalServerError;

            //Needed for IIS7.0
            HttpContext.Current.Response.TrySkipIisCustomErrors = true;

            return new JsonResult
            {
                Data = new { Type = JsonResultType.Warning.ToString(), Message = message },
                ContentEncoding = System.Text.Encoding.UTF8,
                JsonRequestBehavior = JsonRequestBehavior.AllowGet
            };
        }

        #endregion
    }
}