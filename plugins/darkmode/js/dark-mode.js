document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.querySelector('.theme-controller');
    checkbox.checked = localStorage.getItem('darkMode') === 'true';
    checkbox.addEventListener('change', function (event) {
        let darkMode = event.currentTarget.checked;
        axios
            .post('/' + _SUBFOLDER + 'darkmode/toggle/', {
                darkMode: darkMode
            })
            .then(response => {
                localStorage.setItem('darkMode', darkMode);
            })
            .catch(error => {
                console.log(error);
            });
    });
});
