<?php
/* @var $this ItemsController */
/* @var $model Items */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'items-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'itemname'); ?>
		<?php echo $form->textField($model,'itemname',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'itemname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'itemtype'); ?>
		<?php echo $form->textField($model,'itemtype'); ?>
		<?php echo $form->error($model,'itemtype'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'itemabbr'); ?>
		<?php echo $form->textField($model,'itemabbr',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'itemabbr'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'forurl'); ?>
		<?php echo $form->textField($model,'forurl',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'forurl'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->