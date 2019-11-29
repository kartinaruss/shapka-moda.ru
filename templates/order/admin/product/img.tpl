<!-- INCLUDE admin/header.tpl -->
<div class="cats">
    <a href="admin/product/main">Товары на главной</a>
    <a href="admin/product/category">Категории</a>
    <a href="admin/product/all">Все товары</a>
    <a href="admin/product/export/csv">Экспорт</a>
    <a href="admin/product/import/csv">Импорт</a>
    <span style="background:#ffffff;">Импорт фото</span>
</div>
<script type="text/javascript">
$(document).ready(function() {
    var extraBlock = $("#uploadBlock");
    // Загрузка файлов
    var uploader = $(".fileUpload",extraBlock);
    uploader.uploadify({
        'uploader'  : '/flash/uploader.swf',
        'script'    : '/admin/product/upload/img',
        'cancelImg' : 'images/admin/cancel.png',
        'multi': true,
        'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
        'onOpen'      : function(event,ID,fileObj) {
            ajaxloader.show();
        },
        'onAllComplete' : function(event,data) {
            ajaxloader.hide();
            extraBlock.find(".Buttons").hide();
        },
        'onSelectOnce' : function(event,data) {
            extraBlock.find(".Buttons").show(); 
        }
    });
    $(".Buttons .upload input",extraBlock).unbind().click(function(){
        uploader.uploadifyUpload();
        return false;
    });
    $(".Buttons .cancel input",extraBlock).unbind().click(function(){
        uploader.uploadifyClearQueue();
        extraBlock.find(".Buttons").hide();
        return false;
    });
});
</script>
<div class="product oEditor catExt">
    <div class="list oEditor" style="padding:40px;">
        <div class="oT2 oEditItem" id="uploadBlock"><table>
            <tbody>
                <tr><td colspan="2"><h3>Импорт фото</h3></td></tr>
                <tr>
                    <td colspan="2">Название файла фотографии = артикулу товара. Пример: артикул "<b>0788-82818-LEO</b>", фотография "<b>0788-82818-LEO.jpg</b>".<br/>
                        Дополнительные фото товара можно называть 0788-82818-LEO_1.jpg, 0788-82818-LEO_2.jpg и т.д.
                    </td>
                </tr>
                <tr>
                    <td><span>Выберите фотографии для загрузки:</span></td>
                    <td>
                        <div class="e Upload2">
                            <div class="Block">
                                <div class="fileUpload" id="uploader"></div> 
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="empty">&nbsp;</td>
                    <td>
                       <div class="Buttons" style="margin-top:15px;display:none;">
                           <div class="e"><div class="oBut green upload"><input type="submit" value="Загрузить выбранные файлы"/></div></div>
                       </div><br style="clear:both"/>
                    </td>
                </tr>
            </tbody>
        </table></div>
        <!-- BEGIN success --><br/><p style="font-weight:bold;color:green;">Импортирование завершено.<br/>Добавлено позиций: {success.ADDED}<br/>Изменено позиций: {success.EDITED}</p><!-- END success -->
    </div>
</div>
<!-- INCLUDE admin/footer.tpl -->