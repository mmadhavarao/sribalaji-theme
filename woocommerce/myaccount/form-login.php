<?php
/**
 * Login / Register Form Override for Sri Balaji Books & Stationery
 *
 * Supports login via 10-digit Indian Mobile Number, Email Address, or Username.
 * Works seamlessly with Razorpay 1-Click Magic Checkout so all orders
 * and customer profiles are unified under one single account.
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
            <p class="auth-subtitle">Sign in to track orders, manage addresses, and view your purchase history</p>
        </div>

        <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
        <div class="u-columns col2-set" id="customer_login">
            <div class="u-column1 col-1">
        <?php endif; ?>

                <div class="sribalaji-auth-section">
                    <form class="woocommerce-form woocommerce-form-login login" method="post">

                        <?php do_action( 'woocommerce_login_form_start' ); ?>

                        <!-- Unified Input: Phone or Email -->
                        <div class="auth-step-block">
                            <label for="username" class="auth-input-label">
                                Mobile Number or Email Address <span class="required">*</span>
                            </label>
                            <div class="sribalaji-login-input-wrap">
                                <input type="text" 
                                       class="woocommerce-Input woocommerce-Input--text input-text sribalaji-phone-field" 
                                       name="username" 
                                       id="username" 
                                       autocomplete="username" 
                                       placeholder="10-digit mobile (e.g. 9845012345) or email" 
                                       value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" 
                                       required />
                            </div>
                            <p class="auth-field-hint">💡 Tip: You can enter your 10-digit mobile number or your email address.</p>
                        </div>

                        <!-- Password -->
                        <div class="auth-step-block">
                            <div class="auth-label-row">
                                <label for="password" class="auth-input-label">
                                    <?php esc_html_e( 'Password', 'woocommerce' ); ?> <span class="required">*</span>
                                </label>
                                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="auth-text-link">
                                    <?php esc_html_e( 'Forgot Password?', 'woocommerce' ); ?>
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
                                <span><?php esc_html_e( 'Keep me signed in', 'woocommerce' ); ?></span>
                            </label>
                        </div>

                        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                        
                        <button type="submit" 
                                class="woocommerce-button button woocommerce-form-login__submit sribalaji-btn-primary" 
                                name="login" 
                                value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>">
                            <span>Sign In to My Account</span> &rarr;
                        </button>

                        <?php do_action( 'woocommerce_login_form_end' ); ?>

                    </form>

                    <!-- Razorpay Magic Checkout Trust Banner -->
                    <div class="auth-razorpay-notice">
                        <div class="notice-icon">⚡</div>
                        <div class="notice-text">
                            <strong>Shopping on Sri Balaji?</strong>
                            <span>You can also use 1-Click Mobile OTP Checkout at the cart without needing a password.</span>
                        </div>
                    </div>

                </div>

        <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
            </div>

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

                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text sribalaji-phone-field" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" required />
                        </p>

                        <!-- Optional Mobile Number during registration -->
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_billing_phone">Mobile Number (10 digits)&nbsp;<span class="required">*</span></label>
                            <input type="tel" class="woocommerce-Input woocommerce-Input--text input-text sribalaji-phone-field" name="billing_phone" id="reg_billing_phone" placeholder="9845012345" maxlength="10" pattern="[0-9]{10}" inputmode="numeric" />
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
