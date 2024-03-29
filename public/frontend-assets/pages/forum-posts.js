(function ($){
    const startThreadBodyHidden = '#discussion-body';
    const sendReplyBodyHidden = '#reply-content';
    $(document).ready(function() {
        HamkkeQuillHelpers.initializeQuillEditor(
            startThreadBodyHidden,
            '#quill-editor',
            '#postDiscussionForm');

        if($('#threadReplyForm').length > 0) {
            HamkkeQuillHelpers.initializeQuillEditor(
                sendReplyBodyHidden,
                '#reply-content-editor',
                '#threadReplyForm',
                true);
        }
    });
})(jQuery);
