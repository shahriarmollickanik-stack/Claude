# Drone Sark – One Click Setup Plugin
## Plug & Play Elementor Solution

---

## STEP-BY-STEP INSTALLATION (15 minutes total)

### Step 1 – Install Required Plugins
Go to **Plugins → Add New** and install:
- ✅ WooCommerce
- ✅ Elementor (free)
- ✅ Elementor Pro *(required for header/footer builder)*
- ✅ YITH WooCommerce Wishlist (free)

---

### Step 2 – Activate Drone Sark Theme
1. Go to **Appearance → Themes**
2. Click **Drone Sark** → Activate

---

### Step 3 – Run the One-Click Setup Plugin
1. Upload `drone-sark-setup/` folder to `/wp-content/plugins/`
2. Go to **Plugins** → Activate **Drone Sark – One Click Setup**
3. Go to **Tools → Drone Sark Setup**
4. Click **▶ Run Setup Now**

✅ This creates:
- Home V1 (Premium Brand) page — full Elementor layout
- Home V2 (Sales Focus) page — full Elementor layout
- Contact Us page — full Elementor layout
- Track Order page
- Primary navigation menu
- Elementor global colors (black/white palette)
- Elementor global typography (Inter font)

---

### Step 4 – Import Header & Footer in Elementor Pro

**Header:**
1. Elementor → Templates → Theme Builder
2. Add New → Header
3. Import icon (↑) → upload `elementor-header.json`
4. Apply to: All pages
5. Save

**Footer:**
1. Elementor → Templates → Theme Builder
2. Add New → Footer
3. Import icon (↑) → upload `elementor-footer.json`
4. Apply to: All pages
5. Save

---

### Step 5 – Set Homepage

1. **Settings → Reading**
2. Select **A static page**
3. Homepage: **Home – Premium Brand** *(or Home – Sales Focus)*
4. Save Changes

---

### Step 6 – Replace Placeholder Images

Open each page in Elementor and click any image marked **🔁 Replace with...**:
- Hero drone image (main visual)
- Repair service image
- Category images (set via WooCommerce → Categories → Edit → Thumbnail)

---

### Step 7 – Update Contact Info

**Appearance → Customize → Header Settings:**
- Phone number

**Appearance → Customize → Footer Settings:**
- Email, WhatsApp, Address, Social links

---

### Step 8 – Switch Homepage Version

**Option A — Via Customizer:**
- Appearance → Customize → Homepage Settings → Choose V1 or V2

**Option B — Via Elementor:**
- Settings → Reading → Change the Homepage page

---

## HOMEPAGE VERSIONS

| | Home V1 | Home V2 |
|--|---------|---------|
| Style | Dark hero, premium | White, sales-focused |
| Hero | Black bg, dramatic | White split layout |
| Products | 8 products grid | 12 products + Load More |
| Categories | Grid + subcategories | Simple 4-card row |
| Services | Repair + 4 service cards | — |
| Reviews | Auto-sliding ×4 | Auto-sliding ×4 |

---

## EDITING WITH ELEMENTOR

Every section is independent — just open the page in Elementor:

| Action | How |
|--------|-----|
| Edit text | Click any text → type |
| Replace image | Click any image → choose from media library |
| Change colors | Click element → Style tab → Color |
| Remove section | Right-click section → Delete |
| Reorder sections | Drag the ≡ handle |
| Add new section | Click + between sections |
| Make section full-width | Section → Layout → Content Width → Full Width |

---

## FILE STRUCTURE

```
drone-sark-setup/
├── drone-sark-setup.php    ← Main plugin (creates all pages)
├── elementor-header.json   ← Import as Elementor Header template
├── elementor-footer.json   ← Import as Elementor Footer template
└── README.md               ← This guide
```

---

## NEED HELP?

Contact: info@dronesark.com
