<?php
namespace App;
class Emailer {
    private $App;

    public function __construct($App) {
        $this->App = $App;
    }

    public function sendActivationEmail($email, $token,$baseurl) {
    $message = '
    <div style="background-color:#f8f8f8;padding-top:40px;padding-bottom:30px">
        <div style="max-width:600px;margin:auto">
            <div style="background-color:#fff;padding:16px;text-align:center">
                <img style="width:120px" src="'.$baseurl.'/assets/images/apple-touch-icon.png" alt="Logo">
            </div>
            <div style="background-color:#fff;padding:20px;color:#222;font-size:14px;line-height:1.4;text-align:center">
                <p>You have successfully registered as user on the oouth bid platform.  <br>To activate your account, just click the link below:</p>
                <p><a href="'.$baseurl.'/setpassword.php?token=' . $token . '" target="_blank">https://oouth-bid.com.ng/password_reset/?token=' . $token . '</a></p>
                <p>This link will expire in 24 hours, so be sure to activate your account soon.</p>
                <p>If you did not make this request, you can ignore this email.</p>
            </div>
        </div>
    </div>';
    $this->App->sendEmailWithAttachment($email, 'Account Activation Email', $message);
    }
}
?>