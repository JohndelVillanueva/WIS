<div class="collapse" id="collapseExample<?php echo $row['uniqid']; ?>">
    <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">User : <?php echo htmlspecialchars($log['usertouch']); ?></h4>
		<hr>
        <p>Need to pay : </p>
			<?php 
                $selectTheNullValue = $DB_con->prepare("SELECT * FROM s_payables WHERE user_id = :user_id");
                $selectTheNullValue->execute([
                    ':user_id' => $log['ern']
                ]);
                $theNullValue = $selectTheNullValue->fetch(PDO::FETCH_ASSOC);
            ?>
            <div>
    <?php if ($theNullValue): ?>
        <?php
        $fees = [
            'reservation_fee' => 'Reservation Fee',
            'tuition_fee' => 'Tuition Fee',
            'other_fee' => 'Other Fee',
            'assessment_fee' => 'Assessment Fee',
            'registration_fee' => 'Registration Fee',
            'special_permit' => 'Special Permit',
            'international_fee_old' => 'International Fee OLD',
            'international_fee_new' => 'International Fee NEW',
            'pta' => 'PTA'
        ];

        $allNotNull = true;

        foreach ($fees as $key => $label):
            if ($theNullValue[$key] !== NULL):
        ?>
                <label>• <?php echo htmlspecialchars($label); ?></label><br>
        <?php
                $allNotNull = false;
            endif;
        endforeach;

        if ($allNotNull):
        ?>
            <?php echo htmlspecialchars("Paid"); ?><br>
        <?php endif; ?>

    <?php else: ?>
        <?php echo htmlspecialchars("No payables found for this user."); ?>
    <?php endif; ?>
</div>


		<hr>
            
        <p>Log Time : <?php echo htmlspecialchars($log['touch']); ?></p>
        <hr>
        <p class="mb-0">Notes : <?php echo htmlspecialchars($log['notes']); ?></p>
    </div>
</div>
