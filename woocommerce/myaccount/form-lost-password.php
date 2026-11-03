<?php
/**
 * Lost Password Form Override for Sri Balaji Books & Stationery
 *
 * Provides a clean, branded card for password reset with an instant
 * alternative to log in via Mobile OTP if email delivery is delayed.
 *
 * @package SriBalajiTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_lost_password_form' );
?>

<div class="sribalaji-auth-wrapper">
    <div class="sribalaji-auth-card">
        
        <div class="sribalaji-auth-header">
            <span class="auth-trust-pill">🔐 ACCOUNT RECOVERY</span>
            <h2 class="auth-title">Reset Your Password</h2>
            <p class="auth-subtitle">Enter your registered email address or username to receive a password reset link.</p>
        </div>

        <form method="post" class="woocommerce-ResetPassword lost_reset_password">

            <div class="auth-step-block">
                <label for="user_login" class="auth-input-label">
                    Email Address or Username <span class="required">*</span>
                </label>
                <input class="woocommerce-Input woocommerce-Input--text input-text sribalaji-phone-field" 
                       type="text" 
                       name="user_login" 
                       id="user_login" 
                       placeholder="Enter registered email (e.g. madhavamrao@gmail.com)" 
                       autocomplete="username" 
                       required />
                <p class="auth-field-hint">A secure link to create a new password will be sent to your email.</p>
            </div>

            <div class="clear"></div>

            <?php do_action( 'woocommerce_lostpassword_form' ); ?>

            <p class="form-row" style="margin-top: 1rem;">
                <input type="hidden" name="wc_reset_password" value="true" />
                <button type="submit" class="woocommerce-Button button sribalaji-btn-primary" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>">
                    <span>Send Password Reset Link</span> &rarr;
                </button>
            </p>

            <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

        </form>

        <div class="auth-divider">
            <span>OR FAST ACCESS</span>
        </div>

        <!-- Instant Alternative: Sign In with Mobile Number & OTP without password -->
        <div class="auth-alternate-toggle">
            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="auth-switch-btn" style="display: block; text-decoration: none; text-align: center; padding: 0.75rem 1rem;">
                📱 Sign In with Mobile Number &amp; OTP (No Password Needed)
            </a>
        </div>

    </div>
</div>

<?php do_action( 'woocommerce_after_lost_password_form' ); ?>
