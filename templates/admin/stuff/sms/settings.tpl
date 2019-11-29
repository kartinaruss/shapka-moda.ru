<table><tbody>
    <tr><td colspan="2"><h3>Как это работает</h3></td></tr>
    <tr>
        <td align="right"><a href="http://smsc.ru/" onclick="window.open('http://smsc.ru/?pp374466');return false;"><img src="http://smsc.ru/im/smsc_logo.gif" alt="" style="padding:4px;border:1px solid #a7a7a7;margin-right:25px;"/></a></td>
        <td>
            <p>Первым делом, вам необходимо <a href="http://smsc.ru/" onclick="window.open('http://smsc.ru/reg/?pp374466');return false;">зарегистрировать аккаунт на сервисе SMS-Центр</a>. Там же вы можете ознакомиться с действующими тарифами на отправку смс-сообщений.</p>
            <p>Далее необходимо заполнить раздел "Авторизационные данные", который находится ниже, а также пополнить баланс в личном кабинете на сервисе <a href="http://smsc.ru/" onclick="window.open('http://smsc.ru/?pp374466');return false;">SMS-Центр</a>.</p>
        </td>
    </tr>
    <tr><td colspan="2"><h3>Авторизационные данные</h3></td></tr>
    <tr>
         <td><span>Логин:</span></td>
         <td><div class="inputText" style="width:150px;"><i><b><input type="text" name="smsc_login"/></b></i></div>
            <div class="Example">email, указанный при регистрации на SMS-Центр</div>
         </td>
    </tr>
    <tr>
         <td><span>Пароль:</span></td>
         <td><div class="inputText" style="width:150px;"><i><b><input type="text" name="smsc_pass"/></b></i></div>
            <div class="Example">пароль от сервиса SMS-Центр</div>
         </td>
    </tr>
    <tr><td colspan="2"><h3>SMS-уведомления при заказе товара</h3></td></tr>
    <tr>
         <td></td>
         <td><label><input type="checkbox" name="sms_order_enable"/> Включить смс-уведомления при заказе</label></td>
    </tr>
    <tr>
         <td><span>Сообщение покупателю:</span></td>
         <td><div class="textarea"><i><b><textarea name="sms_order_client" style="height:50px"></textarea></b></i></div>
            <div class="Example">Переменные: &#123;NAME&#125; - имя покупателя, &#123;PHONE&#125; - телефон покупателя, &#123;TOTAL&#125; - сумма заказа, &#123;ID&#125; - номер заказа</div>
         </td>
    </tr>
    <tr>
         <td><span>Сообщение админу:</span></td>
         <td><div class="textarea"><i><b><textarea name="sms_order_admin" style="height:50px"></textarea></b></i></div>
            <div class="Example">Переменные: &#123;NAME&#125; - имя покупателя, &#123;PHONE&#125; - телефон покупателя, &#123;TOTAL&#125; - сумма заказа, &#123;ID&#125; - номер заказа</div>
         </td>
    </tr>
    <tr>
         <td><span>Телефон админа:</span></td>
         <td><div class="inputText" style="width:150px;"><i><b><input type="text" name="sms_order_phone"/></b></i></div>
            <div class="Example">Например: 79171234567</div>
         </td>
    </tr>
    <tr><td colspan="2"><h3>SMS-уведомления при заказе звонка</h3></td></tr>
    <tr>
         <td></td>
         <td><label><input type="checkbox" name="sms_call_enable"/> Включить смс-уведомления при заказе звонка</label></td>
    </tr>
    <tr>
         <td><span>Сообщение покупателю:</span></td>
         <td><div class="textarea"><i><b><textarea name="sms_call_client" style="height:50px"></textarea></b></i></div>
            <div class="Example">Переменные: &#123;NAME&#125; - имя покупателя, &#123;PHONE&#125; - телефон покупателя</div>
         </td>
    </tr>
    <tr>
         <td><span>Сообщение админу:</span></td>
         <td><div class="textarea"><i><b><textarea name="sms_call_admin" style="height:50px"></textarea></b></i></div>
            <div class="Example">Переменные: &#123;NAME&#125; - имя покупателя, &#123;PHONE&#125; - телефон покупателя</div>
         </td>
    </tr>
    <tr>
         <td><span>Телефон админа:</span></td>
         <td><div class="inputText" style="width:150px;"><i><b><input type="text" name="sms_call_phone"/></b></i></div>
            <div class="Example">Например: 79171234567</div>
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