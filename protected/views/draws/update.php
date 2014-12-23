<?php
/* @var $this DrawsController */
/* @var $model Draws */

$this->breadcrumbs=array(
	'Draws'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Draws', 'url'=>array('index')),
	array('label'=>'Create Draws', 'url'=>array('create')),
	array('label'=>'View Draws', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Draws', 'url'=>array('admin')),
);
?>

<h1>Update Draws <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>