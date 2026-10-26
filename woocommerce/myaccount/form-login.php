<?php
/**
 * Login / Register Form Override with Firebase Mobile + OTP Authentication
 *
 * @package SriBalajiTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_customer_login_form' );
?>

<div class="sribalaji-auth-wrapper">
    <div class="sribalaji-auth-card">
        
        <!-- Store Identity & Security Trust Badge -->
        <div class="sribalaji-auth-header">
            <span class="auth-trust-pill">🛡️ SECURE 1-CLICK LOGIN</span>
            <h2 class="auth-title">Sri Balaji Books &amp; Stationery</h2>
            <p class="auth-subtitle">Login or create your customer account with your 10-digit mobile number</p>
        </div>

        <!-- Alert Notification Box -->
        <div id="sribalaji-auth-alert" class="sribalaji-auth-alert" style="display: none;" role="alert"></div>

        <!-- PRIMARY: Mobile Number + OTP Login Section -->
        <div id="sribalaji-otp-auth-box" class="sribalaji-auth-section">

            <!-- STEP 1: Phone Number Input Form -->
            <div id="sribalaji-step-phone" class="auth-step-block">
                <label for="sribalaji-phone-input" class="auth-input-label">Mobile Number</label>
                <div class="sribalaji-phone-input-group">
                    <span class="country-code-badge">
                        <span class="flag-icon">🇮🇳</span> +91
                    </span>
                    <input type="tel" 
                           id="sribalaji-phone-input" 
                           class="sribalaji-phone-field" 
                           placeholder="Enter 10-digit mobile number" 
                           maxlength="10" 
                           pattern="[0-9]{10}"
                           inputmode="numeric" 
                           autocomplete="tel-national" 
                           required />
                </div>
                <p class="auth-field-hint">We'll send a 6-digit One Time Password (OTP) via SMS.</p>

                <!-- Invisible reCAPTCHA Anchor -->
                <div id="sribalaji-recaptcha-container"></div>

                <button type="button" id="sribalaji-send-otp-btn" class="sribalaji-btn-primary">
                    <span>Send OTP via SMS</span> &rarr;
                </button>
            </div>

            <!-- STEP 2: 6-Digit OTP Verification Form (Hidden Initially) -->
            <div id="sribalaji-step-otp" class="auth-step-block" style="display: none;">
                <div class="otp-verification-header">
                    <span class="otp-sent-notice">OTP sent to <strong id="sribalaji-display-phone">+91 XXXXX XXXXX</strong></span>
                    <button type="button" id="sribalaji-change-phone-btn" class="auth-text-link">Edit Number</button>
                </div>

                <label for="sribalaji-otp-code" class="auth-input-label">Enter 6-Digit OTP</label>
                <input type="text" 
                       id="sribalaji-otp-code" 
                       class="sribalaji-otp-field" 
                       placeholder="• • • • • •" 
                       maxlength="6" 
                       inputmode="numeric" 
                       autocomplete="one-time-code" 
                       required />

                <button type="button" id="sribalaji-verify-otp-btn" class="sribalaji-btn-primary">
                    <span>Verify OTP &amp; Login</span>
                </button>

                <div id="sribalaji-resend-wrap" class="auth-resend-wrap">
                    <span>Didn't receive SMS?</span>
                    <button type="button" id="sribalaji-resend-otp-btn" class="auth-text-link is-disabled" disabled>
                        Resend OTP <span id="sribalaji-timer-countdown"></span>
                    </button>
                </div>
            </div>

            <div class="auth-divider">
                <span>OR</span>
            </div>

            <!-- Secondary Action: Switch to Classic Email/Password -->
            <div class="auth-alternate-toggle">
                <button type="button" id="sribalaji-toggle-classic-login" class="auth-switch-btn">
                    🔑 Login with Email &amp; Password instead
                </button>
            </div>

        </div>

        <!-- SECONDARY: Classic WooCommerce Email & Password (Hidden by Default) -->
        <div id="sribalaji-classic-login-box" class="sribalaji-auth-section" style="display: none;">
            <div class="classic-login-header">
                <h3>Admin &amp; Staff Email Login</h3>
                <p>Standard WordPress username and password access</p>
            </div>

            <form class="woocommerce-form woocommerce-form-login login" method="post">
                <?php do_action( 'woocommerce_login_form_start' ); ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
                </p>

                <?php do_action( 'woocommerce_login_form' ); ?>

                <p class="form-row">
                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
                    </label>
                    <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                    <button type="submit" class="woocommerce-button button woocommerce-form-login__submit sribalaji-btn-primary" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
                </p>
                <p class="woocommerce-LostPassword lost_password">
                    <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
                </p>

                <?php do_action( 'woocommerce_login_form_end' ); ?>
            </form>

            <div class="auth-divider">
                <span>OR</span>
            </div>

            <div class="auth-alternate-toggle">
                <button type="button" id="sribalaji-toggle-otp-login" class="auth-switch-btn">
                    📱 Return to Mobile Number &amp; OTP Login
                </button>
            </div>
        </div>

    </div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
