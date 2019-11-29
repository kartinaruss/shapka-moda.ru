<table><tbody>
    <tr><td colspan="2"><h3>Блок специального предложения</h3></td></tr>
    <tr>
        <td><span>Товар:</span></td>
        <td>
            <div class="select"><i><b><u><select name="special_product"><option value=""></option>$products</select></u></b></i></div>
            <!-- BEGIN error_special_product --><div class="error">{error_special_product.MESSAGE}</div><!-- END error_special_product -->
        </td>
    </tr>
    <tr style="display:none;">
         <td><span>Заголовок:</span></td>
         <td><div class="inputText"><i><b><input type="text" name="special_header"/></b></i></div></td>
    </tr>
    <tr style="display:none;">
         <td><span>Текст:</span></td>
         <td><textarea name="special_body" style="height:300px" class="wiki"></textarea></td>
    </tr>
    <tr>
        <td><span></span></td>
        <td>
            <label><input type="checkbox" name="special_on"/> Показывать блок на сайте</label>
        </td>
    </tr>
    <tr><td colspan="2"><h3>Cпецпредложения в корзине</h3></td></tr>
    <tr>
        <td><span>Товары:</span></td>
        <td>
            <select name="cart_special" multiple="multiple" size="15" class="chosen" data-placeholder="Выберите товары каталога...">$products</select>
        </td>
    </tr>
    <tr>
        <td class="empty">&nbsp;</td>
        <td>
            <div class="oActButtons">
                <a class="save" href="javascript:;">Сохранить изменения</a>
                <a class="cancel" href="javascript:;">Отмена</a>
            </div>
        </td>
    </tr>
</tbody></table>