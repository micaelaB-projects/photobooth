# 🎨 Retro Photobooth Theme Switcher Guide

Your Retro Photobooth comes with multiple themed variations! Choose your favorite retro era and aesthetic.

## 🌟 Available Themes

### 1. **Classic Photobooth** (Default)
The original retro photobooth theme with warm 70s-90s vibes.
- **Colors**: Warm oranges, golds, neon pink & cyan
- **Vibe**: Disco fever, funky 70s energy mixed with 80s pop
- **Best For**: General retro vibes, most versatile

### 2. **Disco Fever** 🕺
Pure 1970s disco energy with purple and gold.
- **Colors**: Purple gradients, gold accents, neon cyan
- **Vibe**: Studio 54, Saturday Night Fever, groovy!
- **Best For**: Party atmosphere, 70s themed events
- **File**: `css/theme-disco-fever.css`

### 3. **Synthwave Cyberpunk** 🌆
Dark 80s-90s cyberpunk aesthetic with neon pink and cyan.
- **Colors**: Dark backgrounds, neon cyan, hot pink, purple
- **Vibe**: Blade Runner, Tron, 80s synth-pop vibes
- **Best For**: Moody, dramatic, futuristic retro
- **File**: `css/theme-synthwave.css`

### 4. **Game Boy Classic** 🎮
Nostalgic 90s handheld gaming console vibes.
- **Colors**: Classic Game Boy green and gray
- **Vibe**: Nintendo Game Boy, retro gaming, pixels and beeps
- **Best For**: 90s nostalgia, gaming events
- **File**: `css/theme-gameboy.css`

### 5. **Crown of Hearts** ♥💎
Romantic and elegant vintage aesthetic with decorative crown and heart elements.
- **Colors**: Deep red, burgundy, gold accents, soft pink
- **Vibe**: Romantic vintage elegance, classic romance aesthetic
- **Best For**: Weddings, romantic events, Valentine's celebrations, elegant occasions
- **File**: `css/theme-crown-of-hearts.css`

## 🔧 How to Switch Themes

### Method 1: Edit HTML (Recommended)

Open `index.php` and change the CSS link in the `<head>`:

**Default (Photobooth):**
```html
<link rel="stylesheet" href="css/style.css">
```

**To Disco Fever:**
```html
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/theme-disco-fever.css">
```

**To Synthwave Cyberpunk:**wa 
```html
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/theme-synthwave.css">
```

**To Game Boy:**
```html
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/theme-gameboy.css">
```

**To Crown of Hearts:**
```html
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/theme-crown-of-hearts.css">
```

### Method 2: Create a Theme Selector

Add a theme switcher script to `index.php`:

```html
<!-- Add before </head> -->
<script>
    function switchTheme(themeName) {
        // Remove existing theme link
        const existingTheme = document.getElementById('theme-style');
        if (existingTheme) existingTheme.remove();
        
        // Add new theme if not default
        if (themeName !== 'default') {
            const link = document.createElement('link');
            link.id = 'theme-style';
            link.rel = 'stylesheet';
            link.href = `css/theme-${themeName}.css`;
            document.head.appendChild(link);
        }
    }
</script>

<!-- Add theme buttons in controls -->
<div class="theme-switcher" style="text-align: center; margin-bottom: 15px;">
    <button onclick="switchTheme('default')" class="theme-btn">📸 Default</button>
    <button onclick="switchTheme('disco-fever')" class="theme-btn">🕺 Disco</button>
    <button onclick="switchTheme('synthwave')" class="theme-btn">🌆 Synthwave</button>
    <button onclick="switchTheme('gameboy')" class="theme-btn">🎮 Game Boy</button>
    <button onclick="switchTheme('crown-of-hearts')" class="theme-btn">♥ Crown of Hearts</button>
</div>
```

## 🎨 Theme Color Palettes

### Classic Photobooth
```
Primary:     #ff6b35 (Warm Orange)
Secondary:   #f7931e (Golden Orange)
Tertiary:    #fdb833 (Mustard Yellow)
Neon Pink:   #ff1493
Neon Cyan:   #00ffff
Gold:        #ffd700
```

### Disco Fever
```
Primary:     #9d4edd (Purple)
Secondary:   #c77dff (Light Purple)
Gold:        #ffd60a
Neon Pink:   #ff006e
Neon Cyan:   #00f5ff
```

### Synthwave Cyberpunk
```
Dark BG:     #0f0c29 (Deep Blue)
Primary:     #302b63 (Dark Purple)
Neon Pink:   #e94560 (Hot Pink)
Neon Cyan:   #00ffff (Bright Cyan)
Purple:      #533483 (Royal Purple)
```

### Game Boy Classic
```
Primary:     #306230 (Dark Green)
Secondary:   #3d5a3d (Medium Green)
Bright:      #8bac0f (Game Boy Green)
Lighter:     #9bbc0f (Game Boy Light Green)
Background:  #1a1a1a (Black)
```

### Crown of Hearts
```
Primary:     #8b1a1a (Deep Burgundy)
Secondary:   #c41e3a (Rich Red)
Accent:      #e63946 (Heart Red)
Gold:        #ffd700 (Crown Gold)
Light Pink:  #ffb3ba (Soft Pink)
Dark Red:    #6b0f1f (Dark Burgundy)
```

## 🎨 Creating Your Own Theme

### Step 1: Create a New CSS File
Create `css/theme-yourname.css`

### Step 2: Start with Base Structure
```css
/* Your Theme Name */
:root {
    --primary-color: #yourcolor;
    --accent-color: #yourcolor;
    --neon-color: #yourcolor;
}

body {
    background: linear-gradient(45deg, #color1, #color2, #color3);
}

.photobooth {
    background: linear-gradient(135deg, #color1 0%, #color2 100%);
    box-shadow: 
        0 0 0 8px #neoncolor,
        0 0 0 12px #color2,
        0 0 0 16px #color3,
        0 0 40px rgba(neon, neon, neon, 0.5);
    border-color: #neoncolor;
}
```

### Step 3: Customize Key Elements
```css
h1 {
    color: #primarycolor;
    text-shadow: 
        3px 3px 0px #color2,
        6px 6px 0px #color3,
        9px 9px 20px rgba(neon, neon, neon, 0.5);
}

.btn-primary {
    background: linear-gradient(135deg, #color1 0%, #color2 100%);
    border-color: #neoncolor;
}

.btn-capture {
    background: linear-gradient(135deg, #neoncolor 0%, #neoncolor2 100%);
    border-color: #neoncolor;
}
```

### Step 4: Use Your Theme
```html
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/theme-yourname.css">
```

## 🎯 Theme Customization Tips

### For Subtle Changes:
Tweak just the main colors - overrides will cascade

### For Bold Changes:
Override entire sections like `.photobooth`, `h1`, buttons

### Color Harmony:
- Use analogous colors (neighbors on color wheel) for harmony
- Use complementary colors for contrast
- Neon colors pop against dark backgrounds
- Keep text readable (high contrast)

### Neon Glow Effect Formula:
```css
box-shadow: 
    0 0 10px rgba(r, g, b, 0.4),     /* Inner glow */
    0 0 20px rgba(r, g, b, 0.3),     /* Mid glow */
    0 0 40px rgba(r, g, b, 0.2);     /* Outer glow */
```

## 💡 Theme Inspiration Ideas

### VHS Retro (Red & Blue)
```css
Primary: #ff0040
Secondary: #0080ff
Neon: #ffff00
```

### Vaporwave (Pastel)
```css
Primary: #b19cd9
Secondary: #ffb3ba
Neon: #ffafcc
```

### Atari 2600 (Orange & Black)
```css
Primary: #ff3800
Secondary: #000000
Neon: #ffff00
```

### Commodore 64 (Blue & White)
```css
Primary: #3333cc
Secondary: #ffffff
Neon: #ffff00
```

### Retro Apple (Rainbow)
```css
Primary: #ff7f00    (Orange)
Secondary: #ffff00  (Yellow)
Tertiary: #00ff00   (Green)
```

## 🚀 Advanced Theme Techniques

### Add Custom Pattern
```css
body::before {
    background-image: 
        repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(color, 0.05) 35px),
        repeating-linear-gradient(-45deg, transparent, transparent 35px, rgba(color, 0.05) 35px);
}
```

### Animated Background
```css
@keyframes themegradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

body {
    background: linear-gradient(45deg, #c1, #c2, #c3, #c4);
    background-size: 400% 400%;
    animation: themegradient 20s ease infinite;
}
```

### Retro CRT Screen Effect
```css
.photobooth::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: repeating-linear-gradient(
        0deg,
        rgba(0, 0, 0, 0.15),
        rgba(0, 0, 0, 0.15) 1px,
        transparent 1px,
        transparent 2px
    );
    pointer-events: none;
}
```

## 📱 Theme Testing Checklist

- [ ] Looks good on desktop
- [ ] Looks good on mobile (landscape)
- [ ] Looks good on mobile (portrait)
- [ ] Buttons are clearly visible
- [ ] Text is readable (good contrast)
- [ ] Camera feed is visible
- [ ] Neon glows work properly
- [ ] Gallery items are visible and clickable

## 🎬 Switching Themes for Events

**Birthday Party**: Disco Fever 🕺
**Tech Meetup**: Synthwave Cyberpunk 🌆
**Gaming Event**: Game Boy 🎮
**Casual Hangout**: Classic Photobooth 📸

## 📚 Theme Files Reference

| File | Theme | Vibe |
|------|-------|------|
| `css/style.css` | Classic Photobooth | Warm 70s-90s |
| `css/theme-disco-fever.css` | Disco Fever | Purple & Gold 70s |
| `css/theme-synthwave.css` | Synthwave | Dark Neon 80s |
| `css/theme-gameboy.css` | Game Boy | Green 90s Gaming |

## 🎉 Have Fun!

Mix and match colors, create your own themes, and make the photobooth your own! The retro aesthetic is all about personality and fun.

**CUSTOMIZE & CAPTURE! 📸✨**

---

*Retro themes celebrating past decades of technology, gaming, and pop culture.*
