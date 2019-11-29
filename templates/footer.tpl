</main>
</div>
<footer class="site-footer">
    <div class="wrapper">
        <div class="copy">
            <p>{YEAR} © «{SITE_NAME}»</p>
            <p>www.Shapka-Moda.ru</p>
            <div style="width:80%;text-align: left;"><a href="/oferta">Оферта</a></div>


        </div>
        <nav class="footer-menu">
            <!-- INCLUDE widget/menu3.tpl -->
        </nav>

        <div class="soc">
        </div>
        <div class="contacts">
            <ul>
                <li>
                    <p>Звоните в любой день с <span>9:00</span> до <span>21:00</span></p>
                    <p>Заказывайте через сайт в любое время суток!</p>
                </li>
                <li class="contacts-phone">
                    <p class="contacts-phone-number"><span>8 800</span> 555-78-41</p>
                    <p class="contacts-phone-region">беслатный для регионов.</p>
                </li>
                <li class="contacts-phone">
                    <p class="contacts-phone-number"><span>8 499</span> 504-16-14</p>
                    <p class="contacts-phone-region">телефон для Москвы.</p>
                </li>
            </ul>
        </div>

    </div>

</footer>


<div class="topbutton cart">
    <a href="javascript:;"><img src="./images/icon22.png" style="display:inline-block; vertical-align:middle; margin-right:7px;">Корзина</a> (<span id="cartCounter">0</span>)
</div>


[abtest_v1]
<script>
$(document).ready(function () {//see_more
		var see_more_clicks=0;
		var max_clicks=Math.min(3, $('.pageList i ~ a').length);
		//console.log('max_clicks='+max_clicks);
		if(0 == max_clicks)  $('.button.see_more, .button.see_more2').toggle();
		if(0 == $('.pageList a').length)  $('.button.see_more, .button.see_more2').hide();
       $(".see_more").click(function(){
			var button=$(this);
			var el_next_page=$('.pageList i + a').first();
			var url=el_next_page.attr('href');

			var url_arr=url.split('/');
			if(url_arr.shift() == 'catalog' )
				url='catalog/see_more/'+url_arr.join('/');
			else
				url='see_more/'+url;
			//console.log('next go to '+ url);

			$.ajax({
				  url: url,
				  success: function(data){
					  //console.log(data);
					  $('.main-content .product-items').append(data);
					  var num=el_next_page.html();
					  //console.log(num);
					  el_next_page.replaceWith('<i>'+num+'</i>');
					  see_more_clicks++;
					  if(see_more_clicks == max_clicks)  $('.button.see_more, .button.see_more2').toggle();

					    // Выравнивание каталога после догрузки
						var trioBrief, trioHeader, trioParam, Hbrief = 0, Hheader = 0, Hparam = 0;
						$(".main-content .product-items .product-item, .catalog .product-items .product-item").each(function (i, item) {


							Hheader = Math.max(Hheader, $(".product-name", item).height());

							if (i % 3 == 0) {

								trioHeader = $(".product-name", item);

							} else if (i % 3 == 1) {

								trioHeader = trioHeader.add($(".product-name", item));

							} else if (i % 3 == 2) {

								trioHeader = trioHeader.add($(".product-name", item));

								trioHeader.each(function (j, header) {
									$(header).height(Hheader - 2);
								});

								Hheader = 0;


								}
							});

					}
			});

		});


   });
</script>
[/abtest_v1]

<div class="DarkBg" style="display:none;">&nbsp;</div>
<div class="Popup" style="top:50px;display:none">
    <div class="in">
        <div class="C">
            <div class="in">
                <div class="CloseButton">X</div>
                <div class="Block">
                    <div class="PopupBlock clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- INCLUDE foot.tpl -->
