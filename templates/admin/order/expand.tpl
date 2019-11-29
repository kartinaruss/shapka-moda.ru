<!-- BEGIN order -->
<!-- BEGIN cart -->
<h3>Корзина</h3>
<div class="cart"><table>
<thead>
    <tr>
        <td>Наименование</td>
        <td>Кол.</td>
        <td>Стоимость</td>
    </tr>
</thead>
<tbody> 
    <!-- BEGIN product -->
    <tr rel="{product.ID}"> 
        <td><a href="item/{product.KEY}" target="_blank">{product.NAME}</a><!-- BEGIN product.code --> ({product.CODE})<!-- END product.code --></td> 
        <td>{product.COUNT}</td> 
        <td>{product.PRICE} {CURRENCY}</td>
    </tr>
    <!-- END product -->
    <!-- BEGIN shipping -->
    <tr rel="shipping"> 
        <td>Доставка</td> 
        <td></td> 
        <td>{shipping.PRICE} {CURRENCY}</td> 
    </tr>
    <!-- END shipping -->
    <tr>
        <td colspan="2" align="right">Итого</td>
        <td><span id="cartTotalPrice">{PRICE_TOTAL}</span> {CURRENCY}</td>
    </tr>
</tbody></table></div>
<!-- END cart -->
<p>Адрес: {order.ADDRESS}</p>
<p>Комментарий: {order.MESSAGE}</p>
<!-- BEGIN order.ref --><p>Реферал: {order.REF}</p><!-- END order.ref -->
<!-- END order -->