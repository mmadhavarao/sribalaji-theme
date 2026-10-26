/**
 * Sri Balaji Books & Stationery — Firebase Mobile Number + OTP Authentication
 *
 * Client-side script handling invisible reCAPTCHA, phone verification,
 * SMS OTP confirmation, and WordPress customer session establishment.
 */

(function($) {
    'use strict';

    if (typeof sribalaji_firebase_params === 'undefined') {
        return;
    }

    var config = sribalaji_firebase_params.firebase_config;
    var ajaxUrl = sribalaji_firebase_params.ajax_url;
    var nonce = sribalaji_firebase_params.nonce;
    var redirectUrl = sribalaji_firebase_params.redirect_url;

    // Initialize Firebase if not already initialized
    if (!firebase.apps.length) {
        firebase.initializeApp(config);
    }

    var confirmationResult = null;
    var recaptchaVerifier = null;
    var resendTimer = null;
    var countdownSeconds = 30;

    function initRecaptcha() {
        if (!recaptchaVerifier) {
            recaptchaVerifier = new firebase.auth.RecaptchaVerifier('sribalaji-recaptcha-container', {
                'size': 'invisible',
                'callback': function(response) {
                    // reCAPTCHA solved automatically
                },
                'expired-callback': function() {
                    showMessage('reCAPTCHA expired. Please request OTP again.', 'error');
                }
            });
            recaptchaVerifier.render().catch(function(err) {
                console.error('reCAPTCHA render error:', err);
            });
        }
    }

    function showMessage(msg, type) {
        var $alert = $('#sribalaji-auth-alert');
        $alert.removeClass('alert-success alert-error').addClass('alert-' + type).html(msg).slideDown();
    }

    function clearMessage() {
        $('#sribalaji-auth-alert').hide().empty();
    }

    function startResendCountdown() {
        clearInterval(resendTimer);
        countdownSeconds = 30;
        var $resendBtn = $('#sribalaji-resend-otp-btn');
        var $countdownText = $('#sribalaji-timer-countdown');

        $resendBtn.prop('disabled', true).addClass('is-disabled');
        $('#sribalaji-resend-wrap').show();
        $countdownText.text('(' + countdownSeconds + 's)');

        resendTimer = setInterval(function() {
            countdownSeconds--;
            if (countdownSeconds <= 0) {
                clearInterval(resendTimer);
                $resendBtn.prop('disabled', false).removeClass('is-disabled');
                $countdownText.text('');
            } else {
                $countdownText.text('(' + countdownSeconds + 's)');
            }
        }, 1000);
    }

    // Step 1: Send OTP Handler
    $(document).on('click', '#sribalaji-send-otp-btn', function(e) {
        e.preventDefault();
        clearMessage();

        var rawPhone = $('#sribalaji-phone-input').val().replace(/[^0-9]/g, '');
        if (rawPhone.length !== 10) {
            showMessage('Please enter a valid 10-digit Indian mobile number.', 'error');
            $('#sribalaji-phone-input').focus();
            return;
        }

        var fullPhoneNumber = '+91' + rawPhone;
        var $btn = $(this);
        $btn.prop('disabled', true).text('Sending OTP...');

        try {
            initRecaptcha();
        } catch (e) {
            console.error('Recaptcha init error:', e);
        }

        firebase.auth().signInWithPhoneNumber(fullPhoneNumber, recaptchaVerifier)
            .then(function(result) {
                confirmationResult = result;
                $btn.prop('disabled', false).text('Get OTP');

                // Switch UI to Step 2 (OTP Entry)
                $('#sribalaji-step-phone').slideUp(200, function() {
                    $('#sribalaji-display-phone').text('+91 ' + rawPhone);
                    $('#sribalaji-step-otp').slideDown(250);
                    $('#sribalaji-otp-code').focus();
                    startResendCountdown();
                });
                showMessage('OTP sent successfully via SMS to +91 ' + rawPhone, 'success');
            })
            .catch(function(error) {
                $btn.prop('disabled', false).text('Get OTP');
                console.error('Firebase Auth Error:', error);

                var errorMsg = 'Failed to send OTP. Please try again.';
                if (error.code === 'auth/invalid-phone-number') {
                    errorMsg = 'Invalid phone number format.';
                } else if (error.code === 'auth/quota-exceeded') {
                    errorMsg = 'Daily SMS verification limit reached. Please contact support or try again tomorrow.';
                } else if (error.code === 'auth/too-many-requests') {
                    errorMsg = 'Too many requests. Please wait a few moments before trying again.';
                } else if (error.code === 'auth/unauthorized-domain') {
                    errorMsg = 'This domain is not authorized in Firebase Console.';
                } else if (error.message) {
                    errorMsg = error.message;
                }

                showMessage(errorMsg, 'error');

                // Reset recaptcha if needed
                if (recaptchaVerifier) {
                    recaptchaVerifier.render().then(function(widgetId) {
                        if (typeof grecaptcha !== 'undefined') {
                            grecaptcha.reset(widgetId);
                        }
                    });
                }
            });
    });

    // Step 2: Verify OTP Handler
    $(document).on('click', '#sribalaji-verify-otp-btn', function(e) {
        e.preventDefault();
        clearMessage();

        var otp = $('#sribalaji-otp-code').val().replace(/[^0-9]/g, '');
        if (otp.length < 6) {
            showMessage('Please enter the complete 6-digit OTP.', 'error');
            $('#sribalaji-otp-code').focus();
            return;
        }

        if (!confirmationResult) {
            showMessage('Session expired. Please request a new OTP.', 'error');
            return;
        }

        var $btn = $(this);
        $btn.prop('disabled', true).text('Verifying...');

        confirmationResult.confirm(otp)
            .then(function(result) {
                var user = result.user;
                return user.getIdToken().then(function(idToken) {
                    // Send to WordPress backend via AJAX
                    $.ajax({
                        url: ajaxUrl,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            action: 'sribalaji_phone_login_verify',
                            phone: user.phoneNumber,
                            id_token: idToken,
                            nonce: nonce,
                            redirect_to: redirectUrl
                        },
                        success: function(response) {
                            if (response.success) {
                                showMessage('Verification successful! Logging you in...', 'success');
                                window.location.href = response.data.redirect_url || redirectUrl;
                            } else {
                                $btn.prop('disabled', false).text('Verify & Login');
                                showMessage(response.data.message || 'Login failed. Please try again.', 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            $btn.prop('disabled', false).text('Verify & Login');
                            showMessage('Server communication error. Please try again.', 'error');
                        }
                    });
                });
            })
            .catch(function(error) {
                $btn.prop('disabled', false).text('Verify & Login');
                console.error('OTP Confirm Error:', error);
                var errorMsg = 'Invalid verification code. Please check your SMS and try again.';
                if (error.code === 'auth/code-expired') {
                    errorMsg = 'OTP has expired. Please click "Resend OTP".';
                }
                showMessage(errorMsg, 'error');
            });
    });

    // Change Phone Number Link
    $(document).on('click', '#sribalaji-change-phone-btn', function(e) {
        e.preventDefault();
        clearMessage();
        clearInterval(resendTimer);
        $('#sribalaji-step-otp').slideUp(200, function() {
            $('#sribalaji-step-phone').slideDown(250);
            $('#sribalaji-phone-input').focus();
        });
    });

    // Resend OTP Link
    $(document).on('click', '#sribalaji-resend-otp-btn', function(e) {
        e.preventDefault();
        if ($(this).prop('disabled')) return;
        $('#sribalaji-send-otp-btn').trigger('click');
    });

    // Toggle between Phone OTP and Classic Email/Password
    $(document).on('click', '#sribalaji-toggle-classic-login', function(e) {
        e.preventDefault();
        $('#sribalaji-otp-auth-box').slideUp(200);
        $('#sribalaji-classic-login-box').slideDown(250);
    });

    $(document).on('click', '#sribalaji-toggle-otp-login', function(e) {
        e.preventDefault();
        $('#sribalaji-classic-login-box').slideUp(200);
        $('#sribalaji-otp-auth-box').slideDown(250);
    });

})(jQuery);
