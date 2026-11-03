<?php
/**
 * Login / Register Form Override for Sri Balaji Books & Stationery
 *
 * Implements Mandatory Dual-Identifier Onboarding:
 * - Every account is guaranteed to have BOTH a verified 10-digit Mobile Number AND an Email Address.
 * - OTP login prompts new users to confirm their email, automatically linking any existing orders/accounts.
 * - Email registration strictly requires a 10-digit mobile number.
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
            <span class="auth-trust-pill">🛡️ SECURE CUSTOMER ACCESS</span>
            <h2 class="auth-title">Sri Balaji Books &amp; Stationery</h2>
            <p class="auth-subtitle">Sign in with your mobile number or email to access orders and track shipments</p>
        </div>

        <!-- Real-Time Alert Notification Box -->
        <div id="sribalaji-auth-alert" class="sribalaji-auth-alert" style="display: none;" role="alert"></div>

        <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
        <div class="u-columns col2-set" id="customer_login">
            <div class="u-column1 col-1">
        <?php endif; ?>

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
                            <span>Verify OTP</span> &rarr;
                        </button>

                        <div class="auth-resend-wrap">
                            <span>Didn't receive code?</span>
                            <button type="button" id="sribalaji-resend-btn" class="auth-text-link is-disabled" disabled>
                                Resend OTP <span id="sribalaji-timer-text"></span>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 3: Mandatory Email Confirmation (Shown for New / Unlinked Users) -->
                    <div id="sribalaji-step-email" class="auth-step-block" style="display: none;">
                        <div class="onboarding-step-header">
                            <span class="auth-trust-pill" style="margin-bottom: 0.35rem;">STEP 2 OF 2</span>
                            <h3 style="font-size: 1.15rem; color: #1e3a8a; margin: 0 0 0.35rem 0;">Confirm Your Email Address</h3>
                            <p style="font-size: 0.82rem; color: #475569; margin: 0 0 1rem 0;">
                                Please confirm your email address to complete registration. If you already have past orders or an account with this email, they will be automatically linked!
                            </p>
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label for="sribalaji-confirm-email" class="auth-input-label">Email Address <span class="required">*</span></label>
                            <input type="email" 
                                   id="sribalaji-confirm-email" 
                                   class="sribalaji-phone-field" 
                                   placeholder="e.g. user@example.com" 
                                   autocomplete="email" 
                                   required />
                        </div>

                        <div style="margin-bottom: 1.25rem;">
                            <div class="auth-label-row">
                                <label for="sribalaji-confirm-password" class="auth-input-label">Create Password <span class="optional">(Optional)</span></label>
                            </div>
                            <input type="password" 
                                   id="sribalaji-confirm-password" 
                                   class="sribalaji-phone-field" 
                                   placeholder="Create a password for email login" 
                                   autocomplete="new-password" />
                            <p class="auth-field-hint">Allows you to sign in with either your Mobile OTP or Email + Password.</p>
                        </div>

                        <button type="button" id="sribalaji-complete-onboarding-btn" class="sribalaji-btn-primary">
                            <span>Complete &amp; Access My Account</span> &rarr;
                        </button>
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
                        <p>Access with your registered email, mobile number, or username</p>
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
                                   placeholder="10-digit mobile or email address" 
                                   value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" 
                                   required />
                        </div>

                        <div class="auth-step-block">
                            <div class="auth-label-row">
                                <label for="password" class="auth-input-label">
                                    Password <span class="required">*</span>
                                </label>
                                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="auth-text-link">
                                    Forgot password?
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

        <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
            </div>

            <!-- MANDATORY DUAL-IDENTIFIER REGISTRATION -->
            <div class="u-column2 col-2">
                <div class="sribalaji-auth-section">
                    <h3 class="auth-section-title"><?php esc_html_e( 'Register New Account', 'woocommerce' ); ?></h3>

                    <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

                        <?php do_action( 'woocommerce_register_form_start' ); ?>

                        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text sribalaji-phone-field" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
                            </p>
                        <?php endif; ?>

                        <!-- Mandatory Email -->
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text sribalaji-phone-field" name="email" id="reg_email" autocomplete="email" placeholder="e.g. user@example.com" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" required />
                        </p>

                        <!-- Mandatory 10-Digit Mobile Number -->
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_billing_phone">Mobile Number (10 digits)&nbsp;<span class="required">*</span></label>
                            <input type="tel" class="woocommerce-Input woocommerce-Input--text input-text sribalaji-phone-field" name="billing_phone" id="reg_billing_phone" placeholder="Enter 10-digit mobile number" maxlength="10" pattern="[0-9]{10}" inputmode="numeric" required />
                        </p>

                        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text sribalaji-phone-field" name="password" id="reg_password" autocomplete="new-password" required />
                            </p>
                        <?php else : ?>
                            <p><?php esc_html_e( 'A link to set a new password will be sent to your email address.', 'woocommerce' ); ?></p>
                        <?php endif; ?>

                        <?php do_action( 'woocommerce_register_form' ); ?>

                        <p class="woocommerce-form-row form-row">
                            <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                            <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit sribalaji-btn-primary" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
                        </p>

                        <?php do_action( 'woocommerce_register_form_end' ); ?>

                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
