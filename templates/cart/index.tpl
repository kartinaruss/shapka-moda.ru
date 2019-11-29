<style>
    .tshow{
        display: none;
    }

    .cart-product{
        position: relative;
        margin-bottom: 10px;
        border-bottom: 2px solid #f5f5f5;
    }

    .cart-product .fr,
    .cart-product .fl{
        width: 50%;
        box-sizing: border-box;
        padding: 5px;
        min-height: 100%;
    }

    .cart-product .fr img,
    .cart-product .fl img{
        width: 100%;
        height: auto;
    }

    .cart-product-name{
        font-weight: bold;
        margin-top: 15px;
        margin-bottom: 10px;
    }

    .cart-product-count{
        margin-bottom: 10px;
    }

    .cart-product-count input{
        display: inline-block;
        width: 30px;
        background: #f5f5f5;
        border: 1px solid #c2c2c2;
        text-align: center;
        outline: none !important;
    }

    .cart-total{
        margin-bottom: 10px;
        margin-top: 10px;
        font-weight: bold;
    }

    .cart-total .fl,
    .cart-total .fr{
        width: 50%;
        box-sizing: border-box;
        padding: 5px;
    }

    .cart-product-price span{
        font-weight: bold;
    }


    @media screen and (max-width: 520px) {
        .th{
            display: none;
        }

        .tshow{
            display: block;
        }
    }
</style>
<form action="cart/order" method="post">
    <div class="Title">Корзина</div>

    <div style="margin-bottom: 12px; color: #ED479D; font-size: 15px; font-weight: bold">
    {CART_MOTIV}
    </div>

    <div class="Descr successHide"></div>
    <div class="successHide cart">
        <table class="th">
            <thead>
                <tr>
                    <td class="mobileHide" width="100"></td>
                    <td>Наименование</td>
                    <td>Кол.</td>
                    <td>Стоимость</td>
                    <td>&nbsp;</td>
                </tr>
            </thead>
            <tbody>
                <!-- BEGIN product -->
                <tr rel="{product.ID}" data-product-id="{product.ID}">
                    <td class="mobileHide" style="text-align: center;"><img style="max-width: 150px; width: 100%; min-width: 50px;" src="images/product/s/{product.IMGS}" /></td>
                    <td aria-label="Наименование">{product.NAME}</td>
                    <td aria-label="Кол."><div class="inputText"><i><b><input data-product-id="{product.ID}" data-product-price="{product.PRICE}" name="count[{product.ID}]" value="{product.COUNT}" /></b></i></div></td>
                    <td aria-label="Стоимость" style="font-wight: bold">{product.PRICE} {CURRENCY}</td>
                    <td><div class="button gray delete" onclick="delete_basket_Soloway('{product.CATEGORY_ID}','{product.ID}'); return true;">✖</div></td>
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
                    <td></td>
                </tr>
            </tbody>
        </table></div>
        <div class="tshow">
            <!-- BEGIN product -->
            <div class="cart-product" data-product-id="{product.ID}">
                <div class="clearfix">
                    <div class="fl">
                        <img src="images/product/s/{product.IMGS}" />
                    </div>
                    <div class="fr">
                        <div class="cart-product-name">{product.NAME}</div>
                        <div class="cart-product-price">Стоимость: <span>{product.PRICE} {CURRENCY}</span></div>
                        <div class="cart-product-count">
                            <label class="inputText">Колличевство: <input data-product-id="{product.ID}" data-product-price="{product.PRICE}" name="count[{product.ID}]" value="{product.COUNT}"></label>
                        </div>
                        <div class="cart-product-delete" rel="{product.ID}">
                            <div class="button gray delete" onclick="delete_basket_Soloway('{product.CATEGORY_ID}','{product.ID}'); return true;">Удалить</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END product -->
            <div class="cart-total">
                <div class="clearfix">
                    <div class="fl">

                    </div>
                    <div class="fr">
                        Итого: <span id="cartTotalPrice2">{PRICE_TOTAL}</span> {CURRENCY}
                    </div>
                </div>
            </div>
        </div>
    <!-- BEGIN free_shipping --><p style="color:green;font-weight:bold;">При заказе от <span id="freeShippingPrice">{free_shipping.PRICE}</span> руб доставка бесплатна!</p><!-- END free_shipping -->
    <div class="Buttons">
         <div class="button gray cancel">Продолжить покупки</div>
         <div class="button pink red send">Оформить заказ</div>
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
ga('set', 'dimension2','cart');
fbq('track', 'AddToCart');
</script>
<!-- END metrika -->

