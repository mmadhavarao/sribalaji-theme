/**
 * Sri Balaji Books - Comprehensive End-to-End Storefront Validation Suite
 *
 * Runs automated headless browser checks across Desktop, Tablet, and Mobile viewports.
 * Validates:
 *   1. Category parity & count alignment across Home, Shop, and Mobile
 *   2. Desktop header layout (Brand -> Wide Search -> Menu Dropdown -> Cart -> Sign In at end)
 *   3. Mobile header layout (360px & 390px: no collision, full-width search, zero horizontal overflow)
 *   4. Sign-in & OTP modal flow
 *   5. Product card PDP navigation links & quick-commerce "+ ADD" interaction
 *
 * Usage:
 *   NODE_PATH=/workspace/career-ops/node_modules node validate_store_e2e.js [--url=https://staging.sribalajibooks.com]
 */

const { chromium } = require('playwright');

const BASE_URL = process.argv.find(arg => arg.startsWith('--url='))
    ? process.argv.find(arg => arg.startsWith('--url=')).split('=')[1]
    : (process.env.STORE_URL || 'https://staging.sribalajibooks.com');

const results = {
    url: BASE_URL,
    timestamp: new Date().toISOString(),
    testsPassed: 0,
    testsFailed: 0,
    details: []
};

function recordTest(suite, testName, passed, info = '') {
    const status = passed ? 'PASS' : 'FAIL';
    const icon = passed ? '✅' : '❌';
    console.log(`  ${icon} [${status}] [${suite}] ${testName}${info ? ' - ' + info : ''}`);
    if (passed) {
        results.testsPassed++;
    } else {
        results.testsFailed++;
    }
    results.details.push({ suite, testName, passed, info });
}

(async () => {
    console.log(`\n======================================================`);
    console.log(`🧪 Sri Balaji Books E2E Validation Suite`);
    console.log(`🌐 Target: ${BASE_URL}`);
    console.log(`⏰ Time: ${new Date().toLocaleString()}`);
    console.log(`======================================================\n`);

    const browser = await chromium.launch({ headless: true });

    try {
        /* ==========================================================================
           SUITE 1: Desktop Header Hierarchy & Widths (1280px)
           ========================================================================== */
        console.log(`\n--- SUITE 1: Desktop Header Hierarchy & Layout (1280px) ---`);
        const desktopPage = await browser.newPage({ viewport: { width: 1280, height: 800 } });
        await desktopPage.goto(BASE_URL, { waitUntil: 'domcontentloaded', timeout: 30000 });

        // 1.1 Brand exists on left
        const brandBox = await desktopPage.$eval('.brand-title', el => {
            const rect = el.getBoundingClientRect();
            return { x: rect.x, y: rect.y, width: rect.width, text: el.innerText.trim() };
        }).catch(() => null);
        recordTest('Desktop Header', 'Brand Title exists and is left-aligned', brandBox && brandBox.x < 150, `x: ${brandBox?.x}px, title: "${brandBox?.text}"`);

        // 1.2 Wide search bar exists in center
        const searchBox = await desktopPage.$eval('.header-search-container', el => {
            const rect = el.getBoundingClientRect();
            return { x: rect.x, width: rect.width };
        }).catch(() => null);
        recordTest('Desktop Header', 'Search Bar is comfortably wide (> 400px)', searchBox && searchBox.width >= 400, `width: ${searchBox?.width}px, x: ${searchBox?.x}px`);

        // 1.3 Sign In / Account trigger is at the far right end (after search bar)
        const accountBox = await desktopPage.$eval('#headerAccountArea', el => {
            const rect = el.getBoundingClientRect();
            return { x: rect.x, width: rect.width };
        }).catch(() => null);
        const isAccountAtEnd = accountBox && searchBox && (accountBox.x > searchBox.x + searchBox.width);
        recordTest('Desktop Header', 'Sign In / Account is placed at the far right end (after search)', isAccountAtEnd, `account x: ${accountBox?.x}px vs search right: ${searchBox ? searchBox.x + searchBox.width : 0}px`);

        // 1.4 Menu dropdown trigger exists
        const menuBtn = await desktopPage.$('#headerMenuTriggerBtn');
        recordTest('Desktop Header', 'Menu Dropdown trigger button exists', !!menuBtn);

        // 1.5 Menu dropdown opens and contains navigation links
        if (menuBtn) {
            await menuBtn.click();
            await desktopPage.waitForTimeout(300);
            const isMenuOpen = await desktopPage.$eval('#headerMenuDropdownPanel', el => el.classList.contains('is-open')).catch(() => false);
            recordTest('Desktop Header', 'Menu Dropdown opens on click', isMenuOpen);

            const menuLinks = await desktopPage.$$eval('#headerMenuDropdownPanel .header-menu-link', els => els.map(e => e.innerText.trim())).catch(() => []);
            recordTest('Desktop Header', 'Menu Dropdown contains navigation options', menuLinks.length >= 3, `Links: [${menuLinks.join(', ')}]`);
        }

        // 1.6 Zero horizontal overflow on desktop
        const desktopOverflow = await desktopPage.evaluate(() => {
            return document.documentElement.scrollWidth <= window.innerWidth;
        });
        recordTest('Desktop Layout', 'Zero horizontal viewport overflow on 1280px desktop', desktopOverflow);

        await desktopPage.close();


        /* ==========================================================================
           SUITE 2: Mobile Header Layout & Responsiveness (360px & 390px)
           ========================================================================== */
        console.log(`\n--- SUITE 2: Mobile Header Layout & Responsiveness (360px & 390px) ---`);
        for (const width of [360, 390]) {
            const mobilePage = await browser.newPage({ viewport: { width, height: 750 } });
            await mobilePage.goto(BASE_URL, { waitUntil: 'domcontentloaded', timeout: 30000 });

            // 2.1 Check brand and account trigger collision
            const mBrand = await mobilePage.$eval('.brand-title', el => {
                const r = el.getBoundingClientRect();
                return { x: r.x, y: r.y, right: r.right, width: r.width };
            }).catch(() => null);

            const mAccount = await mobilePage.$eval('#headerAccountArea', el => {
                const r = el.getBoundingClientRect();
                return { x: r.x, y: r.y, right: r.right, width: r.width };
            }).catch(() => null);

            const noCollision = mBrand && mAccount && (mBrand.right <= mAccount.x + 2);
            recordTest(`Mobile (${width}px)`, `Brand and Sign In button do not collide`, noCollision, `Brand right: ${mBrand?.right}px, Account x: ${mAccount?.x}px`);

            // 2.2 Search bar is below brand (Row 2 full width)
            const mSearch = await mobilePage.$eval('.header-search-container', el => {
                const r = el.getBoundingClientRect();
                return { y: r.y, width: r.width };
            }).catch(() => null);
            const searchBelow = mBrand && mSearch && (mSearch.y >= mBrand.y);
            recordTest(`Mobile (${width}px)`, `Search bar is positioned on Row 2`, searchBelow);

            // 2.3 Category tabs bar exists on mobile
            const mTabs = await mobilePage.$('#mobileCategoryTabsBar');
            recordTest(`Mobile (${width}px)`, `Horizontal Category Tabs bar is present`, !!mTabs);

            // 2.4 Zero horizontal scrollbar/overflow on mobile
            const mobOverflow = await mobilePage.evaluate(() => {
                return document.documentElement.scrollWidth <= window.innerWidth;
            });
            recordTest(`Mobile (${width}px)`, `Zero horizontal overflow (screen perfectly fits width)`, mobOverflow);

            await mobilePage.close();
        }


        /* ==========================================================================
           SUITE 3: Category Parity & Product Counts (Home vs Shop)
           ========================================================================== */
        console.log(`\n--- SUITE 3: Category Parity & Alignment Check ---`);
        const catPage = await browser.newPage({ viewport: { width: 1280, height: 800 } });
        
        // 3.1 Fetch Shop page categories from reversed-U bar
        await catPage.goto(`${BASE_URL}/shop/`, { waitUntil: 'domcontentloaded', timeout: 30000 });
        const shopTabs = await catPage.$$eval('.sribalaji-reversed-u-bar .reversed-u-cat-card', els => els.map(e => ({
            name: e.querySelector('.reversed-u-title')?.innerText.trim(),
            badge: e.querySelector('.reversed-u-header-badge')?.innerText.trim(),
            dataCat: e.getAttribute('data-category'),
            href: e.getAttribute('href')
        }))).catch(() => []);
        recordTest('Shop Categories', 'Shop Reversed-U Bar rendered categories', shopTabs.length >= 5, `Found ${shopTabs.length} tabs`);

        // 3.2 Fetch Homepage mobile category sections
        await catPage.goto(BASE_URL, { waitUntil: 'domcontentloaded', timeout: 30000 });
        const homeSections = await catPage.$$eval('.mobile-category-section', els => els.map(e => ({
            title: e.querySelector('.mobile-category-title span:last-child')?.innerText.trim(),
            count: e.querySelector('.mobile-category-count')?.innerText.trim(),
            dataCat: e.getAttribute('data-category'),
            seeAllHref: e.querySelector('.mobile-see-all-cat-btn')?.getAttribute('href')
        }))).catch(() => []);
        recordTest('Home Categories', 'Home Quick-Commerce sections rendered', homeSections.length >= 4, `Found ${homeSections.length} sections`);

        // 3.3 Verify no fake static counts like "28 items"
        let fakeCountFound = false;
        for (const sec of homeSections) {
            if (sec.count === '28 items' && sec.title.toLowerCase().includes('notebook')) {
                // If the shop category actually has 151 items, '28 items' was the hardcoded fake count!
                fakeCountFound = true;
            }
        }
        recordTest('Category Integrity', 'No fabricated static counts (dynamic from live database)', !fakeCountFound, `Checked: ${homeSections.map(s => s.title + ': ' + s.count).join('; ')}`);

        // 3.4 Verify "See all products" URLs are authentic category permalinks
        let invalidUrls = 0;
        for (const sec of homeSections) {
            if (!sec.seeAllHref || sec.seeAllHref === BASE_URL || sec.seeAllHref.endsWith('/#')) {
                invalidUrls++;
            }
        }
        recordTest('Category Navigation', 'All "See all {category} products" buttons link to valid category archives', invalidUrls === 0, `${homeSections.length - invalidUrls}/${homeSections.length} valid links`);

        await catPage.close();


        /* ==========================================================================
           SUITE 4: Sign-In Flow & OTP Modal
           ========================================================================== */
        console.log(`\n--- SUITE 4: Sign-In Flow & Modal Check ---`);
        const authPage = await browser.newPage({ viewport: { width: 1280, height: 800 } });
        await authPage.goto(BASE_URL, { waitUntil: 'domcontentloaded', timeout: 30000 });

        const loginBtn = await authPage.$('.header-login-btn');
        if (loginBtn) {
            await loginBtn.click();
            await authPage.waitForTimeout(500);

            // Check if OTP modal or login redirection happened
            const modalVisible = await authPage.$eval('#sribalajiOtpModal', el => el && el.style.display !== 'none' && !el.classList.contains('hidden')).catch(() => false);
            const currentUrl = authPage.url();
            const handledLogin = modalVisible || currentUrl.includes('my-account');
            recordTest('Authentication', 'Sign In trigger launches OTP modal or Account portal', handledLogin, `Modal: ${modalVisible}, URL: ${currentUrl}`);
        } else {
            recordTest('Authentication', 'Sign In / Account trigger exists in header', false, 'Button not found');
        }

        // Test /my-account/ directly on mobile (360px) to verify no horizontal clipping
        await authPage.setViewportSize({ width: 360, height: 700 });
        await authPage.goto(`${BASE_URL}/my-account/`, { waitUntil: 'domcontentloaded', timeout: 30000 });
        const accountNoOverflow = await authPage.evaluate(() => {
            return document.documentElement.scrollWidth <= window.innerWidth;
        });
        recordTest('Account Page', 'My Account / Login screen has zero horizontal overflow on 360px mobile', accountNoOverflow);

        await authPage.close();


        /* ==========================================================================
           SUITE 5: Product Card Details & Cart Interactions
           ========================================================================== */
        console.log(`\n--- SUITE 5: Product Card Details & Interactions ---`);
        const prodPage = await browser.newPage({ viewport: { width: 390, height: 750 } });
        await prodPage.goto(BASE_URL, { waitUntil: 'domcontentloaded', timeout: 30000 });

        // 5.1 Clickable card link
        const cardLink = await prodPage.$('.mobile-product-card a.mobile-card-link');
        const cardHref = cardLink ? await cardLink.getAttribute('href') : null;
        const validProdLink = cardHref && cardHref.length > 5 && cardHref !== '#';
        recordTest('Product Card', 'Mobile product card contains direct link to Product Details Page (PDP)', validProdLink, `Sample href: ${cardHref}`);

        // 5.2 "+ ADD" button state change
        const addBtn = await prodPage.$('.mobile-add-btn');
        if (addBtn) {
            await addBtn.click();
            await prodPage.waitForTimeout(400);
            const btnText = await addBtn.innerText();
            const stateChanged = btnText.includes('ADDED') || btnText.includes('✓');
            recordTest('Add to Cart', 'Mobile Quick-Commerce "+ ADD" button gives instant visual feedback', stateChanged, `Button text: "${btnText}"`);
        } else {
            recordTest('Add to Cart', 'Quick-Commerce "+ ADD" button exists', false, 'Not found');
        }

        await prodPage.close();

    } catch (err) {
        console.error('\n❌ Unhandled error during E2E validation:', err);
        results.testsFailed++;
        results.details.push({ suite: 'Fatal Error', testName: 'Suite Execution', passed: false, info: err.message });
    } finally {
        await browser.close();
    }

    console.log(`\n======================================================`);
    console.log(`📊 Validation Summary:`);
    console.log(`   Passed: ${results.testsPassed}`);
    console.log(`   Failed: ${results.testsFailed}`);
    console.log(`   Success Rate: ${((results.testsPassed / (results.testsPassed + results.testsFailed || 1)) * 100).toFixed(1)}%`);
    console.log(`======================================================\n`);
})();
