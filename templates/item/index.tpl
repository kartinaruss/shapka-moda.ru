<!-- INCLUDE header.tpl -->
<div class="item-page">
    <!-- BEGIN product -->
    <script>
            dataLayer = [{
                "ecommerce": {
                    "detail": {
                        "products": [
                            {
                                "id": "{product.ID}",
                                "name" : "{product.NAME}",
                                "price": {product.PRICE}
                            }
                        ]
                    }
                }
            }];
    </script>
    <section class="item-page-tovar">
        <h2>{product.NAME}</h2>
        <div class="left">
            <!-- BEGIN product.picture -->
            <div class="img cycle">
                <a href="images/product/l/{product.picture.SRC}" title="{product.NAME}" class="fancybox" rel="gallery">
                    <img src="images/product/l/{product.picture.SRC}" title="{product.NAME}" alt="{product.NAME}">
                    <p class="discount">-52<span>%</span></p>
                </a>
                <!-- BEGIN product.album -->
                <!-- END product.album -->
            </div>
            <!-- END product.picture -->
            <!-- BEGIN product.if_album -->
            <div class="album">
                <!-- BEGIN product.picture -->
                <a href="images/product/l/{product.picture.SRC}" title='{product.NAME}' class="fancybox" rel="album">
                    <img src="images/product/s/{product.picture.SRC}" title='{product.NAME}' alt='{product.NAME}'/>
                </a>
                <!-- END product.picture -->
                <!-- BEGIN product.album -->
                <a href="images/product/l/{product.album.SRC}" title='{product.NAME}' class="fancybox" rel="album">
                    <img src="images/product/s/{product.album.SRC}" title='{product.NAME}' alt='{product.NAME}'/>
                </a>
                <!-- END product.album -->
            </div>
            <!-- END product.if_album -->
        </div>


        <div class="item-page-tovar-left">
        <div style="margin-top: 15px; margin-left: 3px; font-size: 16px; color: #909090; font-weight: 600">Артикул: {product.CODE}</div>
            <ul style="font-size: 15px" class="fp_points">
                <li>Натуральный мех</li>
                <li>Европейское качество</li>
                <li>Гарантия на товар</li>
                <li>Обмен/возврат 30 дней</li>
                <li>Доставка по России без предоплаты</li>
            </ul>

			<div style="margin-top: 25px; font: 15px/23px 'Trebuchet MS', Helvetica, sans-serif; color: #444444; font-weight:700;">
				<table>
				<tr>
					<td>Рейтинг товара:
					</td>
					<td style="padding-left: 10px"><img width="100px" src="./images/plusstar{product.RATING}.png">
					</td>
					<td style="padding-left: 5px;">({product.RATING})
					</td>
					</tr>
				</table>
	        </div>


	        <div style="margin-top: 20px; font: 400 16px 'Trebuchet MS', Helvetica, sans-serif; color: #333333">
    	    <span style="color: #333333; text-decoration: underline; font-weight: 600">Материал</span>:&nbsp;&nbsp;{product.DESCRIPTION}
        	</div>
	        <div style="margin-top: 5px; font: 400 16px 'Trebuchet MS', Helvetica, sans-serif; color: #333333">
    	    <span style="color: #333333; text-decoration: underline; font-weight: 600">Цвет</span>:&nbsp;&nbsp;{product.SEOTEXT}
        	</div>
	        <div style="margin-top: 5px; font: 400 16px 'Trebuchet MS', Helvetica, sans-serif; color: #333333">
    	    <span style="color: #333333; text-decoration: underline; font-weight: 600">Размер</span>:&nbsp;&nbsp;универсальный
        	</div>

            <div class="price-shares">
                <p style="color: #888!important;">Цена без акции:</p>
                <!-- BEGIN product.price_old -->
                <p class="price oldprice"> <span class="num" style="color: #888!important;">{product.PRICE_OLD}</span> <span style="font-size: 26px; color: #888!important;">{CURRENCY}</span></p>
                <!-- END product.price_old -->
            </div>

            <div class="not price-shares">
                <p style="color:#111 !important">Цена по акции:</p>
                <!-- BEGIN product.price -->
                <p class="price currprice"> <span class="num" style="color: #ed479d !important;">{product.PRICE}</span> <span style="font-size: 40px;">{CURRENCY}</span></p>
                <!-- END product.price -->
                <!-- BEGIN product.param -->
                <div class="param"  style="padding-top: 1px; padding-bottom: 5px; font-size:16px;">
                <span>{product.param.NAME}:</span>
                    <select>
                        <!-- BEGIN product.param.val --><option value="{product.ID}:{product.param.val.NUM}" rel="{product.param.val.PRICE}" rel2="{product.param.val.PRICE_OLD}">{product.param.val.NAME}</option><!-- END product.param.val -->
                    </select>
                </div>
                <!-- END product.param -->
                <div class="button pink red {BUTTON_ORDER_CLASS}" style="margin-top: 10px" id="{product.ID}<!-- BEGIN product.param -->:0<!-- END product.param -->">Заказать по акции</div>
            </div>
        </div>
        <div class="clearfix"></div>
    </section>

    <div class="item-page-row">
        <div class="clearfix">
            <div class="block-border left">
                <div>
                    <div class="img">
                        <img src="./assets/img/item-page-mp3.png" alt="Картинка">
                    </div>
                    <div class="text">
                        <h5>Стильный mp3-плеер <br>в подарок при покупке!</h5>
                        <p>Спешите, количество подарков<br>ограничено!</p>
                    </div>
                </div>
            </div>

            <div class="block-border right">
                <div>
                    <div class="img">
                        <img src="/assets/img/item-page-clip.jpg" alt="Картинка">
                    </div>
                    <div class="text">
                        <h5>Оплата без риска!</h5>
                        <p>Оплата после получения заказа. <br>Безопасная покупка!<br>
                        <br></p>

                    </div>
                </div>
            </div>
        </div>


        <!-- END product -->

        <!-- BEGIN see_also -->
        <div class="catalog w2 item border2">
            <div style="width:100%; height:32px; color:#ffffff; margin: 0px;padding-top: 10px; padding-bottom: 10px"><h2>Похожие модели:</h2></div>
            <div class="items fix product-items clearfix">
                <!-- BEGIN also -->
                <div class="item product-item">
                    <p class="discount icon">-52<span>%</span></p>
                    <!-- BEGIN also.picture -->
                    <div class="product-image {also.LABEL}">
                        <a href="item/{also.KEY}"><img src="images/product/s/{also.picture.SRC}" alt="{also.NAME}" /></a>
                    </div>
                    <!-- END also.picture -->
                    <div class="product-name"><a href="item/{also.KEY}">{also.NAME}</a>
                    <span style="color: #888888; text-align: right; font-size: 14px; white-space: nowrap; 1font-weight: bold">(арт. {also.CODE})</span>
                    <div style="font-style:italic; font-size: 14px">{also.BRIEF}</div>
                    </div>
                    <div class="product-price">
                        <!-- BEGIN also.price_old -->
                        <div class="old-price">{also.PRICE_OLD} {CURRENCY}</div>
                        <!-- END also.price_old -->
                        <!-- BEGIN also.price -->
                        <div class="price">{also.PRICE} {CURRENCY}</div>
                        <!-- END also.price -->
                    </div>
                    <div class="actions clearfix">
                        <a href="item/{also.KEY}" class="button gray view">Подробнее</a>
                        <div class="button pink red {BUTTON_ORDER_CLASS}" id="{also.ID}<!-- BEGIN also.param -->:0<!-- END also.param -->" >{BUTTON_ORDER_TEXT}</div>
                        <!--onclick="yaCounter34834310.reachGoal('knopka_korzina'); return true;"-->
                    </div>
                </div>
                <!-- END also -->
            </div>
        </div>
        <!-- END see_also -->
    </div>
</div>
<!-- INCLUDE footer.tpl -->
