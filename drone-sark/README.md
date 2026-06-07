# Drone Sark – WordPress WooCommerce Theme

Premium black-and-white startup-tech eCommerce theme for Drone Sark.

## Requirements

- WordPress 6.0+
- PHP 8.0+
- WooCommerce 8.0+
- Elementor Pro (optional but recommended)

## Installation

1. Upload the `drone-sark/` folder to `/wp-content/themes/`
2. Activate the theme in **Appearance → Themes**
3. Install WooCommerce, Elementor Pro, and YITH WooCommerce Wishlist
4. Run the WooCommerce setup wizard
5. Go to **Appearance → Customize** to configure the theme

## Homepage Setup

### Choosing a homepage version

1. Go to **Appearance → Customize → Homepage Settings → Homepage Version**
2. Select **Version 1** (dark/premium hero) or **Version 2** (light/sales-focused)
3. Save changes

### Using Elementor templates (recommended)

1. Create a new Page (e.g. "Home")
2. Set the page template to **Homepage V1** or **Homepage V2** in the Page Attributes panel
3. Open in Elementor → edit each section freely
4. Set this page as the static front page in **Settings → Reading**

## Menus

1. Go to **Appearance → Menus**
2. Create and assign menus to:
   - **Primary Menu** – desktop navigation bar
   - **Mobile Menu** – mobile slide-in drawer

## Widgets

- **Shop Sidebar** – filter widgets for the shop page
- **Blog Sidebar** – widgets for blog/archive pages
- **Footer Columns 1–4** – footer content areas

## Theme Customizer Options

| Setting | Location |
|---------|----------|
| Homepage version | Homepage Settings |
| Header phone / announcement | Header Settings |
| Social links | Footer Settings |
| Contact info | Footer Settings |
| Copyright text | Footer Settings |
| Products per page | Shop Settings |
| Shop columns | Shop Settings |

## WooCommerce

- Install WooCommerce and run the setup wizard
- Assign products to categories: **Drones**, **Accessories & Parts**, **Repair**, **Other Services**
- Drone subcategories: **Toy Drones**, **Beginner Drones**, **Professional Drones**, **Industrial Drones**
- The shop sidebar supports: Category filter, Price filter, Rating filter, Attribute filter (all via WooCommerce widgets)

## Required Plugins

| Plugin | Purpose |
|--------|---------|
| WooCommerce | eCommerce core |
| Elementor Pro | Page builder |
| YITH WooCommerce Wishlist | Wishlist functionality |
| Contact Form 7 (optional) | Contact form on contact page |

## File Structure

```
drone-sark/
├── style.css                          # Theme header + base variables
├── functions.php                      # Theme bootstrap
├── header.php / footer.php            # Main layout wrappers
├── index.php                          # Blog/fallback template
├── page.php / single.php / archive.php
├── search.php / 404.php / comments.php
├── sidebar.php / sidebar-shop.php
├── inc/
│   ├── customizer.php                 # Theme Customizer
│   ├── elementor.php                  # Elementor Pro locations
│   ├── enqueue.php                    # Scripts & styles
│   ├── helpers.php                    # Helper functions + AJAX
│   ├── widgets.php                    # Widget areas
│   └── woocommerce.php                # WooCommerce hooks
├── template-parts/
│   ├── header/header-main.php         # Desktop + mobile header
│   ├── footer/footer-main.php         # Footer with all sections
│   ├── home/
│   │   ├── section-hero-v1.php        # Dark hero (V1)
│   │   ├── section-hero-v2.php        # Light hero (V2)
│   │   ├── section-categories.php     # Categories + subcategories
│   │   ├── section-categories-v2.php  # V2 category row
│   │   ├── section-accessories.php    # Accessories slider
│   │   ├── section-repair.php         # Repair banner
│   │   ├── section-services.php       # Other services grid
│   │   ├── section-all-products.php   # Products grid + load more
│   │   └── section-reviews.php        # Customer reviews slider
│   ├── content/content.php            # Blog post card
│   └── woocommerce/product-card.php   # Reusable product card
├── page-templates/
│   ├── home-v1.php                    # Homepage V1 template
│   ├── home-v2.php                    # Homepage V2 template
│   ├── contact.php                    # Contact Us page
│   └── track-order.php                # Track Order page
├── woocommerce/
│   ├── archive-product.php            # Shop page
│   ├── single-product.php             # Single product page
│   ├── content-product.php            # Product loop card
│   └── single-product/
│       └── content-single-product.php # Product details
├── assets/
│   ├── css/
│   │   ├── main.css                   # All theme styles
│   │   ├── elementor-compat.css       # Elementor overrides
│   │   └── admin.css                  # Admin styles
│   ├── js/
│   │   ├── main.js                    # Core JS (buy now, load more, cart)
│   │   ├── mobile-menu.js             # Mobile drawer + filter
│   │   ├── slider.js                  # Swiper sliders
│   │   └── shop-filter.js             # Shop filter helpers
│   └── images/
│       └── placeholder.svg
└── languages/
    └── drone-sark.pot
```

## Extending / Editing

All sections are modular. To customise with Elementor:

1. Open a homepage in Elementor
2. Each section is an independent Elementor Section/Container
3. Click any section to edit text, images, layout, spacing, or responsiveness
4. To remove a section: right-click → Delete Section
5. To reorder sections: drag-and-drop using the section handle

## Changelog

### 1.0.0
- Initial release
- Homepage V1 (dark/premium brand) and V2 (light/sales-focused)
- Full Elementor Pro compatibility with registered locations
- Mobile-first responsive design with bottom nav bar
- WooCommerce product cards, shop page, single product page
- Swiper-powered accessories and reviews sliders
- Customizer: homepage version switcher, header, footer, shop settings
