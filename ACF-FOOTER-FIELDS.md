# ACF Footer Settings Fields

These ACF fields need to be created in the WordPress admin under **Custom Fields > Add New** for the footer to work properly with theme settings.

## Field Group Settings

- **Field Group Title:** Footer Settings
- **Location:** Show this field group if:
  - Options Page is equal to `d1-general-settings`

---

## Fields to Create

### 1. Footer Style
- **Field Label:** Footer Style
- **Field Name:** `footer_style`
- **Field Type:** Radio Button
- **Choices:**
  ```
  default : Default (Full Width)
  compact : Compact
  ```
- **Default Value:** `default`
- **Layout:** Horizontal

---

### 2. Footer Background Color
- **Field Label:** Background Color
- **Field Name:** `footer_background_color`
- **Field Type:** Radio Button
- **Choices:**
  ```
  soft : Soft (Light Gray)
  dark : Dark
  brand : Brand Color
  ```
- **Default Value:** `soft`
- **Layout:** Horizontal

---

### 3. Footer Background Image
- **Field Label:** Background Image
- **Field Name:** `footer_background_image`
- **Field Type:** Image
- **Return Format:** Image ID
- **Preview Size:** Medium
- **Instructions:** Optional background image for the footer section

---

### 4. Footer Logo
- **Field Label:** Footer Logo
- **Field Name:** `footer_logo`
- **Field Type:** Image
- **Return Format:** Image ID
- **Preview Size:** Thumbnail
- **Instructions:** Upload a custom footer logo (optional, will use site title if not set)

---

### 5. Footer Tagline
- **Field Label:** Footer Tagline
- **Field Name:** `footer_tagline`
- **Field Type:** Textarea
- **Rows:** 3
- **Instructions:** Short description or tagline to display in the footer

---

### 6. Footer Phone
- **Field Label:** Phone Number
- **Field Name:** `footer_phone`
- **Field Type:** Text
- **Placeholder:** +1 (555) 123-4567
- **Instructions:** Contact phone number

---

### 7. Footer Email
- **Field Label:** Email Address
- **Field Name:** `footer_email`
- **Field Type:** Email
- **Placeholder:** hello@example.com
- **Instructions:** Contact email address

---

### 8. Footer Address
- **Field Label:** Address
- **Field Name:** `footer_address`
- **Field Type:** Text
- **Instructions:** Physical address or location

---

### 9. Show Social Links
- **Field Label:** Show Social Links
- **Field Name:** `footer_show_social`
- **Field Type:** True / False
- **Default Value:** 1 (Yes)
- **Message:** Display social media links in footer

---

### 10. Social Links
- **Field Label:** Social Links
- **Field Name:** `footer_social_links`
- **Field Type:** Repeater
- **Conditional Logic:** Show if `footer_show_social` is equal to 1
- **Button Label:** Add Social Link
- **Layout:** Table

#### Sub Fields:

##### 10a. Platform Name
- **Field Label:** Platform
- **Field Name:** `platform`
- **Field Type:** Text
- **Placeholder:** Facebook, Twitter, Instagram, etc.

##### 10b. Social URL
- **Field Label:** URL
- **Field Name:** `url`
- **Field Type:** URL
- **Placeholder:** https://

##### 10c. Icon (SVG or HTML)
- **Field Label:** Icon
- **Field Name:** `icon`
- **Field Type:** Textarea
- **Rows:** 3
- **Instructions:** Paste SVG code or icon HTML (e.g., `<svg>...</svg>`)

---

### 11. Footer Copyright Text
- **Field Label:** Copyright Text
- **Field Name:** `footer_copyright_text`
- **Field Type:** Text
- **Placeholder:** © 2024 Company Name. All rights reserved.
- **Instructions:** Custom copyright text (leave empty to use default)

---

## Menu Locations

The footer uses the following menu locations (already registered in the theme):

1. **Footer Column 1** (`footer_col_1`) - First footer navigation column
2. **Footer Column 2** (`footer_col_2`) - Second footer navigation column
3. **Footer Column 3** (`footer_col_3`) - Third footer navigation column
4. **Footer Bottom** (`footer_bottom`) - Bottom footer links (privacy, terms, etc.)

Assign menus to these locations at **Appearance > Menus**.

---

## Usage Example

After creating these ACF fields and assigning them to the General Settings options page:

1. Go to **Theme Settings > General Settings**
2. Configure your footer options
3. Upload a footer logo
4. Add your contact information
5. Add social media links with SVG icons
6. Create and assign footer menus at **Appearance > Menus**

The footer will automatically render based on these settings using the theme's foundation.css styling system.

---

## CSS Customization

The footer uses CSS variables from `foundation.css`:

- `--color-primary` - Primary brand color
- `--color-text-muted` - Muted text color
- `--space-*` - Spacing scale
- `--fs-*` - Font size scale
- `--transition-*` - Transition speeds

All footer styles are in `/assets/css/footer.css` and follow the same patterns as other theme components.
