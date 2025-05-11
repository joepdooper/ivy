function previewAudio(input, preview) {
    let fileInput = document.getElementById(input);
    let audioPreview = document.getElementById(preview);
    fileInput.onchange = evt => {
        let [file] = fileInput.files
        if (file) {
            let audio = document.createElement('audio');
            audio.src = URL.createObjectURL(file);
            audio.controls = true;
            audioPreview.innerHTML = '';
            audioPreview.appendChild(audio);
        }
    }
}
