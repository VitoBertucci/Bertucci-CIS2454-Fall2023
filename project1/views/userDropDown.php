<select name="user_id">
    <?php foreach ($users as $user) : ?>
        <option value='<?php echo $user->get_id() ?>'> <?php echo $user->get_name() ?> </option>
    <?php endforeach; ?>
</select>