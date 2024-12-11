import './bootstrap';
import { ImageActions } from '@xeger/quill-image-actions';
import { ImageFormats } from '@xeger/quill-image-formats';
import htmlEditButton from "quill-html-edit-button";
import ImageUploader from "quill-image-uploader";

Quill.register("modules/imageUploader", ImageUploader);
Quill.register("modules/imageActions", ImageActions);
Quill.register("modules/imageFormats", ImageFormats);
Quill.register("modules/htmlEditButton", htmlEditButton);

const HamkkeQuillHelpers = {
    initializeQuillEditor(finalSubmissionField, editorContainerSelector, parentFormSelector, noImage = false) {
        const finalSubmissionFieldInstance = $(finalSubmissionField);
        let toolbar = HamkkeJsHelpers.getQuillToolbar(noImage);
        let imageUploader =  {
            upload: (file) => {
                return new Promise((resolve, reject) => {
                    const formData = new FormData(document.querySelector(HamkkeJsHelpers.sitewideForm));
                    formData.append('image', file);
                    fetch(
                        HamkkeJsHelpers.imageUploadEndpoint,
                        {
                            method: "POST",
                            body: formData
                        }
                    )
                        .then(response => response.json())
                        .then((result) => {
                            console.log("SUCCESS:", result);
                            resolve(result.data.url);
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                            reject("Upload failed");
                        });
                });
            }
        }
        const postContentEditor = new Quill(editorContainerSelector, {
            formats: [
                "align", "background", "blockquote", "bold", "code-block",
                "color", "float", "font", "header", "height", "italic", 'image',
                "link", "script", "strike", "size", "underline", "width"
            ],
            bounds: editorContainerSelector,
            placeholder: 'Type Something...',
            modules: {
                imageActions: {},
                imageFormats: {},
                imageUploader,
                toolbar,
                htmlEditButton: {}
            },
            theme: 'snow'
        });
        const currentPageContent = finalSubmissionFieldInstance.html();

        if (currentPageContent) {
            postContentEditor.setContents(
                JSON.parse(currentPageContent)
            );
        }
        $(parentFormSelector).on('submit', function (e) {
            e.preventDefault();
            const contentCharLength = postContentEditor.getLength();
            const maxLength = 500;
            if(!HamkkeJsHelpers.isAdminPath()) {
                if (contentCharLength <= 2) {
                    HamkkeJsHelpers.showToast(
                        'Oops!!',
                        'Please do not submit an empty reply',
                        'error'
                    );
                    return;
                }
                if (contentCharLength > maxLength) {
                    HamkkeJsHelpers.showToast(
                        'Oops!!',
                        `You have exceeded the ${maxLength} character limit by "${contentCharLength - maxLength}" characters.<br> Please review it`,
                        'error'
                    );
                    return;
                }
            }

            finalSubmissionFieldInstance.html(
                JSON.stringify(postContentEditor.getContents())
            )
            e.target.submit();
        });
    },
}

window.HamkkeQuillHelpers = HamkkeQuillHelpers;
