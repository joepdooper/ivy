document.addEventListener('ts-req-after', e => {
    const parser = new DOMParser();
    const doc = parser.parseFromString(e.detail.response, 'text/html');
    const flash = doc.querySelector('#flashes');
    if (flash) document.querySelector('#flashes').innerHTML = flash.innerHTML;
});
