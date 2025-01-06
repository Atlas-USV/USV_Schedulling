const axios = require('axios');

async function scrapeGroups() {
    try {
        // Get all semigroups from endpoint
        const response = await axios.get('YOUR_SEMIGROUPS_ENDPOINT');
        const semigroups = response.data;

        // Get unique groups by groupName
        const uniqueGroups = [...new Map(semigroups.map(item =>
            [item['groupName'], item])).values()];

        // Process each group with delay
        for (const group of uniqueGroups) {
            try {
                await new Promise(resolve => setTimeout(resolve, 200)); // 200ms delay

                const scheduleResponse = await axios.get(
                    `https://orar.usv.ro/orar/vizualizare//orar-grupe.php?mod=grupa&ID=${group.id}&json`
                );

                // Update the group ID with new data
                group.id = scheduleResponse.data.id;

            } catch (error) {
                console.error(`Error processing group ${group.groupName}:`, error.message);
            }
        }

        return uniqueGroups;

    } catch (error) {
        console.error('Error fetching semigroups:', error.message);
        throw error;
    }
}

module.exports = {
    scrapeGroups
};
