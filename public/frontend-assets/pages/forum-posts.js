(function ($) {
    "use strict";
    console.log('HERE');
    const postContentHiddenField = $('#discussion-body');
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
        [{direction: 'rtl'}],
        ['link', 'image'],
        ['clean']
    ];
    $(document).ready(function() {
        console.log($('#quill-editor'));
        const postContentEditor = new Quill('#quill-editor', {
            bounds: '#quill-editor',
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
        $('#postDiscussionForm').on('submit', function (e) {
            e.preventDefault();
            postContentHiddenField.html(
                JSON.stringify(postContentEditor.getContents())
            )
            e.target.submit();
        });
    });
})(jQuery);
