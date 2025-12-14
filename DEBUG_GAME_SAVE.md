# GAME SAVE DEBUGGING - STEP BY STEP

## Current Status
❌ Game results are NOT being saved to database
❌ Profile page shows no game statistics

## Root Cause Analysis

The issue is likely one of these:
1. JavaScript not making the API call
2. API call failing (authentication/CSRF)
3. Database save failing silently

## IMMEDIATE TESTING STEPS

### Step 1: Test if JavaScript is loaded
1. Open http://localhost:8000/games/memory-match
2. Press F12 (open console)
3. Type: `window.gameActivity`
4. Press Enter

**Expected:** Should show `GameActivity {baseURL: '/game-activities', ...}`
**If undefined:** Script not loaded - hard refresh (Ctrl+Shift+R)

### Step 2: Test API endpoint manually
1. Open http://localhost:8000
2. Login as a PLAYER account
3. Open browser console (F12)
4. Paste this code and press Enter:

```javascript
fetch('/game-activities/record', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
    },
    body: JSON.stringify({
        game_type: 'memory-match',
        time_spent: 60,
        moves: 10,
        difficulty: 'medium'
    })
})
.then(r => r.json())
.then(data => console.log('API Response:', data))
.catch(err => console.error('API Error:', err));
```

**Expected Response:**
```json
{
  "success": true,
  "message": "Game activity recorded successfully",
  "data": {...}
}
```

### Step 3: Check if data was saved
After running Step 2, run this in terminal:

```bash
php artisan tinker --execute="print_r(\App\Models\GameActivity::latest()->first()->toArray());"
```

**Expected:** Should show the saved game activity

### Step 4: Play actual game and monitor
1. Open http://localhost:8000/games/memory-match
2. Keep console open (F12)
3. Play and complete the game
4. Watch console for these messages:
   - "Checking gameActivity..."
   - "Recording game: moves=..."
   - "Record result: ..."

### Step 5: Check Laravel logs
```bash
Get-Content storage\logs\laravel.log -Tail 20
```

Look for:
- "Game activity record request received"
- "Game activity saved successfully"
- Any error messages

## Common Issues & Fixes

### Issue 1: "gameActivity is undefined"
**Fix:** The script isn't loading
```bash
# Verify file exists
Test-Path public\js\game-activity.js
# Should return: True
```

### Issue 2: "401 Unauthorized" or "419 CSRF Token Mismatch"
**Fix:** Authentication issue
- Make sure you're logged in as a PLAYER
- Check if CSRF token exists: `document.querySelector('meta[name="csrf-token"]')`

### Issue 3: "Failed to save game"
**Fix:** Check the actual error in console
- Look for red error messages
- Check Network tab (F12 → Network)
- Find the `/game-activities/record` request
- Click it and check Response tab

### Issue 4: API works but profile doesn't update
**Fix:** Profile page needs to fetch data
- Refresh the profile page
- Check if the gameCompleted event is firing
- Verify the stats update function is working

## Quick Verification Checklist

Run these commands in order:

```bash
# 1. Check if game-activity.js exists
Test-Path public\js\game-activity.js

# 2. Check if table exists
php artisan tinker --execute="echo \Illuminate\Support\Facades\Schema::hasTable('game_activities') ? 'Table exists' : 'Table missing';"

# 3. Check table structure
php artisan tinker --execute="print_r(\Illuminate\Support\Facades\Schema::getColumnListing('game_activities'));"

# 4. Check if any records exist
php artisan tinker --execute="echo \App\Models\GameActivity::count() . ' records found';"
```

## What I Need From You

Please run the tests above and tell me:
1. What does `window.gameActivity` show in console?
2. What response do you get from the manual API test (Step 2)?
3. What do you see in the console when playing the game?
4. Any error messages in red?

This will help me pinpoint exactly where the problem is!
