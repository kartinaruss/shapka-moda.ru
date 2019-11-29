<table><tbody>
    <tr><td colspan="2"><h3>Экспорт товаров в Яндекс.Маркет</h3></td></tr>
    <tr>
         <td><span>Секретный код:</span></td>
         <td><div class="inputText"><i><b><input type="text" name="yml_password"/></b></i></div>
             <div class="Example">Любая комбинация латинских букв и цифр, которую вы придумываете сами с той целью, чтобы не допустить выгрузку каталога с вашего сайта посторонним людям.<br/>Используется в ссылке на YML-файл, которая приведена ниже.<br/>Ссылка вида: <code>{BASEURL}yml/ваш_секретный_код</code></div>
             <!-- BEGIN error_yml_password --><div class="error">{error_yml_password.MESSAGE}</div><!-- END error_yml_password -->
         </td>
    </tr>
    <tr>
         <td><span>Текущая ссылка на YML-файл:</span></td>
         <td><a href="{BASEURL}yml/{YML_PASSWORD}" target="_blank">{BASEURL}yml/<span id="yml_code">{YML_PASSWORD}</span></a>
             <div class="Example">Внимание! В файл выгружаются только позиции с заполненными полями "Цена" и "Категория".</div>
         </td>
    </tr>
    <tr>
        <td class="empty">&nbsp;</td>
        <td>
            <div class="oActButtons">
                <a class="save" href="javascript:;">Сохранить изменения</a>
            </div>
        </td>
    </tr>
</tbody></table>