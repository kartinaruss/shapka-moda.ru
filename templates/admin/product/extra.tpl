<form action="admin/product/extra/{ID}" method="post"><div class="oT2"><table><tbody>
    <tr><td colspan="2"><h3>Параметры товара</h3></td></tr>
    <tr>
        <td><span>Название параметра:</span></td>
        <td><div class="inputText"><i><b><input type="text" name="param_name"/></b></i></div>
            <div class="Example">Например: <b>Размеры</b></div>
            <!-- BEGIN error_param_name --><div class="error">{error_param_name.MESSAGE}</div><!-- END error_param_name -->
        </td>
    </tr>
    <tr>
        <td><span>Значения и цены:</span></td>
        <td>
            <div class="oEditor params"><div class="list oEditor">
                <table>
                    <thead><tr class="nodrop nodrag">
                        <td></td>
                        <td width="60%">Значение</td>
                        <td><s>Цена, {CURRENCY}</s></td>
                        <td>Цена, {CURRENCY}</td>
                        <td></td>
                    </tr></thead>
                    <tbody>
                    <!-- BEGIN param -->
                    <tr>
                        <td class="move" title="Передвинуть"><i>&nbsp;</i></td>
                        <td><input type="text" name="param_value[]"/></td>
                        <td><input type="text" name="param_price_old[]"/></td>
                        <td><input type="text" name="param_price[]"/></td>
                        <td><div class="actions">
                            <a href="javascript:;" class="remove" title="Удалить"><i>Удалить</i></a>
                        </div></td>
                    </tr>
                    <!-- END param -->
                    <tr class="nodrop nodrag">
                        <td></td>
                        <td><input type="text" name="param_value_new"/></td>
                        <td><input type="text" name="param_price_new"/></td>
                        <td><input type="text" name="param_price_old_new"/></td>
                        <td><div class="actions"><a href="javascript:;" class="enter" title="Добавить"><i>Добавить</i></a></div></td>
                    </tr>
                    <tr class="nodrop nodrag new" style="display:none;">
                        <td class="move" title="Передвинуть"><i>&nbsp;</i></td>
                        <td><input type="text" name="param_value[]" value=""/></td>
                        <td><input type="text" name="param_price_old[]" value=""/></td>
                        <td><input type="text" name="param_price[]" value=""/></td>
                        <td><div class="actions">
                            <a href="javascript:;" class="remove" title="Удалить"><i>Удалить</i></a>
                        </div></td>
                    </tr>
                    </tbody>
                </table>
            </div></div>
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