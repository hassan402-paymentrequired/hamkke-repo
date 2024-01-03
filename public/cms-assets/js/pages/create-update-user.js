
(function ($){
    "use strict";
    document.addEventListener('DOMContentLoaded', function (e) {
        (function () {
            // Update/reset user image
            HamkkeJsHelpers.uploadAndPreviewImage('#uploadedUserAvatar', '#userAvatar', '#resetAvatarField');

            // $('#formSubmitButton').on('click', function (e){
            //     const formId = $(e.target).data('form_to_submit');
            //     HamkkeJsHelpers.disableEmptyFormFieldsThenSubmit(`#${formId}`);
            //     $(`#${formId}`).submit();
            // });
        })();
    });
})(jQuery);
