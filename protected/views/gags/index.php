<?php

$page = 'GAG-лист';
$this->pageTitle = Yii::app()->name . ' - ' . $page;

$this->breadcrumbs=array(
	$page,
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('gags-grid', {
        data: $(this).serialize()
    });
    return false;
});
");

$this->renderPartial('_search',array(
    'model'=>$model,
));

$this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
	'id'=>'gags-grid',
    'dataProvider'=>isset($_GET['Gags']) ? $model->search() : $dataProvider,
    'enableSorting' => TRUE,
	'summaryText' => 'Показано с {start} по {end} банов из {count}. Страница {page} из {pages}',
	'htmlOptions' => array(
		'style' => 'width: 100%'
	),
	'rowHtmlOptionsExpression'=>'array(
		"id" => "gag_$data->id",
		"class" => $data->unban_time < time() ? "bantr success" : "bantr"
	)',
	'pager' => array(
		'class'=>'bootstrap.widgets.TbPager',
		'displayFirstAndLast' => true,
	),
    'columns'=>array(

		array(
			'header' => 'Ник',
			'type' => 'raw',
			'value' => '$data->country . " " . CHtml::encode(mb_substr($data->name, 0, 18, "UTF-8"))'
		),

        array(
            'header' => 'STEAM_ID',
            'type' => 'raw',
            'value' => '$data->steamid',
            'htmlOptions' => array(
                'style' => 'width: 130px'
            )
        ),

		array(
			'header' => 'Срок до',
			'value' => 'date("d.m.Y H:i", $data->unban_time)',
			'htmlOptions' => array('style' => 'width:130px'),
		),

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{delete}',
            'htmlOptions' => array('style' => 'width:20px'),
            'visible' => Webadmins::checkAccess('bans_edit')
		)
	),
));
?>