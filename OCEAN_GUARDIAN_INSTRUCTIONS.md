# Ocean Guardian - Game Instructions & Voice-over Feature

## Overview
The Ocean Guardian game now includes an interactive instruction modal with voice-over narration to help players understand how to play the game.

## Features Implemented

### 1. **Instruction Modal**
- **Beautiful UI Design**: Gradient background with ocean-themed colors
- **Comprehensive Instructions**: 4 key sections explaining game mechanics:
  - 🎯 Your Mission
  - ❤️ Health System
  - 🗑️ Win Condition
  - ⭐ Difficulty Levels
- **Smooth Animations**: Scale and fade transitions
- **Responsive Design**: Works on both desktop and mobile devices

### 2. **Voice-over Narration**
- **Auto-play**: Instructions are narrated automatically when the modal opens
- **Visual Indicator**: Shows when voice-over is playing
- **Replay Button**: Users can replay the instructions at any time
- **Audio Management**: Background music pauses during instruction narration

### 3. **User Experience**
- **First-time Visitors**: Modal appears automatically on first visit
- **Returning Users**: Instructions are hidden but accessible via the "How to Play" button
- **Multiple Access Points**:
  - Automatic on first visit
  - "How to Play" button (info icon) next to the back button
  - Can be triggered programmatically via `window.showGameInstructions()`
- **Easy Dismissal**: 
  - ESC key
  - Close button (X)
  - "START PLAYING" button

### 4. **Audio Files**
- **Location**: `public/audio/ocean-guardian-instructions.mp3`
- **Generated Using**: Google Text-to-Speech (gTTS)
- **Script**: Available in `public/audio/ocean-guardian-instructions-script.txt`

## How It Works

### Flow for New Users:
1. User visits the Ocean Guardian game
2. Guest modal appears (if not logged in)
3. After closing guest modal, instruction modal appears
4. Voice-over plays automatically
5. User can read and listen to instructions
6. Click "START PLAYING" to begin

### Flow for Returning Users:
1. User visits the Ocean Guardian game
2. No instruction modal (already seen)
3. Can access instructions anytime via "How to Play" button

### Audio Management:
- Background music pauses when instruction modal opens
- Voice-over plays at 80% volume
- Background music resumes when modal closes
- All audio stops properly when navigating away

## Technical Details

### Files Modified:
- `resources/views/games/find-the-pawikan.blade.php`
  - Added instruction modal HTML
  - Added voice-over audio element
  - Added JavaScript for modal management
  - Added "How to Play" button

### Files Created:
- `public/audio/ocean-guardian-instructions.mp3` - Voice-over audio
- `public/audio/ocean-guardian-instructions-script.txt` - Narration script
- `public/audio/generate-voiceover.py` - Audio generation script

### LocalStorage Keys:
- Authenticated users: `{user_id}_ocean_guardian_instructions_seen`
- Guest users: `ocean_guardian_instructions_seen`

## Regenerating Voice-over Audio

If you need to update the voice-over:

1. Edit the script in `public/audio/ocean-guardian-instructions-script.txt`
2. Run the generator:
   ```bash
   cd public/audio
   python generate-voiceover.py
   ```
3. The new audio file will replace the existing one

### Requirements:
```bash
pip install gtts
```

## Customization

### Changing Voice-over Volume:
Edit line in `find-the-pawikan.blade.php`:
```javascript
instructionVoice.volume = 0.8; // Change from 0.0 to 1.0
```

### Disabling Auto-show:
Comment out or remove the setTimeout block:
```javascript
// setTimeout(() => {
//     if (!hasSeenInstructions && !isGuestModalVisible) {
//         showInstructionModal();
//     }
// }, 1000);
```

### Changing Animation Timing:
Modify the `duration-500` classes in the modal HTML and the setTimeout delays in JavaScript.

## Browser Compatibility

- ✅ Chrome/Edge (full support)
- ✅ Firefox (full support)
- ✅ Safari (may require user interaction for audio)
- ✅ Mobile browsers (full support)

## Accessibility

- Keyboard navigation (ESC to close)
- Screen reader friendly
- Visual and audio instructions
- Clear button labels
- High contrast text

## Future Enhancements

Potential improvements:
- Multiple language support
- Different voice options
- Subtitles/captions
- Interactive tutorial mode
- Video demonstrations

## Testing Checklist

- [x] Modal appears on first visit
- [x] Voice-over plays automatically
- [x] Background music pauses during instructions
- [x] Replay button works
- [x] Close button works
- [x] ESC key works
- [x] "How to Play" button works
- [x] Modal doesn't show on subsequent visits
- [x] LocalStorage persistence works
- [x] Mobile responsive design
- [x] Audio cleanup on page navigation

## Support

For issues or questions, check:
1. Browser console for errors
2. Audio file exists in `public/audio/`
3. LocalStorage is enabled in browser
4. Audio autoplay is allowed (may require user interaction)
