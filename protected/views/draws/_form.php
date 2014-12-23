<?php
/* @var $this DrawsController */
/* @var $model Draws */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'draws-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'qishu'); ?>
		<?php echo $form->textField($model,'qishu'); ?>
		<?php echo $form->error($model,'qishu'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'luckynum'); ?>
		<?php echo $form->textField($model,'luckynum'); ?>
		<?php echo $form->error($model,'luckynum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'begin_at'); ?>
		<?php echo $form->textField($model,'begin_at'); ?>
		<?php echo $form->error($model,'begin_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lucky_at'); ?>
		<?php echo $form->textField($model,'lucky_at'); ?>
		<?php echo $form->error($model,'lucky_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'open_at'); ?>
		<?php echo $form->textField($model,'open_at'); ?>
		<?php echo $form->error($model,'open_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'itemid'); ?>
		<?php echo $form->textField($model,'itemid'); ?>
		<?php echo $form->error($model,'itemid'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->