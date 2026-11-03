/**
 * Sri Balaji Books & Stationery — Native Mobile Number + OTP Login Engine
 * 
 * Features Mandatory Dual-Identifier Onboarding:
 * - If user is new or has no email linked, immediately transitions to Step 3 (Confirm Email).
 * - If user already has both verified phone and email, logs in instantly.
 */
(function($) {
    'use strict';

    if (typeof sribalaji_auth_params === 'undefined') {
        return;
    }

    var ajaxUrl = sribalaji_auth_params.ajax_url;
    var nonce = sribalaji_auth_params.nonce;
    var redirectUrl = sribalaji_auth_params.redirect_url;
    var resendTimer = null;
    var countdown = 30;
    var verifiedPhone = '';

    function showNotice(msg, type) {
        var $alert = $('#sribalaji-auth-alert');
        $alert.removeClass('alert-success alert-error')
              .addClass('alert-' + type)
              .html(msg)
              .slideDown(200);
    }

    function clearNotice() {
        $('#sribalaji-auth-alert').hide().empty();
    }

    function startTimer() {
        clearInterval(resendTimer);
        countdown = 30;
        var $btn = $('#sribalaji-resend-btn');
        var $timerText = $('#sribalaji-timer-text');

        $btn.addClass('is-disabled').prop('disabled', true);
        $timerText.text('(' + countdown + 's)');

        resendTimer = setInterval(function() {
            countdown--;
            if (countdown > 0) {
                $timerText.text('(' + countdown + 's)');
            } else {
                clearInterval(resendTimer);
                $timerText.empty();
                $btn.removeClass('is-disabled').prop('disabled', false);
            }
        }, 1000);
    }

    $(document).ready(function() {

        // 1. Send OTP Click Handler
        $('#sribalaji-send-otp-btn').on('click', function(e) {
            e.preventDefault();
            clearNotice();

            var phone = $.trim($('#sribalaji-phone-input').val()).replace(/[^0-9]/g, '');
            if (phone.length > 10 && phone.substring(0, 2) === '91') {
                phone = phone.substring(2);
            } else if (phone.length > 10) {
                phone = phone.slice(-10);
            }

            if (phone.length !== 10) {
                showNotice('Please enter a valid 10-digit Indian mobile number.', 'error');
                $('#sribalaji-phone-input').focus();
                return;
            }

            var $btn = $(this);
            var originalText = $btn.html();
            $btn.prop('disabled', true).html('Sending OTP...');

            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'sribalaji_send_otp',
                    nonce: nonce,
                    phone: phone
                },
                success: function(res) {
                    $btn.prop('disabled', false).html(originalText);
                    if (res && res.success) {
                        verifiedPhone = phone;
                        $('#sribalaji-display-phone').text('+91 ' + phone);
                        $('#sribalaji-step-phone').slideUp(200, function() {
                            $('#sribalaji-step-otp').slideDown(200);
                            $('#sribalaji-otp-input').focus();
                        });
                        startTimer();
                        showNotice(res.data.message || 'OTP sent successfully!', 'success');
                    } else {
                        var err = (res && res.data && res.data.message) ? res.data.message : 'Failed to send OTP. Please try again.';
                        showNotice(err, 'error');
                    }
                },
                error: function() {
                    $btn.prop('disabled', false).html(originalText);
                    showNotice('Network error occurred. Please try again.', 'error');
                }
            });
        });

        // 2. Verify OTP Click Handler
        $('#sribalaji-verify-otp-btn').on('click', function(e) {
            e.preventDefault();
            clearNotice();

            var phone = $.trim($('#sribalaji-phone-input').val()).replace(/[^0-9]/g, '');
            var otp = $.trim($('#sribalaji-otp-input').val()).replace(/[^0-9]/g, '');

            if (otp.length < 4 || otp.length > 6) {
                showNotice('Please enter the 6-digit OTP code received.', 'error');
                $('#sribalaji-otp-input').focus();
                return;
            }

            var $btn = $(this);
            var originalText = $btn.html();
            $btn.prop('disabled', true).html('Verifying...');

            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'sribalaji_verify_otp',
                    nonce: nonce,
                    phone: phone,
                    otp: otp
                },
                success: function(res) {
                    $btn.prop('disabled', false).html(originalText);
                    if (res && res.success) {
                        verifiedPhone = phone;

                        // Check if customer needs to confirm their email (First-time / unlinked user)
                        if (res.data && res.data.needs_email) {
                            showNotice('Phone number verified! Please confirm your email address below to finish setup.', 'success');
                            $('#sribalaji-step-otp').slideUp(200, function() {
                                $('#sribalaji-step-email').slideDown(200);
                                $('#sribalaji-confirm-email').focus();
                            });
                        } else {
                            // Returning user with both phone and email already linked
                            showNotice(res.data.message || 'Login successful! Redirecting...', 'success');
                            setTimeout(function() {
                                window.location.href = res.data.redirect_url || redirectUrl;
                            }, 800);
                        }
                    } else {
                        var err = (res && res.data && res.data.message) ? res.data.message : 'Invalid OTP code. Please try again.';
                        showNotice(err, 'error');
                    }
                },
                error: function() {
                    $btn.prop('disabled', false).html(originalText);
                    showNotice('Verification failed due to a network error.', 'error');
                }
            });
        });

        // 3. Complete Email Onboarding (Mandatory Dual-Identifier Step)
        $('#sribalaji-complete-onboarding-btn').on('click', function(e) {
            e.preventDefault();
            clearNotice();

            var email = $.trim($('#sribalaji-confirm-email').val());
            var password = $.trim($('#sribalaji-confirm-password').val());

            if (!email || email.indexOf('@') === -1 || email.indexOf('.') === -1) {
                showNotice('Please enter a valid email address to complete your account.', 'error');
                $('#sribalaji-confirm-email').focus();
                return;
            }

            var $btn = $(this);
            var originalText = $btn.html();
            $btn.prop('disabled', true).html('Saving Profile...');

            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'sribalaji_complete_email_onboarding',
                    nonce: nonce,
                    phone: verifiedPhone,
                    email: email,
                    password: password
                },
                success: function(res) {
                    if (res && res.success) {
                        showNotice(res.data.message || 'Account verified and ready! Redirecting...', 'success');
                        setTimeout(function() {
                            window.location.href = res.data.redirect_url || redirectUrl;
                        }, 800);
                    } else {
                        $btn.prop('disabled', false).html(originalText);
                        var err = (res && res.data && res.data.message) ? res.data.message : 'Could not link email. Please check and try again.';
                        showNotice(err, 'error');
                    }
                },
                error: function() {
                    $btn.prop('disabled', false).html(originalText);
                    showNotice('A server error occurred. Please try again.', 'error');
                }
            });
        });

        // 4. Edit Phone Number
        $('#sribalaji-edit-phone-btn').on('click', function(e) {
            e.preventDefault();
            clearNotice();
            clearInterval(resendTimer);
            $('#sribalaji-step-otp').slideUp(200, function() {
                $('#sribalaji-step-phone').slideDown(200);
                $('#sribalaji-phone-input').focus();
            });
        });

        // 5. Resend OTP
        $('#sribalaji-resend-btn').on('click', function(e) {
            e.preventDefault();
            if ($(this).hasClass('is-disabled')) {
                return;
            }
            $('#sribalaji-send-otp-btn').trigger('click');
        });

        // 6. Toggle Views between OTP and Email/Password
        $('#sribalaji-toggle-password-view').on('click', function(e) {
            e.preventDefault();
            clearNotice();
            $('#sribalaji-otp-view').slideUp(200, function() {
                $('#sribalaji-password-view').slideDown(200);
            });
        });

        $('#sribalaji-toggle-otp-view').on('click', function(e) {
            e.preventDefault();
            clearNotice();
            $('#sribalaji-password-view').slideUp(200, function() {
                $('#sribalaji-otp-view').slideDown(200);
            });
        });

        // Enter key bindings
        $('#sribalaji-phone-input').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#sribalaji-send-otp-btn').trigger('click');
            }
        });

        $('#sribalaji-otp-input').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#sribalaji-verify-otp-btn').trigger('click');
            }
        });

        $('#sribalaji-confirm-email, #sribalaji-confirm-password').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#sribalaji-complete-onboarding-btn').trigger('click');
            }
        });

    });

})(jQuery);
