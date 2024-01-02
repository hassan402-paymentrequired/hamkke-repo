
(function ($) {
    "use strict";
    const postContentHiddenField = $('#postContent');
    const fullToolbar = [
        [
            {
                font: []
            },
            {
                size: []
            }
        ],
        ['bold', 'italic', 'underline', 'strike'],
        [
            {
                color: []
            },
            {
                background: []
            }
        ],
        [
            {
                script: 'super'
            },
            {
                script: 'sub'
            }
        ],
        [
            {
                header: '1'
            },
            {
                header: '2'
            },
            'blockquote',
            'code-block'
        ],
        [
            {
                list: 'ordered'
            },
            {
                list: 'bullet'
            },
            {
                indent: '-1'
            },
            {
                indent: '+1'
            }
        ],
        [{ direction: 'rtl' }],
        ['link', 'image', 'video', 'formula'],
        ['clean']
    ];
    const postContentEditor = new Quill('#full-editor', {
        bounds: '#full-editor',
        placeholder: 'Type Something...',
        modules: {
            formula: true,
            toolbar: fullToolbar
        },
        theme: 'snow'
    });
    const currentPageContent = postContentHiddenField.html();
    if (currentPageContent) {
        postContentEditor.setContents(
            JSON.parse(currentPageContent)
        );
    }
    $('#postUpdateForm').on('submit', function (e) {
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
