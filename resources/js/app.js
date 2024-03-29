import './bootstrap';
import ImageUploader from "quill-image-uploader";
import { ImageActions } from 'https://cdn.jsdelivr.net/npm/@xeger/quill-image-actions/lib/index.js';
import { ImageFormats } from "https://cdn.jsdelivr.net/npm/@xeger/quill-image-formats/lib/index.js";
import htmlEditButton from "quill-html-edit-button";

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
                    const formData = new FormData(document.querySelector(this.sitewideForm));
                    formData.append('image', file);
                    console.log({formData});
                    fetch(
                        this.imageUploadEndpoint,
                        {
                            method: "POST",
                            body: formData
                        }
                    )
                        .then(response => response.json())
                        .then((result) => {
                            console.log(result);
                            resolve(result.data.url);
                        })
                        .catch((error) => {
                            reject("Upload failed");
                            console.error("Error:", error);
                        });
                });
            }
        }
        const postContentEditor = new Quill(editorContainerSelector, {
            formats: [
                "align", "background", "blockquote", "bold", "code-block",
                "color", "float", "font", "header", "height", "image", "italic",
                "link", "script", "strike", "size", "underline", "width"
            ],
            bounds: editorContainerSelector,
            placeholder: 'Type Something...',
            modules: {
                imageActions: {},
                imageFormats: {},
                toolbar,
                imageUploader,
                htmlEditButton: {}
            },
            theme: 'snow'
        });
        const currentPageContent = finalSubmissionFieldInstance.html();
        console.log({currentPageContent})
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
                    HamkkeJsHelpers.showFrontendAlert(
                        'Please do not submit an empty reply',
                        'danger'
                    );
                    return;
                }
                if (contentCharLength > maxLength) {
                    HamkkeJsHelpers.showFrontendAlert(
                        `You have exceeded the ${maxLength} character limit by "${contentCharLength - maxLength}" characters.<br> Please review it`,
                        'danger'
                    );
                    return;
                }
            }

            console.log({finalSubmission: postContentEditor.getContents()})
            finalSubmissionFieldInstance.html(
                JSON.stringify(postContentEditor.getContents())
            )
            e.target.submit();
        });
    },
}

window.HamkkeQuillHelpers = HamkkeQuillHelpers;
console.log({quillBaseToolbar : HamkkeJsHelpers.quillBaseToolbar});
