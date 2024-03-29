
(function ($) {
    "use strict";

    window.onload = function (){
        HamkkeQuillHelpers.initializeQuillEditor(
            '#postContent',
            '#full-editor',
            '#postUpdateForm'
        );
    }

    document.addEventListener('DOMContentLoaded', function (e) {
        (function () {

            // Update/reset user image of account page
            let accountUserImage = document.getElementById('uploadedFeaturedImage');
            const fileInput = document.querySelector('.upload-featured-image-input'),
                resetFileInput = document.querySelector('.reset-featured-image-input');

            if (accountUserImage) {
                const resetImage = accountUserImage.src;
                fileInput.onchange = () => {
                    if (fileInput.files[0]) {
                        accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
                    }
                };
                resetFileInput.onclick = () => {
                    fileInput.value = '';
                    accountUserImage.src = resetImage;
                };
            }
        })();
    });
})(jQuery);
