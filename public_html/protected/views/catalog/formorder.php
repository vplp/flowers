<?php echo CHtml::beginForm(); ?>
 
<?php echo CHtml::errorSummary($user); ?>
 
<div class="simple">
<?php echo CHtml::activeLabel($user,'username'); ?>
<?php echo CHtml::activeTextField($user,'username'); ?>
</div>
 
<div class="simple">
<?php echo CHtml::activeLabel($user,'password'); ?>
<?php echo CHtml::activePasswordField($user,'password'); ?>
</div>
 
<div class="action">
<?php echo CHtml::activeCheckBox($user,'rememberMe'); ?>
Запомнить меня<br/>
<?php echo CHtml::submitButton('Login'); ?>
</div>
 
<?php echo CHtml::endForm(); ?>