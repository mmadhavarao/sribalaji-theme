# Sri Balaji Books — Custom WordPress Starter Theme
A lightweight, blazingly fast, zero-bloat e-commerce starter theme designed for continuous deployment from GitHub to Hostinger.

## Repository Structure
* `style.css` - Theme header metadata & responsive modern styling
* `functions.php` - Native WooCommerce support & style enqueuing
* `header.php` - Responsive site header with dynamic navigation & live cart counter
* `footer.php` - Clean, lightweight footer
* `index.php` - Storefront homepage with Git badge and automated WooCommerce product grid
* `screenshot.png` - Theme thumbnail preview in WordPress Admin

## Quick Deployment to Hostinger
1. Push this repository to GitHub:
   ```bash
   git init
   git add .
   git commit -m "Initial commit: Sri Balaji Books Custom Theme"
   git branch -M main
   git remote add origin https://github.com/<YOUR_USERNAME>/sribalaji-theme.git
   git push -u origin main
   ```
2. In Hostinger hPanel:
   * Select `stg.sribalajibooks.com` in top dropdown.
   * Go to **Advanced** > **Git**.
   * Repository: `https://github.com/<YOUR_USERNAME>/sribalaji-theme.git`
   * Branch: `main`
   * Install Path: `public_html/wp-content/themes/sribalaji-theme`
   * Click **Create** / **Deploy**.
3. In WP Admin (`stg.sribalajibooks.com/wp-admin`):
   * Go to **Appearance** > **Themes** > Click **Activate** on "Sri Balaji Books Custom".
