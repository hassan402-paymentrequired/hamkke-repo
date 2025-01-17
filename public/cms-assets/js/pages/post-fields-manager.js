(function ($) {
    "use strict";
    $(document).ready(function () {
        if (POST_TYPES && CATEGORIES) {
            const postCategoryField = $('#postCategory');
            const postTypeSelector = '#postType';
            $(document).on('change', postTypeSelector, function (e, oldCategorySelection) {
                let selectedPostType = e.target.value;
                if (!selectedPostType) {
                    postCategoryField.prop('disabled', true);
                } else {
                    let postType = POST_TYPES[parseInt(selectedPostType)];
                    let matchingCategories = HamkkeJsHelpers.objectMap(CATEGORIES, function (category) {
                        return category;
                    }, true).filter((category) => {
                        return (category.post_type_id === parseInt(selectedPostType));
                    });
                    postCategoryField.prop('disabled', false);
                    $('#postCategory').empty();
                    postCategoryField.append(`
                    <option value="">Select Post Category</option>
                `);
                    matchingCategories.forEach(function (cat) {
                        postCategoryField.append(`
                            <option value="${cat.id}" ${(oldCategorySelection && oldCategorySelection == cat.id) ? 'selected' : ''}>
                                ${postType.name}::${cat.name}
                            </option>
                        `);
                    });
                }
            });
            const oldCategorySelection = postCategoryField.data('old-selection');
            $(postTypeSelector).trigger('change', [oldCategorySelection]);
        }
    });
})(jQuery);
