<?php

use \Stripe\Stripe;
use \Stripe\Charge;

class Pewin_Payment {

    public $id;
    public $time;
    public $event;
    public $member;
    public $currency;
    public $fee;
    public $token;
    public $charged;
    public $email;

    static $table = 'pewin_payments';

    public function __construct() {
        Stripe::setApiKey(get_option('stripe_test_mode') ? get_option('stripe_test_secret_key') : get_option('stripe_secret_key'));
    }

    public static function all() {
        $result = $wpdb->get_results(sprintf('SELECT * FROM %s', self::$table));
    }

    public function load() {
        global $wpdb;
        if ((int) !$this->id) {
            return false;
        }
        $result = $wpdb->get_row(sprintf(
            'SELECT * FROM %s WHERE id = %s',
            self::$table,
            (int) $this->id
        ));
        if ($result === null) {
            return false;
        }
        foreach($result as $k => $v) {
            $this->{$k} = $v;
        }
        return true;
    }

    public function save() {
        global $wpdb;

        if (! (int) $this->id) {
            $saved = $wpdb->insert(self::$table, $this->getAttributes());
            if ($saved) {
                $this->id = $wpdb->insert_id;
            }
            return $saved;
        }

        return $wpdb->update(
            self::$table,
            $this->getAttributes(),
            array('id' => $this->id)
        );
    }

    // Charge charges the transaction and returns an error message if something went wrong.
    // If everything was okay, it will return something falsey.
    public function charge() {

        if ($this->charged) {
            return;
        }

        // TODO Check that we're not using currencies which shouldn't be multiplied by 100
        try {
            $charge = Charge::create(array(
                "amount" => $this->fee * 100,
                "currency" => $this->currency,
                "source" => $this->token,
                "description" => sprintf("Charge to %s for event %s", $this->member, $this->event),
                "statement_descriptor" => substr(sprintf("Charge for %s", $this->event), 0, 22),
                "receipt_email" => $this->email,
                "metadata" => array (
                    "member" => $this->member,
                    "event" => $this->event,
                )
            ));

            $this->charged = $charge->captured;
            $this->save();
            if ($charge->failure_message) {
                return $charge->failure_message;
            }

            return false;
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    private function getAttributes() {
        return array(
            'id' => (int) $this->id,
            'time' => $this->time ?: date("Y-m-d H:i:s"),
            'event' => $this->event,
            'member' => $this->member,
            'currency' => $this->currency,
            'fee' => $this->fee,
            'token' => $this->token,
            'charged' => $this->charged ? 1 : 0,
        );
    }

}
