<?php
/**
 *
 * @var ReviewController $this
 * @var Review[] $reviews
 * @var Review $model
 */

?>
<h1 xmlns="http://www.w3.org/1999/html">Отзывы</h1>

<?php
if(count($reviews) > 0){
    ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th><a href="/review?order=name">Имя</a></th>
            <th><a href="/review?order=email">E-mail</a></th>
            <th>Tекст сообщения</th>
            <th><a href="/review?order=creation_date">Дата</a></th>

        </tr>
        </thead>
        <tbody>
        <?php
        foreach($reviews as $review){
            ?>
            <tr>
                <td><?= $review->name; ?></td>
                <td><?= $review->email; ?></td>
                <td><?= $review->clearText(); ?></td>
                <td><?= $review->creation_date; ?><?
                    if($review->edited){
                        ?>
                        <abbr title="Изменен администратором" class="initialism">
                            <span
                                class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
                        </abbr>
                        <?
                    }
                    ?></td>
            </tr>
            <?
        }
        ?>
        </tbody>
    </table>
    <?
}
?>


<h2>Оставить отзыв</h2>
<form action="/review/index" method="post" class="active" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Имя</label>
        <input type="text" class="form-control" id="name" name='Review[name]' placeholder="Имя"
               value=<?= $model->name; ?>>
    </div>
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name='Review[email]' placeholder="Email"
               value=<?= $model->email; ?>>
    </div>

    <div class="form-group">
        <label for="text">Текст</label>
        <textarea id="text" cols="30" rows="10" name='Review[text]' class="form-control"
        ><?= $model->text; ?></textarea>
    </div>

    <div class="form-group">
        <label for="email">Картинка</label>
        <input type="file" name='Review[file]'>
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
    <div id="result">

    </div>

    <button class="btn btn-success" id="preview">Предпросмотр</button>
    <button type="submit" class="btn btn-primary">Добавить</button>
</form>

<script src="/js/preview.js"></script>
