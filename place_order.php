<?php
require 'util.php';

$uid = user_id();

$type = post('type');
$type = strtoupper($type);
$want_type = post('want_type');
$want_type = strtoupper($want_type);

curr_supported_check($type);
curr_supported_check($want_type);

# convert for inclusion into database
$amount_disp = post('amount');
$amount = numstr_to_internal($amount_disp);
$want_amount_disp = post('want_amount');
$want_amount = numstr_to_internal($want_amount_disp);

order_worthwhile_check($amount);
order_worthwhile_check($want_amount);

enough_money_check($amount, $type);

# deduct money from their account
deduct_funds($amount, $type);

# add the money to the order book
$query = "
    INSERT INTO orderbook(uid, amount, type, want_amount, want_type)
    VALUES ('$uid', '$amount', '$type', '$want_amount', '$want_type');
    ";
$result = do_query($query);
?>

<div class='content_box'><div class='content_sideshadow'>
    <h3>Order placed</h3>
    <p>
    <?php echo "Your order offering $amount_disp $type for $want_amount_disp $want_type has been placed."; ?>
    </p>
    <p>You may visit the <a href='?page=orderbook'>orderbook</a>.
</div>

