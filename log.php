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
                    <?php if ($theNullValue['reservation_fee'] === NULL): ?>
                        <label>• Reservation Fee</label><br>
                    <?php endif; ?>
                    <?php if ($theNullValue['tuition_fee'] === NULL): ?>
                        <label>• Tuition Fee</label><br>
                    <?php endif; ?>
                    <?php if ($theNullValue['other_fee'] === NULL): ?>
                        <label>• Other Fee</label><br>
                    <?php endif; ?>
                    <?php if ($theNullValue['assessment_fee'] === NULL): ?>
                        <label>• Assessment Fee</label><br>
                    <?php endif; ?>
                    <?php if ($theNullValue['registration_fee'] === NULL): ?>
                        <label>• Registration Fee</label><br>
                    <?php endif; ?>
                    <?php if ($theNullValue['special_permit'] === NULL): ?>
                        <label>• Special Permit</label><br>
                    <?php endif; ?>
                    <?php if ($theNullValue['international_fee_old'] === NULL): ?>
                        <label>• International Fee OLD</label><br>
                    <?php endif; ?>
                    <?php if ($theNullValue['international_fee_new'] === NULL): ?>
                        <label>• International Fee NEW</label><br>
                    <?php endif; ?>
                    <?php if ($theNullValue['reservation_fee'] !== NULL 
                             && $theNullValue['tuition_fee'] !== NULL 
                             && $theNullValue['other_fee'] !== NULL 
                             && $theNullValue['assessment_fee'] !== NULL 
                             && $theNullValue['registration_fee'] !== NULL 
                             && $theNullValue['special_permit'] !== NULL 
                             && $theNullValue['international_fee_old'] !== NULL 
                             && $theNullValue['international_fee_new'] !== NULL):?>
                             
                        <p><?php echo htmlspecialchars("None"); ?></p><br>
                    <?php endif; ?>
                <?php else: ?>
                    <label><?php echo htmlspecialchars("No payables found for this user."); ?> </label>
                <?php endif; ?>
            </div>

		<hr>
            
        <p>Log Time : <?php echo htmlspecialchars($log['touch']); ?></p>
        <hr>
        <p class="mb-0">Notes : <?php echo htmlspecialchars($log['notes']); ?></p>
    </div>
</div>
