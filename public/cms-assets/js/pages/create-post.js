function deletePost(url) {
    HamkkeJsHelpers.submitActionForm(url, 'This post will not longer be accessible', 'POST', 'Are you sure?');
}
(function ($){
    "use strict";
    console.log('Here 123');

    HamkkeQuillHelpers.initializeQuillEditor(
        '#postContent',
        '#full-editor',
        '#postCreationForm'
    );

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
