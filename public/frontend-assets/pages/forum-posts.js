(function ($){
    const startThreadBodyHidden = '#discussion-body';
    const sendReplyBodyHidden = '#reply-content';
    $(document).ready(function() {
        HamkkeJsHelpers.initializeQuillEditor(
            startThreadBodyHidden,
            '#quill-editor',
            '#postDiscussionForm');

        if($('#threadReplyForm').length > 0) {
            HamkkeJsHelpers.initializeQuillEditor(
                sendReplyBodyHidden,
                '#reply-content-editor',
                '#threadReplyForm');
        }
    });
})(jQuery);
