VIDEO DIRECTORY
===============

This directory was created for storing local video files, but the website now uses 
YouTube embeds for better performance and easier content management.

CURRENT IMPLEMENTATION:
-----------------------
The homepage now features a YouTube video embed from "Amihan sa Dahican" 
People's Organization, showcasing community-based conservation efforts in 
Brgy. Dahican, Mati City, Davao Oriental.

Video Details:
- Title: "Quest for Love: Amihan sa Dahican"
- Source: YouTube (https://www.youtube.com/watch?v=nzKU4c66uP8)
- Attribution: © Amihan sa Dahican People's Organization
- Location: LandingPage.blade.php (Video Showcase Section)

HOW TO UPDATE THE VIDEO:
-------------------------
To change or update the video:

1. Open: resources/views/LandingPage.blade.php
2. Find the section: "Video Showcase Section" (around line 286)
3. Update the iframe src attribute with your new YouTube video ID
4. Update the attribution text with the proper owner's name
5. Modify the description text to match your new video content

YOUTUBE EMBED FORMAT:
---------------------
https://www.youtube.com/embed/[VIDEO_ID]

Example: 
- YouTube URL: https://www.youtube.com/watch?v=nzKU4c66uP8
- Embed URL: https://www.youtube.com/embed/nzKU4c66uP8

BENEFITS OF YOUTUBE EMBED:
---------------------------
✓ No file size limitations
✓ Automatic video optimization
✓ Built-in player controls
✓ Mobile-friendly responsive design
✓ Reduced server bandwidth usage
✓ Easy content updates

NOTE: This directory can still be used for local video files if needed in the future.

