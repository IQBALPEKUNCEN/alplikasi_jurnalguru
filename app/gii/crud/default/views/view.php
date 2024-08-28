<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator mootensai\enhancedgii\crud\Generator */

$urlParams = $generator->generateUrlParams();
$tableSchema = $generator->getTableSchema();
$pk = empty($tableSchema->primaryKey) ? $tableSchema->getColumnNames()[0] : $tableSchema->primaryKey[0];
$fk = $generator->generateFK($tableSchema);
echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= ($generator->pluralize) ? $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) : $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
    <div class="d-flex justify-content-between mt-4 mb-2">
        <h2><?= "<?= " ?><?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) . ' ' ?> . Html::encode($this->title) ?></h2>

        <div>
            <?php if ($generator->pdf) : ?>
                <?= "<?= " ?>
                <?= "
             Html::a(" . $generator->generateString('PDF') . ", 
                ['pdf', $urlParams],
                [
                    'class' => 'btn btn-danger',
                    'target' => '_blank',
                    'data-toggle' => 'tooltip',
                    'title' => " . $generator->generateString('Will open the generated PDF file in a new window') . "
                ]
            )?>\n"
                ?>
            <?php endif; ?>
            <?php if ($generator->saveAsNew) : ?>
                <?= "            <?= Html::a(" . $generator->generateString('Save As New') . ", ['save-as-new', " . $generator->generateUrlParams() . "], ['class' => 'btn btn-warning']) ?>" ?>
            <?php endif; ?>
            <?= "
            <?= GhostHtml::a(" . $generator->generateString('Baru') . ", ['/" . Inflector::camel2id(StringHelper::basename($generator->modelClass)) . "/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a(" . $generator->generateString('List') . ", ['/" . Inflector::camel2id(StringHelper::basename($generator->modelClass)) . "/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a(" . $generator->generateString('Update') . ", ['/" . Inflector::camel2id(StringHelper::basename($generator->modelClass)) . "/update', " . $generator->generateUrlParams() . "], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a(" . $generator->generateString('Delete') . ", ['/" . Inflector::camel2id(StringHelper::basename($generator->modelClass)) . "/delete', " . $generator->generateUrlParams() . "], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => " . $generator->generateString('Are you sure you want to delete this item?') . ",
                    'method' => 'post',
                ],
            ])
            ?>\n" ?>
        </div>
    </div>

    <?= "<?php \n" ?>
    $gridColumn = [
    <?php
    if ($tableSchema === false) {
        foreach ($generator->getColumnNames() as $name) {
            if (++$count < 6) {
                echo "            '" . $name . "',\n";
            } else {
                echo "            // '" . $name . "',\n";
            }
        }
    } else {
        foreach ($tableSchema->getColumnNames() as $attribute) {
            if (!in_array($attribute, $generator->skippedColumns)) {
                echo "        " . $generator->generateDetailViewField($attribute, $fk, $tableSchema);
            }
        }
    } ?>
    ];
    echo DetailView::widget([
    'model' => $model,
    'attributes' => $gridColumn
    ]);
    ?>
    <br>
    <?php foreach ($relations as $name => $rel) : ?>
        <?php if ($rel[2] && isset($rel[3]) && !in_array($name, $generator->skippedRelations)) : ?>
                <?= "<?php\n" ?>
                if($provider<?= $rel[1] ?>->totalCount){
                $gridColumn<?= $rel[1] ?> = [
                ['class' => 'yii\grid\SerialColumn'],
                <?php
                $relTableSchema = $generator->getDbConnection()->getTableSchema($rel[3]);
                $fkRel = $generator->generateFK($relTableSchema);
                if ($tableSchema === false) {
                    foreach ($relTableSchema->getColumnNames() as $attribute) {
                        if (!in_array($attribute, $generator->skippedColumns)) {
                            echo "            '" . $attribute . "',\n";
                        }
                    }
                } else {
                    foreach ($relTableSchema->getColumnNames() as $attribute) {
                        if (!in_array($attribute, $generator->skippedColumns)) {
                            echo '            ' . $generator->generateGridViewField($attribute, $fkRel, $relTableSchema);
                        }
                    }
                }
                ?>
                ];
                echo Gridview::widget([
                'dataProvider' => $provider<?= $rel[1] ?>,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-<?= Inflector::camel2id($rel[3]) ?>']],
                'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode(<?= $generator->generateString(Inflector::camel2words($rel[1])) ?>),
                ],
                <?php if (!$generator->pdf) : ?>
                    'export' => false,
                <?php endif; ?>
                'columns' => $gridColumn<?= $rel[1] . "\n" ?>
                ]);
                }
                <?= "?>\n" ?>
        <?php elseif (empty($rel[2])) : ?>
            <br>
            <h4><?= $rel[1] ?><?= "<?= " ?>' '. Html::encode($this->title) ?></h4>
            <?= "<?php \n" ?>
            $gridColumn<?= $rel[1] ?> = [
            <?php
            $relTableSchema = $generator->getDbConnection()->getTableSchema($rel[3]);
            $fkRel = $generator->generateFK($relTableSchema);
            foreach ($relTableSchema->getColumnNames() as $attribute) {
                if ($attribute == $rel[5]) {
                    continue;
                }
                if ($relTableSchema === false) {
                    if (!in_array($attribute, $generator->skippedColumns)) {
                        echo "        '" . $attribute . "',\n";
                    }
                } else {
                    if (!in_array($attribute, $generator->skippedColumns)) {
                        echo "        " . $generator->generateDetailViewField($attribute, $fkRel);
                    }
                }
            }
            ?>
            ];
            echo DetailView::widget([
            'model' => $model-><?= $name ?>,
            'attributes' => $gridColumn<?= $rel[1] ?>
            ]);
            ?>
        <?php endif; ?>
    <?php endforeach; ?>
</div>