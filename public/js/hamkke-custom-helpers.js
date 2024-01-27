/**
 * Main
 */
'use strict';
const HamkkeJsHelpers = {
    sitewideForm:  $('#site-wide-action-form'),
    submitLogoutForm() {
        return HamkkeJsHelpers.confirmationAlert(
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

    submitActionForm: (url, message, method = 'POST', alertTitle = "Are you sure?") => {
        HamkkeJsHelpers.confirmationAlert(message, alertTitle)
            .then((continueAction) => {
                if (continueAction) {
                    this.sitewideForm.attr('action', url).attr('method', method);
                    this.sitewideForm.submit();
                }
            });
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
        return keyValue === '+' || HamkkeJsHelpers.allowOnlyNum(e);
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

    /**
     *
     * @param wrapper {string} The id of the section that the loader should display in
     * @param show {boolean} Defaults to true, determines whether show or hide the loader
     * @param loading_text {string} Text to display in the loader
     */
    dataLoading: function ({wrapper = '', show = true, loading_text = "Fetching Data"}) {
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
        Object.assign(options, {maximumFractionDigits, minimumFractionDigits});
        return Number(number).toLocaleString(undefined, options)
    },

    populateFormWithData(namedData, subjectFormID) {
        for (let item in namedData) {
            if (namedData.hasOwnProperty(item)) {
                let subjectField = $(`#${subjectFormID} [name=${item}]`);
                let namedDataValue = (namedData[item] == null) ? "" : namedData[item];
                if (Array.isArray(namedDataValue)) {
                    console.log({fieldName: item, namedDataValue});
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
        HamkkeJsHelpers.populateFormWithData(details, formID);
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
                if (value && typeof payload[item] == 'string' && HamkkeJsHelpers.stringIsValidJson(value)) {
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
        console.log({FileSize});
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
        if (!HamkkeJsHelpers.validateUploadSize(uploadField, maxSize)) {
            response.correctMaxSize = false;
            Swal.fire(
                'Invalid File',
                'File size is ' + HamkkeJsHelpers.number_format(uploadField.files[0].size / 1024 / 1024, 2) + 'MB. It should not exceed ' + maxSize + 'MB',
                'error'
            );
        }
        return callback(response);
    },

    uploadAndPreviewImage(displayContainerSelector, inputFieldSelector, resetButtonSelector) {
        let displayContainer = document.querySelector(displayContainerSelector);
        const fileInput = document.querySelector(inputFieldSelector),
            resetFileInput = document.querySelector(resetButtonSelector);

        if (displayContainer) {
            const resetImage = displayContainer.src;
            fileInput.onchange = () => {
                if (fileInput.files[0]) {
                    displayContainer.src = window.URL.createObjectURL(fileInput.files[0]);
                }
            };
            resetFileInput.onclick = () => {
                fileInput.value = '';
                displayContainer.src = resetImage;
            };
        }
    },

    /**
     * Calculates the estimated reading time for a given text.
     *
     * @param {string} text - The input text to calculate reading time for.
     * @returns {string} - Formatted reading time.
     */
    readingTime(text) {
        // Constants
        const AVERAGE_WPM = 250;
        const WORD_LENGTH_DIVISOR = 5;

        // Error handling
        if (!text || typeof text !== 'string') {
            return "Invalid input";
        }

        // Remove duplicate characters and sentences
        const adjustedText = text.replace(/(.)\1+/g, '$1').replace(/([.!?])\s*\1+/g, '$1');

        // Count characters and words
        const adjustedCharCount = adjustedText.length;
        const adjustedWords = adjustedText.trim().split(/\s+/);
        const adjustedWordCount = adjustedWords.length;
        const averageWordLength = adjustedCharCount / adjustedWordCount;

        // Calculate adjusted reading time
        const adjustedTime = (adjustedCharCount / AVERAGE_WPM) * (averageWordLength / WORD_LENGTH_DIVISOR);

        // Formatted reading time
        return adjustedTime > 1 ? Math.round(adjustedTime) + " min" : "Less than 1 min";
    }
}
