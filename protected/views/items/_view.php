<?php
/* @var $this ItemsController */
/* @var $data Items */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('itemname')); ?>:</b>
	<?php echo CHtml::encode($data->itemname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('itemtype')); ?>:</b>
	<?php echo CHtml::encode($data->itemtype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('itemabbr')); ?>:</b>
	<?php echo CHtml::encode($data->itemabbr); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('forurl')); ?>:</b>
	<?php echo CHtml::encode($data->forurl); ?>
	<br />


</div>