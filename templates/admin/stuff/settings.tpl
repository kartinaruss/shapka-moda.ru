<table><tbody>
    <tr><td colspan="2"><h3>Контакты</h3></td></tr>
    <tr>
         <td><span>E-mail:</span></td>
         <td><div class="inputText"><i><b><input type="text" name="email"/></b></i></div>
             <!-- BEGIN error_email --><div class="error">{error_email.MESSAGE}</div><!-- END error_email -->
         </td>
    </tr>
    <tr>
         <td><span>Телефон:</span></td>
         <td><div class="inputText" style="width:150px;"><i><b><input type="text" name="phone"/></b></i></div></td>
    </tr>
    <tr>
         <td><span>Телефон 2:</span></td>
         <td><div class="inputText" style="width:150px;"><i><b><input type="text" name="phone2"/></b></i></div></td>
    </tr>
    <tr>
         <td><span>Skype:</span></td>
         <td><div class="inputText" style="width:150px;"><i><b><input type="text" name="skype"/></b></i></div></td>
    </tr>
    <tr>
         <td><span>ICQ:</span></td>
         <td><div class="inputText" style="width:150px;"><i><b><input type="text" name="icq"/></b></i></div></td>
    </tr>
    <tr>
         <td><span>Подпись под телефоном:</span></td>
         <td><div class="textarea"><i><b><textarea name="work_hours" style="height:50px"></textarea></b></i></div>
             <div class="Example">Например: Есть вопросы - звоните!</div>
         </td>
    </tr>
    <tr>
         <td><span>Дескрипт:</span></td>
         <td><div class="inputText"><i><b><input type="text" name="descript"/></b></i></div>
             <div class="Example">Например: Интернет-магазин по продаже чемоданов с доставкой по всей России!</div>
         </td>
    </tr>
    <tr>
         <td><span>ОГРН:</span></td>
         <td><div class="inputText"><i><b><input type="text" name="ogrn"/></b></i></div></td>
    </tr>
    <tr><td colspan="2"><h3>Параметры сайта</h3></td></tr>
    <tr>
         <td><span>Название сайта:</span></td>
         <td><div class="inputText"><i><b><input type="text" name="site_name"/></b></i></div>
             <div class="Example">Показывается в копирайтах</div>
         </td>
    </tr>
    <tr>
         <td><span>Год создания сайта:</span></td>
         <td><div class="inputText" style="width:50px;"><i><b><input type="text" name="year"/></b></i></div>
             <!-- BEGIN error_year --><div class="error">{error_year.MESSAGE}</div><!-- END error_year -->
         </td>
    </tr>
    <tr>
         <td><span>Постфикс к заголовку:</span></td>
         <td><div class="inputText"><i><b><input type="text" name="title_postfix"/></b></i></div>
             <div class="Example">Прибавляется к заголовкам всех страниц, кроме главной.</div>
         </td>
    </tr>
    <tr>
         <td><span>Валюта на сайте:</span></td>
         <td><div class="inputText" style="width:50px;"><i><b><input type="text" name="currency"/></b></i></div>
             <!-- BEGIN error_currency --><div class="error">{error_currency.MESSAGE}</div><!-- END error_currency -->
         </td>
    </tr>
    <tr>
         <td><span>Маска номера телефона:</span></td>
         <td><div class="inputText" style="width:200px;"><i><b><input type="text" name="phone_mask"/></b></i></div>
             <div class="Example">Например: +7 (999) 999-9999<br/>где 9 - обозначение одной цифры номера<br/><b>Внимание! НЕ ПИСАТЬ СЮДА НОМЕР СВОЕГО ТЕЛЕФОНА!</b></div>
             <!-- BEGIN error_phone_mask --><div class="error">{error_phone_mask.MESSAGE}</div><!-- END error_phone_mask -->
         </td>
    </tr>
    <tr>
         <td><span>Текст кнопки заказа:</span></td>
         <td><div class="inputText" style="width:100px;"><i><b><input type="text" name="button_order_text"/></b></i></div>
             <!-- BEGIN error_button_order_text --><div class="error">{error_button_order_text.MESSAGE}</div><!-- END error_button_order_text -->
         </td>
    </tr>
    <tr><td colspan="2"><h3>Доставка (в корзине)</h3></td></tr>
    <tr>
         <td><span>Стоимость доставки ({CURRENCY}):</span></td>
         <td><div class="inputText" style="width:50px;"><i><b><input type="text" name="shipping"/></b></i></div>
             <!-- BEGIN error_shipping --><div class="error">{error_shipping.MESSAGE}</div><!-- END error_shipping -->
         </td>
    </tr>
    <tr>
         <td><span>Бесплатная доставка<br/>при заказе от ({CURRENCY}):</span></td>
         <td><br/><div class="inputText" style="width:50px;"><i><b><input type="text" name="free_shipping"/></b></i></div>
             <!-- BEGIN error_free_shipping --><div class="error">{error_free_shipping.MESSAGE}</div><!-- END error_free_shipping -->
         </td>
    </tr>
    <tr><td colspan="2"><h3>Всплывающее окно при уходе с сайта</h3></td></tr>
    <tr>
         <td></td>
         <td><input type="checkbox" name="enable_popup"/> Включить всплывающее окно при закрытии сайта</td>
    </tr>
    <tr>
         <td><span>Текст сообщения:</span></td>
         <td><div class="textarea"><i><b><textarea name="exit_message" style="height:50px"></textarea></b></i></div>
         </td>
    </tr>
    <tr><td colspan="2"><h3>Онлайн-консультант</h3></td></tr>
    <tr>
         <td><span>Код консультанта:</span></td>
         <td><div class="textarea"><i><b><textarea name="online_chat" style="height:50px"></textarea></b></i></div>
             <div class="Example">Можно подключить такие сервисы, как: 
                 <a href="http://jivosite.ru/" onclick="window.open('http://www.jivosite.ru?pid=980');return false;">JivoSite</a>, 
                 <a href="http://livetex.ru/" onclick="window.open('http://billing.livetex.ru/reg/326/');return false;">LiveTex</a>, 
                 <a href="http://siteheart.com/" target="_blank">SiteHeart</a> или любой другой.
             </div>
         </td>
    </tr>
    <tr><td colspan="2"><h3>Социальные сети</h3></td></tr>
    <tr>
         <td><span>ВКонтакте App ID:</span></td>
         <td><div class="inputText" style="width:150px;"><i><b><input type="text" name="vk_app_id"/></b></i></div>
             <div class="Example">Например: <b>2635640</b>. 
                Можно достать на <a href="http://vk.com/editapp?act=create&site=1" target="_blank">http://vk.com/editapp?act=create&site=1</a>.<br/>
                (при создании приложения необходимо выбрать "Веб-сайт" и указать ваш домен, далее найти идентификатор приложения)<br/>
                Подключает кнопки "Мне нравится" и блок комментариев для каждого товара.</div>
             <!-- BEGIN error_vk_app_id --><div class="error">{error_vk_app_id.MESSAGE}</div><!-- END error_vk_app_id -->
         </td>
    </tr>
    <tr>
         <td><span>ВКонтакте Group ID:</span></td>
         <td><div class="inputText" style="width:150px;"><i><b><input type="text" name="vk_group_id"/></b></i></div>
             <div class="Example">Например: <b>30898572</b>. Можно узнать на <a href="http://vk.com/developers.php?oid=-1&p=Groups" target="_blank">http://vk.com/developers.php?oid=-1&p=Groups</a>.<br/>Подключает блок "Сообщество".</div>
             <!-- BEGIN error_vk_group_id --><div class="error">{error_vk_group_id.MESSAGE}</div><!-- END error_vk_group_id -->
         </td>
    </tr>
    <tr>
         <td><span>Ссылка Vkontakte:</span></td>
         <td><div class="inputText"><i><b><input type="text" name="link_vk"/></b></i></div></td>
    </tr>
    <tr>
         <td><span>Ссылка Facebook:</span></td>
         <td><div class="inputText"><i><b><input type="text" name="link_fb"/></b></i></div></td>
    </tr>
    <tr>
         <td><span>Ссылка Twitter:</span></td>
         <td><div class="inputText"><i><b><input type="text" name="link_tw"/></b></i></div></td>
    </tr>
    <tr>
         <td><span>Ссылка Odnoklassniki:</span></td>
         <td><div class="inputText"><i><b><input type="text" name="link_od"/></b></i></div></td>
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