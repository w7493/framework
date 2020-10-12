<?php

/** @var \Model\Entity\Product[] $productList */
$body = function () use ($productList, $path) {
    ?>
    <table cellpadding="40" cellspacing="0" border="0">
        <tr><td colspan="3" align="center"><a href=<?= $path('product_list') ?>>Наши курсы</a>
            <a href=<?= $path('course_description') ?>>Описание курсов</a></td></tr>
        <tr>
            <td colspan="3" align="left">Сортировать по:
                <a href="<?= $path('product_list') ?>?sort=price">Цене</a>
                <a href="<?= $path('product_list') ?>?sort=name">Названию</a>
            </td>
        </tr>
<?php
            $position = 0;
    foreach ($productList as $key => $product) {
        echo $position % 3 ? '' : '<tr>'; ?>
                <td style="text-align: center">
                    <a href="<?= $path('product_info', ['id' => $product->getId()]) ?>"><?= $product->getName() ?></a>
                    <br /><br />
                    <h1><?= $product->getDescription() ?></h1>
                    <?= $product->getPrice() ?> руб.
                </td>
<?php
                echo($position + 1) % 3 ? '' : '</tr>';
        ++$position;
    }
    echo $position % 5 ? str_repeat('<td></td>', 5 - $position) . '</tr>' : ''; //3?>
    </table>
<?php
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Курсы',
        'body' => $body,
    ]
);
