<?php
/**
 * Created by PhpStorm.
 * User: Rheola
 * Date: 31.08.16
 * Time: 22:20
 */
?>
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

?>

<table class="table table-bordered">
    <thead>
    <tr>
        <th colspan="2">ID</th>
        <th>Имя</th>
        <th>E-mail</th>
        <th>Tекст сообщения</th>
        <th>Дата</th>
        <th>Статус</th>
        <th colspan="3"></th>
    </tr>
    </thead>
    <tbody>

    <?php
    foreach($reviews as $review){
        ?>
        <tr>
            <td><?= $review->id; ?></td>
            <td>
                <?php
                if($review->file_name !== null){
                    ?>
                    <img src="/files/<?=$review->file_name;?>" alt="" width="50px">
                <?
                }
                ?></td>
            <td><?= $review->name; ?></td>
            <td><?= $review->email; ?></td>
            <td><?= $review->clearText(); ?></td>
            <td><?= $review->creation_date; ?></td>
            <td><?= $review->statusName(); ?></td>
            <td><a href="/review/update?id=<?= $review->id; ?>" class="btn btn-primary btn-xs"><span
                        class="glyphicon glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                <?php
                if($review->show == 0){
                ?>
                <a href="/review/public?id=<?= $review->id; ?>" class="btn btn-success btn-xs"><span
                        class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span></a>


                <a href="/review/decline?id=<?= $review->id; ?>" class="btn btn-danger btn-xs"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>
            <?
            }
            ?>
        </tr>
        <?
    }
    ?>
    </tbody>
</table>
