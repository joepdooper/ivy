import {CallbackHooks} from "callbackhooks";

function previewImage(input, preview, attribute) {
    let fileInput = document.getElementById(input);
    let imagePreview = document.getElementById(preview);
    fileInput.onchange = evt => {
        let [file] = fileInput.files
        if (file) {
            if (attribute === 'background') {
                imagePreview.setAttribute("style", "background-image: url(" + URL.createObjectURL(file) + ");");
                CallbackHooks.call("imageBackgroundPreview");
            } else if (attribute === 'src') {
                imagePreview.src = URL.createObjectURL(file);
                imagePreview.parentNode.style.minHeight = "initial";
                CallbackHooks.call("imageSrcPreview");
            }
        }
    }
}
