<?php
/**
 * Login / Register Form Override with Native Mobile OTP + Unified Account Linking
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
            <p class="auth-subtitle">Login or access your orders instantly with your 10-digit mobile number</p>
        </div>

        <!-- Real-Time Alert Notification Box -->
        <div id="sribalaji-auth-alert" class="sribalaji-auth-alert" style="display: none;" role="alert"></div>

        <!-- VIEW 1: Native Mobile Number + OTP Login (Primary Experience) -->
        <div id="sribalaji-otp-view" class="sribalaji-auth-section">

            <!-- STEP 1: Enter Phone Number -->
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
                <p class="auth-field-hint">We'll send a 6-digit One Time Password (OTP) to your phone.</p>

                <button type="button" id="sribalaji-send-otp-btn" class="sribalaji-btn-primary">
                    <span>Send OTP</span> &rarr;
                </button>
            </div>

            <!-- STEP 2: Enter 6-Digit OTP (Hidden Initially) -->
            <div id="sribalaji-step-otp" class="auth-step-block" style="display: none;">
                <div class="otp-verification-header">
                    <span class="otp-sent-notice">OTP sent to <strong id="sribalaji-display-phone">+91 XXXXX XXXXX</strong></span>
                    <button type="button" id="sribalaji-edit-phone-btn" class="auth-text-link">Edit Number</button>
                </div>

                <label for="sribalaji-otp-input" class="auth-input-label">Enter 6-Digit OTP</label>
                <input type="text" 
                       id="sribalaji-otp-input" 
                       class="sribalaji-otp-field" 
                       placeholder="• • • • • •" 
                       maxlength="6" 
                       inputmode="numeric" 
                       autocomplete="one-time-code" 
                       required />

                <button type="button" id="sribalaji-verify-otp-btn" class="sribalaji-btn-primary">
                    <span>Verify &amp; Sign In</span> &rarr;
                </button>

                <div class="auth-resend-wrap">
                    <span>Didn't receive code?</span>
                    <button type="button" id="sribalaji-resend-btn" class="auth-text-link is-disabled" disabled>
                        Resend OTP <span id="sribalaji-timer-text"></span>
                    </button>
                </div>
            </div>

            <div class="auth-divider">
                <span>OR</span>
            </div>

            <!-- Switch to Email/Password -->
            <div class="auth-alternate-toggle">
                <button type="button" id="sribalaji-toggle-password-view" class="auth-switch-btn">
                    🔑 Sign In with Email &amp; Password instead
                </button>
            </div>

        </div>

        <!-- VIEW 2: Classic Email & Password Login (Hidden by Default) -->
        <div id="sribalaji-password-view" class="sribalaji-auth-section" style="display: none;">
            <div class="classic-login-header">
                <h3>Email &amp; Password Sign In</h3>
                <p>Access with your registered email or username</p>
            </div>

            <form class="woocommerce-form woocommerce-form-login login" method="post">
                <?php do_action( 'woocommerce_login_form_start' ); ?>

                <div class="auth-step-block">
                    <label for="username" class="auth-input-label">
                        Mobile Number, Email, or Username <span class="required">*</span>
                    </label>
                    <input type="text" 
                           class="woocommerce-Input woocommerce-Input--text input-text sribalaji-phone-field" 
                           name="username" 
                           id="username" 
                           autocomplete="username" 
                           placeholder="Enter phone, email or username" 
                           value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" 
                           required />
                </div>

                <div class="auth-step-block">
                    <div class="auth-label-row">
                        <label for="password" class="auth-input-label">
                            Password <span class="required">*</span>
                        </label>
                        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="auth-text-link">
                            Forgot?
                        </a>
                    </div>
                    <input class="woocommerce-Input woocommerce-Input--text input-text sribalaji-phone-field" 
                           type="password" 
                           name="password" 
                           id="password" 
                           placeholder="Enter your password" 
                           autocomplete="current-password" 
                           required />
                </div>

                <?php do_action( 'woocommerce_login_form' ); ?>

                <div class="auth-action-row">
                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> 
                        <span>Remember me</span>
                    </label>
                </div>

                <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                
                <button type="submit" 
                        class="woocommerce-button button woocommerce-form-login__submit sribalaji-btn-primary" 
                        name="login" 
                        value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>">
                    <span>Sign In</span> &rarr;
                </button>

                <?php do_action( 'woocommerce_login_form_end' ); ?>
            </form>

            <div class="auth-divider">
                <span>OR</span>
            </div>

            <div class="auth-alternate-toggle">
                <button type="button" id="sribalaji-toggle-otp-view" class="auth-switch-btn">
                    📱 Return to Mobile Number &amp; OTP Login
                </button>
            </div>
        </div>

    </div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
