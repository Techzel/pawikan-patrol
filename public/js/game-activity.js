/**
 * Game Activity Helper
 * Handles recording and managing game activities for Pawikan Patrol
 */

class GameActivity {
    constructor() {
        this.baseURL = '/game-activities';
        console.log('🎯 GameActivity initialized!');
        console.log('   Base URL:', this.baseURL);
    }

    /**
     * Record a new game activity
     */
    async recordActivity(activityData) {
        // Always get fresh CSRF token from the DOM
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        console.log('🎮 recordActivity called with:', activityData);
        console.log('📍 Base URL:', this.baseURL);
        console.log('🔑 CSRF Token:', csrfToken);

        try {
            const url = this.baseURL + '/record';
            console.log('📡 Making POST request to:', url);

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(activityData),
                keepalive: true
            });

            console.log('📥 Response status:', response.status);
            console.log('📥 Response ok:', response.ok);

            if (!response.ok) {
                const errorText = await response.text();
                console.error('❌ Response not OK:', errorText);
                throw new Error('Failed to record activity: ' + response.status);
            }

            const result = await response.json();
            console.log('✅ Success! Result:', result);
            return result;
        } catch (error) {
            console.error('❌ Error recording game activity:', error);
            console.error('❌ Error stack:', error.stack);
            return null;
        }
    }

    /**
     * Helper method to record Memory Match completion
     */
    async recordMemoryMatch(moves, timeSpent, difficulty = 'medium') {
        return await this.recordActivity({
            game_type: 'memory-match',
            time_spent: timeSpent,
            moves: moves,
            difficulty: difficulty
        });
    }

    /**
     * Helper method to record Puzzle completion
     */
    async recordPuzzle(moves, timeSpent, difficulty) {
        return await this.recordActivity({
            game_type: 'puzzle',
            time_spent: timeSpent,
            moves: moves,
            difficulty: difficulty
        });
    }

    /**
     * Helper method to record Find the Pawikan completion
     */
    async recordFindThePawikan(timeSpent, difficulty = 'easy') {
        return await this.recordActivity({
            game_type: 'find-the-pawikan',
            time_spent: timeSpent,
            difficulty: difficulty
        });
    }
}

// Initialize global game activity instance
window.gameActivity = new GameActivity();

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = GameActivity;
}
