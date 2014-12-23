<?php
/* @var $this DrawsController */
/* @var $model Draws */

$this->breadcrumbs=array(
	'Draws'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Draws', 'url'=>array('index')),
	array('label'=>'Create Draws', 'url'=>array('create')),
	array('label'=>'Update Draws', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Draws', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Draws', 'url'=>array('admin')),
);
?>

<h1>View Draws #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'qishu',
		'luckynum',
		'begin_at',
		'lucky_at',
		'open_at',
		'itemid',
	),
)); ?>
