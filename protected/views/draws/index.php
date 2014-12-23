<?php
/* @var $this DrawsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Draws',
);

$this->menu=array(
	array('label'=>'Create Draws', 'url'=>array('create')),
	array('label'=>'Manage Draws', 'url'=>array('admin')),
);
?>

<h1>Draws</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
