(function ($){
    $('#back-button').on('click', function (e) {
        location.href = $(e.target).data('href');
    });

    $(document).on('load', function () {
        $('#comment-textarea').trigger('input');
    })

    $('#commentRegisterLink').on('click', function (e) {
        $('#register-tab').trigger('click');
    });

    $('.comment-submit-btn').on('click', function (e) {
        e.preventDefault();
        console.log('I/nnnn', $(e.target))
        let formId = $(e.target).data('form-id');
        if($(e.target).attr('id') === 'submit-comment') {
            const formToSubmit = $(HamkkeJsHelpers.sitewideForm);
            console.log({formToSubmit});
            formId = formToSubmit.attr('id');
            console.log({formId});
            const formUrl = $(e.target).data('form-action');
            console.log({formUrl});
            formToSubmit.attr('action', formUrl)
                .attr('method', 'POST');
        }
        $('#comment-textarea').clone().css('display', 'none').appendTo( "#" + formId );
        $( "#" + formId ).submit();
    });
})(jQuery)
