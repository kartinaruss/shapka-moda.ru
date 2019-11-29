<form action="admin/product/edit/{ID}" method="post" enctype="multipart/form-data"><div class="oT2"><table><tbody>
    <tr><td colspan="2"><h3>Редактирование товара</h3></td></tr>
    <tr>
        <td><span>Название: <font color="red">*</font></span></td>
        <td>
            <div class="inputText"><i><b><input type="text" name="name"/></b></i></div>
            <!-- BEGIN error_name --><div class="error">{error_name.MESSAGE}</div><!-- END error_name -->
        </td>
    </tr>
    <tr>
        <td><span>Алиас: <font color="red">*</font></span></td>
        <td>
            <div style="width:40px;float:left;line-height:22px;">item/</div>
            <div class="inputText" style="padding-left:40px;width:360px"><i><b><input type="text" name="key"/></b></i></div>
            <!-- BEGIN error_key --><div class="error">{error_key.MESSAGE}</div><!-- END error_key -->
        </td>
    </tr>
    <tr>
        <td><span>Артикул: </span></td>
        <td>
            <div class="inputText"><i><b><input type="text" name="code"/></b></i></div>
            <!-- BEGIN error_code --><div class="error">{error_code.MESSAGE}</div><!-- END error_code -->
        </td>
    </tr>
    <tr>
        <td><span>Категории:</span></td>
        <td>
            <select name="category_id" multiple="multiple" size="5" class="chosen" data-placeholder="Выберите категории товара...">$categories</select>
            <!-- BEGIN error_category_id --><div class="error">{error_category_id.MESSAGE}</div><!-- END error_category_id -->
        </td>
    </tr>
    <tr>
        <td><span>Критерии:</span></td>
        <td>
            <select name="criteria_id" multiple="multiple" size="10" class="chosen" data-placeholder="Выберите критерии для фильтра...">
                <!-- BEGIN criteria -->
                <optgroup label="{criteria.NAME}">
                <!-- BEGIN criteria.sub -->
                    <option value="{criteria.sub.ID}">{criteria.sub.NAME}</option>
                <!-- END criteria.sub -->
                </optgroup>
                <!-- END criteria -->
            </select>
            <div class="Example" style="display:none;">Удерживайте Ctrl<br/>для выбора<br/>нескольких критериев</div>
            <!-- BEGIN error_criteria_id --><div class="error">{error_criteria_id.MESSAGE}</div><!-- END error_criteria_id -->
        </td>
    </tr>
    <tr>
        <td><span>Картинка:</span></td>
        <td>
            <div class="Picture">
                <!-- BEGIN no_picture -->
                <div class="addImage">
                    <span class="oFileLink"><i>Прикрепить</i><input type="file" name="file" size="40" rel="admin/product/picture"/></span>
                </div>
                <!-- END no_picture -->
                <!-- BEGIN picture2 -->
                <div class="changeImage">
                    <img src="images/product/temp/{picture2.KEY}" alt="" title=""  width="180" />
                    <span class="oFileLink"><i>Поменять</i><input type="file" name="file" size="40" rel="admin/product/picture"/></span>
                </div>
                <!-- END picture2 -->
                <!-- BEGIN picture -->
                <div class="changeImage">
                    <img src="images/product/s/{picture.FILE}" alt="" title="" width="180" />
                    <span class="oFileLink"><i>Поменять</i><input type="file" name="file" size="40" rel="admin/product/picture"/></span>
                </div>
                <!-- END picture -->
                <input type="hidden" name="pictureKey" default=""/>
            </div>
        </td>
    </tr>
    <tr>
        <td><span>Пару слов о товаре:</span></td>
        <td><div class="textarea"><i><b><textarea name="brief" cols="30" rows="10" style="height:50px;"></textarea></b></i></div></td>
    </tr>
    <tr>
        <td><span>Краткое описание:</span></td>
        <td><textarea name="description_wiki" cols="30" rows="10" style="height:150px;" class="wiki"></textarea></td>
    </tr>
    <tr>
        <td class="empty">&nbsp;</td>
        <td><div class="oActButtons">
            <a href="javascript:;" class="preview" for="description_wiki">Предпросмотр</a>
            <a href="admin/upload/image" class="upload">Загрузить картинку</a>
            <a href="admin/upload/file" class="upload">Загрузить файл</a>
        </div></td>
    </tr>
    <tr class="previewRow" for="description_wiki" style="display:none">
         <td><span>Предпросмотр:</span></td>
         <td>
              <div class="oPreview manual wikitext"></div>
         </td>
    </tr>
    <tr>
        <td><span>Подробное описание:</span></td>
        <td><textarea name="seotext_wiki" cols="30" rows="10" style="height:300px;" class="wiki"></textarea></td>
    </tr>
    <tr>
        <td class="empty">&nbsp;</td>
        <td><div class="oActButtons">
            <a href="javascript:;" class="preview" for="seotext_wiki">Предпросмотр</a>
            <a href="admin/upload/image" class="upload">Загрузить картинку</a>
            <a href="admin/upload/file" class="upload">Загрузить файл</a>
        </div></td>
    </tr>
    <tr class="previewRow" for="seotext_wiki" style="display:none">
         <td><span>Предпросмотр:</span></td>
         <td>
              <div class="oPreview manual wikitext"></div>
         </td>
    </tr>
    <tr>
        <td><span>Рейтинг </span></td>
        <td><div class="inputText"><i><b><input type="text" name="rating"/></b></i></div>
            
</td>
    </tr>
    <tr>
        <td><span>Приоритет <font color="red">*</font></span></td>
        <td><div class="inputText"><i><b><input type="text" name="prioritet"/></b></i></div>
            <!-- BEGIN error_prioritet --><div class="error">{error_prioritet.MESSAGE}</div><!-- END error_prioritet -->
</td>
    </tr>
    <tr>
        <td><span><s>Старая цена ({CURRENCY})</s>:</span></td>
        <td>
            <div class="inputText"><i><b><input type="text" name="price_old"/></b></i></div>
            <!-- BEGIN error_price_old --><div class="error">{error_price_old.MESSAGE}</div><!-- END error_price_old -->
        </td>
    </tr>
    <tr>
        <td><span>Цена ({CURRENCY}):</span></td>
        <td>
            <div class="inputText"><i><b><input type="text" name="price"/></b></i></div>
            <!-- BEGIN error_price --><div class="error">{error_price.MESSAGE}</div><!-- END error_price -->
        </td>
    </tr>
    <tr>
        <td><span>Ярлык:</span></td>
        <td>
            <label><input type="radio" name="label" value=""/> нет</label>
            <label><input type="radio" name="label" value="new"/> Новый</label>
            <label><input type="radio" name="label" value="hit"/> Хит</label>
            <label><input type="radio" name="label" value="discount"/> Скидка</label>
            <label><input type="radio" name="label" value="promo"/> Акция</label>
        </td>
    </tr>
    <tr>
        <td><span>С этим товаром также покупают:</span></td>
        <td>
            <select name="also" multiple="multiple" size="10" class="chosen" data-placeholder="Выберите товары...">$products</select>
            <!-- BEGIN error_also --><div class="error">{error_also.MESSAGE}</div><!-- END error_also -->
        </td>
    </tr>
    <tr>
        <td><span></span></td>
        <td>
            <label><input type="checkbox" name="main"/> Показывать товар на главной странице</label>
        </td>
    </tr>
    <tr><td class="empty">&nbsp;</td><td><h3>Параметры для поисковых систем</h3></td></tr>
    <tr>
        <td><span>Title:</span></td>
        <td><div class="inputText"><i><b><input type="text" name="title"/></b></i></div></td>
    </tr>
    <tr>
        <td><span>Keywords:</span></td>
        <td><div class="inputText"><i><b><input type="text" name="keywords"/></b></i></div>
            <div class="Example">5-10 слов, разделенных запятыми</div></td>
    </tr>
    <tr>
        <td><span>Description:</span></td>
        <td>
            <div class="textarea"><i><b><textarea name="description" rows="5" cols="100" style="height:50px;"></textarea></b></i></div>
            <div class="Example">Одно-два предложения, кратко представляющие информацию на странице</div>
        </td>
    </tr>
    <tr>
       <td class="empty">&nbsp;</td>
       <td><div class="oActButtons">
           <a href="javascript:;" class="save">Сохранить изменения</a>
           <a href="javascript:;" class="cancel">Отмена</a>
       </div></td>
    </tr>
</tbody></table></div></form>