<!-- INCLUDE header.tpl -->
<div class="product w2 item border2">
    <!-- BEGIN product -->
    <!-- BEGIN if_uppercats -->
	<div style="width:100%; height:32px; color:#ffffff; margin: 0px;"><h2><a href="./">Главная</a> <!-- BEGIN uppercat -->> <a href="catalog/{uppercat.KEY}">{uppercat.NAME}</a> <!-- END uppercat --></h2></div>
    <!-- END if_uppercats -->
    
    <div class="L">
	    <!-- BEGIN product.picture -->
	    <div class="img cycle {product.LABEL}">
	        <a href="images/product/l/{product.picture.SRC}" title='{product.NAME}' class="fancybox" rel="gallery"><img src="images/product/s/{product.picture.SRC}" title='{product.NAME}' alt='{product.NAME}' style=" border: 1px solid #d1d1d1; width:100%;"/></a>
	        <!-- BEGIN product.album --><a href="images/product/l/{product.album.SRC}" title='{product.NAME}' class="fancybox" rel="gallery"><img src="images/product/s/{product.album.SRC}" title='{product.NAME}' alt='{product.NAME}'/></a><!-- END product.album -->
	    </div>
        <!-- END product.picture -->
        <!-- BEGIN product.if_album -->
        <div class="album">
            <!-- BEGIN product.picture --><a href="images/product/l/{product.picture.SRC}" title='{product.NAME}' class="fancybox" rel="album"><img src="images/product/s/{product.picture.SRC}" title='{product.NAME}' alt='{product.NAME}'/></a><!-- END product.picture -->
            <!-- BEGIN product.album --><a href="images/product/l/{product.album.SRC}" title='{product.NAME}' class="fancybox" rel="album"><img src="images/product/s/{product.album.SRC}" title='{product.NAME}' alt='{product.NAME}'/></a><!-- END product.album -->
        </div>
        <!-- END product.if_album -->

    </div>
    <div class="R" style="padding-top: 0px; margin-top: 0px">
		<h1 style=" font-size: 16px;font-family: 'PTSansBold'; text-transform:uppercase; margin-top:5px; padding-bottom:5px;">{product.NAME}
	    </h1>

        <table style='margin-top: 5px; font-size: 16px;font-family:"PTSansRegular","Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; color: #363636; font-weight:400;'>
        <tr>
          <td><div style="padding-left: 0px"><img src="./images/tb1.png">
          </td>
          <td width="100%"><div style="padding-left: 10px"> 100% Оригинал.<br> Качество США.</div>
          </td>
        </tr>
        <tr>
          <td><div style="padding-top: 10px; padding-left: 0px"><img src="./images/tb2.png"></div>
          </td>
          <td><div style="padding-top: 10px; padding-left: 10px">90 дней обмен возврат</div>
          </td>
        </tr>
        <tr>
          <td><div style="padding-top: 10px; padding-left: 0px"><img src="./images/tb3.png"></div>
          </td>
          <td><div style="padding-top: 10px; padding-left: 10px">Товар в наличии</div>
          </td>
        </tr>
        </table>


 <!--       <div style="margin-top: 20px; font-size: 16px;font-family: 'PT Sans Narrow'; color: #222222">
        <span style="color: #222222; text-decoration: underline">Материал</span>:&nbsp;&nbsp;натуральная {product.DESCRIPTION}
        </div>-->


        <div style="padding-top: 15px">
        <table style='margin: 0px; font-size: 15px;font-family:":"PTSansRegular",Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; color: #111111;font-weight:500; width:100%;'>
        <tr>
          <td align="left" valign="top">



          <!-- BEGIN product.price_old --><div class="oldprice" style="text-align:left; font-size: 17px; padding-bottom: 0px">Старая цена: <span>{product.PRICE_OLD}</span> {CURRENCY}</div><!-- END product.price_old -->
          <!-- BEGIN product.price --><div class="price3"  style="text-align:left; font-size: 19px; padding-bottom: 5px; padding-top: 0px">Цена по акции: <span>{product.PRICE}</span> {CURRENCY}</div><!-- END product.price -->
          	<table width="100%"> <tr><td align="left">
            <!-- BEGIN product.param -->
            <div class="param"  style="padding-top: 5px; padding-bottom: 2px; margin-top: 0px; font-size:16px;">
            <span>{product.param.NAME}:</span>
                <select>
                    <!-- BEGIN product.param.val --><option value="{product.ID}:{product.param.val.NUM}" rel="{product.param.val.PRICE}" rel2="{product.param.val.PRICE_OLD}">{product.param.val.NAME}</option><!-- END product.param.val -->
                </select>
            </div>
            <div style="font-size: 12px; font-style: 1italic; font-weight: normal; margin-bottom: 5px; margin-left: 0px; margin-right: 15px; padding-left: 0px; padding-right: 0px; float:right;">
            <a href="./choise_size" style="color: #363636; font-weight: normal" target="_blanc">
            Как узнать свой размер?
            </a></div>
            
            <!-- END product.param -->
          <!--</td>
          <td valign="top"><div style="padding-left: 15px; padding-top: 23px">

          </div>-->
          	</td><td align="center">
            <div class="button red {BUTTON_ORDER_CLASS}" id="{product.ID}<!-- BEGIN product.param -->:0<!-- END product.param -->">&nbsp;{BUTTON_ORDER_TEXT}&nbsp;</div>
            </td></tr></table>
          </td>
        </tr>
        </table>
        </div>





       <div style="margin-left: 0px; margin-top: 20px; margin-bottom: 20px; padding: 2px 10px 0px 10px; background: #eeeeed;">
           <!-- <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr>
              <td valign="top"><div class="text" style="margin: 0px; font-size: 16px;font-family: 'PT Sans Narrow'">
              <div style="color: #FF3C00; font-size: 19px; margin-bottom: 7px">Акция!</div>
              При покупке этой пары обуви мы дарим Вам <span style="color: #FF3C00">комплект обувной косметики 4в1.</span><br>
              </div>
              </td>
              <td width="110px"><img width="108px" src="./images/present.png">
              </td>
            </tr>
            </table> -->
           <div style="margin-top: 10px;font-size: 15px; color: #363636; font-weight:600;">
              <div style="color: #7d3f8c; font-size:15px; margin-bottom: 2px;">Акция!</div>
              При покупке этой пары обуви <span style="color: #7d3f8c">мы дарим Вам комплект обувной косметики 4в1.</span>
              </div>
              <div style="margin: 10px 0 3px"><img style="margin-bottom:10px;" src="./images/sale33.png"></div>
        </div>



     </div>

     <div class="text basement" style="padding-top: 10px; padding-left: 7px; padding-right: 7px; font-size: 16px; font-weight: 400; font-family: Calibri; font-weight: 300;">{product.SEOTEXT}
<p style="padding-bottom: 10px; font-weight: 600;">Стоимость кроссовок</p>

В первую очередь необходимо обратить внимание на стоимость. Большая цена не дает никакой гарантии того, что кроссовки будут удобными,
прочными и легкими.<br><br>

Однако купить хорошие кроссовки, которые прослужат вам не один сезон, и при этом будут отвечать всем требованиям удобства,
задешево не получится. Особенно это касается настоящих фирменных кроссовок компаний Nike, New Balace, Reebok, Adidas, которые занимают лидирующие
позиции в производстве спортивной обуви. Но при  этом отличные кроссовки можно приобрести в пределах 3000-5000 рублей.
Что для настоящей фирменной обуви не дорого. <br><br>

<p style="padding-bottom: 10px; font-weight: 600;">Удобство, легкость и прочность.</p>

Настоящие кроссовки разрабатываются в специальных исследовательских лабораториях. Именно поэтому каждый сможет подобрать обувь для
себя в зависимости от целей. В широком модельном ряде таких кроссовок вы найдете обувь на любой вкус. Есть зимние и летние варианты кроссовок.<br><br>

Подошва таких кроссовок снабжена специальной амортизирующей воздушной подушкой, которая уменьшает воздействие твердой поверхности на ваши ноги.
А стелька снабжена супинатором, который также уменьшает вероятность появления травм от бега по асфальту или бетону.<br><br>

При этом кроссовки отличаются своей легкостью и прочностью. Если сравнивать фирменные кроссовки с их китайскими подделками, то китайские, выигрывая
в цене, вчистую проигрывают в качестве и легкости. В итоге фирменных кроссовок хватает на несколько сезонов, а китайские аналоги разваливаются
за пару месяцев.<br><br>

<p style="padding-bottom: 10px; font-weight: 600;">Красота и дизайн</p>

Над моделями известных марок трудятся лучше дизайнеры. Среди таких кроссовок вы всегда сможете подобрать обувь, отвечающую всем вашим требованиям. <br><br>
<!--	<br><br>
	<div style="text-align: center;">
	<img src="./images/prem.png">
	</div>                          -->
     </div>
		<table width="50%"><tr><td>
        <div style="padding-top: 25px; text-align: left;font-size: 16px;font-family:'PTSansRegular', 'PT Sans Narrow'; color: #333333">

          <!-- BEGIN product.price_old --><div class="oldprice" style="font-size: 17px; padding-bottom: 2px;text-align: left;">Старая цена: <span>{product.PRICE_OLD}</span> {CURRENCY}</div><!-- END product.price_old -->
          <!-- BEGIN product.price --><div class="price3"  style="font-size: 19px; padding-bottom: 5px; padding-top: 0px">Цена по акции: <span>{product.PRICE}</span> {CURRENCY}</div><!-- END product.price -->
            <!-- BEGIN product.param -->
            <div class="param"  style="padding-top: 0px; padding-bottom: 10px; margin-top: 0px">
            <span>{product.param.NAME}</span>
                <select>
                    <!-- BEGIN product.param.val --><option value="{product.ID}:{product.param.val.NUM}" rel="{product.param.val.PRICE}" rel2="{product.param.val.PRICE_OLD}">{product.param.val.NAME}</option><!-- END product.param.val -->
                </select>
            </div>
            <!-- END product.param -->
          

        </div>
        </td><td>
        <div class="button red {BUTTON_ORDER_CLASS}" id="{product.ID}<!-- BEGIN product.param -->:0<!-- END product.param -->">&nbsp;{BUTTON_ORDER_TEXT}&nbsp;</div>
		</td></tr></table>
     <!-- END product -->
     <!-- BEGIN neighbours -->
     <div class="basement">
          <!-- BEGIN product_prev --><span style="float:left;">&larr; <a href="item/{product_prev.KEY}">{product_prev.NAME}</a></span><!-- END product_prev -->
          <!-- BEGIN product_next --><span style="float:right;"><a href="item/{product_next.KEY}">{product_next.NAME}</a> &rarr;</span><!-- END product_next -->
     </div>
     <!-- END neighbours -->
</div>
<!-- BEGIN see_also -->
<div class="catalog w" style="border: 1px solid #5F4D40">
    <div class="head">
        <h3>Похожие модели:</h3>
    </div>
    <div class="items fix">
        <!-- BEGIN also -->
        <div class="item">
            <h3><a style="font-weight: bold" href="item/{also.KEY}">{also.NAME}
            </a></h3>
            <!-- BEGIN also.picture -->
            <div class="img {also.LABEL}">
                <a href="item/{also.KEY}"><img src="images/product/s/{also.picture.SRC}" alt=""/></a>
            </div>
            <!-- END also.picture -->
            <div class="brief text"><p>{also.BRIEF}</p></div>
            <!-- BEGIN also.param -->
            <div class="param"><span>{also.param.NAME}</span>
                <select>
                    <!-- BEGIN also.param.val --><option value="{also.ID}:{also.param.val.NUM}" rel="{also.param.val.PRICE}" rel2="{also.param.val.PRICE_OLD}">{also.param.val.NAME}</option><!-- END also.param.val -->
                </select>
            </div>
            <!-- END also.param -->
            <!-- BEGIN also.price_old --><div class="oldprice text">Старая цена: <span>{also.PRICE_OLD}</span> {CURRENCY}</div><!-- END also.price_old -->
            <!-- BEGIN also.price --><div class="price">Цена: <span>{also.PRICE}</span> {CURRENCY}</div><!-- END also.price -->
            <div class="actions">
                <a href="item/{also.KEY}" class="button gray view">Подробнее</a>
                <div class="button red3 {BUTTON_ORDER_CLASS}" id="{also.ID}<!-- BEGIN also.param -->:0<!-- END also.param -->">{BUTTON_ORDER_TEXT}</div>
            </div>
        </div>
        <!-- END also -->
    </div>
</div>
<!-- END see_also -->
<!-- INCLUDE footer.tpl -->