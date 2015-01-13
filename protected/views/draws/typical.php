<?php
/* @var $this DrawsController */
/* @var $model Draws */
$this->breadcrumbs = array(
    'Draws' => array(
        'index'
    ),
    'Manage'
);



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#draws-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<!-- search-form -->

<?php

$this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'draws-grid',
        'dataProvider' => $model,
        //'filter' => $model,
        'pager' => array(
            'class' => 'SimplaPager',
            'cssFile' => Yii::app()->baseUrl.'/css/gridViewStyle/pager.css',
            'header' => false,
            'firstPageLabel' => '&lt&lt',
            'prevPageLabel' => '&lt',
            'nextPageLabel' => '&gt',
            'lastPageLabel' => '&gt&gt',
        ),
        'summaryText' => 'Show you {start} - {end} of {count} cool records',
        'columns' => array(
                array(
                    'name' => 'qishu',
                    'value' => '$data->qishu',
                    'htmlOptions' => array(
                            'width' => '10px'
                    )
                ),
                array(
                    'name' => 'luckynum',
                    'value' => '$data->luckynum',
                    'htmlOptions' => array(
                            'width' => '20px'
                    )
                ),
                array(
                    'name' => 'begin_at',
                    'value' => '$data->begin_at',
                    'htmlOptions' => array(
                        'width' => '90px'
                    )
                ),
                
                array(
                    'name' => 'lucky_at',
                    'value' => '$data->lucky_at',
                    'htmlOptions' => array(
                        'width' => '90px'
                    )
                ),

            array(
                'name' => 'itemid',
                'filter' => CHtml::listData(Items::model()->findAll(), 'id', 'itemname'),
                // ok 'filter' => CHtml::activeDropDownList($model, 'itemid', CHtml::listData(Items::model()->findAll(), 'id', 'itemname'), array('prompt' => '66 ')),
                'value' => '$data->item->itemname',
                'htmlOptions' => array(
                    'width' => '130px'
                )
            ),
            array(
                'name' => 'Bymins',
                'value' => 'Util::caculateDiffByMinutes($data->begin_at,$data->lucky_at)',
                'htmlOptions' => array(
                    'width' => '40px'
                )
            ),
            array(
                'name' => 'DrawsWeight',
                'type'=>'raw',
                'value'=>array($this,'cweight'),
                'htmlOptions' => array(
                    'width' => '100px'
                )
            ),
            array(
                'name' => 'DrawsWeight',
                'type'=>'raw',
                'value'=>array($this,'c3weight'),
                'htmlOptions' => array(
                    'width' => '120px'
                )
            ),
                array(
                    'header' => 'Actions',                    
                    'class' => 'CButtonColumn',
                    'viewButtonImageUrl' => Yii::app()->baseUrl . '/css/gridViewStyle/images/' . 'gr-view.png',
                    'updateButtonImageUrl' => Yii::app()->baseUrl . '/css/gridViewStyle/images/' . 'gr-update.png',
                    'deleteButtonImageUrl' => Yii::app()->baseUrl . '/css/gridViewStyle/images/' . 'gr-delete.png',
                
                )
        )
)); ?>
