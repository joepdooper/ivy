// Preview image from file input
function previewImage(input, preview, attribute) {
    let fileInput = document.getElementById(input);
    let imagePreview = document.getElementById(preview);
    fileInput.onchange = evt => {
        let [file] = fileInput.files
        if (file) {
            if (attribute === 'background') {
                imagePreview.setAttribute("style", "background-image: url(" + URL.createObjectURL(file) + ");");
                call_my_function("imageBackgroundPreview");
            } else if (attribute === 'src') {
                imagePreview.src = URL.createObjectURL(file);
                imagePreview.parentNode.style.minHeight = "initial";
                call_my_function("imageSrcPreview");
            }
        }
    }
}
