export class Location {
    static async getCurrentLocation(options = {}) {
        try {
            const position = await new Promise((resolve, reject) => {
                if (!navigator.geolocation) {
                    reject(new Error("Geolocation is not supported by your browser."));
                    return;
                }

                navigator.geolocation.getCurrentPosition(resolve, reject, options);
            });

            const { latitude, longitude } = position.coords;

            const response = await fetch(
                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&zoom=10&addressdetails=1`
            );

            if (!response.ok) {
                throw new Error("Failed to fetch location details.");
            }

            const data = await response.json();
            const address = data.address || {};

            return {
                latitude,
                longitude,
                city:
                    address.city ||
                    address.town ||
                    address.village ||
                    address.hamlet ||
                    address.municipality ||
                    address.county ||
                    null,
                country: address.country || null,
                countryCode: address.country_code ? address.country_code.toUpperCase() : null,
            };
        } catch (error) {
            console.error("Error getting location:", error);
            throw error;
        }
    }

    static async getCoordinatesFromQuery(query) {
        if (!query) throw new Error("No location query provided.");

        const url = `https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&q=${encodeURIComponent(query)}&limit=1`;

        const response = await fetch(url);
        if (!response.ok) throw new Error("Failed to fetch coordinates.");

        const results = await response.json();
        if (results.length === 0) throw new Error("No results found for the given location.");

        const place = results[0];
        const address = place.address || {};

        return {
            latitude: parseFloat(place.lat),
            longitude: parseFloat(place.lon),
            country: address.country || null,
            countryCode: address.country_code ? address.country_code.toUpperCase() : null,
            city:
                address.city ||
                address.town ||
                address.village ||
                address.hamlet ||
                address.municipality ||
                address.county ||
                null,
        };
    }
}