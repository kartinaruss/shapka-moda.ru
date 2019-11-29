<form action="cart/order" method="post">
    <div class="Title">Корзина</div>
    <div class="Descr successHide"></div>
    <div class="successHide cart"><table>
    <thead>
        <tr>
            <td>Наименование</td>
            <td>Кол.</td>
            <td>Стоимость</td>
            <td>&nbsp;</td>
        </tr>
    </thead>
    <tbody>
        <!-- BEGIN product -->
        <tr rel="{product.ID}">
            <td>{product.NAME}</td>
            <td>
                <div class="inputText"><i><b><input type="text" name="count[{product.ID}]" value="{product.COUNT}" /></b></i></div>
            </td>
            <td style="font-wight: bold">{product.PRICE} {CURRENCY}</td>
            <td>
                <div class="button gray delete">✖</div>
            </td>
        </tr>
        <!-- END product -->
        <!-- BEGIN shipping -->
        <tr rel="shipping">
            <td>Доставка</td>
            <td></td>
            <td><span id="shippingPrice">{shipping.PRICE}</span> {CURRENCY}</td>
            <td></td>
        </tr>
        <!-- END shipping -->
        <tr>
            <td colspan="2" align="right">Итого</td>
            <td><span id="cartTotalPrice">{PRICE_TOTAL}</span> {CURRENCY}</td>
            <td></td>
        </tr>
    </tbody></table></div>
    <!-- BEGIN free_shipping --><p style="color:green;font-weight:bold;">При заказе от <span id="freeShippingPrice">{free_shipping.PRICE}</span> руб доставка бесплатна!</p><!-- END free_shipping -->
    <div class="Buttons">
         <div class="button red send">Оформить заказ</div>
         <div class="button gray cancel">Продолжить покупки</div>
         <div class="button gray clear">Очистить</div>
    </div>
</form>

<!-- BEGIN see_also -->
<div class="catalog">
    <div class="head">
        <h3></h3>
    </div>
    <div class="items">
        <!-- BEGIN also -->
        <div class="item">
            <h3><a href="item/{also.KEY}">{also.NAME}</a></h3>
            <!-- BEGIN also.picture -->
            <div class="img {also.LABEL}">
                <a href="item/{also.KEY}"><img src="images/product/s/{also.picture.SRC}" alt=""/></a>
            </div>
            <!-- END also.picture -->
            <div class="brief text"><p>{also.BRIEF}</p></div>
            <!-- BEGIN also.price_old --><div class="oldprice text">Старая цена: <span>{also.PRICE_OLD}</span> {CURRENCY}</div><!-- END also.price_old -->
            <!-- BEGIN also.price --><div class="price">Цена: <span>{also.PRICE}</span> {CURRENCY}</div><!-- END also.price -->
            <div class="actions">
                <div class="button red cart" id="{also.ID}">В корзину</div>
            </div>
        </div>
        <!-- END also -->
    </div>
</div>
<!-- END see_also -->

<!-- BEGIN metrika -->
<script type="text/javascript">
yaCounter{metrika.COUNTER_ID}.reachGoal('BASKET_1');
</script>
<!-- END metrika -->