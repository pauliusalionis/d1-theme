# ACF Hero Slider Block Fields

Complete ACF field structure for the Hero - Slider block using Swiper library.

## Field Group Settings

- **Field Group Title:** Hero - Slider
- **Location:** Show this field group if:
  - Block is equal to `acf/hero-slider`

---

## Tab 1: Section Settings

### 1. Section Hidden
- **Field Label:** Hide Section
- **Field Name:** `section_hidden`
- **Field Type:** True / False
- **Default Value:** 0
- **Message:** Hide this section from the frontend

### 2. Section Background
- **Field Label:** Background Color
- **Field Name:** `section_background`
- **Field Type:** Select
- **Choices:**
  ```
  default : Default (White)
  alt : Soft (Light Gray)
  dark : Dark
  brand : Brand Color
  ```
- **Default Value:** `default`
- **Allow Null:** 0

### 3. Section Spacing
- **Field Label:** Vertical Spacing
- **Field Name:** `section_spacing`
- **Field Type:** Select
- **Choices:**
  ```
  narrow : Narrow
  default : Default
  spacious : Spacious
  ```
- **Default Value:** `spacious`
- **Allow Null:** 0

### 4. Section Width
- **Field Label:** Content Width
- **Field Name:** `section_width`
- **Field Type:** Select
- **Choices:**
  ```
  narrow : Narrow
  default : Default
  wide : Wide
  ```
- **Default Value:** `default`
- **Allow Null:** 0

---

## Tab 2: Slider Settings

### 5. Slider Autoplay
- **Field Label:** Enable Autoplay
- **Field Name:** `slider_autoplay`
- **Field Type:** True / False
- **Default Value:** 1
- **Message:** Automatically advance slides
- **UI:** 1

### 6. Slider Autoplay Delay
- **Field Label:** Autoplay Delay (ms)
- **Field Name:** `slider_autoplay_delay`
- **Field Type:** Number
- **Default Value:** 5000
- **Min:** 1000
- **Max:** 10000
- **Step:** 500
- **Conditional Logic:** Show if `slider_autoplay` is equal to 1

### 7. Slider Loop
- **Field Label:** Enable Loop
- **Field Name:** `slider_loop`
- **Field Type:** True / False
- **Default Value:** 1
- **Message:** Loop back to first slide
- **UI:** 1

### 8. Slider Navigation
- **Field Label:** Show Navigation Arrows
- **Field Name:** `slider_navigation`
- **Field Type:** True / False
- **Default Value:** 1
- **Message:** Display prev/next arrows
- **UI:** 1

### 9. Slider Pagination
- **Field Label:** Show Pagination Dots
- **Field Name:** `slider_pagination`
- **Field Type:** True / False
- **Default Value:** 1
- **Message:** Display pagination bullets
- **UI:** 1

### 10. Slider Effect
- **Field Label:** Transition Effect
- **Field Name:** `slider_effect`
- **Field Type:** Select
- **Choices:**
  ```
  slide : Slide
  fade : Fade
  ```
- **Default Value:** `slide`
- **Allow Null:** 0

### 11. Text Alignment
- **Field Label:** Text Alignment
- **Field Name:** `text_alignment`
- **Field Type:** Select
- **Choices:**
  ```
  left : Left
  center : Center
  ```
- **Default Value:** `center`
- **Allow Null:** 0

### 12. Content Position
- **Field Label:** Vertical Position
- **Field Name:** `content_position`
- **Field Type:** Select
- **Choices:**
  ```
  top : Top
  center : Center
  bottom : Bottom
  ```
- **Default Value:** `center`
- **Allow Null:** 0

---

## Tab 3: Slides

### 13. Slides (Repeater)
- **Field Label:** Slides
- **Field Name:** `slides`
- **Field Type:** Repeater
- **Button Label:** Add Slide
- **Layout:** Block
- **Min Rows:** 1

#### Sub Fields:

##### 13a. Background Image
- **Field Label:** Background Image
- **Field Name:** `background_image`
- **Field Type:** Image
- **Return Format:** ID
- **Preview Size:** Medium
- **Instructions:** Full-width background image for this slide

##### 13b. Eyebrow
- **Field Label:** Eyebrow Text
- **Field Name:** `eyebrow`
- **Field Type:** Text
- **Placeholder:** NEW FEATURE
- **Instructions:** Small text above heading (optional)

##### 13c. Heading
- **Field Label:** Heading
- **Field Name:** `heading`
- **Field Type:** Text
- **Placeholder:** Your Amazing Headline
- **Required:** 1

##### 13d. Heading Tag
- **Field Label:** Heading Tag
- **Field Name:** `heading_tag`
- **Field Type:** Select
- **Choices:**
  ```
  h1 : H1
  h2 : H2
  h3 : H3
  ```
- **Default Value:** `h2`
- **Allow Null:** 0

##### 13e. Subheading
- **Field Label:** Subheading
- **Field Name:** `subheading`
- **Field Type:** Textarea
- **Rows:** 2
- **Placeholder:** A compelling subheading to support your message
- **Instructions:** Text below the heading

##### 13f. Content
- **Field Label:** Content
- **Field Name:** `content`
- **Field Type:** WYSIWYG Editor
- **Tabs:** Visual
- **Toolbar:** Basic
- **Media Upload:** 0
- **Instructions:** Additional text content (optional)

##### 13g. Buttons (Repeater)
- **Field Label:** Buttons
- **Field Name:** `buttons`
- **Field Type:** Repeater
- **Button Label:** Add Button
- **Layout:** Table
- **Min Rows:** 0
- **Max Rows:** 2

###### Button Sub Fields:

**13g-1. Link**
- **Field Label:** Link
- **Field Name:** `link`
- **Field Type:** Link
- **Return Format:** Array

**13g-2. Style**
- **Field Label:** Button Style
- **Field Name:** `style`
- **Field Type:** Select
- **Choices:**
  ```
  primary : Primary
  ghost : Ghost
  text : Text Link
  ```
- **Default Value:** `primary`

**13g-3. Size**
- **Field Label:** Button Size
- **Field Name:** `size`
- **Field Type:** Select
- **Choices:**
  ```
  default : Default
  small : Small
  ```
- **Default Value:** `default`

---

## Usage Instructions

### Adding the Block

1. In the WordPress editor, click the `+` button
2. Search for "Hero - Slider"
3. Add the block to your page

### Configuring the Slider

1. **Section Settings Tab:**
   - Choose background color (default, soft, dark, or brand)
   - Set vertical spacing (narrow, default, or spacious)
   - Set content width (narrow, default, or wide)

2. **Slider Settings Tab:**
   - Enable/disable autoplay
   - Set autoplay delay (1-10 seconds)
   - Enable/disable loop
   - Show/hide navigation arrows
   - Show/hide pagination dots
   - Choose transition effect (slide or fade)
   - Set text alignment (left or center)
   - Set vertical position (top, center, or bottom)

3. **Slides Tab:**
   - Click "Add Slide" to create a new slide
   - For each slide:
     - Upload a background image
     - Add eyebrow text (optional)
     - Add heading text (required)
     - Choose heading tag (H1, H2, or H3)
     - Add subheading (optional)
     - Add content in WYSIWYG editor (optional)
     - Add up to 2 buttons per slide
   - Repeat for additional slides

### Features

✅ **Swiper Library Integration** - Modern, touch-enabled slider
✅ **Multiple Transition Effects** - Slide or fade animations
✅ **Autoplay Support** - Automatic slide advancement
✅ **Navigation Controls** - Prev/next arrows and pagination dots
✅ **Responsive Design** - Optimized for all screen sizes
✅ **Content Animations** - Smooth fade-in effects for text
✅ **Background Images** - Full-width images with overlay
✅ **Flexible Positioning** - Align content vertically and horizontally
✅ **Accessibility** - Reduced motion support and focus styles
✅ **Foundation.css Integration** - Uses theme variables and styles

### Tips

- Use high-quality images (at least 1920x1080px) for best results
- Keep heading text concise for better readability
- Limit to 3-5 slides for optimal user experience
- Use contrasting text colors on background images
- Test autoplay timing with actual content
- Consider using fade effect for image-heavy sliders
- Use center alignment for hero sections
- Add buttons strategically (1-2 per slide maximum)

### Customization

The slider uses Swiper 11 and can be further customized by:
- Editing `/assets/css/blocks/hero-slider.css` for styling
- Modifying `/template-parts/blocks/hero-slider.php` for functionality
- Adjusting foundation.css variables for global changes

### Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Touch-enabled devices (iOS, Android)
- Keyboard navigation support
- Reduced motion preferences honored
