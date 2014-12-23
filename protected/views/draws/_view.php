<?php
/* @var $this DrawsController */
/* @var $data Draws */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qishu')); ?>:</b>
	<?php echo CHtml::encode($data->qishu); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('luckynum')); ?>:</b>
	<?php echo CHtml::encode($data->luckynum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('begin_at')); ?>:</b>
	<?php echo CHtml::encode($data->begin_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lucky_at')); ?>:</b>
	<?php echo CHtml::encode($data->lucky_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('open_at')); ?>:</b>
	<?php echo CHtml::encode($data->open_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('itemid')); ?>:</b>
	<?php echo CHtml::encode($data->itemid); ?>
	<br />


</div>