
(function ($){
    "use strict";
    document.addEventListener('DOMContentLoaded', function (e) {
        (function () {
            // Update/reset user image
            HamkkeJsHelpers.uploadAndPreviewImage('#uploadedNavigationIcon', '#navigationIcon', '#resetNavigationIcon');
            HamkkeJsHelpers.uploadAndPreviewImage('#uploadedNavigationIcon_edit', '#navigationIcon_edit', '#resetNavigationIcon_edit');
        })();
    });
})(jQuery);
