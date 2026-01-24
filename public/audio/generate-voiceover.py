"""
Ocean Guardian - Voice-over Generator
This script generates the instruction voice-over audio file using gTTS (Google Text-to-Speech)
"""

try:
    from gtts import gTTS
    import os
    
    # Read the script
    script_path = os.path.join(os.path.dirname(__file__), 'ocean-guardian-instructions-script.txt')
    with open(script_path, 'r', encoding='utf-8') as f:
        text = f.read()
    
    # Generate speech
    print("Generating voice-over audio...")
    tts = gTTS(text=text, lang='en', slow=False)
    
    # Save the audio file
    output_path = os.path.join(os.path.dirname(__file__), 'ocean-guardian-instructions.mp3')
    tts.save(output_path)
    
    print(f"✓ Voice-over audio generated successfully!")
    print(f"  Saved to: {output_path}")
    
except ImportError:
    print("Error: gTTS library not found.")
    print("\nTo install gTTS, run:")
    print("  pip install gtts")
    print("\nAlternatively, you can:")
    print("1. Use an online text-to-speech service")
    print("2. Record the audio yourself")
    print("3. Use a professional voice-over service")
    
except Exception as e:
    print(f"Error generating voice-over: {e}")
