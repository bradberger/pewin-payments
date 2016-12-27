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

$_REQUEST['fee'] = isset($_REQUEST['fee']) ? $_REQUEST['fee'] : 10;
$_REQUEST['currency'] = isset($_REQUEST['currency']) ? $_REQUEST['currency'] : 'USD';
$_REQUEST['event'] = isset($_REQUEST['event']) ? $_REQUEST['event']: 'test event name';
$_REQUEST['member'] = isset($_REQUEST['member']) ? $_REQUEST['member'] : 'john member';

if (isset($_POST['token'])) {

    foreach(['fee', 'event', 'member', 'token', 'currency'] as $k ) {
        if (empty($_POST[$k])) {
            $error = sprintf('The %s field is missing', $k);
            break;
        }
    }

    if (!$error) {
        try {
            $payment = new Pewin_Payment();
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

<div class="success <?php echo empty($payment) || $error ? 'hide' : '' ?>">
    <p>Your payment was recorded with an ID of <?php echo $payment ? $payment->id : ''; ?>. Thanks!</p>
</div>

<form method="POST" id="payment-form" action="<?php echo $_SERVER['REQUEST_URI'] ?>" class="<?php echo empty($payment) || $error ? '' : 'hide' ?>">
    <span class="payment-errors"><?php echo $error; ?></span>

    <div class="form-row">
        <label>
            <span>Member<span>
            <input type="text" readonly value="<?php echo $_REQUEST['member'] ?>">
        </label>
    </div>

    <div class="form-row">
        <label>
            <span>Event<span>
            <input type="text" readonly value="<?php echo $_REQUEST['event'] ?>">
        </label>
    </div>

    <div class="form-row">
        <label>
            <span>Amount<span>
            <input type="text" readonly value="<?php echo $_REQUEST['fee'] . ' ' . $_REQUEST['currency'] ?>">
        </label>
    </div>

    <div class="form-row">
        <label>
            <span>Name on the Card<span>
            <input type="text" data-stripe="name">
        </label>
    </div>

    <div class="form-row">
        <label>
            <span>Address<span>
            <input type="text" data-stripe="address_line1">
        </label>
    </div>

    <div class="form-row">
        <label>
            <span>Address (line 2)<span>
            <input type="text" data-stripe="address_line2">
        </label>
    </div>

    <div class="form-row">
        <label>
            <span>City<span>
            <input type="text" data-stripe="address_city">
        </label>
    </div>

    <div class="form-row">
        <label>
            <span>State<span>
            <input type="text" data-stripe="address_state">
        </label>
    </div>

    <div class="form-row">
        <label>
            <span>Zip/Postal Code<span>
            <input type="text" data-stripe="address_zip">
        </label>
    </div>

    <div class="form-row">
        <label>
            <span>Country<span>
            <input type="text" data-stripe="address_country">
        </label>
    </div>

    <div class="form-row">
        <label>
            <span>Card Number</span>
            <input type="text" size="20" data-stripe="number">
        </label>
  </div>

    <div class="form-row">
        <label>
            <span>Expiration (MM/YY)</span>
            <input type="text" size="2" data-stripe="exp_month">
        </label>
        <span> / </span>
        <input type="text" size="2" data-stripe="exp_year">
    </div>

    <div class="form-row">
        <label>
            <span>CVC</span>
            <input type="text" size="4" data-stripe="cvc">
        </label>
    </div>


    <input type="hidden" name="event" value="<?php echo $_REQUEST['event'] ?>">
    <input type="hidden" name="member" value="<?php echo $_REQUEST['member'] ?>">
    <input type="hidden" name="currency" value="<?php echo $_REQUEST['currency'] ?>">
    <input type="hidden" name="fee" value="<?php echo $_REQUEST['fee'] ?>">
    <input type="hidden" name="token" value="">
    <button type="button" class="submit">Submit Payment</button>
</form>
