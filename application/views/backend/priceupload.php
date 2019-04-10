<p>Желаете обновить прайс-лист? важно, чтобы файл соответствовал следующим критериям:</p>
<ol>
    <li>Формат CSV, разделитель точка с запятой</li>
    <li>Порядок столбоцов строго как в <a href="/examples/price.csv">образце</a></li>
    <li>Кодировка UTF-8</li>
</ol>

<p>
    <form action="/manager/testform/" method="post" enctype="multipart/form-data">
        
        <div class="form-group">
                <label for="exampleFormControlFile1">Добавить прайс-лист</label>
                <input type="file" class="form-control-file" id="upload" name="upload">
            </div>
        <input type="submit" value="Загрузить" class="btn btn-primary"/>
        
        
    </form>
</p>

<p><a href="/manager/pricetmptruncate/">Очистить</a> <a href="/manager/pricerenew/">Обновить данные</a></p>
<div class="scroll-x">
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Наименование</th>
            <th>Артикул</th>
            <th>Производитель</th>
            <th>Цена</th>
            <th>Цена поставщика</th>
            <th>Старая цена</th>
            <th>Наличие</th>
            <th>Мин. заказ</th>
            <th>Валюта</th>
            <th>Изображения</th>
            <th>Meta-description</th>
            <th>ID поставщика</th>
            <th>ID категории</th>
            <th>Meta-title</th>
            <th>Meta-keywords</th>
        </tr>
        
        <?php foreach ( $data['products-tmp'] as $product ) { ?>
            <tr>
                <td><?=$product['id']?></th>
                <td><?=$product['name']?></td>
                <td><?=$product['artno']?></td>
                <td><?=$product['manufacture']?></td>
                <td><?=$product['price']?></td>
                <td><?=$product['cost_price']?></td>
                <td><?=$product['old_price']?></td>
                <td><?=$product['qnt']?></td>
                <td><?=$product['min_order']?></td>
                <td><?=$product['currency']?></td>
                <td><?=$product['images']?></td>
                <td><?=$product['description']?></td>
                <td><?=$product['supplier_id']?></td>
                <td><?=$product['category_id']?></td>
                <td><?=$product['title']?></td>
                <td><?=$product['keywords']?></td>
            </tr>
        <?php } ?>
        
    </table>
</div>









