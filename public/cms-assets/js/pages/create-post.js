
(function ($){
    "use strict";
    console.log('HERE');
    const postContentHiddenField = $('#postContent');

    const postContentEditor = new Quill('#full-editor', {
        bounds: '#full-editor',
        placeholder: 'Type Something...',
        modules: {
            formula: true,
            toolbar: HamkkeJsHelpers.quillFullToolbar
        },
        theme: 'snow'
    });
    const currentPageContent = postContentHiddenField.html();
    if(currentPageContent){
        postContentEditor.setContents(
            JSON.parse(currentPageContent)
        );
    }
    $('#postCreationForm').on('submit', function (e){
        e.preventDefault();
        postContentHiddenField.html(
            JSON.stringify(postContentEditor.getContents())
        )
        e.target.submit();
    });
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
