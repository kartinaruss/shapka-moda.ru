<!-- INCLUDE admin/header.tpl -->
<div class="cats">
    <a href="admin/product/main">Товары на главной</a>
    <a href="admin/product/category">Категории</a>
    <a href="admin/product/all">Все товары</a>
    <a href="admin/product/export/csv">Экспорт</a>
    <span style="background:#ffffff;">Импорт</span>
</div>
<div class="product oEditor catExt">
    <div class="list oEditor" style="padding:40px;">
        <form action="admin/product/import/csv" method="post" enctype="multipart/form-data">
        <div class="oT2 oEditItem"><table>
            <tbody>
                <tr><td colspan="2"><h3>Импорт из CSV</h3></td></tr>
                <tr><td><span>Столбцы:</span></td>
                    <td>
                    id, code, key, name, price, price_old, brief, description1, description2, categories, title, keywords, description, label, main, disabled<br/>
                    (для импорта используйте формат файла, получаемого при экспорте)
                </td></tr>
                <tr>
                    <td><span>Файл:</span></td>
                    <td>
                        <input type="file" name="file"/>
                    </td>
                </tr>
                <tr>
                    <td class="empty">&nbsp;</td>
                    <td>
                        <div class="oActButtons">
                            <input type="submit" name="submit" value="Загрузить"/>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table></div>
        </form>
        <!-- BEGIN success --><br/><p style="font-weight:bold;color:green;">Импортирование завершено.<br/>Добавлено позиций: {success.ADDED}<br/>Изменено позиций: {success.EDITED}</p><!-- END success -->
    </div>
</div>
<!-- INCLUDE admin/footer.tpl -->