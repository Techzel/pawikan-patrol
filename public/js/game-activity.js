/**
 * Game Activity Helper
 * Handles recording and managing game activities for Pawikan Patrol
 */

class GameActivity {
    constructor() {
        this.baseURL = '/game-activities';
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        this.setupAxios();
    }

    setupAxios() {
        if (typeof axios !== 'undefined') {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken;
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        }
    }

    /**
     * Record a new game activity
     */
    async recordActivity(activityData) {
        try {
            const response = await axios.post(this.baseURL + '/record', activityData);
            return response.data;
        } catch (error) {
            console.error('Error recording game activity:', error);
            throw error;
        }
    }

    /**
     * Get user's game activities
     */
    async getActivities(filters = {}) {
        try {
            const params = new URLSearchParams(filters);
            const response = await axios.get(this.baseURL + '?' + params.toString());
            return response.data;
        } catch (error) {
            console.error('Error fetching game activities:', error);
            throw error;
        }
    }

    /**
     * Get user's game statistics
     */
    async getStatistics() {
        try {
            const response = await axios.get(this.baseURL + '/statistics');
            return response.data;
        } catch (error) {
            console.error('Error fetching game statistics:', error);
            throw error;
        }
    }

    /**
     * Get user's best scores
     */
    async getBestScores() {
        try {
            const response = await axios.get(this.baseURL + '/best-scores');
            return response.data;
        } catch (error) {
            console.error('Error fetching best scores:', error);
            throw error;
        }
    }

    /**
     * Get leaderboard
     */
    async getLeaderboard(gameType = null) {
        try {
            const url = gameType ? `${this.baseURL}/leaderboard/${gameType}` : `${this.baseURL}/leaderboard`;
            const response = await axios.get(url);
            return response.data;
        } catch (error) {
            console.error('Error fetching leaderboard:', error);
            throw error;
        }
    }

    /**
     * Delete a game activity
     */
    async deleteActivity(activityId) {
        try {
            const response = await axios.delete(this.baseURL + '/' + activityId);
            return response.data;
        } catch (error) {
            console.error('Error deleting game activity:', error);
            throw error;
        }
    }

    /**
     * Helper method to record quiz completion
     */
    async recordQuizCompletion(score, totalQuestions, correctAnswers, timeSpent, difficulty = 'medium') {
        const accuracy = totalQuestions > 0 ? (correctAnswers / totalQuestions) * 100 : 0;
        
        return await this.recordActivity({
            game_type: 'quiz',
            game_name: 'Turtle Knowledge Quiz',
            score: score,
            total_questions: totalQuestions,
            correct_answers: correctAnswers,
            accuracy: accuracy,
            time_spent: timeSpent,
            difficulty_level: difficulty,
            completed: true
        });
    }

    /**
     * Helper method to record word scramble completion
     */
    async recordWordScrambleCompletion(score, totalWords, correctWords, timeSpent, difficulty = 'medium') {
        const accuracy = totalWords > 0 ? (correctWords / totalWords) * 100 : 0;
        
        return await this.recordActivity({
            game_type: 'word_scramble',
            game_name: 'Turtle Word Scramble',
            score: score,
            total_questions: totalWords,
            correct_answers: correctWords,
            accuracy: accuracy,
            time_spent: timeSpent,
            difficulty_level: difficulty,
            completed: true
        });
    }

    /**
     * Helper method to record game progress (for incomplete games)
     */
    async recordGameProgress(gameType, gameName, currentScore, progressData = {}) {
        return await this.recordActivity({
            game_type: gameType,
            game_name: gameName,
            score: currentScore,
            game_data: progressData,
            completed: false
        });
    }

    /**
     * Update game statistics display
     */
    updateStatisticsDisplay(stats) {
        const totalScoreElement = document.querySelector('[data-stat="total-score"]');
        const totalGamesElement = document.querySelector('[data-stat="total-games"]');
        const avgAccuracyElement = document.querySelector('[data-stat="average-accuracy"]');
        
        if (totalScoreElement) {
            totalScoreElement.textContent = stats.total_score || 0;
        }
        if (totalGamesElement) {
            totalGamesElement.textContent = stats.total_games_played || 0;
        }
        if (avgAccuracyElement) {
            avgAccuracyElement.textContent = (stats.average_accuracy || 0).toFixed(1) + '%';
        }
        
        // Dispatch custom event for profile page updates
        const event = new CustomEvent('userStatsUpdated', { 
            detail: stats 
        });
        document.dispatchEvent(event);
    }

    /**
     * Update leaderboard display
     */
    updateLeaderboardDisplay(leaderboard) {
        const leaderboardContainer = document.querySelector('[data-leaderboard]');
        if (!leaderboardContainer) return;

        let html = '<div class="leaderboard-list">';
        
        leaderboard.forEach((entry, index) => {
            html += `
                <div class="leaderboard-item">
                    <div class="rank">${index + 1}</div>
                    <div class="player-info">
                        <div class="player-name">${entry.user?.name || 'Anonymous'}</div>
                        <div class="player-score">${entry.score} points</div>
                    </div>
                    <div class="game-info">
                        <div class="game-type">${entry.game_type}</div>
                        <div class="play-date">${new Date(entry.played_at).toLocaleDateString()}</div>
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        leaderboardContainer.innerHTML = html;
    }

    /**
     * Show success notification
     */
    showSuccess(message) {
        this.showNotification(message, 'success');
    }

    /**
     * Show error notification
     */
    showError(message) {
        this.showNotification(message, 'error');
    }

    /**
     * Show notification
     */
    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        // Add to page
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
}

// Initialize global game activity instance
window.gameActivity = new GameActivity();

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = GameActivity;
}
