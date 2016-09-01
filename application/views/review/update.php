<?php
/**
 * @var ReviewController $this
 * @var Review[] $reviews
 * @var Review $model
 */
?>
<form action="/review/update?id=<?=$model->id;?>" method="post">
    <div class="form-group">

        <label for="name">Имя</label>
        <p><?= $model->name ?></p>
    </div>

    <div class="form-group">

        <label for="name">Email</label>
        <p><?= $model->email; ?></p>
    </div>


    <div class="form-group">
        <label for="text">Текст</label>
        <textarea id="text" cols="30" rows="10" name='Review[text]' class="form-control"
                   ><?= $model->text; ?></textarea>

    </div>

    <?
    if($model->hasErrors()){
        ?>
        <div class='form-group bg-danger'>
            <ul>
                <? echo $model->getErrors(); ?>
            </ul>
        </div>
        <?
    }
    ?>

    <button type="submit" class="btn btn-default">Сохранить</button>
</form>
