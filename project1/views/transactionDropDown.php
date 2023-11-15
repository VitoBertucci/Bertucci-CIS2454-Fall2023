<select name="transaction_id">
    <?php foreach ($transactions as $transaction) : ?>
        <option value='<?php echo $transaction->get_id(); ?>'> <?php echo $transaction->get_id(); ?> </option>
    <?php endforeach; ?> 
</select>