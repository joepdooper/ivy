// Pointer selection
function getSelectionText(node) {
  if (window.getSelection) {
    window.getSelection().getRangeAt(0).surroundContents(node);
  }
  else if (document.selection && document.selection.type != "Control") {
    const range = document.selection.createRange();
    range.selectNode();
    range.surroundContents(node);
  }
}

// Styling: Headings, Bold, Italic, Underline, Quotes, Lists
document.querySelectorAll('[data-edit]').forEach(btn =>
  btn.addEventListener('click', edit)
);

function edit(ev) {
  ev.preventDefault();
  const cmd_val = this.getAttribute('data-edit').split(':');
  document.execCommand(cmd_val[0], false, cmd_val[1]);
}

// Functions: links and images
const btns = document.querySelectorAll('[data-edt]');

function Space(aID) {
  return document.getElementById(aID);
}

function trigger() {
  //Buttons Commands //
  for (let b of btns) {
    b.addEventListener('click', () => {
      run(b.dataset.edt, b, b.dataset.param);
      // document.getElementById('content').focus();
    });
  }
}

// Insert Link //
function run(cmd, ele, value = null) {
  let status = document.execCommand(cmd, false, value);
  if (!status) {
    switch (cmd) {
      case 'insertLink':
      value = prompt('Enter url');
      if (value.slice(0, 4) != 'http') {
        value = 'http://' + value;
      }
      document.execCommand('createLink', false, value);
      // Overrides inherited attribute "contenteditable" from parent
      // which would otherwise prevent anchor tag from being interacted with.
      atag = document.getSelection().focusNode.parentNode;
      atag.setAttribute("contenteditable", "false");
      break;
    }
  }
}

var toolbar = document.getElementById('toolbar');
if(toolbar){
  var centertoolbar = toolbar.offsetWidth / 2;
  toolbar.style.display = 'none';
}
var hideToolbar;


function activateToolbar(e) {
  var selection = window.getSelection(),
  range = selection.getRangeAt(0),
  rect = range.getBoundingClientRect();
  if (range.startOffset != range.endOffset) {
    var centerselection = rect.width / 2;
    toolbar.style.position = 'absolute';
    toolbar.style.top = (rect.top + window.pageYOffset - 50) + 'px';
    toolbar.style.left = (rect.left - 60 + centerselection) + 'px';
    document.body.appendChild(toolbar);
    // this.parentNode.appendChild(toolbar);
    toolbar.style.display = '';
    hideToolbar = window.setTimeout(function() {
      toolbar.style.display = 'none';
    }, 4000);
  } else {
    clearTimeout(hideToolbar);
    toolbar.style.display = 'none';
  }
}

function setToolbar() {
  document.querySelectorAll('[contenteditable]').forEach(contenteditable =>
    {
      contenteditable.addEventListener('click', activateToolbar);
    }
  );
}

// Preview image from file input
function previewImage(input,preview,attribute) {
  let fileInput = document.getElementById(input);
  let imagePreview = document.getElementById(preview);
  fileInput.onchange = evt => {
    let [file] = fileInput.files
    if (file) {
      if (attribute == 'background') {
        imagePreview.setAttribute("style", "background-image: url(" + URL.createObjectURL(file) + ");");
        call_my_function("imageBackgroundPreview");
      } else if(attribute == 'src') {
        imagePreview.src = URL.createObjectURL(file);
        imagePreview.parentNode.style.minHeight = "initial";
        call_my_function("imageSrcPreview");
      }
    }
  }
}

function inputTextListener(id) {
  var inputBox = document.getElementById('content' + id);
  inputBox.addEventListener('input', function () {
    document.getElementById('input' + id).value = inputBox.innerHTML.trim();
  });
  // Paste plain text //
  inputBox.addEventListener('paste', function (e) {
    e.preventDefault();
    const text = (e.originalEvent || e).clipboardData.getData('text/plain');
    console.log(text);
    document.execCommand('insertText', false, text);
  });
}


window.addEventListener('DOMContentLoaded', (event) => {
  setToolbar();
  trigger();
});
