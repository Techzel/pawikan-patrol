/**
 * Game Activity Helper
 * Handles recording and managing game activities for Pawikan Patrol
 */

class GameActivity {
    constructor() {
        this.baseURL = '/game-activities';
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    }

    /**
     * Record a new game activity
     */
    async recordActivity(activityData) {
        try {
            const response = await fetch(this.baseURL + '/record', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(activityData)
            });

            if (!response.ok) {
                throw new Error('Failed to record activity');
            }

            return await response.json();
        } catch (error) {
            console.error('Error recording game activity:', error);
            return null;
        }
    }

    /**
     * Helper method to record Memory Match completion
     */
    async recordMemoryMatch(moves, timeSpent) {
        // Calculate score: base 1000 points, minus points for moves and time
        const score = Math.max(100, 1000 - (moves * 10) - Math.floor(timeSpent / 2));

        return await this.recordActivity({
            game_type: 'memory-match',
            score: score,
            time_spent: timeSpent,
            moves: moves
        });
    }

    /**
     * Helper method to record Puzzle completion
     */
    async recordPuzzle(moves, timeSpent, difficulty) {
        // Calculate score based on difficulty
        const baseScores = { easy: 500, medium: 1000, hard: 1500 };
        const baseScore = baseScores[difficulty] || 500;
        const score = Math.max(100, baseScore - (moves * 5) - Math.floor(timeSpent / 2));

        return await this.recordActivity({
            game_type: 'puzzle',
            score: score,
            time_spent: timeSpent,
            moves: moves,
            difficulty: difficulty
        });
    }

    /**
     * Helper method to record Find the Pawikan completion
     */
    async recordFindThePawikan(timeSpent) {
        // Calculate score: faster = higher score
        const score = Math.max(100, 1500 - Math.floor(timeSpent * 2));

        return await this.recordActivity({
            game_type: 'find-the-pawikan',
            score: score,
            time_spent: timeSpent
        });
    }
}

// Initialize global game activity instance
window.gameActivity = new GameActivity();

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = GameActivity;
}
