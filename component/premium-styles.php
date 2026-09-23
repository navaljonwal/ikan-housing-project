<style>
/* ==========================================================================
   💎 IKAN HOUSING — ULTRA-LUXURY REAL ESTATE PORTAL DESIGN SYSTEM
   Modern, cohesive, high-conversion property details theme
   ========================================================================== */

@import url('https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');

/* Universal Font & Element Reset */
#propertyDetailPage,
.premium-hero-header,
.property-section,
.property-actions-toolbar,
.property-subnav-bar,
.emi-card-premium,
.modal-site-visit,
.sidebar-sticky,
.mobile-sticky-actionbar {
  font-family: 'Outfit', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
  box-sizing: border-box;
}

/* Neutralize legacy rk.css artifacts */
.rtyu {
  box-shadow: none !important;
  padding: 0 !important;
}

.why-box {
  background: transparent !important;
  border-left: none !important;
  padding: 0 !important;
  border-radius: 0 !important;
}

.why-box h3 {
  color: #0f172a !important;
}

/* 🌟 Section Headings (Luxury Editorial Style) */
.section-title-luxury {
  font-size: 1.5rem !important;
  font-weight: 800 !important;
  color: #0f172a !important;
  letter-spacing: -0.02em !important;
  margin-bottom: 6px !important;
  display: flex !important;
  align-items: center !important;
  gap: 10px !important;
}

.section-subtitle-luxury {
  color: #64748b !important;
  font-size: 14px !important;
  margin-bottom: 22px !important;
}

.heading-accent-bar {
  display: inline-block;
  width: 5px;
  height: 22px;
  background: linear-gradient(180deg, #c02a7c 0%, #ec4899 100%);
  border-radius: 4px;
}

/* 🏛️ Hero Header Section */
.premium-hero-header {
  padding: 100px 0 24px !important;
  background: #ffffff !important;
  border-bottom: 1px solid #edf2f7 !important;
}

.property-breadcrumb {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 8px;
  font-size: 13px;
  color: #64748b;
  margin-bottom: 14px;
  font-weight: 500;
}

.property-breadcrumb a {
  color: #64748b;
  text-decoration: none;
  transition: color 0.2s ease;
}

.property-breadcrumb a:hover {
  color: #c02a7c;
}

.property-breadcrumb .separator {
  color: #cbd5e1;
  font-size: 11px;
}

.property-breadcrumb .current {
  color: #0f172a;
  font-weight: 600;
}

.project-title {
  font-size: clamp(1.8rem, 3.5vw, 2.4rem) !important;
  font-weight: 850 !important;
  color: #0f172a !important;
  letter-spacing: -0.025em !important;
  line-height: 1.2 !important;
  margin-bottom: 10px !important;
}

.project-meta-row {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 16px;
  font-size: 14px;
  color: #475569;
  font-weight: 500;
  margin-bottom: 14px;
}

.project-meta-item {
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.project-meta-item i {
  color: #c02a7c;
  font-size: 15px;
}

.project-meta-item a {
  color: #0f172a;
  font-weight: 700;
  text-decoration: none;
}

.project-meta-item a:hover {
  color: #c02a7c;
}

/* Luxury Badges in Hero */
.badge-pill-luxury {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 14px;
  border-radius: 30px;
  font-size: 12.5px;
  font-weight: 700;
  letter-spacing: 0.2px;
}

.badge-pill-rera {
  background: #f0fdf4;
  color: #166534;
  border: 1px solid #bbf7d0;
}

.badge-pill-status {
  background: #eff6ff;
  color: #1d4ed8;
  border: 1px solid #bfdbfe;
}

.badge-pill-neutral {
  background: #f8fafc;
  color: #475569;
  border: 1px solid #e2e8f0;
}

/* Price Card in Hero */
.hero-price-card {
  background: linear-gradient(135deg, #fff5f9 0%, #ffffff 100%);
  border: 1.5px solid #fbcfe8;
  border-radius: 18px;
  padding: 16px 22px;
  text-align: right;
  display: inline-block;
  box-shadow: 0 4px 20px rgba(192, 42, 124, 0.06);
}

.hero-price-label {
  font-size: 12px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: #94a3b8;
  margin-bottom: 2px;
}

.hero-price-value {
  font-size: clamp(1.6rem, 2.5vw, 2.2rem);
  font-weight: 850;
  color: #c02a7c;
  letter-spacing: -0.02em;
  line-height: 1.1;
  white-space: nowrap;
}

.hero-price-emi {
  font-size: 12px;
  color: #64748b;
  font-weight: 600;
  margin-top: 4px;
}

.hero-price-emi a {
  color: #c02a7c;
  text-decoration: underline;
  font-weight: 700;
}

/* 🖼️ Premium Gallery System */
.gallery-wrapper {
  position: relative;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 15px 40px rgba(15, 23, 42, 0.08);
  margin-top: 20px;
  background: #0f172a;
}

.gallery-grid-premium {
  display: grid;
  gap: 10px;
}

.gallery-img-bx {
  position: relative;
  overflow: hidden;
  cursor: pointer;
}

.gallery-img-bx img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.7s cubic-bezier(0.165, 0.84, 0.44, 1);
  display: block;
}

.gallery-img-bx:hover img {
  transform: scale(1.04);
}

.badge-verified-float {
  position: absolute;
  top: 18px;
  left: 18px;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(8px);
  color: #16a34a;
  padding: 7px 15px;
  border-radius: 30px;
  font-weight: 800;
  font-size: 12px;
  display: flex;
  align-items: center;
  gap: 6px;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
  z-index: 10;
  letter-spacing: 0.3px;
}

.featured-price-tag {
  position: absolute;
  bottom: 18px;
  left: 18px;
  background: linear-gradient(135deg, #c02a7c 0%, #991b5b 100%);
  color: white;
  padding: 6px 14px;
  border-radius: 10px;
  font-weight: 700;
  font-size: 12.5px;
  z-index: 10;
  box-shadow: 0 4px 15px rgba(192, 42, 124, 0.4);
}

.g-view-more {
  position: absolute;
  inset: 0;
  background: rgba(15, 23, 42, 0.65);
  backdrop-filter: blur(5px);
  color: white;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 1rem;
  transition: all 0.3s ease;
  z-index: 5;
}

.g-view-more i {
  font-size: 1.6rem;
  margin-bottom: 6px;
}

.gallery-img-bx:hover .g-view-more {
  background: rgba(15, 23, 42, 0.8);
}

.gallery-grid-1 { grid-template-columns: 1fr; aspect-ratio: 2.33/1; }
.gallery-grid-2 { grid-template-columns: 1fr 1fr; aspect-ratio: 2.33/1; }
.gallery-grid-3 { grid-template-columns: 2fr 1fr; grid-template-rows: 1fr 1fr; aspect-ratio: 2.33/1; }
.gallery-grid-3 .g-main { grid-row: span 2; }
.gallery-grid-4 { grid-template-columns: 2fr 1fr 1fr; grid-template-rows: 1fr 1fr; aspect-ratio: 2.33/1; }
.gallery-grid-4 .g-main { grid-row: span 2; }
.gallery-grid-4 .gallery-img-bx:nth-child(2) { grid-column: span 2; }

.gallery-grid-5, .gallery-grid-default { 
  grid-template-columns: 2fr 1.1fr 1.1fr; 
  grid-template-rows: 1fr 1fr; 
  aspect-ratio: 2.33/1; 
}
.g-main { grid-row: span 2; }

/* Mobile Slider (Swiper) */
.mobile-gallery-swiper {
  display: none;
  border-radius: 20px;
  overflow: hidden;
  height: 320px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  position: relative;
}

.mobile-gallery-swiper .swiper-slide {
  height: 100%;
}

.mobile-gallery-swiper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.gallery-count-chip {
  position: absolute;
  bottom: 16px;
  right: 16px;
  background: rgba(15, 23, 42, 0.75);
  backdrop-filter: blur(8px);
  color: white;
  padding: 5px 12px;
  border-radius: 30px;
  font-size: 12px;
  font-weight: 700;
  z-index: 10;
}

.swiper-pagination-premium {
  bottom: 16px !important;
}

.swiper-pagination-premium .swiper-pagination-bullet {
  background: white;
  opacity: 0.6;
  width: 7px;
  height: 7px;
  transition: all 0.3s ease;
}

.swiper-pagination-premium .swiper-pagination-bullet-active {
  opacity: 1;
  background: white;
  width: 22px;
  border-radius: 10px;
}

/* 🎯 High-Converting Action Toolbar (Directly Below Gallery) */
.property-actions-container {
  margin-top: 18px;
}

.property-actions-toolbar {
  display: flex !important;
  align-items: center !important;
  justify-content: space-between !important;
  flex-wrap: wrap !important;
  gap: 12px !important;
  background: #ffffff !important;
  padding: 12px 18px !important;
  border-radius: 20px !important;
  border: 1.5px solid #edf2f7 !important;
  box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04) !important;
}

.actions-group-primary {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
}

.actions-group-secondary {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
}

.btn-action-primary {
  background: linear-gradient(135deg, #c02a7c 0%, #991b5b 100%) !important;
  color: #ffffff !important;
  border: none !important;
  font-weight: 700 !important;
  font-size: 14px !important;
  padding: 11px 22px !important;
  border-radius: 14px !important;
  box-shadow: 0 4px 15px rgba(192, 42, 124, 0.3) !important;
  display: inline-flex !important;
  align-items: center !important;
  gap: 8px !important;
  cursor: pointer !important;
  transition: all 0.25s ease !important;
  text-decoration: none !important;
}

.btn-action-primary:hover {
  transform: translateY(-2px) !important;
  box-shadow: 0 6px 20px rgba(192, 42, 124, 0.45) !important;
  color: #ffffff !important;
}

.btn-action-whatsapp {
  background: #f0fdf4 !important;
  border: 1.5px solid #bbf7d0 !important;
  color: #166534 !important;
  font-weight: 700 !important;
  font-size: 14px !important;
  padding: 11px 20px !important;
  border-radius: 14px !important;
  display: inline-flex !important;
  align-items: center !important;
  gap: 8px !important;
  cursor: pointer !important;
  transition: all 0.25s ease !important;
  text-decoration: none !important;
}

.btn-action-whatsapp:hover {
  background: #dcfce7 !important;
  border-color: #86efac !important;
  transform: translateY(-2px) !important;
  color: #14532d !important;
}

.btn-action-brochure {
  background: #f8fafc !important;
  border: 1.5px solid #e2e8f0 !important;
  color: #334155 !important;
  font-weight: 700 !important;
  font-size: 14px !important;
  padding: 11px 18px !important;
  border-radius: 14px !important;
  display: inline-flex !important;
  align-items: center !important;
  gap: 8px !important;
  cursor: pointer !important;
  transition: all 0.2s ease !important;
  text-decoration: none !important;
}

.btn-action-brochure:hover {
  background: #f1f5f9 !important;
  border-color: #cbd5e1 !important;
  color: #0f172a !important;
}

.btn-action-pill {
  background: #f8fafc !important;
  border: 1.5px solid #e2e8f0 !important;
  color: #475569 !important;
  font-weight: 600 !important;
  font-size: 13.5px !important;
  padding: 10px 16px !important;
  border-radius: 14px !important;
  display: inline-flex !important;
  align-items: center !important;
  gap: 8px !important;
  cursor: pointer !important;
  transition: all 0.2s ease !important;
  text-decoration: none !important;
}

.btn-action-pill:hover {
  background: #f1f5f9 !important;
  border-color: #cbd5e1 !important;
  color: #0f172a !important;
}

/* 🧭 Sticky Quick Anchor Navigation Sub-Bar */
.property-subnav-sticky {
  position: -webkit-sticky;
  position: sticky;
  top: 72px;
  z-index: 95;
  background: rgba(255, 255, 255, 0.94);
  backdrop-filter: blur(12px);
  border-bottom: 1px solid #edf2f7;
  padding: 10px 0;
  box-shadow: 0 4px 15px rgba(15, 23, 42, 0.03);
  margin-bottom: 25px;
}

.subnav-scroll-wrap {
  display: flex;
  align-items: center;
  gap: 8px;
  overflow-x: auto;
  scrollbar-width: none;
  -ms-overflow-style: none;
  padding: 2px 0;
}

.subnav-scroll-wrap::-webkit-scrollbar {
  display: none;
}

.subnav-link {
  white-space: nowrap;
  padding: 8px 16px;
  border-radius: 30px;
  font-size: 13.5px;
  font-weight: 600;
  color: #64748b;
  text-decoration: none;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.subnav-link:hover {
  color: #0f172a;
  background: #f1f5f9;
}

.subnav-link.active {
  background: #fff0f6;
  color: #c02a7c;
  font-weight: 700;
}

/* 🍱 Bento Property Overview Grid */
.bento-overview-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 14px;
  margin-bottom: 28px;
}

.bento-card {
  background: #ffffff;
  border: 1px solid #edf2f7;
  border-radius: 18px;
  padding: 16px;
  display: flex;
  align-items: center;
  gap: 14px;
  transition: all 0.25s ease;
  box-shadow: 0 2px 8px rgba(15, 23, 42, 0.02);
}

.bento-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
  border-color: #fbcfe8;
}

.bento-icon-circle {
  width: 46px;
  height: 46px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  flex-shrink: 0;
}

/* Dynamic soft pastel colors for bento icons */
.bento-icon-status { background: #eff6ff; color: #2563eb; }
.bento-icon-bhk { background: #faf5ff; color: #7c3aed; }
.bento-icon-carpet { background: #ecfdf5; color: #059669; }
.bento-icon-buildup { background: #fff7ed; color: #ea580c; }
.bento-icon-price { background: #fff1f2; color: #e11d48; }
.bento-icon-possession { background: #fdf2f8; color: #c02a7c; }
.bento-icon-furnish { background: #f0fdfa; color: #0d9488; }
.bento-icon-category { background: #fefce8; color: #ca8a04; }
.bento-icon-rera { background: #f0fdf4; color: #16a34a; }

.bento-label {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  color: #64748b;
  margin-bottom: 2px;
}

.bento-value {
  font-size: 14.5px;
  font-weight: 800;
  color: #0f172a;
  margin: 0;
  line-height: 1.2;
}

/* 📄 About Project Content Card */
.content-card-luxury {
  background: #ffffff;
  border-radius: 20px;
  border: 1px solid #edf2f7;
  padding: 28px;
  margin-bottom: 28px;
  box-shadow: 0 4px 20px rgba(15, 23, 42, 0.02);
}

.property-rich-desc {
  color: #334155;
  line-height: 1.8;
  font-size: 15px;
  word-break: break-word;
}

.property-rich-desc p {
  margin-bottom: 14px;
}

/* Polished Table for Admin Content */
.property-rich-desc table {
  width: 100% !important;
  border-collapse: separate !important;
  border-spacing: 0 !important;
  border: 1px solid #e2e8f0 !important;
  border-radius: 16px !important;
  overflow: hidden !important;
  margin: 18px 0 24px !important;
  background: #ffffff !important;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02) !important;
}

.property-rich-desc table tr {
  border-bottom: 1px solid #f1f5f9 !important;
  transition: background 0.15s ease !important;
}

.property-rich-desc table tr:last-child {
  border-bottom: none !important;
}

.property-rich-desc table tr:hover {
  background: #fffafc !important;
}

.property-rich-desc table td,
.property-rich-desc table th {
  padding: 13px 20px !important;
  font-size: 14px !important;
  color: #334155 !important;
  border: none !important;
  border-bottom: 1px solid #f1f5f9 !important;
  vertical-align: middle !important;
}

.property-rich-desc table td:first-child,
.property-rich-desc table th:first-child {
  font-weight: 700 !important;
  color: #475569 !important;
  width: 32% !important;
  background: #f8fafc !important;
  border-right: 1px solid #f1f5f9 !important;
}

.property-rich-desc table td:last-child {
  font-weight: 600 !important;
  color: #0f172a !important;
}

/* 💎 Brochure Download Card */
.brochure-card-premium {
  background: linear-gradient(135deg, #fdf2f8 0%, #f8fafc 100%) !important;
  border-radius: 18px !important;
  border: 1.5px solid #fce7f3 !important;
  padding: 22px !important;
  display: flex !important;
  align-items: center !important;
  gap: 18px !important;
  margin-top: 24px !important;
}

.brochure-icon-badge {
  width: 54px;
  height: 54px;
  background: #ffffff;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 6px 16px rgba(192, 42, 124, 0.12);
  flex-shrink: 0;
  font-size: 26px;
  color: #ef4444;
}

.btn-premium-brochure {
  background: linear-gradient(135deg, #c02a7c 0%, #991b5b 100%) !important;
  color: #ffffff !important;
  padding: 11px 22px !important;
  border-radius: 12px !important;
  text-decoration: none !important;
  font-weight: 700 !important;
  font-size: 13.5px !important;
  transition: all 0.25s ease !important;
  box-shadow: 0 4px 12px rgba(192, 42, 124, 0.3) !important;
  white-space: nowrap !important;
}

.btn-premium-brochure:hover {
  transform: translateY(-2px) !important;
  box-shadow: 0 6px 18px rgba(192, 42, 124, 0.45) !important;
  color: #ffffff !important;
}

/* ✨ Highlights & Connectivity Cards */
.highlights-grid-container {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 12px;
}

.highlight-item-card {
  background: #f8fafc;
  border: 1px solid #edf2f7;
  border-radius: 14px;
  padding: 13px 16px;
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 14px;
  font-weight: 600;
  color: #1e293b;
  transition: all 0.2s ease;
}

.highlight-item-card:hover {
  background: #ffffff;
  border-color: #fbcfe8;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.03);
}

.highlight-icon-check {
  width: 26px;
  height: 26px;
  border-radius: 50%;
  background: #fdf2f8;
  color: #c02a7c;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  flex-shrink: 0;
}

/* 🏊 Amenities Premium Grid */
.amenities-premium-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  gap: 14px;
}

.amenity-premium-badge {
  background: #ffffff;
  border: 1.5px solid #edf2f7;
  padding: 14px;
  border-radius: 16px;
  display: flex;
  align-items: center;
  gap: 12px;
  transition: all 0.2s ease;
  box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
}

.amenity-premium-badge:hover {
  background: #fffafc;
  border-color: #fbcfe8;
  transform: translateY(-2px);
  box-shadow: 0 8px 18px rgba(192, 42, 124, 0.08);
}

.amenity-premium-badge img {
  width: 28px;
  height: 28px;
  object-fit: contain;
  flex-shrink: 0;
}

.amenity-premium-badge span {
  font-size: 13.5px;
  font-weight: 700;
  color: #1e293b;
  line-height: 1.2;
}

/* 📐 Floor Plans (Magenta Modern Switcher) */
.floorplan-card-luxury {
  background: #ffffff;
  border-radius: 20px;
  border: 1px solid #edf2f7;
  padding: 28px;
  margin-bottom: 28px;
  box-shadow: 0 4px 20px rgba(15, 23, 42, 0.02);
}

.rd-flore-pland {
  margin-top: 0 !important;
  background: transparent !important;
  border: none !important;
  padding: 0 !important;
  box-shadow: none !important;
}

.rd-bhk-buttons {
  display: flex !important;
  gap: 10px !important;
  flex-wrap: wrap !important;
  margin-bottom: 22px !important;
}

.rd-bhk-buttons button {
  padding: 10px 24px !important;
  border: 1.5px solid #e2e8f0 !important;
  border-radius: 30px !important;
  background: #f8fafc !important;
  color: #475569 !important;
  font-weight: 700 !important;
  font-size: 14px !important;
  cursor: pointer !important;
  transition: all 0.25s ease !important;
}

.rd-bhk-buttons button:hover {
  background: #f1f5f9 !important;
  border-color: #cbd5e1 !important;
  color: #0f172a !important;
}

.rd-bhk-buttons button.active {
  background: linear-gradient(135deg, #c02a7c 0%, #991b5b 100%) !important;
  color: #ffffff !important;
  border-color: #c02a7c !important;
  box-shadow: 0 4px 14px rgba(192, 42, 124, 0.3) !important;
  transform: none !important;
}

.rd-slider {
  position: relative !important;
  overflow: hidden !important;
  border-radius: 16px !important;
  display: none !important;
  background: #f8fafc !important;
  border: 1px solid #e2e8f0 !important;
  min-height: 380px !important;
}

.rd-slider.active {
  display: block !important;
}

.rd-slides {
  display: flex !important;
  transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
  width: 100% !important;
}

.rd-slides img {
  width: 100% !important;
  flex: 0 0 100% !important;
  max-height: 480px !important;
  object-fit: contain !important;
  padding: 20px !important;
  background: #ffffff !important;
}

.rd-arrow {
  position: absolute !important;
  top: 50% !important;
  transform: translateY(-50%) !important;
  background: rgba(15, 23, 42, 0.75) !important;
  color: #ffffff !important;
  border: none !important;
  width: 42px !important;
  height: 42px !important;
  border-radius: 50% !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  cursor: pointer !important;
  z-index: 10 !important;
  transition: all 0.2s ease !important;
}

.rd-arrow:hover {
  background: #c02a7c !important;
  transform: translateY(-50%) scale(1.1) !important;
}

/* 🧮 Interactive Home Loan EMI Calculator */
.emi-card-premium {
  background: #ffffff !important;
  border-radius: 24px !important;
  border: 1px solid #edf2f7 !important;
  padding: 32px !important;
  box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04) !important;
  margin-bottom: 28px !important;
}

.emi-section-badge {
  display: inline-block !important;
  font-size: 11px !important;
  font-weight: 800 !important;
  letter-spacing: 1.5px !important;
  text-transform: uppercase !important;
  color: #c02a7c !important;
  margin-bottom: 4px !important;
}

.emi-section-title {
  font-size: 1.45rem !important;
  font-weight: 800 !important;
  color: #0f172a !important;
  margin: 0 !important;
  display: flex !important;
  align-items: center !important;
  gap: 10px !important;
}

.emi-section-subtitle {
  color: #64748b !important;
  font-size: 13.5px !important;
  margin: 4px 0 0 !important;
}

.emi-rate-pill {
  background: #fdf2f8 !important;
  color: #c02a7c !important;
  border: 1.5px solid #fbcfe8 !important;
  padding: 6px 14px !important;
  border-radius: 30px !important;
  font-size: 12px !important;
  font-weight: 700 !important;
}

.emi-slider-wrap {
  margin-bottom: 24px !important;
}

.emi-label-row {
  display: flex !important;
  justify-content: space-between !important;
  align-items: center !important;
  width: 100% !important;
  margin-bottom: 6px !important;
}

.emi-label-title {
  font-size: 12.5px !important;
  font-weight: 700 !important;
  color: #475569 !important;
  text-transform: uppercase !important;
  letter-spacing: 0.5px !important;
}

.emi-val-pill {
  font-size: 16px !important;
  font-weight: 800 !important;
  color: #0f172a !important;
  background: #f8fafc !important;
  border: 1px solid #e2e8f0 !important;
  padding: 3px 12px !important;
  border-radius: 8px !important;
}

.emi-slider {
  -webkit-appearance: none !important;
  appearance: none !important;
  width: 100% !important;
  height: 7px !important;
  border-radius: 10px !important;
  background: #e2e8f0 !important;
  outline: none !important;
  margin: 12px 0 10px !important;
  cursor: pointer !important;
}

.emi-slider::-webkit-slider-thumb {
  -webkit-appearance: none !important;
  appearance: none !important;
  width: 22px !important;
  height: 22px !important;
  border-radius: 50% !important;
  background: #c02a7c !important;
  cursor: pointer !important;
  box-shadow: 0 0 0 4px rgba(192, 42, 124, 0.2) !important;
  border: 2px solid #ffffff !important;
  transition: transform 0.15s ease, box-shadow 0.15s ease !important;
}

.emi-slider::-webkit-slider-thumb:hover {
  transform: scale(1.15) !important;
  box-shadow: 0 0 0 6px rgba(192, 42, 124, 0.28) !important;
}

.emi-slider::-moz-range-thumb {
  width: 22px !important;
  height: 22px !important;
  border-radius: 50% !important;
  background: #c02a7c !important;
  cursor: pointer !important;
  box-shadow: 0 0 0 4px rgba(192, 42, 124, 0.2) !important;
  border: 2px solid #ffffff !important;
}

.emi-quick-btn {
  font-size: 11.5px !important;
  font-weight: 600 !important;
  background: #f8fafc !important;
  color: #475569 !important;
  border: 1px solid #e2e8f0 !important;
  border-radius: 20px !important;
  padding: 3px 11px !important;
  cursor: pointer !important;
  transition: all 0.2s ease !important;
  outline: none !important;
}

.emi-quick-btn:hover {
  background: #fff0f6 !important;
  color: #c02a7c !important;
  border-color: #fbcfe8 !important;
  font-weight: 700 !important;
}

/* Dark Slate Luxury Result Panel */
.emi-result-panel {
  background: linear-gradient(150deg, #1e293b 0%, #0f172a 100%) !important;
  border-radius: 20px !important;
  border: 1px solid #334155 !important;
  padding: 26px !important;
  color: #ffffff !important;
  display: flex !important;
  flex-direction: column !important;
  justify-content: space-between !important;
  height: 100% !important;
  box-shadow: 0 15px 35px -5px rgba(15, 23, 42, 0.25) !important;
}

.emi-result-panel .emi-card-lbl {
  font-size: 11.5px !important;
  font-weight: 700 !important;
  text-transform: uppercase !important;
  letter-spacing: 1px !important;
  color: #94a3b8 !important;
  margin-bottom: 2px !important;
}

.emi-highlight-amount {
  font-size: 2.2rem !important;
  font-weight: 850 !important;
  color: #f472b6 !important;
  line-height: 1.1 !important;
  letter-spacing: -0.02em !important;
}

.emi-sub-duration {
  color: #94a3b8 !important;
  font-size: 12.5px !important;
  margin-top: 2px !important;
}

.emi-breakup-bar {
  display: flex !important;
  height: 10px !important;
  border-radius: 8px !important;
  overflow: hidden !important;
  margin: 16px 0 10px !important;
  background: #334155 !important;
}

.emi-bar-principal {
  background: #38bdf8 !important;
  transition: width 0.3s ease !important;
}

.emi-bar-interest {
  background: #ec4899 !important;
  transition: width 0.3s ease !important;
}

.emi-breakdown-row {
  display: flex !important;
  justify-content: space-between !important;
  padding: 5px 0 !important;
  font-size: 13px !important;
}

.emi-breakdown-row .lbl {
  color: #94a3b8 !important;
}

.emi-breakdown-row .val {
  font-weight: 700 !important;
  color: #ffffff !important;
}

.emi-breakdown-row.total-row {
  border-top: 1px solid #334155 !important;
  margin-top: 6px !important;
  padding-top: 8px !important;
  font-size: 13.5px !important;
}

.emi-breakdown-row.total-row .val {
  color: #38bdf8 !important;
  font-size: 15.5px !important;
  font-weight: 800 !important;
}

.btn-emi-cta {
  background: linear-gradient(135deg, #c02a7c 0%, #ec4899 100%) !important;
  color: #ffffff !important;
  font-weight: 700 !important;
  font-size: 13.5px !important;
  border-radius: 12px !important;
  padding: 12px 18px !important;
  border: none !important;
  text-decoration: none !important;
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  box-shadow: 0 4px 16px rgba(192, 42, 124, 0.4) !important;
  transition: all 0.25s ease !important;
  width: 100% !important;
  margin-top: 14px !important;
}

.btn-emi-cta:hover {
  transform: translateY(-2px) !important;
  box-shadow: 0 8px 22px rgba(192, 42, 124, 0.5) !important;
  color: #ffffff !important;
}

/* 📍 Map Card */
.map-card-luxury {
  background: #ffffff;
  border-radius: 20px;
  border: 1px solid #edf2f7;
  padding: 26px;
  margin-bottom: 28px;
  box-shadow: 0 4px 20px rgba(15, 23, 42, 0.02);
}

.map-iframe-container {
  width: 100% !important;
  height: 380px !important;
  border-radius: 16px !important;
  overflow: hidden !important;
  background: #f1f5f9 !important;
  border: 1px solid #e2e8f0 !important;
}

.map-iframe-container iframe {
  width: 100% !important;
  height: 100% !important;
  border: none !important;
}

/* 📌 High-Conversion Sticky Contact Sidebar */
.sidebar-sticky {
  position: -webkit-sticky !important;
  position: sticky !important;
  top: 90px !important;
  z-index: 20 !important;
}

.luxury-sidebar-card {
  background: #ffffff !important;
  border-radius: 24px !important;
  border: 1px solid #edf2f7 !important;
  padding: 26px !important;
  box-shadow: 0 15px 35px rgba(15, 23, 42, 0.06) !important;
}

.badge-sidebar-demand {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: #fff1f2;
  color: #e11d48;
  padding: 5px 12px;
  border-radius: 30px;
  font-size: 11.5px;
  font-weight: 700;
  margin-bottom: 16px;
}

.sidebar-agency-profile {
  background: #f8fafc;
  border: 1px solid #edf2f7;
  border-radius: 16px;
  padding: 14px;
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 20px;
}

.sidebar-agency-avatar {
  width: 44px;
  height: 44px;
  background: linear-gradient(135deg, #c02a7c 0%, #991b5b 100%);
  color: white;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  flex-shrink: 0;
}

.sidebar-form-group {
  margin-bottom: 14px;
}

.sidebar-input-wrap {
  position: relative;
}

.sidebar-input-icon {
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: #94a3b8;
  font-size: 14px;
}

.sidebar-input {
  width: 100%;
  height: 46px;
  padding: 8px 14px 8px 38px;
  border: 1.5px solid #e2e8f0;
  border-radius: 12px;
  font-size: 13.5px;
  font-weight: 500;
  color: #0f172a;
  background: #f8fafc;
  transition: all 0.2s ease;
  outline: none;
}

.sidebar-input:focus {
  background: #ffffff;
  border-color: #c02a7c;
  box-shadow: 0 0 0 3px rgba(192, 42, 124, 0.12);
}

.btn-sidebar-submit {
  width: 100%;
  padding: 13px;
  background: linear-gradient(135deg, #c02a7c 0%, #991b5b 100%);
  color: #ffffff !important;
  border: none;
  border-radius: 12px;
  font-weight: 700;
  font-size: 15px;
  cursor: pointer;
  transition: all 0.25s ease;
  box-shadow: 0 4px 14px rgba(192, 42, 124, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  text-decoration: none;
}

.btn-sidebar-submit:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(192, 42, 124, 0.45);
}

.sidebar-dual-actions {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
  margin-top: 14px;
  padding-top: 14px;
  border-top: 1px solid #edf2f7;
}

.sidebar-btn-visit {
  background: #fff0f6;
  border: 1.5px solid #fbcfe8;
  color: #c02a7c;
  font-weight: 700;
  font-size: 13px;
  padding: 10px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  text-decoration: none;
  transition: all 0.2s ease;
  cursor: pointer;
}

.sidebar-btn-visit:hover {
  background: #fce7f3;
  color: #991b5b;
}

.sidebar-btn-whatsapp {
  background: #f0fdf4;
  border: 1.5px solid #bbf7d0;
  color: #166534;
  font-weight: 700;
  font-size: 13px;
  padding: 10px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  text-decoration: none;
  transition: all 0.2s ease;
}

.sidebar-btn-whatsapp:hover {
  background: #dcfce7;
  color: #14532d;
}

.sidebar-trust-box {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  margin-top: 16px;
  font-size: 11.5px;
  color: #64748b;
  font-weight: 600;
}

/* 📱 Mobile Bottom Sticky Bar */
.mobile-sticky-actionbar {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(255, 255, 255, 0.98);
  backdrop-filter: blur(12px);
  border-top: 1px solid #e2e8f0;
  padding: 10px 16px;
  z-index: 1000;
  box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
}

.mobile-sticky-price {
  line-height: 1.2;
}

.mobile-sticky-price .lbl {
  font-size: 10px;
  text-transform: uppercase;
  color: #64748b;
  font-weight: 700;
}

.mobile-sticky-price .val {
  font-size: 16px;
  font-weight: 800;
  color: #c02a7c;
}

.mobile-sticky-btns {
  display: flex;
  align-items: center;
  gap: 8px;
}

.btn-mobile-wa {
  background: #22c55e;
  color: white;
  width: 42px;
  height: 42px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  text-decoration: none;
  box-shadow: 0 3px 10px rgba(34, 197, 94, 0.3);
}

.btn-mobile-visit {
  background: linear-gradient(135deg, #c02a7c 0%, #991b5b 100%);
  color: white;
  padding: 10px 18px;
  border-radius: 12px;
  font-size: 13.5px;
  font-weight: 700;
  border: none;
  display: flex;
  align-items: center;
  gap: 6px;
  box-shadow: 0 4px 14px rgba(192, 42, 124, 0.3);
}

/* ==========================================================================
   📅 Site Visit Modal — Compact & Widescreen Responsive Luxury System
   ========================================================================== */
.modal-site-visit {
  z-index: 1060 !important;
}

.modal-site-visit .modal-dialog {
  max-width: 720px !important;
  margin: 1.25rem auto !important;
  transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
}

.modal-site-visit .modal-content {
  border-radius: 20px !important;
  border: 1px solid rgba(192, 42, 124, 0.12) !important;
  box-shadow: 0 25px 70px -10px rgba(15, 23, 42, 0.28) !important;
  overflow: hidden !important;
  background: #ffffff !important;
}

.modal-site-visit .modal-header {
  background: linear-gradient(135deg, #fff5f9 0%, #ffffff 100%) !important;
  border-bottom: 1px solid #f1f5f9 !important;
  padding: 13px 22px 11px !important;
  position: relative;
  align-items: center !important;
}

.modal-site-visit .modal-header::after {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3.5px;
  background: linear-gradient(90deg, #c02a7c, #ec4899);
}

.modal-site-visit .site-visit-badge-top {
  display: inline-flex;
  align-items: center;
  background: rgba(192, 42, 124, 0.08);
  color: #c02a7c;
  font-size: 10px;
  font-weight: 700;
  padding: 2px 8px;
  border-radius: 20px;
  letter-spacing: 0.3px;
  text-transform: uppercase;
  vertical-align: middle;
}

.modal-site-visit .modal-title {
  font-family: 'Outfit', sans-serif !important;
  font-weight: 800 !important;
  font-size: 17.5px !important;
  color: #0f172a !important;
  letter-spacing: -0.3px;
  line-height: 1.25;
}

.modal-site-visit .modal-subtitle {
  font-family: 'Outfit', sans-serif !important;
  font-size: 12px !important;
  color: #64748b !important;
  margin-top: 2px !important;
  margin-bottom: 0 !important;
  line-height: 1.3;
}

.modal-site-visit .btn-close {
  background-color: #f1f5f9;
  border-radius: 50%;
  padding: 8px;
  opacity: 0.8;
  transition: all 0.2s ease;
  font-size: 10.5px;
}

.modal-site-visit .btn-close:hover {
  opacity: 1;
  background-color: #fee2e2;
  transform: rotate(90deg);
}

.modal-site-visit .modal-body {
  padding: 14px 22px 18px !important;
  max-height: calc(90vh - 75px);
  overflow-y: auto;
  -webkit-overflow-scrolling: touch;
}

.modal-site-visit label.form-label {
  font-family: 'Outfit', sans-serif !important;
  font-size: 11.5px !important;
  font-weight: 700 !important;
  color: #334155 !important;
  margin-bottom: 3px !important;
  display: block;
}

/* 🧼 Seamless Unified Input Group */
.modal-site-visit .input-group {
  border: 1.5px solid #e2e8f0 !important;
  border-radius: 10px !important;
  overflow: hidden !important;
  background: #f8fafc !important;
  transition: all 0.25s ease !important;
}

.modal-site-visit .input-group:focus-within {
  border-color: #c02a7c !important;
  background: #ffffff !important;
  box-shadow: 0 0 0 3px rgba(192, 42, 124, 0.12) !important;
}

.modal-site-visit .input-group-text {
  background: transparent !important;
  border: none !important;
  color: #94a3b8 !important;
  font-size: 13px !important;
  padding: 0 0 0 12px !important;
  height: 41px !important;
  display: flex;
  align-items: center;
}

.modal-site-visit .input-group .form-control {
  border: none !important;
  background: transparent !important;
  height: 41px !important;
  font-size: 13.5px !important;
  font-family: 'Outfit', sans-serif !important;
  font-weight: 500 !important;
  color: #0f172a !important;
  padding: 6px 12px 6px 8px !important;
  box-shadow: none !important;
}

.modal-site-visit .input-group input[type="date"] {
  min-height: 41px !important;
  color: #334155 !important;
}

.modal-site-visit .input-group .form-control::placeholder {
  color: #94a3b8 !important;
  font-weight: 400 !important;
}

/* 🕒 Time Slot Pills (Horizontal Compact Alignment) */
.slot-pill-input {
  display: none !important;
}

.slot-pill-label {
  display: flex !important;
  flex-direction: row !important;
  align-items: center !important;
  justify-content: center !important;
  gap: 8px !important;
  padding: 6px 10px !important;
  border: 1.5px solid #e2e8f0 !important;
  border-radius: 10px !important;
  color: #475569 !important;
  cursor: pointer !important;
  text-align: center !important;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
  background: #ffffff !important;
  min-height: 44px !important;
  width: 100%;
  user-select: none;
}

.slot-pill-label .slot-icon {
  font-size: 15px;
  margin-bottom: 0;
  flex-shrink: 0;
}

.slot-pill-label .slot-pill-content {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  text-align: left;
  line-height: 1.2;
}

.slot-pill-label .slot-title {
  font-size: 11.5px;
  font-weight: 700;
  display: block;
}

.slot-pill-label .slot-time {
  font-size: 9.5px;
  font-weight: 500;
  opacity: 0.8;
  display: block;
  white-space: nowrap;
}

.slot-pill-label:hover {
  border-color: #cbd5e1 !important;
  background: #f8fafc !important;
  transform: translateY(-1px);
}

.slot-pill-input:checked + .slot-pill-label {
  border-color: #c02a7c !important;
  background: #fff0f6 !important;
  color: #c02a7c !important;
  box-shadow: 0 3px 10px rgba(192, 42, 124, 0.14) !important;
}

/* 🚗 Cab Request Checkbox */
.modal-site-visit .visit-cab-check {
  background: #f8fafc;
  border: 1px dashed #cbd5e1;
  border-radius: 10px;
  padding: 6px 10px 6px 30px;
  min-height: 38px;
  transition: all 0.2s ease;
}

.modal-site-visit .visit-cab-check:hover {
  background: #fff5f9;
  border-color: #f472b6;
}

.modal-site-visit .visit-cab-check .form-check-input {
  margin-left: -20px;
  margin-top: 0;
  cursor: pointer;
}

.modal-site-visit .visit-cab-check .form-check-input:checked {
  background-color: #c02a7c;
  border-color: #c02a7c;
}

.modal-site-visit .visit-cab-check .form-check-label {
  font-size: 11px !important;
  color: #334155 !important;
  cursor: pointer;
  font-weight: 600 !important;
  line-height: 1.3;
  margin-bottom: 0 !important;
}

.badge-cab-free {
  background: #16a34a;
  color: #ffffff;
  font-size: 8.5px;
  font-weight: 800;
  padding: 1px 5px;
  border-radius: 4px;
  letter-spacing: 0.3px;
  margin-left: 3px;
  display: inline-block;
  vertical-align: middle;
}

/* 🛡️ Trust Box */
.modal-site-visit .trust-guarantee-box {
  background: #f0fdf4 !important;
  border: 1px solid #bbf7d0 !important;
  border-radius: 10px !important;
  padding: 6px 10px !important;
  min-height: 38px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.modal-site-visit .trust-guarantee-box i {
  color: #16a34a;
  font-size: 15px;
  flex-shrink: 0;
}

.modal-site-visit .trust-guarantee-box div {
  font-size: 11px;
  color: #166534;
  line-height: 1.3;
}

/* 🔘 Submit Button */
.modal-site-visit .btn-submit-visit {
  background: linear-gradient(135deg, #c02a7c 0%, #991b5b 100%) !important;
  color: #ffffff !important;
  border-radius: 10px !important;
  font-weight: 700 !important;
  font-size: 14px !important;
  font-family: 'Outfit', sans-serif !important;
  height: 42px !important;
  width: 100% !important;
  border: none !important;
  box-shadow: 0 6px 16px rgba(192, 42, 124, 0.22) !important;
  transition: all 0.25s ease !important;
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-site-visit .btn-submit-visit:hover {
  transform: translateY(-1px);
  box-shadow: 0 10px 20px rgba(192, 42, 124, 0.3) !important;
  color: #ffffff !important;
}

.modal-site-visit .btn-submit-visit:active {
  transform: translateY(0) scale(0.99);
}

/* 📱 Responsive Mobile Adjustments (< 768px) */
@media (max-width: 767.98px) {
  .modal-site-visit .modal-dialog {
    margin: 10px auto !important;
    width: calc(100% - 16px) !important;
    max-width: 460px !important;
  }

  .modal-site-visit .modal-content {
    border-radius: 18px !important;
    max-height: calc(100vh - 20px) !important;
  }

  .modal-site-visit .modal-header {
    padding: 12px 15px 10px !important;
  }

  .modal-site-visit .site-visit-badge-top {
    font-size: 9.5px;
    padding: 1px 6px;
  }

  .modal-site-visit .modal-title {
    font-size: 16px !important;
  }

  .modal-site-visit .modal-subtitle {
    font-size: 11px !important;
  }

  .modal-site-visit .modal-body {
    padding: 12px 15px 16px !important;
    max-height: calc(100vh - 95px) !important;
  }

  .modal-site-visit .input-group-text {
    height: 44px !important;
    padding: 0 0 0 12px !important;
  }

  .modal-site-visit .input-group .form-control {
    height: 44px !important;
    font-size: 16px !important; /* 16px prevents iOS Safari auto-zoom */
    padding: 6px 12px !important;
  }

  .modal-site-visit .input-group input[type="date"] {
    min-height: 44px !important;
    font-size: 15px !important;
  }

  .slot-pills-row {
    --bs-gutter-x: 5px !important;
  }

  .slot-pill-label {
    flex-direction: column !important;
    gap: 1px !important;
    min-height: 52px !important;
    padding: 6px 3px !important;
    border-radius: 9px !important;
  }

  .slot-pill-label .slot-pill-content {
    align-items: center !important;
    text-align: center !important;
  }

  .slot-pill-label .slot-icon {
    font-size: 14px !important;
    margin-bottom: 2px !important;
  }

  .slot-pill-label .slot-title {
    font-size: 10.5px !important;
  }

  .slot-pill-label .slot-time {
    font-size: 8px !important;
    letter-spacing: -0.2px;
  }

  .modal-site-visit .visit-cab-check {
    padding: 6px 8px 6px 28px;
    min-height: 36px;
  }

  .modal-site-visit .visit-cab-check .form-check-label {
    font-size: 11px !important;
  }

  .modal-site-visit .trust-guarantee-box {
    padding: 6px 8px !important;
    border-radius: 9px !important;
    min-height: 36px;
  }

  .modal-site-visit .trust-guarantee-box div {
    font-size: 10.5px !important;
    line-height: 1.25 !important;
  }

  .modal-site-visit .btn-submit-visit {
    height: 44px !important;
    font-size: 13.5px !important;
    border-radius: 9px !important;
  }
}

/* 📱 Super Narrow Mobile (< 360px) */
@media (max-width: 359.98px) {
  .modal-site-visit .modal-dialog {
    width: calc(100% - 10px) !important;
  }
  .modal-site-visit .modal-title {
    font-size: 14.5px !important;
  }
  .slot-pill-label .slot-title {
    font-size: 9.5px !important;
  }
  .slot-pill-label .slot-time {
    font-size: 7.5px !important;
  }
}

/* 📱 Responsive Adjustments */
@media (max-width: 991px) {
  .gallery-grid-premium {
    display: none;
  }
  .mobile-gallery-swiper {
    display: block;
  }
  .bento-overview-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  .highlights-grid-container {
    grid-template-columns: 1fr;
  }
  .hero-price-card {
    text-align: left;
    margin-top: 14px;
    width: 100%;
  }
  .property-actions-toolbar {
    flex-direction: column;
    align-items: stretch !important;
  }
  .actions-group-primary, .actions-group-secondary {
    width: 100%;
    justify-content: space-between;
  }
  .btn-action-primary, .btn-action-whatsapp {
    flex: 1;
    justify-content: center;
  }
  body {
    padding-bottom: 70px; /* Offset for mobile bottom bar */
  }
}

@media (max-width: 576px) {
  .bento-overview-grid {
    grid-template-columns: 1fr;
  }
  .premium-hero-header {
    padding-top: 85px !important;
  }
  .property-rich-desc table,
  .property-rich-desc table tbody,
  .property-rich-desc table tr,
  .property-rich-desc table td {
    display: block !important;
    width: 100% !important;
  }
  .property-rich-desc table tr {
    padding: 10px 14px !important;
    border-bottom: 1px solid #e2e8f0 !important;
  }
  .property-rich-desc table td:first-child {
    font-size: 11.5px !important;
    text-transform: uppercase !important;
    color: #64748b !important;
    background: transparent !important;
    border-right: none !important;
    padding: 0 0 3px 0 !important;
    border-bottom: none !important;
  }
  .property-rich-desc table td:last-child {
    font-size: 13.5px !important;
    padding: 0 0 4px 0 !important;
    border-bottom: none !important;
  }
}
</style>
