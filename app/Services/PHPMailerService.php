<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerService
{
    public function sendOtpMail($toEmail, $toName, $otp): bool
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST', 'smtp.gmail.com');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME');
            $mail->Password   = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');
            $mail->Port       = env('MAIL_PORT', 587);

            // Recipients
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME', 'OTP System'));
            $mail->addAddress($toEmail, $toName);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body    = "<p>Your OTP is: <strong>{$otp}</strong></p><p>This OTP is valid for 5 minutes.</p>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            logger()->error('PHPMailer Error: ' . $mail->ErrorInfo);
            return false;
        }
    }

    public function sendNewsletterEmail($toEmail, $emailData): bool
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST', 'smtp.gmail.com');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME');
            $mail->Password   = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');
            $mail->Port       = env('MAIL_PORT', 587);

            // Recipients
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME', 'Newsletter'));
            $mail->addAddress($toEmail);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $emailData['subject'];

            // Generate email body using template
            $emailBody = view('emails.newsletter-template', [
                'subject' => $emailData['subject'],
                'message' => $emailData['message'],
                'subscriber' => $emailData['subscriber']
            ])->render();

            $mail->Body = $emailBody;

            $mail->send();
            return true;
        } catch (Exception $e) {
            logger()->error('Newsletter Email Error: ' . $mail->ErrorInfo);
            return false;
        }
    }

    // send password reset email
    public function sendPasswordResetEmail($toEmail, $details): bool
    {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST', 'smtp.gmail.com');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME');
            $mail->Password   = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');
            $mail->Port       = env('MAIL_PORT', 587);

            // Recipients
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME', 'Standing On The Rock'));
            $mail->addAddress($toEmail);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Link - ' . config('app.name');

            $resetLink = route('reset.password', [$details['id'], $details['token']]);
            $mail->Body = "
            <div style='max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;'>
                <div style='background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>
                    <div style='text-align: center; margin-bottom: 30px;'>
                        <h1 style='color: #2c3e50; margin: 0; font-size: 28px;'>Password Reset</h1>
                        <p style='color: #7f8c8d; margin: 10px 0 0 0;'>Standing On The Rock</p>
                    </div>

                    <div style='margin-bottom: 30px;'>
                        <p style='color: #34495e; font-size: 16px; line-height: 1.6; margin-bottom: 20px;'>
                            Hello,
                        </p>
                        <p style='color: #34495e; font-size: 16px; line-height: 1.6; margin-bottom: 20px;'>
                            We received a request to reset your password. Click the button below to create a new password:
                        </p>
                    </div>

                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='{$resetLink}' style='background-color: #3498db; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px; display: inline-block; box-shadow: 0 2px 4px rgba(52, 152, 219, 0.3);'>
                            Reset Password
                        </a>
                    </div>

                    <div style='background-color: #ecf0f1; padding: 20px; border-radius: 5px; margin: 20px 0;'>
                        <p style='color: #7f8c8d; font-size: 14px; margin: 0; line-height: 1.5;'>
                            <strong>Security Note:</strong> This link will expire in 60 minutes for security reasons. If you didn't request this password reset, please ignore this email.
                        </p>
                    </div>

                    <div style='border-top: 1px solid #ecf0f1; padding-top: 20px; margin-top: 30px;'>
                        <p style='color: #95a5a6; font-size: 12px; text-align: center; margin: 0;'>
                            If the button doesn't work, copy and paste this link into your browser:<br>
                            <a href='{$resetLink}' style='color: #3498db; word-break: break-all;'>{$resetLink}</a>
                        </p>
                    </div>
                </div>
            </div>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            logger()->error('Password Reset Email Error: ' . $mail->ErrorInfo);
            return false;
        }
    }

    // send consent form rejection mail to user sendConsentFormRejectionMail($user->email, $user->name, $course->name, $reason);
    public function sendConsentFormRejectionMail($toEmail, $toName, $courseName, $reason): bool
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST', 'smtp.gmail.com');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME');
            $mail->Password   = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');
            $mail->Port       = env('MAIL_PORT', 587);

            // Recipients
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME', 'Standing On The Rock'));
            $mail->addAddress($toEmail, $toName);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Consent Form Rejected - ' . config('app.name');
            $mail->Body    = "
                <p>Dear {$toName},</p>
                <p>Your consent form for course <strong>{$courseName}</strong> has been rejected.</p>
                <p><strong>Reason:</strong> {$reason}</p>
                <p>Please re-upload your consent form or contact support for further assistance.</p>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            logger()->error('Consent Form Rejection Email Error: ' . $mail->ErrorInfo);
            return false;
        }
    }
}
