import { Location } from "../collection/momentlocation/js/location_admin";

const setInputValue = (name, value) => {
    const el = document.querySelector(`input[name="${name}"]`);
    if (el) el.value = value ?? "";
};

const randomFrom = arr => arr[Math.floor(Math.random() * arr.length)];

(async () => {
    try {
        const location = await Location.getCurrentLocation();

        setInputValue("city", location.city);
        setInputValue("country", location.country);
        setInputValue("country_code", location.countryCode);
        setInputValue("longitude", location.longitude);
        setInputValue("latitude", location.latitude);
    } catch (err) {
        console.error("Unable to fill location fields:", err.message);
    }
})();