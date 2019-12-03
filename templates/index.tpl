<!-- INCLUDE header.tpl -->

<!-- BEGIN special -->
<div class="product w item" style="border: 1px solid #d1d1d1">
    <div class="L">
        <!-- BEGIN special.picture -->
        <div class="img cycle {special.LABEL}">
            <a href="images/product/l/{special.picture.SRC}" title='{special.NAME}' class="fancybox" rel="gallery"><img src="images/product/s/{special.picture.SRC}" title='{special.NAME}' alt='{special.NAME}' /></a>
            <!-- BEGIN special.album -->
            <a href="images/product/l/{special.album.SRC}" title='{special.NAME}' class="fancybox" rel="gallery"><img src="images/product/s/{special.album.SRC}" title='{special.NAME}' alt='{special.NAME}' /></a>
            <!-- END special.album -->
        </div>
        <!-- END special.picture -->
        <!-- BEGIN special.if_album -->
        <div class="album">
            <!-- BEGIN special.picture -->
            <a href="images/product/l/{special.picture.SRC}" title='{special.NAME}' class="fancybox" rel="album"><img src="images/product/s/{special.picture.SRC}" title='{special.NAME}' alt='{special.NAME}' /></a>
            <!-- END special.picture -->
            <!-- BEGIN special.album -->
            <a href="images/product/l/{special.album.SRC}" title='{special.NAME}' class="fancybox" rel="album"><img src="images/product/s/{special.album.SRC}" title='{special.NAME}' alt='{special.NAME}' /></a>
            <!-- END special.album -->
        </div>
        <!-- END special.if_album -->
        <table width="100%">
            <tr>
                <td style="vertical-align:top;text-align:left;">
                    <!-- BEGIN vk_app -->
                    <div id="vk_like" style="margin-top:10px;"></div>
                    <script:no-cache type="text/javascript">
                        VK.Widgets.Like("vk_like", {type: "button"});
                        </script>
                        <!-- END vk_app -->
                        <div id="fb-root"></div>
                        <script>
                        (function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s);
                            js.id = id;
                            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=160752127313829";
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));
                        </script>
                        <div class="fb-like" data-send="true" data-layout="button_count" data-width="150" data-show-faces="true" style="margin-top:10px;"></div>
                        <div style="text-align:left;margin-top:10px;"><a href="https://twitter.com/share" class="twitter-share-button" data-lang="ru" style="width:100px;">Твитнуть</a></div>
                        <script>
                        ! function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (!d.getElementById(id)) {
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "//platform.twitter.com/widgets.js";
                                fjs.parentNode.insertBefore(js, fjs);
                            }
                        }(document, "script", "twitter-wjs");
                        </script>
                </td>
                <td>
                    <div style="text-align:right;margin-top:10px;">
                        <g:plusone size="tall" annotation="none"></g:plusone>
                        <script type="text/javascript">
                        (function() {
                            var po = document.createElement('script');
                            po.type = 'text/javascript';
                            po.async = true;
                            po.src = 'https://apis.google.com/js/plusone.js';
                            var s = document.getElementsByTagName('script')[0];
                            s.parentNode.insertBefore(po, s);
                        })();
                        </script>
                        <link href="http://stg.odnoklassniki.ru/share/odkl_share.css" rel="stylesheet">
                        <script src="http://stg.odnoklassniki.ru/share/odkl_share.js" type="text/javascript"></script>
                        <div style="text-align:right;margin-top:10px;"><a class="odkl-klass-stat" href="{BASEURL}item/{special.KEY}" onclick="ODKL.Share(this);return false;"><span>0</span></a></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="R">
        <h2>{special.NAME}</h2>
        <div class="text">
            {special.DESCRIPTION}
        </div>
        <div class="actions">
            <!-- BEGIN special.param -->
            <div class="param"><span>{special.param.NAME}</span>
                <select>
                    <!-- BEGIN special.param.val -->
                    <option value="{special.ID}:{special.param.val.NUM}" rel="{special.param.val.PRICE}" rel2="{special.param.val.PRICE_OLD}">{special.param.val.NAME}</option>
                    <!-- END special.param.val -->
                </select>
            </div>
            <!-- END special.param -->
            <!-- BEGIN special.price_old -->
            <div class="oldprice text">Старая цена: <span>{special.PRICE_OLD}</span> {CURRENCY}</div>
            <!-- END special.price_old -->
            <!-- BEGIN special.price -->
            <div class="price">Цена: <span>{special.PRICE}</span> {CURRENCY}</div>
            <!-- END special.price -->
            <div class="button red3 {BUTTON_ORDER_CLASS}" id="{special.ID}<!-- BEGIN special.param -->:0<!-- END special.param -->" onclick="yaCounter34834310.reachGoal('knopka_korzina'); return true;">{BUTTON_ORDER_TEXT}</div>
        </div>
    </div>
</div>
<!-- END special -->


    <!-- BEGIN products -->
    <div class="product-items clearfix">
        <!-- BEGIN product -->
        <div class="product-item">
            <p class="discount icon">-52<span>%</span></p>
            <!-- BEGIN product.picture -->
            <div class="product-image {product.LABEL}">
                <a href="item/{product.KEY}"><img src="images/product/s/{product.picture.SRC}" alt="{product.NAME}" /></a>
            </div>
            <!-- END product.picture -->
            
            <!-- BEGIN product.top -->
			<p class="best-seller icon"></p>
			<!-- END product.top -->
			
            <div class="product-name"><a href="item/{product.KEY}">{product.NAME}</a>
            <span style="color: #888888; text-align: right; font-size: 14px; white-space: nowrap; ">(арт. {product.CODE})</span>
            <div style="font-style:italic; font-size: 14px">{product.BRIEF}</div>
            </div>
            <div class="product-price">
                <!-- BEGIN product.price_old -->
                <div class="old-price">{product.PRICE_OLD} {CURRENCY}</div>
                <!-- END product.price_old -->
                <!-- BEGIN product.price -->
                <div class="price">{product.PRICE} {CURRENCY}</div>
                <!-- END product.price -->
            </div>
            <div class="actions clearfix">
                <a href="item/{product.KEY}" class="button gray view">Подробнее</a>
                <div class="button pink red {BUTTON_ORDER_CLASS}" id="{product.ID}<!-- BEGIN product.param -->:0<!-- END product.param -->" >{BUTTON_ORDER_TEXT}</div>
                <!--onclick="yaCounter34834310.reachGoal('knopka_korzina'); return true;"-->
            </div>
        </div>
        <!-- END product -->
    </div>
    
    [abtest_v1]    
    <div class="see_more_wrapper">
		<div class="see_more button pink clearfix" style="width: 25%;margin: 0 auto;min-width: 300px;">
				Смотреть еще
		</div>
		<div class="see_more2 button gray clearfix" style="display:none;cursor:default;width: 25%;margin: 0 auto;min-width: 300px;">
				Смотреть еще
		</div>
	</div>
	[/abtest_v1]
    
    <!-- BEGIN paginator -->
    <div class="pageList">
        <!-- BEGIN paginator.first --><a href="page/{paginator.first.NUM}{URL_POSTFIX}">{paginator.first.NUM}</a><!-- END paginator.first -->
        <!-- BEGIN paginator.separator1 --><ins>...</ins><!-- END paginator.separator1 -->
        <!-- BEGIN paginator.middle1 --><a href="page/{paginator.middle1.NUM}{URL_POSTFIX}">{paginator.middle1.NUM}</a><!-- END paginator.middle1 -->
        <!-- BEGIN paginator.current --><i>{paginator.current.NUM}</i><!-- END paginator.current -->
        <!-- BEGIN paginator.middle2 --><a href="page/{paginator.middle2.NUM}{URL_POSTFIX}">{paginator.middle2.NUM}</a><!-- END paginator.middle2 -->
        <!-- BEGIN paginator.separator2 --><ins>...</ins><!-- END paginator.separator2 -->
        <!-- BEGIN paginator.last --><a href="page/{paginator.last.NUM}{URL_POSTFIX}">{paginator.last.NUM}</a><!-- END paginator.last -->
    </div>
    <!-- END paginator -->
    <!-- END products -->
    
 <!-- INCLUDE widget/visited_mobile.tpl -->

<!-- BEGIN content_foot -->
<div class="catalog w border2">
    <div class="text">{content_foot.CONTENT}</div>
</div>
<!-- END content_foot -->

<!-- INCLUDE footer.tpl -->
