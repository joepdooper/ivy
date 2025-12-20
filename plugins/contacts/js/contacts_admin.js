selectRecipientsButton.addEventListener('click', async () => {
    const contacts = await navigator.contacts.select(['name', 'email'], {multiple: true});

    if (!contacts.length) {
        // No contacts were selected in the picker.
        return;
    }

    // Use the names and e-mail addresses in |contacts| to populate the
    // recipients field in the website’s UI.
    populateRecipients(contacts);
});