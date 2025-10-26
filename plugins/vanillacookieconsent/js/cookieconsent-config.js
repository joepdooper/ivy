import '../node_modules/vanilla-cookieconsent/dist/cookieconsent.esm.js';

/**
 * All config. options available here:
 * https://cookieconsent.orestbida.com/reference/configuration-reference.html
 */
CookieConsent.run({

    categories: {
        necessary: {
            enabled: true,  // this category is enabled by default
            readOnly: true  // this category cannot be disabled
        },
        analytics: {}
    },

    guiOptions: {
        consentModal: {
            layout: 'box wide',
            position: 'bottom center'
        }
    },

    language: {
        default: 'en',
        translations: {
            'en': _SUBFOLDER + 'plugins/vanillacookieconsent/json/en.json'
        }
    }

});
