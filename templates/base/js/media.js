window.addEventListener('DOMContentLoaded', (event) => {
  document.querySelectorAll('.file').forEach(function(el){
    el.addEventListener("dblclick", function() {
      document.getElementById('showFile').innerHTML = "";
      document.getElementById("loading-mode").checked = true;
      fetch(this.dataset.link)
      .then(res => res.blob())
      .then(blob => {
        console.log(blob.type);
        // console.log(blob.text());
        let objectURL = URL.createObjectURL(blob);
        let myFile;
        if(blob.type.startsWith("image")) {
          myFile = new Image();
        } else if(blob.type.startsWith("audio")) {
          myFile = new Audio();
          myFile.controls = true;
        } else if(blob.type.startsWith("video")) {
          myFile = document.createElement("video");
          myFile.controls = true;
        } else if(blob.type.startsWith("text")) {
          myFile = new Text();
        }
        myFile.src = objectURL;
        console.log(myFile);
        document.getElementById('showFile').appendChild(myFile);
        document.getElementById("show-file").checked = true;
        document.getElementById("loading-mode").checked = false;
      });
      // window.location.href = this.dataset.link;
    });
  });
  document.querySelectorAll('[for=show-file]').forEach(function(el){
    el.addEventListener("click", function() {
      if (document.getElementById("show-file").checked == true){
        document.getElementById('showFile').innerHTML = "";
      }
    });
  });
});
