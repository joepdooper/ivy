import { Location } from "../collection/momentlocation/js/location_admin";

const setInputValue = (name, value) => {
    const el = document.querySelector(`input[name="${name}"]`);
    if (el) el.value = value ?? "";
};

const autoFillFromGeolocation = async () => {
    try {
        const location = await Location.getCurrentLocation();
        setInputValue("city", location.city);
        setInputValue("country", location.country);
        setInputValue("country_code", location.countryCode);
        setInputValue("longitude", location.longitude);
        setInputValue("latitude", location.latitude);
    } catch (err) {
        console.warn("Geolocation failed or denied:", err.message);
    }
};

const handleUserLocationInput = async () => {
    const cityInputEl = document.querySelector('input[name="city"]');
    const countryInputEl = document.querySelector('input[name="country"]');

    const typedCity = cityInputEl?.value.trim();
    const typedCountry = countryInputEl?.value.trim();

    let query = null;

    if (typedCity) {
        query = typedCity;
    } else if (typedCountry) {
        query = typedCountry;
    } else {
        return;
    }

    try {
        const result = await Location.getCoordinatesFromQuery(query);

        if (typedCity) {
            setInputValue("city", typedCity); // preserve exactly what user typed
            setInputValue("country", result.country || typedCountry);
            setInputValue("country_code", result.countryCode || "");
            setInputValue("longitude", result.latitude != null ? result.longitude : "");
            setInputValue("latitude", result.latitude != null ? result.latitude : "");
        } else if (typedCountry) {
            setInputValue("country", result.country || typedCountry);
            setInputValue("country_code", result.countryCode || "");
            setInputValue("longitude", result.latitude != null ? result.longitude : "");
            setInputValue("latitude", result.latitude != null ? result.latitude : "");
        }
    } catch (err) {
        console.error("Unable to fetch coordinates:", err.message);
    }
};

const cityInput = document.querySelector('input[name="city"]');
const countryInput = document.querySelector('input[name="country"]');

cityInput?.addEventListener("blur", handleUserLocationInput);
countryInput?.addEventListener("blur", handleUserLocationInput);

const askLocationElement = document.querySelector('[data-action="enable-geolocation"]');
askLocationElement?.addEventListener("click", async (e) => {
    await autoFillFromGeolocation();
});
