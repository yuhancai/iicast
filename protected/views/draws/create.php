<?php
/* @var $this DrawsController */
/* @var $model Draws */

$this->breadcrumbs=array(
	'Draws'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Draws', 'url'=>array('index')),
	array('label'=>'Manage Draws', 'url'=>array('admin')),
);
?>

<h1>Create Draws</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>