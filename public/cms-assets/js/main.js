/**
 * Main
 */
'use strict';
const HamkkeJsHelpers = {
    submitLogoutForm() {
        return this.confirmationAlert(
            'You will be required to login to perfome any actions after',
            'Are you sure'
        ).then(completeAction => {
            if (completeAction) {
                $('#logoutForm').submit();
            }
        });
    },

    /**
     *
     * @param editorInstance
     * @param postContent
     */
    insertManualHTML(editorInstance, postContent) {

        const temporaryElement = document.createElement('div');
        const quillInstance = new Quill(temporaryElement);
        //Set the quill delta in the newly created div.( This converts to HTML )
        const delta = quillInstance.clipboard.convert(postContent);
        console.log({delta});
        const htmlContent = temporaryElement.getElementsByClassName("ql-editor")[0].innerHTML;
        editorInstance.setContents(delta);
    },

    convertQuillDeltaToHTML(postContentContainer, postContent) {
        const temporaryElement = document.createElement('div');
        const quillInstance = new Quill(temporaryElement);
        //Set the quill delta in the newly created div.( This converts to HTML )
        quillInstance.setContents(
            JSON.parse(postContent)
        )
        const htmlContent = temporaryElement.getElementsByClassName("ql-editor")[0].innerHTML;
        $(postContentContainer).html(htmlContent)
    },

    confirmationAlert(text, title = "Are you sure?", icon = 'question') {
        return Swal.fire({
            title,
            text,
            icon,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            customClass: {
              confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
              cancelButton: 'btn btn-label-secondary waves-effect waves-light'
            },
            buttonsStyling: false
        })
            .then((confirmed) => confirmed.value);
    },

    changeRequestInitiationPrompt: () => {
        return Swal.fire({
            title: "Are you sure?",
            html: `
                <strong>A change request would be created for this action, please upload any supporting documents if any and specify the reason below</strong>
                <br><br>
                <p >Upload supporting document</p>
                <input style="display: initial" type="file" name="supporting_documents" multiple id="cr_supporting_documents" />
            `,
            input: 'textarea',
            inputAttributes: {
                'required': true,
                'placeholder': "Please state the reason for this change",
                'autofocus': true,
                'style': "line-height: initial; color:#475570"
            },
            icon: "question",
            showCancelButton: true,
            confirmButtonText: 'Proceed',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        });
    },

    submitActionForm: (url, message, confirmFirst = false, method = 'POST', alertTitle = "Are you sure?") => {
        const formRef = $('#sitewide-action-form');
        if (confirmFirst) {
            BaseHelper.confirmationAlert(message, alertTitle)
                .then((continueAction) => {
                    console.log(continueAction);
                    if (continueAction) {
                        formRef.attr('action', url).attr('method', method);
                        formRef.submit();
                    }
                });
        } else {
            formRef.attr('action', url).attr('method', method);
            formRef.submit();
        }
    },

    autocompleteHelper: (inputId, sourceUrl = null, selectFunction, responseFunction = null) => {
        const target = $(`#${inputId}`);
        const url = sourceUrl || target.data('source-url');
        target.autocomplete({
            source: url,
            minLength: 2,
            response: responseFunction,
            select: function (event, ui) {
                if (selectFunction) {
                    selectFunction(event, ui);
                }
                return false;
            }
        });
    },

    allowOnlyNum(e) {
        const keyCode = e.which || e.keyCode;
        return (keyCode >= 48 && keyCode <= 57) || [8, 37, 39].includes(keyCode);
    },

    allowOnlyPhoneCharacters(e) {
        const keyValue = e.key;
        return keyValue === '+' || this.allowOnlyNum(e);
    },

    phoneNumberCheck(value, element, params) {
        const regex = RegExp('(^0[0-9]{10}$|^\\+234[1-9][0-9]{9}$)');
        return regex.test(value);
    },

    internationalPhoneNumberCheck(value, element, params) {
        // ^[\s()+-]*([0-9][\s()+-]*){6,20}$
        const regex = RegExp('(^[\s+]([0-9]){6,20}$)');
        return regex.test(value);
    },

    setAttributes(element, attributes) {
        for (let key in attributes) {
            element.setAttribute(key, attributes[key]);
        }
    },

    dataTableInit(elementSelector, customOptions = null) {
        const tableOptions = {
            // responsive: !0,
            autoWidth: !1,
            pageLength: 10,
            paging: true,
            language: {
                searchPlaceholder: "Search",
                search: "",
            },
            destroy: true,
        };
        if (customOptions) {
            Object.assign(tableOptions, customOptions);
        }
        $(elementSelector).DataTable(tableOptions)
    },

    printContent(selector) {
        const bodyEl = $('body');
        const initialContent = bodyEl.html();
        const printContent = $(selector).clone();
        bodyEl.empty().html(printContent);
        window.print();
        bodyEl.html(initialContent);
    },

    printTag(selector) {
        const tagName = $(selector).prop("tagName").toLowerCase();
        let attributes = "";
        const attrs = document.querySelector(selector).attributes;
        $.each(attrs, function (i, elem) {
            attributes += " " + elem.name + " ='" + elem.value + "' ";
        });
        const divToPrint = $(selector).html();
        const head = "<html lang='en'><head>" + $("head").html() + "</head>";
        const allContent = head + "<body onload='window.print()' >" + "<" + tagName + attributes + ">" + divToPrint + "</" + tagName + ">" + "</body></html>";
        const newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write(allContent);
        newWin.document.close();
        newWin.onafterprint = function () {
            newWin.close();
        };
        // setTimeout(function(){},10);
    },

    verifyApplicant(wrapperEL, formID, proceedButtonAction) {
        const _this = this;
        const country = $('#applicant-country').val();
        const phone = $('#applicant-phone').val();
        const redirect_route = $('#redirect_route').val();
        const service_id = $('#service').val();
        _this.dataLoading({ wrapper: wrapperEL, show: true, loading_text: 'Verifying applicant' });
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: '/verify-applicant',
            data: {
                country,
                phone,
                redirect_route,
                service_id
            },
            success: function (result) {
                console.log(result);
                const { status, message, data } = result;
                if (status) {
                    let formData = {
                        address: null,
                        email: null,
                        firstname: null,
                        lastname: null,
                        redirect_route: redirect_route,
                        applicant_id: null
                    };
                    if (data.exists) {
                        const applicant = data.applicant;
                        formData = {
                            address: applicant.address,
                            // country: applicant.country || country,
                            email: applicant.email,
                            firstname: applicant.firstname,
                            lastname: applicant.lastname,
                            // phone: applicant.phone,
                            redirect_route: redirect_route,
                            service: service_id,
                            applicant_id: applicant.id
                        };

                    }
                    _this.populateFormWithData(formData, formID);
                }
                _this.dataLoading({ wrapper: wrapperEL, show: false });
                $('#applicantDetails').removeClass('hidden');
                proceedButtonAction(result);
            },
            error: function (requestError, statusText) {
                const jsonResponse = requestError.responseJSON;
                proceedButtonAction(jsonResponse)
            }
        });
    },

    /**
     *
     * @param wrapper {string} The id of the section that the loader should display in
     * @param show {boolean} Defaults to true, determines whether show or hide the loader
     * @param loading_text {string} Text to display in the loader
     */
    dataLoading: function ({ wrapper = '', show = true, loading_text = "Fetching Data" }) {
        if (show) {
            const loader = document.querySelector('#preloader-template').content.cloneNode(true);
            $(loader).find('#loading-message')[0].textContent = loading_text;
            $(wrapper).append(loader).css('position', 'relative');
        } else {
            $(wrapper + ' > .preloader').remove();
        }
    },

    /**
     *
     * @param element The ID of the form
     * @returns object : Key-value pair of the form data
     */
    formToArray: function (element) {
        let formData = $("#" + element).serializeArray();
        let dataArray = {};
        for (let i in formData) {
            dataArray[formData[i].name.trim()] = formData[i].value.trim();
        }
        return dataArray;
    },

    disableEmptyFormFieldsThenSubmit(formSelector) {
        const subjectForm = $(formSelector);
        const fields = subjectForm.find('input, select');
        $.each(fields, (index, field) => {
            $(field).prop('disabled', !$(field).val());
        });
        subjectForm.submit();
    },

    number_format: (number, maximumFractionDigits = 2, minimumFractionDigits = 2, moreOptions = {}) => {
        if (minimumFractionDigits > maximumFractionDigits) {
            minimumFractionDigits = maximumFractionDigits;
        }
        const options = moreOptions;
        Object.assign(options, { maximumFractionDigits, minimumFractionDigits });
        return Number(number).toLocaleString(undefined, options)
    },

    populateFormWithData(namedData, subjectFormID) {
        for (let item in namedData) {
            if (namedData.hasOwnProperty(item)) {
                let subjectField = $(`#${subjectFormID} [name=${item}]`);
                let namedDataValue = (namedData[item] == null) ? "" : namedData[item];
                if (Array.isArray(namedDataValue)) {
                    console.log({ fieldName: item, namedDataValue });
                    subjectField = $(`#${subjectFormID} [name="${item}[]"]`);
                    subjectField.val(namedDataValue).trigger('change');
                } else if (subjectField.is('input[type=checkbox]')) {
                    const isChecked = ['on', true].includes(namedDataValue);
                    if (isChecked) {
                        subjectField.trigger('click');
                    }
                    subjectField.prop('checked', isChecked);
                } else {
                    subjectField.val(`${namedDataValue}`);

                    if (subjectField.is('select.form-select')) {
                        subjectField.trigger('change');
                    }
                }
            }
        }
    },

    openCreationOrUpdateModal(details, modalID, formID) {
        BaseHelper.populateFormWithData(details, formID);
        if (details.update_route) {
            $('#' + formID).attr('action', details.update_route);
        }
        $('#' + modalID).modal('show');
    },

    renderPayloadToTableInModal(modalID, tableBodyID, payload) {
        const tableBodySelector = '#' + tableBodyID;
        $(tableBodySelector).empty();
        let sn = 1;
        const renderObjValueAsString = (value) => {
            if (typeof value == 'object') {
                let result = '';
                let n = 1;
                for (let i in value) {
                    const render = (typeof value[i] == 'object') ? JSON.stringify(value[i], undefined, 4) : value[i];
                    result += `${i} => ${render}`;
                    if (n !== Object.keys(value).length) {
                        result += '<hr style="margin-top: 0.3em; margin-bottom: 0.3em;">';
                    }
                    n += 1;
                }
                value = result;
            }
            return value;
        };
        for (let item in payload) {
            if (payload.hasOwnProperty(item)) {
                let value = payload[item];
                if (value && typeof payload[item] == 'string' && this.stringIsValidJson(value)) {
                    try {
                        value = JSON.parse(value);
                        if (typeof value == 'object') {
                            payload[item] = value
                        }
                    } catch (err) {
                        console.warn('Error Parsing [' + item + ']', err.message)
                    }
                }
                value = renderObjValueAsString(value);
                $(tableBodySelector).append(`
                    <tr>
                        <td>${sn}</td>
                        <td>${item}</td>
                        <td>${value}</td>
                    </tr>
                `);
                sn += 1;
            }
        }
        $(tableBodySelector).append(`
            <tr><td colspan="3">Entry As JSON</td></tr>
            <tr>
                <td colspan="3">
                    <pre style="width: 100%; height: 500px; background-color: #fffaf0">${JSON.stringify(payload, undefined, 4)}</pre>
                </td>
            </tr>
        `);
        $('#' + modalID).modal('show');
    },

    stringIsValidJson(subjectString) {
        return (/^[\],:{}\s]*$/.test(
            subjectString.replace(/\\["\\\/bfnrtu]/g, '@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').replace(/(?:^|:|,)(?:\s*\[)+/g, ''))
        );
    },

    strPluralize(count, noun, suffix = 's') {
        return `${count} ${noun}${count !== 1 ? suffix : ''}`;
    },

    timeDiffInHrsAndMinutesOrSecs(startTime, endTime) {
        const diffInMinutes = moment(endTime).diff(moment(startTime), 'seconds');

        const dy = Math.floor(diffInMinutes / (3600 * 24));
        const hr = Math.floor(diffInMinutes % (3600 * 24) / 3600);
        const mi = Math.floor(diffInMinutes % 3600 / 60);
        const se = Math.floor(diffInMinutes % 60);

        const dyPluralize = dy > 0 ? dy + (dy == 1 ? " day, " : " days, ") : "";
        const hrPluralize = hr > 0 ? hr + (hr == 1 ? " hour, " : " hours, ") : "";
        const miPluralize = mi > 0 ? mi + (mi == 1 ? " minute, " : " minutes, ") : "";
        const sePluralize = se > 0 ? se + (se == 1 ? " second" : " seconds") : "";
        return dyPluralize + hrPluralize + miPluralize + sePluralize;
    },

    removeItemFromArray(array, itemToRemove) {
        const itemIndex = array.indexOf(itemToRemove);
        if (itemIndex > -1) {
            array.splice(itemIndex, 1);
        }
    },

    setSelect2WithPlaceholder(el) {
        const placeholder = $(el).data('placeholder') || "Select an option";
        $(el).select2({
            placeholder,
            allowClear: true
        });
    },

    validateUploadSize(file, max_size) {
        const FileSize = file.files[0].size / 1024 / 1024; // in MB
        console.log({ FileSize });
        return (FileSize <= max_size);
    },

    fileUploadCheck(uploadField, {
        allowedTypes = ['image/jpg', 'image/jpeg'],
        allowedTypesShortName = ['jpg', 'jpeg'],
        maxSize = 2
    }, callback) {
        let response = {
            correctFileType: true,
            correctMaxSize: true
        };
        let thisFileType = uploadField.files[0].type;
        if (allowedTypes.indexOf(thisFileType) === -1) {
            response.correctFileType = false;
            Swal.fire(
                'Invalid File',
                `Only ${allowedTypesShortName} files are allowed`,
                'error'
            );
        }
        if (!this.validateUploadSize(uploadField, maxSize)) {
            response.correctMaxSize = false;
            Swal.fire(
                'Invalid File',
                'File size is ' + this.number_format(uploadField.files[0].size / 1024 / 1024, 2) + 'MB. It should not exceed ' + maxSize + 'MB',
                'error'
            );
        }
        return callback(response);
    }
};

let isRtl = window.Helpers.isRtl(),
    isDarkStyle = window.Helpers.isDarkStyle(),
    menu,
    animate,
    isHorizontalLayout = false;

if (document.getElementById('layout-menu')) {
    isHorizontalLayout = document.getElementById('layout-menu').classList.contains('menu-horizontal');
}

(function () {
    setTimeout(function () {
        window.Helpers.initCustomOptionCheck();
    }, 1000);

    if (typeof Waves !== 'undefined') {
        Waves.init();
        Waves.attach(".btn[class*='btn-']:not([class*='btn-outline-']):not([class*='btn-label-'])", ['waves-light']);
        Waves.attach("[class*='btn-outline-']");
        Waves.attach("[class*='btn-label-']");
        Waves.attach('.pagination .page-item .page-link');
    }

    // Initialize menu
    //-----------------

    let layoutMenuEl = document.querySelectorAll('#layout-menu');
    layoutMenuEl.forEach(function (element) {
        menu = new Menu(element, {
            orientation: isHorizontalLayout ? 'horizontal' : 'vertical',
            closeChildren: isHorizontalLayout ? true : false,
            // ? This option only works with Horizontal menu
            showDropdownOnHover: localStorage.getItem('templateCustomizer-' + templateName + '--ShowDropdownOnHover') // If value(showDropdownOnHover) is set in local storage
                ? localStorage.getItem('templateCustomizer-' + templateName + '--ShowDropdownOnHover') === 'true' // Use the local storage value
                : window.templateCustomizer !== undefined // If value is set in config.js
                    ? window.templateCustomizer.settings.defaultShowDropdownOnHover // Use the config.js value
                    : true // Use this if you are not using the config.js and want to set value directly from here
        });
        // Change parameter to true if you want scroll animation
        window.Helpers.scrollToActive((animate = false));
        window.Helpers.mainMenu = menu;
    });

    // Initialize menu togglers and bind click on each
    let menuToggler = document.querySelectorAll('.layout-menu-toggle');
    menuToggler.forEach(item => {
        item.addEventListener('click', event => {
            event.preventDefault();
            window.Helpers.toggleCollapsed();
            // Enable menu state with local storage support if enableMenuLocalStorage = true from config.js
            if (config.enableMenuLocalStorage && !window.Helpers.isSmallScreen()) {
                try {
                    localStorage.setItem(
                        'templateCustomizer-' + templateName + '--LayoutCollapsed',
                        String(window.Helpers.isCollapsed())
                    );
                    // Update customizer checkbox state on click of menu toggler
                    let layoutCollapsedCustomizerOptions = document.querySelector('.template-customizer-layouts-options');
                    if (layoutCollapsedCustomizerOptions) {
                        let layoutCollapsedVal = window.Helpers.isCollapsed() ? 'collapsed' : 'expanded';
                        layoutCollapsedCustomizerOptions.querySelector(`input[value="${layoutCollapsedVal}"]`).click();
                    }
                } catch (e) {
                }
            }
        });
    });

    // Menu swipe gesture

    // Detect swipe gesture on the target element and call swipe In
    window.Helpers.swipeIn('.drag-target', function (e) {
        window.Helpers.setCollapsed(false);
    });

    // Detect swipe gesture on the target element and call swipe Out
    window.Helpers.swipeOut('#layout-menu', function (e) {
        if (window.Helpers.isSmallScreen()) window.Helpers.setCollapsed(true);
    });

    // Display in main menu when menu scrolls
    let menuInnerContainer = document.getElementsByClassName('menu-inner'),
        menuInnerShadow = document.getElementsByClassName('menu-inner-shadow')[0];
    if (menuInnerContainer.length > 0 && menuInnerShadow) {
        menuInnerContainer[0].addEventListener('ps-scroll-y', function () {
            if (this.querySelector('.ps__thumb-y').offsetTop) {
                menuInnerShadow.style.display = 'block';
            } else {
                menuInnerShadow.style.display = 'none';
            }
        });
    }

    // Update light/dark image based on current style
    function switchImage(style) {
        if (style === 'system') {
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                style = 'dark';
            } else {
                style = 'light';
            }
        }
        const switchImagesList = [].slice.call(document.querySelectorAll('[data-app-' + style + '-img]'));
        switchImagesList.map(function (imageEl) {
            const setImage = imageEl.getAttribute('data-app-' + style + '-img');
            imageEl.src = assetsPath + 'img/' + setImage; // Using window.assetsPath to get the exact relative path
        });
    }

    //Style Switcher (Light/Dark/System Mode)
    let styleSwitcher = document.querySelector('.dropdown-style-switcher');

    // Get style from local storage or use 'system' as default
    let storedStyle =
        localStorage.getItem('templateCustomizer-' + templateName + '--Style') || //if no template style then use Customizer style
        (window.templateCustomizer?.settings?.defaultStyle ?? 'light'); //!if there is no Customizer then use default style as light

    // Set style on click of style switcher item if template customizer is enabled
    if (window.templateCustomizer && styleSwitcher) {
        let styleSwitcherItems = [].slice.call(styleSwitcher.children[1].querySelectorAll('.dropdown-item'));
        styleSwitcherItems.forEach(function (item) {
            item.addEventListener('click', function () {
                let currentStyle = this.getAttribute('data-theme');
                if (currentStyle === 'light') {
                    window.templateCustomizer.setStyle('light');
                } else if (currentStyle === 'dark') {
                    window.templateCustomizer.setStyle('dark');
                } else {
                    window.templateCustomizer.setStyle('system');
                }
            });
        });

        // Update style switcher icon based on the stored style

        const styleSwitcherIcon = styleSwitcher.querySelector('i');

        if (storedStyle === 'light') {
            styleSwitcherIcon.classList.add('ti-sun');
            new bootstrap.Tooltip(styleSwitcherIcon, {
                title: 'Light Mode',
                fallbackPlacements: ['bottom']
            });
        } else if (storedStyle === 'dark') {
            styleSwitcherIcon.classList.add('ti-moon');
            new bootstrap.Tooltip(styleSwitcherIcon, {
                title: 'Dark Mode',
                fallbackPlacements: ['bottom']
            });
        } else {
            styleSwitcherIcon.classList.add('ti-device-desktop');
            new bootstrap.Tooltip(styleSwitcherIcon, {
                title: 'System Mode',
                fallbackPlacements: ['bottom']
            });
        }
    }

    // Run switchImage function based on the stored style
    switchImage(storedStyle);

    // Notification
    // ------------
    const notificationMarkAsReadAll = document.querySelector('.dropdown-notifications-all');
    const notificationMarkAsReadList = document.querySelectorAll('.dropdown-notifications-read');

    // Notification: Mark as all as read
    if (notificationMarkAsReadAll) {
        notificationMarkAsReadAll.addEventListener('click', event => {
            notificationMarkAsReadList.forEach(item => {
                item.closest('.dropdown-notifications-item').classList.add('marked-as-read');
            });
        });
    }
    // Notification: Mark as read/unread onclick of dot
    if (notificationMarkAsReadList) {
        notificationMarkAsReadList.forEach(item => {
            item.addEventListener('click', event => {
                item.closest('.dropdown-notifications-item').classList.toggle('marked-as-read');
            });
        });
    }

    // Notification: Mark as read/unread onclick of dot
    const notificationArchiveMessageList = document.querySelectorAll('.dropdown-notifications-archive');
    notificationArchiveMessageList.forEach(item => {
        item.addEventListener('click', event => {
            item.closest('.dropdown-notifications-item').remove();
        });
    });

    // Init helpers & misc
    // --------------------

    // Init BS Tooltip
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Accordion active class
    const accordionActiveFunction = function (e) {
        if (e.type == 'show.bs.collapse' || e.type == 'show.bs.collapse') {
            e.target.closest('.accordion-item').classList.add('active');
        } else {
            e.target.closest('.accordion-item').classList.remove('active');
        }
    };

    const accordionTriggerList = [].slice.call(document.querySelectorAll('.accordion'));
    const accordionList = accordionTriggerList.map(function (accordionTriggerEl) {
        accordionTriggerEl.addEventListener('show.bs.collapse', accordionActiveFunction);
        accordionTriggerEl.addEventListener('hide.bs.collapse', accordionActiveFunction);
    });

    // If layout is RTL add .dropdown-menu-end class to .dropdown-menu
    // if (isRtl) {
    //   Helpers._addClass('dropdown-menu-end', document.querySelectorAll('#layout-navbar .dropdown-menu'));
    // }

    // Auto update layout based on screen size
    window.Helpers.setAutoUpdate(true);

    // Toggle Password Visibility
    window.Helpers.initPasswordToggle();

    // Speech To Text
    window.Helpers.initSpeechToText();

    // Init PerfectScrollbar in Navbar Dropdown (i.e notification)
    window.Helpers.initNavbarDropdownScrollbar();

    let horizontalMenuTemplate = document.querySelector("[data-template^='horizontal-menu']");
    if (horizontalMenuTemplate) {
        // if screen size is small then set navbar fixed
        if (window.innerWidth < window.Helpers.LAYOUT_BREAKPOINT) {
            window.Helpers.setNavbarFixed('fixed');
        } else {
            window.Helpers.setNavbarFixed('');
        }
    }

    // On window resize listener
    // -------------------------
    window.addEventListener(
        'resize',
        function (event) {
            // Hide open search input and set value blank
            if (window.innerWidth >= window.Helpers.LAYOUT_BREAKPOINT) {
                if (document.querySelector('.search-input-wrapper')) {
                    document.querySelector('.search-input-wrapper').classList.add('d-none');
                    document.querySelector('.search-input').value = '';
                }
            }
            // Horizontal Layout : Update menu based on window size
            if (horizontalMenuTemplate) {
                // if screen size is small then set navbar fixed
                if (window.innerWidth < window.Helpers.LAYOUT_BREAKPOINT) {
                    window.Helpers.setNavbarFixed('fixed');
                } else {
                    window.Helpers.setNavbarFixed('');
                }
                setTimeout(function () {
                    if (window.innerWidth < window.Helpers.LAYOUT_BREAKPOINT) {
                        if (document.getElementById('layout-menu')) {
                            if (document.getElementById('layout-menu').classList.contains('menu-horizontal')) {
                                menu.switchMenu('vertical');
                            }
                        }
                    } else {
                        if (document.getElementById('layout-menu')) {
                            if (document.getElementById('layout-menu').classList.contains('menu-vertical')) {
                                menu.switchMenu('horizontal');
                            }
                        }
                    }
                }, 100);
            }
        },
        true
    );

    // Manage menu expanded/collapsed with templateCustomizer & local storage
    //------------------------------------------------------------------

    // If current layout is horizontal OR current window screen is small (overlay menu) than return from here
    if (isHorizontalLayout || window.Helpers.isSmallScreen()) {
        return;
    }

    // If current layout is vertical and current window screen is > small

    // Auto update menu collapsed/expanded based on the themeConfig
    if (typeof TemplateCustomizer !== 'undefined') {
        if (window.templateCustomizer.settings.defaultMenuCollapsed) {
            window.Helpers.setCollapsed(true, false);
        } else {
            window.Helpers.setCollapsed(false, false);
        }
    }

    // Manage menu expanded/collapsed state with local storage support If enableMenuLocalStorage = true in config.js
    if (typeof config !== 'undefined') {
        if (config.enableMenuLocalStorage) {
            try {
                if (localStorage.getItem('templateCustomizer-' + templateName + '--LayoutCollapsed') !== null)
                    window.Helpers.setCollapsed(
                        localStorage.getItem('templateCustomizer-' + templateName + '--LayoutCollapsed') === 'true',
                        false
                    );
            } catch (e) {
            }
        }
    }
})();
