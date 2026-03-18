# 🎬 Photo Strip Selector Guide

## Overview

Your retro photobooth now includes an interactive **Photo Strip Builder** - a fun feature that lets you create classic photobooth-style vertical photo strips!

---

## 🎯 What is the Strip Selector?

The Strip Selector allows you to:
- View your captured photos arranged in vertical strips (like classic photobooth prints)
- Browse through different combinations of 4 photos
- Download complete photo strips as single images
- Print strips with vintage styling
- Create custom strip selections

---

## 📐 How Photo Strips Work

### Strip Composition
- **4 Photos Per Strip** - Each strip displays 4 photos stacked vertically
- **Traditional Layout** - Mimics classic photobooth output
- **Navigation** - Use arrow buttons to browse different combinations

### Example Layout
```
┌──────────┐
│ Photo 1  │
├──────────┤
│ Photo 2  │
├──────────┤
│ Photo 3  │
├──────────┤
│ Photo 4  │
└──────────┘
```

---

## 🎮 Using the Strip Selector

### Step 1: Capture Photos
1. Click "Start Camera"
2. Select your desired filter
3. Click "Capture" to take photos
4. Download or continue capturing

### Step 2: View Your Strip
Once you have at least 4 photos:
- The strip automatically populates in the "BUILD YOUR STRIP" section
- Shows photos 1-4 from your gallery

### Step 3: Navigate Strips

**◀ Previous Button**
- Goes to the previous set of 4 photos
- Disabled on the first strip
- Appears as grey when unavailable

**▶ Next Button**
- Goes to the next set of 4 photos
- Disabled on the last strip
- Appears as grey when unavailable

**Current Strip Display**
- Shows "Strip X of Y" in the status bar
- Example: "Strip 1 of 3" = 3 possible strips

**Example:**
```
Photos: [1] [2] [3] [4] [5] [6] [7] [8] [9]
Strip 1: Photos 1-4 ◀ X ▶ ← Can go NEXT
Strip 2: Photos 5-8 ◀ ✓ ▶ ← Can go LEFT or RIGHT
Strip 3: Photos 9   ◀ ✓ X ← Can only go PREVIOUS
```

---

## 💾 Saving Your Strips

### Download as Image
**Button:** 💾 Download Strip

Creates a vertical image file with:
- All 4 photos stacked
- Black background frame
- Gold border styling
- Retro photobooth aesthetic
- Saved as `photobooth-strip-[timestamp].jpg`

**File Details:**
- Format: JPEG (95% quality)
- Width: 440px (400px photos + padding)
- Height: 1,680px (4×400px + padding)
- Suitable for sharing on social media

### Print Strip
**Button:** 🖨️ Print Strip

Opens a print preview showing:
- Professional photobooth strip layout
- 4 photos in vertical arrangement
- Print-optimized styling
- "KEEPSAKE 📸" text at bottom
- Ready for physical printing

**Print Tips:**
- Use standard letter size (8.5" × 11")
- Set margins to minimal
- Print in color for best results
- Gloss photo paper recommended

**Printing Process:**
1. Click "🖨️ Print Strip"
2. Print dialog appears
3. Select printer and settings
4. Click "Print"

---

## 🔄 Clear Selection

**Button:** 🔄 Clear Selection

Resets the strip selector to:
- Strip 1 (first 4 photos)
- Useful if you want to start browsing over

---

## 💡 Tips & Tricks

### Optimal Strip Composition
- **Sequential Shots**: Use 4 consecutive photos for story-telling
- **Alternative Angles**: Mix different angles of same scene
- **Expression Variety**: Show different expressions in each photo
- **Same Pose**: Recreate same pose across 4 strips (cinematic effect)

### Download Strategy
1. Check preview before downloading
2. Use arrow buttons to find favorite combination
3. Download that strip specifically
4. Skip to next combination with ▶

### Print Quality
- Larger prints work better
- 4"×6" per photo recommended
- Trim after printing or laminate
- Works on regular paper or photo paper

### Social Media Tips
- Instagram: Vertical strips work great
- TikTok: Download + upload as video
- WhatsApp: Share full strip image
- Twitter: Crop to preferred size

---

## 🧮 Strip Math

### How Many Strips Can You Make?

Formula: `Total Photos ÷ 4 = Number of Strips`

**Examples:**
```
4 photos   → 1 strip
8 photos   → 2 strips
10 photos  → 2.5 strips (10÷4 = 2 full + 2 remaining)
12 photos  → 3 strips
15 photos  → 3 strips (with 3 unbundled)
```

### Incomplete Final Strip

If you have 9 photos:
- Strip 1: Photos 1-4 ✓
- Strip 2: Photos 5-8 ✓
- Strip 3: Photo 9 (only 1 photo)

The last strip still downloads/prints with available photos!

---

## 🎨 Strip Styling

### What You Get

**Golden Frame**
- 3px #ffd700 border
- Professional photobooth look
- Retro 90s aesthetic

**Separator Lines**
- Hot pink (#ff1493) dividers between photos
- Authentically separated photos
- Vintage photobooth realism

**Black Background**
- Professional booth space
- Photos pop with better contrast
- Timeless aesthetic

**High Quality Output**
- 95% JPEG compression
- 400×400px per photo
- Sharp, clear images

---

## ⚙️ Display Options

### Strip Selector States

**With Photos:**
```
◀ ▀▀▀▀▀▀▀▀▀▀▀ ▶
(Navigation enabled)
🖨️ Print | 💾 Download | 🔄 Clear
(All buttons enabled)
```

**Empty/No Photos:**
```
◀ (placeholders) ▶
(Navigation disabled - grey)
🖨️ Print | 💾 Download | 🔄 Clear
(All buttons disabled - grey)
```

---

## 🚀 Advanced Features (Future)

Planned enhancements:
- Drag-and-drop photo reordering
- Custom strip sizes (3, 4, 5, 6 photos)
- Add text/date to strips
- Multiple frame styles
- Color overlay options
- Batch download multiple strips
- Social media direct share
- Email strip function

---

## 🛠️ Troubleshooting

### Strip buttons are greyed out
→ You need at least 4 photos in your gallery first

### Photos not showing in preview
→ Make sure photos uploaded successfully to database

### Download not working
→ Check browser permissions for file downloads

### Print dialog not appearing
→ Allow pop-ups for localhost in browser settings

### Strip preview looks different from download
→ Browser may be scaling preview - actual download size is fixed

### Photos not in order
→ Photos display in reverse chronological order (newest first)
→ Use arrow buttons to find desired combination

---

## 📱 Mobile Compatibility

- ✅ Strip selector works on all devices
- ✅ Touch-friendly arrow buttons
- ✅ Responsive layout for phones/tablets
- ✅ Download works on mobile
- ⚠️ Print dialog may vary by device

---

## 🎬 Strip Examples

### Selfie Strip
1. Face close-up (Photo 1)
2. Peace sign pose (Photo 2)
3. Silly expression (Photo 3)
4. Wink shot (Photo 4)

### Group Strip
1. Full group shot (Photo 1)
2. Hugging shot (Photo 2)
3. Jumping shot (Photo 3)
4. Final pose (Photo 4)

### Sequential Strip
1. Props off (Photo 1)
2. Props starting (Photo 2)
3. Props on (Photo 3)
4. Showing off props (Photo 4)

---

**Enjoy creating your retro photobooth strips! 🎉📸✨**
