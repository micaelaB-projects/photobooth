# 🌈 Retro Photobooth Theme - 70s-90s Aesthetic

Welcome to the **RETRO PHOTOBOOTH** - a time machine experience with authentic vintage vibes inspired by classic photobooth culture!

## 🎨 Visual Theme Overview

### Color Palette
- **Warm Oranges & Yellows**: `#ff6b35`, `#f7931e`, `#fdb833` (70s warmth)
- **Neon Pink**: `#ff1493` (80s pop culture)
- **Neon Cyan**: `#00ffff` (80s/90s synthwave)
- **Gold Accents**: `#ffd700` (classic glow)
- **Dark Background**: `#1a1a1a`, `#2d2d2d` (contrast and depth)

### Typography
- **Font Family**: `Courier New` (typewriter/retro feel)
- **Font Weight**: 900 (bold, unapologetic style)
- **Letter Spacing**: Increased for impact
- **Text Effects**: Shadow layering (yellow → pink → cyan)

## ✨ Key Features

### Animated Gradient Background
The background features an animated gradient that cycles through warm sunset tones, creating a dynamic retro atmosphere.

```css
animation: retrogradient 15s ease infinite;
```

### Geometric Patterns
Subtle repeating diagonal patterns overlay the background, reminiscent of 70s wallpaper and design.

### Neon Box Styling
The main photobooth container features:
- Multiple colored borders (gold, pink, cyan)
- Glowing shadows with neon colors
- Dashed golden border (vintage polaroid style)

```css
box-shadow: 
    0 0 0 8px #ffd700,
    0 0 0 12px #ff1493,
    0 0 0 16px #00ffff,
    0 0 40px rgba(255, 20, 147, 0.5)
```

### Retro Photo Filters

Every photo captured automatically gets vintage effects applied:

#### 🎬 Film Grain
- Random noise added to simulate analog film
- Grain intensity: 25 pixels
- Adds authentic aged film look

#### 💡 Light Leaks
- Random colored light from corners (orange, yellow, pink, cyan)
- Simulates light exposures from vintage cameras
- Creates organic, unpredictable analog feel

#### 🌅 Vignette Effect
- Darkened edges focusing attention on center
- Adds depth and atmosphere
- Classic photography technique

#### 🔥 Color Enhancement
- **Saturation Boost**: `1.3x` for bold, punchy colors
- **Warm Tone**: Red +10%, Blue -15%
- Creates that nostalgic warm glow effect

### Button Styling
Buttons feature:
- Rectangular (no curves - 80s/90s design)
- Bold uppercase text
- Thick borders
- Hover effects with skew transforms
- Colorful gradients matching the theme

### Interactive Elements
- **Gallery Items**: Slight rotation (-2° to +2°) for organic, scattered aesthetic
- **Hover Effects**: Transform, glow, and shadow enhancements
- **Transitions**: Smooth 0.3s transitions for juicy feedback

## 🎮 User Experience Elements

### Status Messages
- **Loading**: Orange gradient background
- **Success**: Neon green glow effect
- **Error**: Red highlight with warning effect

### Photo Gallery
- Polaroid-style cards with gold borders
- Random slight rotations for authenticity
- Shadow effects suggesting paper photos
- Hover interactions with scale and glow

### Mobile Responsiveness
- Theme adapts to smaller screens
- Maintains neon aesthetic on all sizes
- Touch-friendly button sizes

## 🎨 Customization Guide

### Change Primary Color Scheme

Edit `css/style.css` color values:

```css
/* Warm Tone Palette */
background: linear-gradient(45deg, #ff6b35, #f7931e, #fdb833, #f37021);

/* To Cool Palette (80s synthwave) */
background: linear-gradient(45deg, #0f0c29, #302b63, #24243e);
```

### Adjust Filter Intensity

Edit `js/script.js` filter functions:

```javascript
// Increase saturation in applyRetroFilter()
const saturation = 1.3; // Change to 1.5 for more intense

// Adjust grain in addFilmGrain()
const grainIntensity = 25; // Change to 40 for more grain

// Modify light leak opacity in addLightLeak()
{ color: 'rgba(255, 100, 50, 0.15)', ... } // Adjust alpha (0.15)
```

### Modify Button Appearance

```css
.btn-primary {
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    /* Change colors here */
    border-color: #ffd700; /* Border color */
    padding: 12px 24px; /* Button size */
}
```

### Change Neon Glow Colors

```css
.photobooth {
    box-shadow: 
        0 0 0 8px #ffd700,        /* Outer gold */
        0 0 0 12px #ff1493,       /* Pink */
        0 0 0 16px #00ffff,       /* Cyan */
        0 0 40px rgba(255, 20, 147, 0.5); /* Glow intensity */
}
```

## 🎬 Photo Effects Breakdown

### Film Grain Simulation
- Random noise across all RGB channels
- Creates scan-line feel of old film
- Noise intensity: ±12.5 per channel

### Light Leak Colors
Four preset leak types (randomly selected):
1. **Orange Heat** - `rgba(255, 100, 50, 0.15)`
2. **Golden Sun** - `rgba(255, 200, 0, 0.12)`
3. **Pink Drama** - `rgba(255, 50, 150, 0.1)`
4. **Cyan Dream** - `rgba(0, 255, 150, 0.1)`

### Saturation & Warmth
Applied to image data:
- Saturation multiplier: 1.3x
- Red channel boost: 1.1x
- Green channel: 1.05x
- Blue channel reduction: 0.85x

## 🎯 Browser Compatibility

- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

## 💾 Performance Tips

- Filters are applied in real-time on capture
- Canvas operations are optimized
- No external filter libraries needed
- Smooth 60fps on most devices

## 🚀 Advanced Customization Examples

### Add More Filter Options

```javascript
// Add a new vintage filter type
function applyCinemaFilter(ctx, width, height) {
    const imageData = ctx.getImageData(0, 0, width, height);
    const data = imageData.data;
    
    // Desaturate slightly for B&W film looked
    for (let i = 0; i < data.length; i += 4) {
        const avg = (data[i] + data[i+1] + data[i+2]) / 3;
        data[i] = data[i] * 0.7 + avg * 0.3;
        data[i+1] = data[i+1] * 0.7 + avg * 0.3;
        data[i+2] = data[i+2] * 0.7 + avg * 0.3;
    }
    ctx.putImageData(imageData, 0, 0);
}
```

### Create Theme Variations

**Disco Fever (Purple & Gold)**
```css
--primary-color: #9d4edd;
--accent-color: #ffd60a;
--neon-color: #00f5ff;
```

**Retro Game Boy (Green & Gray)**
```css
--primary-color: #8bac0f;
--accent-color: #9bbc0f;
--neon-color: #306230;
```

**VHS (Red & Blue)**
```css
--primary-color: #ff0040;
--accent-color: #0080ff;
--neon-color: #ffff00;
```

## 📚 File Reference

| File | Purpose |
|------|---------|
| `css/style.css` | Retro visual styling, colors, animations |
| `js/script.js` | Photo capture and filter application |
| `index.php` | HTML markup with retro branding |

## 🎉 Have Fun!

The Retro Photobooth captures the spirit of past decades. Experiment with the filters, customize the colors, and create your own vintage aesthetic!

**SNAP THOSE MEMORIES IN RETRO STYLE! 📸✨**

---

*Theme inspired by classic photobooth culture, 70s disco fever, 80s synthwave, and 90s nostalgia.*
