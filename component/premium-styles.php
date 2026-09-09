<style>
/* 💎 Premium Property Detail Styles (Consolidated) */
@import url('https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');

.project-title {
  font-family: 'Outfit', sans-serif;
  font-weight: 850;
  color: #0f172a;
  letter-spacing: -0.02em;
  font-size: clamp(1.8rem, 4vw, 2.5rem);
  margin-top: 10px;
}

.premium-hero-header {
  padding: 120px 0 40px;
  background: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
}

.price-label {
  font-size: 14px;
  font-weight: 700;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.header-price {
  font-size: clamp(1.5rem, 3vw, 2rem);
  font-weight: 850;
  color: #c02a7c !important;
}

.jda-badge {
  background: #f1f5f9;
  color: #2563eb;
  padding: 8px 14px;
  font-size: 13px;
  font-weight: 700;
  border-radius: 8px;
  display: inline-flex;
  align-items: center;
}

/* 🖼️ Premium Gallery System */
.gallery-wrapper {
  position: relative;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 20px 50px rgba(0,0,0,0.1);
}

.gallery-grid-premium {
  display: grid;
  gap: 12px;
  margin-bottom: 2rem;
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
  transition: transform 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
  display: block;
}

.gallery-img-bx:hover img {
  transform: scale(1.05);
}

/* Verified & Featured Badges */
.badge-verified-float {
  position: absolute;
  top: 20px;
  left: 20px;
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(10px);
  color: #22c55e;
  padding: 8px 16px;
  border-radius: 50px;
  font-weight: 800;
  font-size: 12px;
  display: flex;
  align-items: center;
  gap: 6px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  z-index: 10;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.featured-price-tag {
    position: absolute;
    bottom: 20px;
    left: 20px;
    background: #c02a7c;
    color: white;
    padding: 6px 14px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 13px;
    z-index: 10;
    box-shadow: 0 10px 20px rgba(192, 42, 124, 0.3);
}

.g-view-more {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.5);
  color: white;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 1rem;
  transition: all 0.3s ease;
  z-index: 5;
  backdrop-filter: blur(4px);
}

.g-view-more i { font-size: 1.5rem; margin-bottom: 8px; }

.gallery-img-bx:hover .g-view-more {
  background: rgba(0,0,0,0.7);
  backdrop-filter: blur(8px);
}

/* Grid Variatons */
.gallery-grid-1 { grid-template-columns: 1fr; aspect-ratio: 2.33/1; }
.gallery-grid-2 { grid-template-columns: 1fr 1fr; aspect-ratio: 2.33/1; }
.gallery-grid-3 { grid-template-columns: 2fr 1fr; grid-template-rows: 1fr 1fr; aspect-ratio: 2.33/1; }
.gallery-grid-3 .g-main { grid-row: span 2; }
.gallery-grid-4 { grid-template-columns: 2fr 1fr 1fr; grid-template-rows: 1fr 1fr; aspect-ratio: 2.33/1; }
.gallery-grid-4 .g-main { grid-row: span 2; }
.gallery-grid-4 .gallery-img-bx:nth-child(2) { grid-column: span 2; }

.gallery-grid-5, .gallery-grid-default { 
    grid-template-columns: 2fr 1.2fr 1.2fr; 
    grid-template-rows: 1fr 1fr; 
    aspect-ratio: 2.33/1; 
}
.g-main { grid-row: span 2; }

/* 📱 Mobile Slider Logic (Swiper) */
.mobile-gallery-swiper {
    display: none;
    border-radius: 20px;
    overflow: hidden;
    height: 350px;
    margin-bottom: 2rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.mobile-gallery-swiper .swiper-slide {
    height: 100%;
}

.mobile-gallery-swiper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.swiper-pagination-premium {
    bottom: 20px !important;
}

.swiper-pagination-premium .swiper-pagination-bullet {
    background: white;
    opacity: 0.6;
    width: 8px;
    height: 8px;
    transition: all 0.3s ease;
}

.swiper-pagination-premium .swiper-pagination-bullet-active {
    opacity: 1;
    background: white;
    width: 24px;
    border-radius: 10px;
}

.gallery-count-chip {
    position: absolute;
    bottom: 20px;
    right: 20px;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(10px);
    color: white;
    padding: 6px 14px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 700;
    z-index: 10;
}

/* Overview Section */
.overview-grid-premium {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 20px;
  margin-top: 25px;
  margin-bottom: 40px;
}

.overview-card-premium {
  background: white;
  border: 1px solid #e2e8f0;
  padding: 15px;
  border-radius: 16px;
  display: flex;
  align-items: center;
  gap: 15px;
  transition: all 0.3s ease;
}

.overview-card-premium:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
  border-color: #c02a7c33;
}

.overview-icon-container {
  width: 42px;
  height: 42px;
  background: #fdf2f8;
  color: #c02a7c;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  flex-shrink: 0;
}

.ov-title {
  font-size: 12px;
  color: #64748b;
  font-weight: 600;
  margin-bottom: 2px;
  text-transform: uppercase;
}

.ov-val {
  font-size: 14px;
  color: #0f172a;
  font-weight: 700;
  margin: 0;
}

/* Amenities */
.amenities-premium-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
  gap: 15px;
}

.amenity-premium-badge {
  background: white;
  border: 1px solid #f1f5f9;
  padding: 12px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  gap: 10px;
  transition: all 0.2s ease;
}

.amenity-premium-badge:hover {
  background: #fffcfd;
  border-color: #c02a7c22;
}

.amenity-premium-badge img {
  width: 24px;
  height: 24px;
  object-fit: contain;
}

.amenity-premium-badge span {
  font-size: 13px;
  font-weight: 600;
  color: #334155;
}

/* Sidebar Contact Card */
.premium-contact-card {
  background: white;
  border-radius: 24px;
  padding: 30px;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
  border: 1px solid #f1f5f9;
  position: relative;
  overflow: hidden;
}

.badge-premium {
  display: inline-block;
  background: #fff1f2;
  color: #e11d48;
  padding: 6px 14px;
  border-radius: 100px;
  font-size: 12px;
  font-weight: 700;
  margin-bottom: 20px;
}

.btn-premium-cta {
  width: 100%;
  padding: 15px;
  background: #c02a7c;
  color: white !important;
  border: none;
  border-radius: 14px;
  font-weight: 700;
  font-size: 16px;
  transition: all 0.3s ease;
  box-shadow: 0 10px 15px -3px rgba(192, 42, 124, 0.25);
  text-align: center;
}

.btn-premium-cta:hover {
  background: #a02268;
  transform: translateY(-2px);
  box-shadow: 0 15px 20px -3px rgba(192, 42, 124, 0.35);
  color: white !important;
}

.btn-share-premium {
  background: white;
  border: 1px solid #e2e8f0;
  padding: 10px 18px;
  border-radius: 12px;
  font-weight: 700;
  font-size: 14px;
  color: #475569;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
}

.btn-share-premium:hover {
  background: #f8fafc;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

/* Shared UI Components */
.vh {
  font-weight: 800;
  color: #0f172a;
  font-size: 1.5rem;
  margin-bottom: 1.5rem;
  position: relative;
}

.vh::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: -6px;
  width: 40px;
  height: 4px;
  background: #c02a7c !important;
  border-radius: 2px;
}

.brochure-card-premium {
  background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
  border-radius: 20px;
  border: 1px solid #e2e8f0;
}

/* 📱 Mobile Responsive Gallery Logic */
@media (max-width: 991px) {
  .gallery-grid-premium {
    display: none;
  }
  .mobile-gallery-swiper {
    display: block;
  }
}

@media (max-width: 768px) {
  .overview-grid-premium {
    grid-template-columns: 1fr 1fr;
  }
  .premium-hero-header {
      padding-top: 100px;
  }
}

/* 🖼️ Popup Gallery Navigation Fix */
.popup-v .prevv, 
.popup-v .nextt {
    background: #c02a7c !important; /* Premium Pink */
    color: white !important;
    width: 50px !important;
    height: 50px !important;
    display: flex !important;
    align-items: center;
    justify-content: center;
    border-radius: 50% !important;
    font-size: 24px !important;
    z-index: 1000 !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    transition: all 0.3s ease !important;
    text-decoration: none !important;
    opacity: 0.8;
}

.popup-v .prevv:hover, 
.popup-v .nextt:hover {
    opacity: 1;
    transform: translateY(-50%) scale(1.1) !important;
    background: #0f172a !important; /* Dark on hover */
}

.popup-v .prevv { left: 20px !important; }
.popup-v .nextt { right: 20px !important; }

.popup-v .close {
    color: white !important;
    background: rgba(0,0,0,0.5);
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 30px !important;
    top: 20px !important;
    right: 20px !important;
    transition: all 0.3s ease;
}

.popup-v .close:hover {
    background: #ef4444;
}
</style>
