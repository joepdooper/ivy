document.addEventListener('DOMContentLoaded', function () {
  const checkbox = document.querySelector('.dark-mode-checkbox');
  checkbox.checked = localStorage.getItem('darkMode') === 'true';
  checkbox.addEventListener('change', function (event) {
    let darkMode = event.currentTarget.checked;
    axios
    .post(_SUBFOLDER + 'darkmode/toggle/', {
      darkMode: darkMode
    })
    .then(response => {
      localStorage.setItem('darkMode', darkMode);
    })
    .catch(error =>{
      console.log(error);
    });
  });
  if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches && localStorage.getItem('darkMode') === null) {
    checkbox.checked = true;
  }
});
