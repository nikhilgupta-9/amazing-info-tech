# Amazing Infotech Pvt. Ltd. — Web Architecture & Development Rules (`RULE.md`)

> **Document Version:** 1.0.0  
> **Last Updated:** October 2026  
> **Scope:** Entire Codebase (`amazinginfotech.in` / Local XAMPP Environment)  
> **Purpose:** This file defines the mandatory engineering, SEO, UI/UX, mobile-first responsiveness, and branding rules for the Amazing Infotech web platform. Any developer, AI agent, or administrator working on this project must strictly comply with these rules. This document can be updated over time to reflect evolving business priorities.

---

## 1. Global Favicon Standard (Rule #1)

Every public and admin page must display the official Amazing Infotech brand mark favicon in the browser tab, bookmarks, and mobile home screen shortcuts.

1. **Favicon Asset Path:**  
   - Master Favicon: `admin/uploads/fav_icon_image/1789609951-logo.jpg`
   - Root Fallback: `favicon.ico` and `favicon.png`
2. **Mandatory `<head>` Tags on Every Public Page:**
   ```html
   <!-- Official Amazing Infotech Favicon -->
   <link rel="icon" type="image/jpeg" href="<?= $site ?>admin/uploads/fav_icon_image/1789609951-logo.jpg">
   <link rel="shortcut icon" href="<?= $site ?>admin/uploads/fav_icon_image/1789609951-logo.jpg">
   <link rel="apple-touch-icon" href="<?= $site ?>admin/uploads/fav_icon_image/1789609951-logo.jpg">
   ```
3. **No Missing Favicons:** Direct browser requests to `/favicon.ico` or `/favicon.png` must resolve cleanly with HTTP 200 OK without triggering 404 logs.

---

## 2. SEO-Friendly Slug URLs & Apache Rewrite Rules (Rule #2)

All public endpoints must expose clean, descriptive, human-readable URLs without query string parameters like `?id=123` or `.php` extensions where possible.

1. **URL Patterns:**
   - **Product Details:** `/product-details/{product-slug}`  
     *Example:* `/product-details/hp-designjet-smart-tank-t858-36-in-printer`
   - **Category Listing:** `/products/{category-slug}` or `products.php?category={category-slug}`  
     *Example:* `/products/hp-designjet-printers`, `/products/hp-latex-printers`
   - **All Products (Unfiltered):** `/products.php` or `/products` (must never crash or show "Category not specified" — must render the full catalog with interactive category filter tabs).
   - **News & Events:** `/news-details/{news-slug}` and `/news-and-events.php`
   - **Location Landing Pages:** `/location/{city-slug}`  
     *Example:* `/location/hp-plotters-delhi-ncr`, `/location/hp-plotters-mumbai`
2. **Slug Generation Rules:**
   - Lowercase alphanumeric characters separated strictly by single hyphens (`-`).
   - Must contain primary keywords (e.g. `hp-designjet`, `plotter`, `printer`).
   - Avoid special characters (`&`, `%`, `+`, `_`, spaces).
3. **Canonical Link Tags:** Every page must include `<link rel="canonical" href="...">` pointing to its clean, canonical URL.

---

## 3. Mandatory Image Optimization & Descriptive ALT Tags (Rule #3)

Empty `alt=""` or generic placeholder attributes (`alt="img"`, `alt="image"`, `alt="banner"`) are **strictly prohibited**.

1. **ALT Tag Formula:**
   - **Product Thumbnails & Galleries:**  
     `alt="{Product Name} - HP Large-Format Plotter | Amazing Infotech Authorized Partner"`
   - **Company & Facility Images:**  
     `alt="Amazing Infotech - {Facility / Service / Award Description}"`
   - **Icons & Functional Visuals:**  
     Provide descriptive intent (e.g. `alt="HP Certified Plotter Repair Icon"`). If purely decorative, mark with `aria-hidden="true"` or an explicit descriptive role.
2. **Performance:**  
   - All below-the-fold images must specify `loading="lazy"` to preserve Core Web Vitals (LCP, FID, CLS).
   - Width and height or CSS aspect ratios must be specified to prevent Cumulative Layout Shift (CLS).

---

## 4. Location-Wise Promotion Engine — Delhi NCR & Metro Cities (Rule #4)

Local SEO and targeted regional visibility must be powered dynamically via a centralized, structured JSON configuration: **`data/locations.json`**.

1. **Primary Priority:** **Delhi NCR**  
   - New Delhi (Okhla Phase-2 Head Office & Experience Center)
   - Gurugram (Gurgaon AEC / Corporate Hub)
   - Noida / Greater Noida (IT & Manufacturing Corridors)
   - Faridabad & Ghaziabad (Industrial printing clusters)
2. **Secondary Priority:** **Metro Cities & Commercial Capitals**  
   - Mumbai (Andheri East Service Center & Showroom)
   - Bengaluru (Karnataka AEC, Tech & CAD Hub)
   - Pune (Kasba Peth Branch & Service Center)
   - Hyderabad (Telangana Architectural & GIS Hub)
   - Chennai (Automotive CAD & Textile Plotters)
   - Kolkata (Eastern India Regional Hub)
   - Ahmedabad (Textile & Industrial Signage Hub)
   - Lucknow (Uttar Pradesh State Capital Center)
3. **JSON Schema Requirements (`data/locations.json`):**
   - `city_id`, `city_name`, `slug`, `region`
   - `primary_focus` (`true` for Delhi NCR & Tier-1 Metros)
   - `service_sla` (e.g., "4-Hour On-Site Engineer Dispatch in Delhi NCR")
   - `address`, `contact_person`, `phone`, `email`
   - `target_keywords` (e.g., "HP Plotter Dealer in Delhi", "HP DesignJet Repair in Noida")
   - `recommended_models` (CAD AEC vs. High-Volume Latex vs. PageWide)
   - `schema_geo` (Latitude, Longitude, Postal Code for Google LocalBusiness Schema)

---

## 5. Mobile-First Responsiveness & Product Card Consistency (Rule #5)

The product listing on [`products.php`](file:///d:/xampp/htdocs/amazing/products.php) must strictly match the modern, interactive, high-converting product card standard established on [`index.php`](file:///d:/xampp/htdocs/amazing/index.php).

1. **Card Architecture:**
   - **Grid System:** `col-6 col-md-4 col-lg-3` (2-column layout on mobile screens, 3-column on tablets, 4-column on desktop).
   - **Badge:** Top-left badge (`HP Plotter`, `HP Latex`, `PageWide XL`).
   - **Quick Action:** Top-right floating WhatsApp inquiry button with pre-filled model name inquiry message.
   - **Image:** Clean, contained product visual with aspect ratio preserved, zero edge distortion, and descriptive `alt` attribute.
   - **Title:** 2-line clamped title with hover color transition to `--theme-color` (`#00B6B1`).
   - **Price Bar:** Bold Indian Rupee formatted value (`₹.../-`) or `Best Quote` pill.
   - **Action Button:** Circular or pill button linking directly to the product detail page.
2. **Zero Horizontal Overflow Rule:**
   - The document (`html`, `body`, `.main`) must never exceed the viewport width (`scrollWidth === clientWidth`).
   - No row may use unconstrained `g-5` on screens `< 992px`. Use `g-3 g-lg-4` or `g-4 g-lg-5`.
   - Never allow absolute/transformed elements to bleed past the viewport edge.

---

## 6. Security, Performance & Cache-Busting Standards (Rule #6)

1. **Security & Input Sanitization:**
   - All dynamic parameters (`$_GET['alias']`, `$_GET['category']`, search queries) must be sanitized with `mysqli_real_escape_string()` or prepared statements.
   - All output reflected in HTML must be escaped using `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')`.
2. **CSS & JS Versioning:**
   - All project-specific stylesheets and scripts must append automated file modification timestamps for cache-busting:
     `href="<?= $site ?>assets/css/modern-upgrade.css?v=<?= filemtime(__DIR__ . '/assets/css/modern-upgrade.css') ?>"`
3. **Database Portability:**
   - Database credentials and site URLs must strictly load through `conn.php` via environment variables (`.env`) to support seamless switching between local XAMPP and live production servers.

---

---

## 7. Dynamic Admin-Controlled Contact Settings (Rule #7)

Hardcoded static phone numbers, WhatsApp numbers, support numbers, or email addresses in page templates are **strictly prohibited**.

1. **Mandatory Dynamic Variables (from `users` table `id='1'` via `conn.php`):**
   - `$mobile` — Primary sales and mobile helpline (admin controlled)
   - `$whatsapp_number` — Official WhatsApp desk number (admin controlled)
   - `$customer_support_number` — Central office landline / customer support (admin controlled)
   - `$email` — Official corporate contact email (admin controlled)
   - `$enquiry_email` — Secondary / service operations email (admin controlled)
   - `$address` — Registered office address (admin controlled)
2. **Implementation Scope:**
   - Header topbar, mobile drawer, desktop floating widgets, sticky bottom docks.
   - Footer consultation strip, contact column, and quick inquiry buttons.
   - Product detail CTA action rows, WhatsApp quotation links, and call specialists.
   - Supplies & AMC Operations Desk and quotation booking triggers.
   - Schema.org JSON-LD structured data (`LocalBusiness.telephone`, `Service.provider`).

---

## 8. Change Log & Rule Updates

| Date | Version | Description | Maintained By |
| :--- | :--- | :--- | :--- |
| **Oct 2026** | **1.0.0** | Initial baseline rules: Favicon standard, SEO slugs, ALT tags, Locations JSON engine, and Product Card responsiveness. | Amazing Infotech Dev Team |
| **Oct 2026** | **1.1.0** | Phase 3 (Products & Product Details) & Phase 4 (Supplies & AMC Service) completed with 0px mobile overflow, B2B CTAs, Schema.org, and SLA matrix. | Amazing Infotech Dev Team |
| **Oct 2026** | **1.2.0** | Added Rule #7: Mandatory Dynamic Admin-Controlled Contact Settings. Zero static hardcoded numbers allowed anywhere in codebase. | Amazing Infotech Dev Team |

*Note: Edit this document whenever new design patterns, business cities, or technical policies are approved.*
