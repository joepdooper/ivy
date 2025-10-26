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
}