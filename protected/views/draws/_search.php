<?php
/* @var $this DrawsController */
/* @var $model Draws */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qishu'); ?>
		<?php echo $form->textField($model,'qishu'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'luckynum'); ?>
		<?php echo $form->textField($model,'luckynum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'begin_at'); ?>
		<?php echo $form->textField($model,'begin_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lucky_at'); ?>
		<?php echo $form->textField($model,'lucky_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'open_at'); ?>
		<?php echo $form->textField($model,'open_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'itemid'); ?>
		<?php echo $form->textField($model,'itemid'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->