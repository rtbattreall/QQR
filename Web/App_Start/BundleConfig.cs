using System.Web;
using System.Web.Optimization;

namespace LyncStream.QQR.Web
{
    public class BundleConfig
    {
        // For more information on Bundling, visit http://go.microsoft.com/fwlink/?LinkId=254725
        public static void RegisterBundles(BundleCollection bundles)
        {
                      bundles.Add(new ScriptBundle("~/bundles/js").Include(
                        "~/Scripts/plugins.js"));

            bundles.Add(new ScriptBundle("~/bundles/ContactJS").Include(
                        "~/Scripts/qqr.contactus.js"));

            bundles.Add(new StyleBundle("~/Content/custom/css").Include("~/Content/custom/base.css",
                                                                "~/Content/custom/grid.css",
                                                                "~/Content/custom/layout.css",
                                                                "~/Content/custom/qqr.notie9.css"));

            bundles.Add(new StyleBundle("~/Content/themes/base/css").Include(
                        "~/Content/themes/base/jquery-ui.css",
                        "~/Content/themes/base/jquery.ui.core.css",
                        "~/Content/themes/base/jquery.ui.resizable.css",
                        "~/Content/themes/base/jquery.ui.selectable.css",
                        "~/Content/themes/base/jquery.ui.accordion.css",
                        "~/Content/themes/base/jquery.ui.autocomplete.css",
                        "~/Content/themes/base/jquery.ui.button.css",
                        "~/Content/themes/base/jquery.ui.dialog.css",
                        "~/Content/themes/base/jquery.ui.slider.css",
                        "~/Content/themes/base/jquery.ui.tabs.css",
                        "~/Content/themes/base/jquery.ui.datepicker.css",
                        "~/Content/themes/base/jquery.ui.progressbar.css",
                        "~/Content/themes/base/jquery.ui.theme.css"));
        }
    }
}