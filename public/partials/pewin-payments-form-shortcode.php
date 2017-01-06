<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://bradb.net
 * @since      1.0.0
 *
 * @package    Pewin_Payments
 * @subpackage Pewin_Payments/public/partials
 */
?>

<?php

$payment = null;
$error = '';
$saved = false;
$redirectURL = null;

$_REQUEST['email'] = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
$_REQUEST['fee'] = isset($_REQUEST['fee']) ? $_REQUEST['fee'] : 0;
$_REQUEST['currency'] = isset($_REQUEST['currency']) ? $_REQUEST['currency'] : 'USD';
$_REQUEST['event'] = isset($_REQUEST['event']) ? $_REQUEST['event']: '';
$_REQUEST['member'] = isset($_REQUEST['member']) ? $_REQUEST['member'] : '';

if (isset($_POST['token'])) {

    foreach(array('fee', 'event', 'member', 'token', 'currency', 'email') as $k ) {
        if (empty($_POST[$k])) {
            $error = sprintf('The %s field is missing', $k);
            break;
        }
    }

    if (!$error) {
        try {
            $payment = new Pewin_Payment();
            $payment->email = $_POST['email'];
            $payment->fee = $_POST['fee'];
            $payment->event = $_POST['event'];
            $payment->member = $_POST['member'];
            $payment->currency = $_POST['currency'];
            $payment->token = $_POST['token'];

            // Try to charge, and if it fails get the error string back.
            $error = $payment->charge();
            if (!$error) {
                $redirectURL = get_option('redirect_url');
            }

        } catch(Exception $e) {
            $error = $e->getMessage();
        }
    }
}

?>

<script type="text/javascript">
Stripe.setPublishableKey('<?php echo get_option('stripe_test_mode') ? get_option('stripe_test_publishable_key') : get_option('stripe_publishable_key'); ?>');
var redirectURL = '<?php echo $redirectURL ?>';
if (redirectURL) {
    setTimeout(function() {
        window.location.href = redirectURL;
    }, 5000);
}
</script>

<div class="payment-form success <?php echo empty($payment) || $error ? 'hide' : '' ?>">
    <p>Thank you registering for the event. You will receive your receipt shortly</p>
</div>

<form method="POST" id="payment-form" action="<?php echo $_SERVER['REQUEST_URI'] ?>" class="<?php echo empty($payment) || $error ? '' : 'hide' ?>">
    <span class="payment-errors"><?php echo $error; ?></span>

    <fieldset>
        <legend>Details</legend>
        <div class="vc_row">
            <div class="vc_col-sm-12">
                <label>Member</label>
            </div>
            <div class="vc_col-sm-12">
                <input type="text" readonly value="<?php echo $_REQUEST['member'] ?>">
            </div>
        </div>
        <div class="vc_row">
            <div class="vc_col-sm-12">
                <label>Email</label>
            </div>
            <div class="vc_col-sm-12">
                <input type="email" value="" required  value="<?php echo $_REQUEST['email'] ?>">
            </div>
        </div>
        <div class="vc_row">
            <div class="vc_col-sm-12">
                <label>Event</label>
            </div>
            <div class="vc_col-sm-12">
                <input type="text" readonly value="<?php echo $_REQUEST['event'] ?>">
            </div>
        </div>
        <div class="vc_row">
            <div class="vc_col-sm-12">
                <label>Amount</label>
            </div>
            <div class="vc_col-sm-12">
                <input type="text" readonly value="<?php echo $_REQUEST['fee'] . ' ' . $_REQUEST['currency'] ?>">
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>Billing Information</legend>

        <div class="vc_row">
            <div class="vc_col-sm-12">
                <label>Name on the Card</label>
            </div>
            <div class="vc_col-sm-12">
                <input type="text" data-stripe="name">
            </div>
        </div>

        <div class="vc_row">
            <div class="vc_col-sm-12">
                <label>Address</label>
            </div>
            <div class="vc_col-sm-12">
                <input type="text" data-stripe="address_line1">
            </div>
        </div>

        <div class="vc_row">
            <div class="vc_col-sm-12">
                <label>Address (line 2)</label>
            </div>
            <div class="vc_col-sm-12">
                <input type="text" data-stripe="address_line2">
            </div>
        </div>

        <div class="vc_row">
            <div class="vc_col-sm-12">
                <label>City</label>
            </div>
            <div class="vc_col-sm-12">
                <input type="text" data-stripe="address_city">
            </div>
        </div>

        <div class="vc_row">
            <div class="vc_col-sm-12">
                <label>State</label>
            </div>
            <div class="vc_col-sm-12">
                <input type="text" data-stripe="address_state">
            </div>
        </div>

        <div class="vc_row">
            <div class="vc_col-sm-12">
                <label>Zip/Postal Code</label>
            </div>
            <div class="vc_col-sm-12">
                <input type="text" data-stripe="address_zip">
            </div>
        </div>

        <div class="vc_row">
            <div class="vc_col-sm-12">
                <label>Country</label>
            </div>
            <div class="vc_col-sm-12">
                <input type="text" data-stripe="address_country">
            </div>
        </div>

    </fieldset>

    <fieldset>
        <legend>Payment Details</legend>

        <div class="vc_row">
            <div class="vc_col-sm-12">
                <label>Card Number</label>
            </div>
            <div class="vc_col-sm-12">
                <input type="text" size="20" data-stripe="number" placeholder="Card number">
            </div>
        </div>

        <div class="vc_row">
            <div class="vc_col-sm-4">
                <div class="vc_row">
                    <div class="vc_col-sm-12">
                        <label>CVC</label>
                    </div>
                    <div class="vc_col-sm-12">
                        <input type="text" size="4" data-stripe="cvc" placeholder="CVC">
                    </div>
                </div>
            </div>
            <div class="vc_col-sm-8">
                <div class="vc_row">
                    <div class="vc_col-sm-12">
                        <label>Expiration</label>
                    </div>
                    <div class="vc_col-sm-6">
                        <input type="text" size="2" data-stripe="exp_month" placeholder="MM">
                    </div>
                    <div class="vc_col-sm-6">
                        <input type="text" size="2" data-stripe="exp_year" placeholder="YY">
                    </div>
                </div>
            </div>
        </div>
    </fieldset>

    <div class="vc_row">
        <div class="vc_col-sm-12 vc_text-right">
            <input type="hidden" name="event" value="<?php echo $_REQUEST['event'] ?>">
            <input type="hidden" name="member" value="<?php echo $_REQUEST['member'] ?>">
            <input type="hidden" name="currency" value="<?php echo $_REQUEST['currency'] ?>">
            <input type="hidden" name="fee" value="<?php echo $_REQUEST['fee'] ?>">
            <input type="hidden" name="token" value="">
            <button type="button" class="vc_btn vc_btn-primary vc_btn-block">Submit Payment</button>
        </div>
    </div>
</form>
