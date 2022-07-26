<?php
/**
 * @var $model \app\modules\admin\models\Feedback
 */

use yii\bootstrap4\Html;
use yii\widgets\Pjax;

?>
<?php  $feedback_id = $model['id'] ?>
    <div class="feedback_id" data-attr="<?=$feedback_id;?>">
</div>
<br>
<div id="feedbacks">
    <div>
        <?= Html::tag('p', 'Автор: ' . $model['user']['name']) ?>
        <p>Отзыв: <strong><?= Html::encode($model['message']) ?> </strong></p>
        <?php $images = $model['images']; ?>
        <?php if (!empty($images)): ?>
            <?php foreach ($images as $image): ?>
                <li><?= Html::img('/images/' . $image['name'], ['width' => 150, 'height' => 120]) ?></li>
            <?php endforeach; ?>
            <hr>
        <?php endif; ?>
    </div>
    <br>
    <?php Pjax::begin([
        'enablePushState' => false,
        'timeout' => 12000,
    ]); ?>
    <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('Добавить комментарий', ['comment/add', 'id' => $feedback_id], ['class' => 'btn btn-outline-success']) ?>
    <?php endif; ?>
    <?php Pjax::end(); ?>
</div>
<br>
<h2><strong>Комментарии: </strong></h2>
<div id="comments">
    <?php if (count($model['comments']) == 0): ?>
        <h3><?php echo '' ?></h3>
    <?php else: ?>
    <?php foreach ($model['comments'] as $key =>$comment): ?>
        <div>
            <?= Html::tag('p', ($key+1) . ' Автор: ' . $comment['user']['name'])?>
            <p>Комментарий: <strong><?= Html::encode($comment['message']) ?> </strong></p>
            <?php $images = $comment['imgforcomments']; ?>
            <?php if (!empty($images)): ?>
                <?php foreach ($images as $image): ?>
                    <ul>
                        <li><?= Html::img('/images/' . $image['name'], ['width' => 150, 'height' => 120]) ?></li>
                    </ul>
                <?php endforeach; ?>
            <?php endif; ?>
            <br>
            <div>
            </div>
            <hr>
        </div>
    <?php endforeach; ?>
    <?php endif;?>
</div>
<?php if (count($model['comments']) == 5): ?>
    <div>
        <form class="form" id="comment">
            <?= Html::submitButton("Посмотреть еще комментарии", ['class' => "btn-outline-info"]); ?>
        </form>
    </div>
<?php else: ?>
<strong><?php echo "Комментарии закончились :("?></strong>
<?php endif;?>
<?php
$this->registerJsFile(
    '@web/js/view.js',['depends' => 'yii\web\YiiAsset',
    'yii\bootstrap4\BootstrapAsset',
]);
?>
