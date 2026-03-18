# 🎨 Filters & Layouts Guide

## New Features Added

Your retro photobooth now includes 6 amazing filters and 5 creative gallery layouts!

---

## 📸 Photo Filters

### 1. ✨ Retro Classic
The original warm, nostalgic filter with:
- Enhanced saturation for vivid colors
- Warm orange/yellow color cast
- Natural film grain for vintage texture
- Subtle light leaks from corners
- Elegant vignette edge darkening

**Best for:** Capturing that authentic 70s-90s vibe

### 2. 🟤 Sepia Vintage
Transform your photos into timeless sepia tones:
- Classic brown-toned color grading
- Authentic 1980s-90s photograph aesthetic
- Subtle film grain texture
- Gentle vignette effect

**Best for:** Creating vintage, nostalgic memories

### 3. ⚫ Black & White
Timeless monochrome photography:
- Pure black and white conversion
- Based on professional luminance calculations
- Film grain for analog feel
- Dramatic vignette for depth

**Best for:** Artistic, dramatic compositions

### 4. 💜 Vaporwave
Bold cyberpunk aesthetics with purple and cyan:
- Desaturated base with color shifts
- Magenta/cyan color separation
- Cyberpunk neon vibes
- Reduced saturation for dreamy effect

**Best for:** Futuristic, surreal shots

### 5. 🌈 Neon Glow
Hyper-saturated neon brilliance:
- Extreme color saturation (2.5x boost!)
- Vibrant, electric color palette
- Perfect for already colorful subjects
- Dramatic vignette effect

**Best for:** Neon signs, vibrant scenes, party photos

### 6. ❄️ Cool Blue
Chill blue-toned photographs:
- Blue color temperature shift
- Reduced reds, enhanced blues
- Film grain simulation
- Vignette effect

**Best for:** Water, sky, cool-toned subjects

---

## 🖼️ Gallery Layouts

### 1. 🔲 Grid (Default)
Classic photo grid layout:
```
[Photo] [Photo] [Photo]
[Photo] [Photo] [Photo]
```
- Responsive auto-fill columns
- Scattered rotation for casual feel
- Ideal for browsing all photos at once

**Best for:** Viewing all photos simultaneously

### 2. 📽️ Film Strip
Vertical strip photobooth style:
```
[Photo]
[Photo]
[Photo]
[Photo]
```
- Single column layout
- Traditional photobooth aesthetic
- Full-width photos
- Great for sequential shots

**Best for:** Multi-photo strips and sequences

### 3. 📷 Polaroid Stack
Overlapping polaroid-style cards:
```
  [Photo]
   [Photo]
    [Photo]
```
- White polaroid-style frames
- Natural card-like drop shadows
- Overlapped offset arrangement
- Vintage scrapbook feel

**Best for:** Casual, nostalgic collections

### 4. 🖼️ Wall Display
Carefully arranged wall gallery:
```
[Photo] [Photo] [Photo]
  [Photo] [Photo]
[Photo] [Photo] [Photo]
```
- Smaller, compact photos
- Thicker frame borders
- Gallery wall aesthetic
- Neon glow effects

**Best for:** Dense photo collections

### 5. ⏱️ Timeline
Chronological timeline presentation:
```
[Photo] |
        |
        [Photo]
[Photo] |
        |
        [Photo]
```
- Vertical center timeline
- Alternating left/right placement
- Perfect for documenting progression
- Full-height photos with gradual rainbow timeline

**Best for:** Before & after, time progression stories

---

## 🎮 How to Use

### Applying Filters
1. **Before Capture:**
   - Select your desired filter from the "Filter" dropdown
   - The selected filter will apply automatically when you capture
   - Change filters anytime before capturing

2. **Filter Icon Guide:**
   - ✨ = Retro vibes
   - 🟤 = Vintage sepia
   - ⚫ = Classic black & white
   - 💜 = Cyberpunk neon
   - 🌈 = Ultra-saturated neon
   - ❄️ = Cool blue tones

### Changing Layouts
1. **After Capture:**
   - Select desired layout from the "Layout" dropdown
   - Gallery instantly rearranges with new layout
   - Switch layouts anytime - no photo changes!

2. **Layout Abbreviations:**
   - Grid = Multi-column responsive
   - Film Strip = Traditional photobooth vertical
   - Polaroid Stack = Vintage scrapbook cards
   - Wall Display = Dense gallery wall
   - Timeline = Chronological progression

---

## 💡 Filter + Layout Combinations

### Best Combinations

**Retro Party Mode:**
- Filter: Neon Glow
- Layout: Wall Display
- Great for: Dance events, nightlife

**Vintage Memory Lane:**
- Filter: Sepia Vintage
- Layout: Timeline
- Great for: Documenting memories chronologically

**Moody Artistry:**
- Filter: Black & White
- Layout: Polaroid Stack
- Great for: Artistic portfolios

**Cyberpunk Future:**
- Filter: Vaporwave
- Layout: Wall Display
- Great for: Tech events, modern aesthetic

**Classic Photobooth:**
- Filter: Retro Classic
- Layout: Film Strip
- Great for: Traditional photobooth experience

---

## 🎨 Technical Details

### Filter Processing
- All filters process in real-time on Canvas API
- RGB pixel manipulation for color effects
- No external dependencies - pure JavaScript
- Maintains image quality at 95% JPEG compression

### Layout Styling
- CSS Grid for responsive layouts
- Dynamic class application via JavaScript
- Mobile-responsive breakpoints
- Works across all browser themes (Classic, Disco, Synthwave, Game Boy)

### Performance
- Filters render instantly during capture
- Layout changes are CSS-only (no reprocessing)
- Smooth transitions between layouts
- Optimized for browsers 2+ years old

---

## 🚀 Creating Custom Filters

Want to create your own filter? Edit `js/script.js` and add:

```javascript
/**
 * Your Custom Filter Name
 */
function applyYourFilter(ctx, width, height) {
    const imageData = ctx.getImageData(0, 0, width, height);
    const data = imageData.data;
    
    // Modify pixel data (R, G, B, Alpha every 4 bytes)
    for (let i = 0; i < data.length; i += 4) {
        // Your color modifications here
        data[i] *= 1.1; // Red channel example
    }
    
    ctx.putImageData(imageData, 0, 0);
}
```

Then add to the `applyFilter()` dispatcher:
```javascript
case 'yourfilter':
    applyYourFilter(ctx, width, height);
    break;
```

And add option to HTML dropdown:
```html
<option value="yourfilter">🎨 Your Custom Filter</option>
```

---

## 🛠️ Troubleshooting

### Filter not applying?
- Ensure camera permission is granted
- Check browser developer console for errors
- Try refreshing the page

### Layout not changing?
- Make sure photos exist in gallery
- Try a different layout
- Clear browser cache if issues persist

### Photos look washed out?
- Try "Neon Glow" or "Retro Classic" filters
- Adjust lighting conditions in camera
- Use different filter for better results

---

## 📱 Mobile Support

- All 6 filters work on mobile
- All 5 layouts are responsive
- Touch-friendly dropdown menus
- Optimized for portrait orientation

---

## 🎯 Next Features (Ideas)

- Filter intensity slider (0-100%)
- Custom color picker for filters
- Save filter presets
- Export photos with filters
- Layer multiple filters
- Layout templates/themes
- AI-powered filter suggestions

---

**Enjoy your enhanced retro photobooth! 🎉📸✨**
