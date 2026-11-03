<?php
/**
 * Production SEO & Technical Remediation Helper
 * ikanhousing.com
 */

class SeoHelper
{
    const BASE_CANONICAL = 'https://ikanhousing.com';
    const DEFAULT_OG_IMAGE = 'https://ikanhousing.com/img/homepage.jpeg';
    const LOGO_URL = 'https://ikanhousing.com/assets/images/logo.png';
    const BRAND_NAME = 'I Kan Housing';
    const BRAND_DEFAULT_TITLE = 'I Kan Housing | Trusted Real Estate Company in Jaipur';
    const BRAND_DEFAULT_DESC = 'Explore residential, commercial, and land projects in Jaipur with I Kan Housing. Find verified properties, investment opportunities, and expert real estate guidance.';

    // Known placeholder or audit test strings to ignore
    private static $testStrings = [
        'tese', 'wdswasd', 'dsds', 'harsh', 'ssdds', 'lorem', 'hgjhkl', 'dffddf', 'sdds'
    ];

    /**
     * Route registry for static pages
     */
    private static $routes = [
        'index' => [
            'title' => 'I Kan Housing | Trusted Real Estate Company in Jaipur',
            'desc'  => 'Explore residential, commercial, and land projects in Jaipur with I Kan Housing. Find verified properties, investment opportunities, and expert real estate guidance.',
            'canonical' => 'https://ikanhousing.com/'
        ],
        'about-us' => [
            'title' => 'About I Kan Housing | Jaipur Real Estate Experts',
            'desc'  => 'Learn about I Kan Housing, a Jaipur real estate company helping buyers and investors discover residential, commercial, and land opportunities.',
            'canonical' => 'https://ikanhousing.com/about-us'
        ],
        'ongoing-project' => [
            'title' => 'Ongoing Residential Projects in Jaipur | I Kan Housing',
            'desc'  => 'Explore ongoing residential and commercial projects in Jaipur, including project locations, configurations, amenities, prices, and enquiry details.',
            'canonical' => 'https://ikanhousing.com/ongoing-project'
        ],
        'complete-project' => [
            'title' => 'Completed Real Estate Projects in Jaipur | I Kan Housing',
            'desc'  => 'View completed residential and commercial projects in Jaipur with project details, locations, configurations, and enquiry information.',
            'canonical' => 'https://ikanhousing.com/complete-project'
        ],
        'services' => [
            'title' => 'Real Estate Services in Jaipur | I Kan Housing',
            'desc'  => 'Explore I Kan Housing services for residential sales, land, commercial property, investment, leasing, post-sales support, and real estate advisory in Jaipur.',
            'canonical' => 'https://ikanhousing.com/services'
        ],
        'residential' => [
            'title' => 'Residential Properties and Projects in Jaipur | I Kan Housing',
            'desc'  => 'Find residential apartments, homes, and housing projects in Jaipur with project details, locations, configurations, amenities, and enquiry options.',
            'canonical' => 'https://ikanhousing.com/residential'
        ],
        'land-services' => [
            'title' => 'Land Investment and Development Services in Jaipur | I Kan Housing',
            'desc'  => 'Find land investment, development, and advisory opportunities in Jaipur with I Kan Housing’s local real estate expertise.',
            'canonical' => 'https://ikanhousing.com/land-services'
        ],
        'contact' => [
            'title' => 'Contact I Kan Housing | Jaipur Real Estate Enquiries',
            'desc'  => 'Contact I Kan Housing for residential, commercial, land, investment, and property enquiries in Jaipur.',
            'canonical' => 'https://ikanhousing.com/contact'
        ],
        'career' => [
            'title' => 'Careers at I Kan Housing | Real Estate Jobs in Jaipur',
            'desc'  => 'Explore career opportunities at I Kan Housing and join a growing real estate team serving buyers and investors in Jaipur.',
            'canonical' => 'https://ikanhousing.com/career'
        ],
        'rewards-&-team' => [
            'title' => 'I Kan Housing Leadership Team and Achievements | Jaipur Real Estate',
            'desc'  => 'Meet the I Kan Housing team and learn about the company’s achievements, experience, and real estate work in Jaipur.',
            'canonical' => 'https://ikanhousing.com/rewards-&-team'
        ],
        'blog-grid' => [
            'title' => 'Real Estate Blog & Market Insights | I Kan Housing Jaipur',
            'desc'  => 'Read the latest real estate articles, guides, and property market updates in Jaipur from the I Kan Housing advisory team.',
            'canonical' => 'https://ikanhousing.com/blog-grid'
        ],
        'business-solutions' => [
            'title' => 'Commercial & Business Real Estate Solutions in Jaipur | I Kan Housing',
            'desc'  => 'Tailored commercial real estate solutions, strategic corporate leasing, and business property acquisition advisory in Jaipur.',
            'canonical' => 'https://ikanhousing.com/business-solutions'
        ],
        'joint-venture' => [
            'title' => 'Real Estate Joint Ventures in Jaipur | I Kan Housing',
            'desc'  => 'Partner with I Kan Housing for strategic real estate joint ventures, land monetization, and development opportunities in Jaipur.',
            'canonical' => 'https://ikanhousing.com/joint-venture'
        ],
        'post-sales' => [
            'title' => 'Post-Sales Support & Property Management | I Kan Housing',
            'desc'  => 'Dedicated post-purchase assistance, documentation, and property handover services in Jaipur by I Kan Housing.',
            'canonical' => 'https://ikanhousing.com/post-sales'
        ],
        'sales-marketing' => [
            'title' => 'Real Estate Sales & Marketing Services | I Kan Housing',
            'desc'  => 'Strategic sales execution and marketing solutions for real estate developers and property owners in Jaipur.',
            'canonical' => 'https://ikanhousing.com/sales-marketing'
        ],
        'investment' => [
            'title' => 'Real Estate Investment Opportunities in Jaipur | I Kan Housing',
            'desc'  => 'Discover high-yield residential, commercial, and land investment opportunities in prime Jaipur locations.',
            'canonical' => 'https://ikanhousing.com/investment'
        ],
        'retail' => [
            'title' => 'Retail Spaces & High-Street Showrooms in Jaipur | I Kan Housing',
            'desc'  => 'Explore prime retail spaces, shops, and high-street showrooms for sale and lease across Jaipur with I Kan Housing.',
            'canonical' => 'https://ikanhousing.com/retail'
        ],
        'commer-leasing' => [
            'title' => 'Commercial Leasing Solutions in Jaipur | I Kan Housing',
            'desc'  => 'Find prime office spaces, retail outlets, and commercial buildings for lease in Jaipur with I Kan Housing.',
            'canonical' => 'https://ikanhousing.com/commer-leasing'
        ],
        'commer-retail' => [
            'title' => 'Commercial & Retail Real Estate in Jaipur | I Kan Housing',
            'desc'  => 'Comprehensive commercial and retail property consultancy, acquisitions, and leasing services in Jaipur.',
            'canonical' => 'https://ikanhousing.com/commer-retail'
        ],
        'indus-logi' => [
            'title' => 'Industrial & Logistics Real Estate in Jaipur | I Kan Housing',
            'desc'  => 'Warehousing, industrial land, and logistics infrastructure spaces in Jaipur and strategic growth corridors.',
            'canonical' => 'https://ikanhousing.com/indus-logi'
        ],
        'strat-ad-va' => [
            'title' => 'Strategic Advisory & Valuation Services | I Kan Housing',
            'desc'  => 'Professional real estate advisory, asset valuation, and feasibility consulting across Jaipur.',
            'canonical' => 'https://ikanhousing.com/strat-ad-va'
        ],
        'hospitality' => [
            'title' => 'Hospitality Real Estate & Resort Lands | I Kan Housing',
            'desc'  => 'Explore hotel, resort, and hospitality real estate development opportunities in Jaipur and Rajasthan.',
            'canonical' => 'https://ikanhousing.com/hospitality'
        ],
        'home-solution' => [
            'title' => 'End-to-End Home Solutions in Jaipur | I Kan Housing',
            'desc'  => 'Comprehensive home buying, interior design, and loan assistance solutions by I Kan Housing Jaipur.',
            'canonical' => 'https://ikanhousing.com/home-solution'
        ],
        'privacy-policy' => [
            'title' => 'Privacy Policy | I Kan Housing',
            'desc'  => 'Read the privacy policy of I Kan Housing covering data protection, user privacy, and cookie policies.',
            'canonical' => 'https://ikanhousing.com/privacy-policy'
        ],
        'terms' => [
            'title' => 'Terms and Conditions | I Kan Housing',
            'desc'  => 'Read the terms and conditions for browsing and utilizing real estate advisory services from I Kan Housing.',
            'canonical' => 'https://ikanhousing.com/terms'
        ],
        'agent-registration' => [
            'title' => 'Channel Partner & Agent Registration | I Kan Housing',
            'desc'  => 'Register as an authorized real estate agent or channel partner with I Kan Housing in Jaipur.',
            'canonical' => 'https://ikanhousing.com/agent-registration'
        ],
        'career-apply' => [
            'title' => 'Apply for Real Estate Careers in Jaipur | I Kan Housing',
            'desc'  => 'Submit your application to join the professional real estate team at I Kan Housing in Jaipur.',
            'canonical' => 'https://ikanhousing.com/career-apply'
        ],
        'company-reg' => [
            'title' => 'Corporate Partner Registration | I Kan Housing',
            'desc'  => 'Register your company or institutional organization with I Kan Housing for real estate partnerships.',
            'canonical' => 'https://ikanhousing.com/company-reg'
        ],
        'sitemap' => [
            'title' => 'Sitemap | I Kan Housing Real Estate Jaipur',
            'desc'  => 'Explore the complete directory of residential properties, commercial projects, services, and blogs on I Kan Housing.',
            'canonical' => 'https://ikanhousing.com/sitemap'
        ]
    ];

    /**
     * Determines whether a string is an invalid/test placeholder
     */
    public static function isPlaceholder($str)
    {
        if (empty($str)) return true;
        $clean = strtolower(trim($str));
        if (strlen($clean) < 4) return true;
        foreach (self::$testStrings as $t) {
            if ($clean === $t || preg_match('/\b' . preg_quote($t, '/') . '\b/i', $clean)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Build SEO metadata and render HTML head tags
     */
    public static function render($con = null, $customMeta = [])
    {
        // 1. Identify current route
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? ($_SERVER['PHP_SELF'] ?? '');
        $pageKey = basename($scriptName, '.php');
        if (empty($pageKey) || $pageKey === 'index') {
            $pageKey = 'index';
        }

        // Default metadata
        $title = self::BRAND_DEFAULT_TITLE;
        $description = self::BRAND_DEFAULT_DESC;
        $canonical = ($pageKey === 'index') ? self::BASE_CANONICAL . '/' : self::BASE_CANONICAL . '/' . $pageKey;
        $robots = 'index, follow';
        $ogType = 'website';
        $ogImage = self::DEFAULT_OG_IMAGE;
        $ogImageAlt = 'I Kan Housing - Real Estate Company in Jaipur';
        $extraSchema = null;

        // 2. Check Static Route Registry
        if (isset(self::$routes[$pageKey])) {
            $title = self::$routes[$pageKey]['title'];
            $description = self::$routes[$pageKey]['desc'];
            $canonical = self::$routes[$pageKey]['canonical'];
        }

        // 3. Database Lookup in seo_pages if DB connection is provided
        if ($con && $pageKey !== 'property-detail-for' && $pageKey !== 'blog-details') {
            $sql = "SELECT meta_title, meta_description, meta_keywords FROM seo_pages WHERE page_name = ? AND status = 1 LIMIT 1";
            if ($stmt = mysqli_prepare($con, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $pageKey);
                mysqli_stmt_execute($stmt);
                $res = mysqli_stmt_get_result($stmt);
                if ($res && $row = mysqli_fetch_assoc($res)) {
                    if (!empty($row['meta_title']) && !self::isPlaceholder($row['meta_title'])) {
                        $title = trim($row['meta_title']);
                    }
                    if (!empty($row['meta_description']) && !self::isPlaceholder($row['meta_description'])) {
                        $description = trim($row['meta_description']);
                    }
                }
                mysqli_stmt_close($stmt);
            }
        }

        // 4. Dynamic Property Detail Page Handling
        global $property;
        if ($pageKey === 'property-detail-for' || isset($customMeta['property']) || !empty($property)) {
            $prop = $customMeta['property'] ?? $property;
            if ($prop && is_array($prop)) {
                $pName = trim($prop['project_name'] ?? '');
                $rawLoc = trim($prop['location'] ?? 'Jaipur');
                $slug = trim($prop['slug'] ?? '');
                
                // Clean locality
                $locParts = array_filter(array_map('trim', explode(',', $rawLoc)));
                $locality = 'Jaipur';
                if (!empty($locParts)) {
                    // Pick the most descriptive part that isn't 'Rajasthan' or pincode
                    foreach ($locParts as $part) {
                        if (!preg_match('/rajasthan|[0-9]{6}/i', $part)) {
                            $locality = $part;
                            break;
                        }
                    }
                }

                // Format Title: {Project/Property Name} in {Locality}, Jaipur | I Kan Housing
                if (stripos($locality, 'Jaipur') !== false) {
                    $title = "{$pName} in Jaipur | " . self::BRAND_NAME;
                } else {
                    $title = "{$pName} in {$locality}, Jaipur | " . self::BRAND_NAME;
                }

                // Format Description: Configuration, Locality, Status, Price, Amenities
                $bhk = trim($prop['bhk'] ?? '');
                if (empty($bhk) || strtolower($bhk) === 'n/a') {
                    $bhkConfig = 'premium residential properties';
                } else {
                    $bhkConfig = "{$bhk} apartments";
                }

                $statusVal = $prop['construct_Status'] ?? null;
                $statusText = '';
                if ($statusVal === '0' || $statusVal === 0) {
                    $statusText = 'Ready to Move';
                } elseif ($statusVal === '1' || $statusVal === 1) {
                    $statusText = 'Under Construction';
                }

                $priceText = '';
                if (!empty($prop['min_price'])) {
                    $priceText = " starting from " . trim($prop['min_price']);
                    if (!empty($prop['max_price'])) {
                        $priceText .= " to " . trim($prop['max_price']);
                    }
                }

                $descParts = [];
                if (stripos($locality, 'Jaipur') !== false) {
                    $descParts[] = "Explore {$pName} in Jaipur.";
                } else {
                    $descParts[] = "Explore {$pName} in {$locality}, Jaipur.";
                }
                if ($statusText) {
                    $descParts[] = "Featuring {$statusText} {$bhkConfig}{$priceText}.";
                } else {
                    $descParts[] = "Featuring {$bhkConfig}{$priceText}.";
                }
                $descParts[] = "Verified project details, amenities, floor plans, and expert guidance by I Kan Housing.";
                $description = implode(' ', $descParts);

                // Canonical URL
                $canonical = self::BASE_CANONICAL . '/property-detail-for/' . $slug;

                // OG Image
                if (!empty($prop['main_image']) && $prop['main_image'] !== 'default.jpg') {
                    $ogImage = self::BASE_CANONICAL . '/uploads/' . $prop['main_image'];
                }
                $ogImageAlt = "{$pName} in {$locality}, Jaipur";
                $ogType = 'product';

                // RealEstateListing JSON-LD Schema
                $extraSchema = [
                    '@context' => 'https://schema.org',
                    '@type' => 'RealEstateListing',
                    '@id' => $canonical . '#listing',
                    'name' => $pName,
                    'url' => $canonical,
                    'image' => $ogImage,
                    'description' => substr($description, 0, 300),
                    'provider' => [
                        '@type' => 'RealEstateAgent',
                        '@id' => self::BASE_CANONICAL . '/#organization',
                        'name' => self::BRAND_NAME
                    ]
                ];

                if (!empty($prop['min_price_int']) || !empty($prop['max_price_int'])) {
                    $extraSchema['offers'] = [
                        '@type' => 'AggregateOffer',
                        'priceCurrency' => 'INR',
                        'lowPrice' => (int)($prop['min_price_int'] ?? 0),
                        'highPrice' => (int)($prop['max_price_int'] ?? 0)
                    ];
                }
            }
        }

        // 5. Dynamic Blog Detail Page Handling
        global $blog;
        if ($pageKey === 'blog-details' || isset($customMeta['blog']) || !empty($blog)) {
            $b = $customMeta['blog'] ?? $blog;
            if ($b && is_array($b)) {
                $headline = trim($b['name'] ?? '');
                $slug = trim($b['slug'] ?? '');

                // Title format: {Article Headline} | I Kan Housing
                $title = "{$headline} | " . self::BRAND_NAME;

                // Description format: First 150–160 characters of article summary
                $rawContent = $b['massage'] ?? ($b['content'] ?? '');
                $plainText = trim(preg_replace('/\s+/', ' ', strip_tags($rawContent)));
                if (!empty($plainText)) {
                    if (mb_strlen($plainText) > 155) {
                        $description = mb_substr($plainText, 0, 152) . '...';
                    } else {
                        $description = $plainText;
                    }
                } else {
                    $description = "Read '{$headline}' on the official I Kan Housing blog for verified real estate news and property insights in Jaipur.";
                }

                // Canonical URL
                $canonical = self::BASE_CANONICAL . '/blog/' . $slug;

                // OG Image
                if (!empty($b['image'])) {
                    $ogImage = self::BASE_CANONICAL . '/img/' . $b['image'];
                }
                $ogImageAlt = $headline;
                $ogType = 'article';

                // BlogPosting JSON-LD Schema
                $extraSchema = [
                    '@context' => 'https://schema.org',
                    '@type' => 'BlogPosting',
                    '@id' => $canonical . '#article',
                    'mainEntityOfPage' => [
                        '@type' => 'WebPage',
                        '@id' => $canonical
                    ],
                    'headline' => $headline,
                    'image' => $ogImage,
                    'datePublished' => !empty($b['created_at']) ? date('c', strtotime($b['created_at'])) : date('c'),
                    'author' => [
                        '@type' => 'Organization',
                        'name' => self::BRAND_NAME,
                        'url' => self::BASE_CANONICAL . '/'
                    ],
                    'publisher' => [
                        '@type' => 'Organization',
                        '@id' => self::BASE_CANONICAL . '/#organization',
                        'name' => self::BRAND_NAME,
                        'logo' => [
                            '@type' => 'ImageObject',
                            'url' => self::LOGO_URL
                        ]
                    ],
                    'description' => $description
                ];
            }
        }

        // 6. Explicit Custom Overrides (if passed directly by view)
        if (!empty($customMeta['title'])) $title = $customMeta['title'];
        if (!empty($customMeta['description'])) $description = $customMeta['description'];
        if (!empty($customMeta['canonical'])) $canonical = $customMeta['canonical'];
        if (!empty($customMeta['robots'])) $robots = $customMeta['robots'];
        if (!empty($customMeta['og_image'])) $ogImage = $customMeta['og_image'];
        if (!empty($customMeta['og_type'])) $ogType = $customMeta['og_type'];

        // Canonical URL Safety Check: Clean HTTPS without queries or .php
        $parsed = parse_url($canonical);
        $cleanPath = $parsed['path'] ?? '/';
        $cleanPath = preg_replace('/\.php$/i', '', $cleanPath);
        if ($cleanPath === '/index' || $cleanPath === '') {
            $cleanPath = '/';
        }
        $canonical = self::BASE_CANONICAL . $cleanPath;

        // Output tags
        echo "<!-- 🌟 Primary SEO Metadata -->\n";
        echo "    <title>" . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "</title>\n";
        echo "    <meta name=\"description\" content=\"" . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . "\">\n";
        echo "    <link rel=\"canonical\" href=\"" . htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8') . "\">\n";
        echo "    <meta name=\"robots\" content=\"" . htmlspecialchars($robots, ENT_QUOTES, 'UTF-8') . "\">\n";

        echo "\n    <!-- 🌐 Open Graph / Facebook -->\n";
        echo "    <meta property=\"og:locale\" content=\"en_IN\">\n";
        echo "    <meta property=\"og:type\" content=\"" . htmlspecialchars($ogType, ENT_QUOTES, 'UTF-8') . "\">\n";
        echo "    <meta property=\"og:site_name\" content=\"" . htmlspecialchars(self::BRAND_NAME, ENT_QUOTES, 'UTF-8') . "\">\n";
        echo "    <meta property=\"og:title\" content=\"" . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "\">\n";
        echo "    <meta property=\"og:description\" content=\"" . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . "\">\n";
        echo "    <meta property=\"og:url\" content=\"" . htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8') . "\">\n";
        echo "    <meta property=\"og:image\" content=\"" . htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8') . "\">\n";
        echo "    <meta property=\"og:image:alt\" content=\"" . htmlspecialchars($ogImageAlt, ENT_QUOTES, 'UTF-8') . "\">\n";

        echo "\n    <!-- 🐦 Twitter Card -->\n";
        echo "    <meta name=\"twitter:card\" content=\"summary_large_image\">\n";
        echo "    <meta name=\"twitter:site\" content=\"@IkanHousing\">\n";
        echo "    <meta name=\"twitter:title\" content=\"" . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "\">\n";
        echo "    <meta name=\"twitter:description\" content=\"" . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . "\">\n";
        echo "    <meta name=\"twitter:image\" content=\"" . htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8') . "\">\n";

        // JSON-LD Structured Data: Core Organization & WebSite (Always rendered)
        $coreSchema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'RealEstateAgent',
                    '@id' => self::BASE_CANONICAL . '/#organization',
                    'name' => self::BRAND_NAME,
                    'url' => self::BASE_CANONICAL . '/',
                    'logo' => self::LOGO_URL,
                    'image' => self::DEFAULT_OG_IMAGE,
                    'telephone' => '+91-99839-99839',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'addressLocality' => 'Jaipur',
                        'addressRegion' => 'Rajasthan',
                        'addressCountry' => 'IN'
                    ],
                    'sameAs' => [
                        'https://www.facebook.com/ikanhousingjpr',
                        'https://x.com/IkanHousing',
                        'https://www.instagram.com/ikanhousing/',
                        'https://www.linkedin.com/company/i-kan/'
                    ]
                ],
                [
                    '@type' => 'WebSite',
                    '@id' => self::BASE_CANONICAL . '/#website',
                    'url' => self::BASE_CANONICAL . '/',
                    'name' => self::BRAND_NAME,
                    'publisher' => [
                        '@id' => self::BASE_CANONICAL . '/#organization'
                    ]
                ]
            ]
        ];

        echo "\n    <!-- 🏗 JSON-LD Structured Data: Organization & WebSite -->\n";
        echo "    <script type=\"application/ld+json\">\n";
        echo json_encode($coreSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "\n";
        echo "    </script>\n";

        if ($extraSchema) {
            echo "    <!-- 🏗 JSON-LD Structured Data: Specific Entity -->\n";
            echo "    <script type=\"application/ld+json\">\n";
            echo json_encode($extraSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "\n";
            echo "    </script>\n";
        }
    }
}
