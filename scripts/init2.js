var FLOCKTORY = function (act, id, price, count) {
    window.flocktory = window.flocktory || [];
    window.flocktory.push(
        [
            act,
            {
                item: {
                    "id": id, // product id
                    "price": price, // product price
                    "count": count // quantity of the product  added/deleted
                }
            }
        ]
    );

}
// РїСЂР°РІРєР° РЅР° el-postel

$(document).ready(function () {

    document.mobile = false;

    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        document.mobile = true;
    }

    //console.log($('.lidform').attr('action'));
    //console.log($('html').data('variant'));

    // var lidform = '#subscribe';
    // if (window.location.hash.length && window.location.hash === lidform) {
    //      $.fancybox({/*padding: 0,*/ type: 'inline', href: '#lidform_unisender'})
    // }

    $(".lidform").submit(function (event) {
        event.preventDefault();
        var data = $(this).serialize();

        $.ajax({
            type: "POST",
            url: $('.lidform').attr('action'),
            data: data,
            //padding: 0,
            success: function (msg) {

                //$.fancybox.close();
                $.fancybox({content: msg});

                //РЈСЃС‚Р°РЅР°РІР»РёРІР°РµРј РєСѓРєСѓ С‡С‚Рѕ РїРѕР»СЊР·РѕРІР°С‚РµР»СЊ РїРѕРґРїРёСЃР°Р»СЃСЏ
                $.cookie('subscriptionOk', '1', {expires: 3600 * 24 * 365 * 5, path: '/'});
            }
        });
    });

    bg = $(".DarkBg");
    popup = $(".Popup");
    var block = $(".PopupBlock", popup);
    // info size
    $(".btnsize").click(function () {
        hideFlash();
        var msg = $(this).attr('rel');
        var linkpage = $(this).attr('href');
        block.load(linkpage, {}, function () {
            //initOrderForm(block);
            //block.find("textarea[name='message']").val(msg);
            bg.fadeIn(300);
            popup.css({'top': (getBodyScrollTop() + 50) + 'px'});
            popup.show();
            $(".CloseButton", popup).add(bg).unbind().click(function () {
                bg.fadeOut(300);
                popup.hide();
                showFlash();
            });
        });
        return false;
    });
    // Р¤РѕСЂРјР° Р·Р°РєР°Р·Р° Р·РІРѕРЅРєР°
    $(".button.call,.needhelp").click(function () {

        if (document.mobile) {
            return true;
        }

        hideFlash();
        var msg = $(this).attr('rel');
        block.load('call', {}, function () {
            initOrderForm(block);
            block.find("textarea[name='message']").val(msg);
            bg.fadeIn(300);
            popup.css({'top': (getBodyScrollTop() + 50) + 'px'});
            popup.show();
            $(".CloseButton", popup).add(bg).unbind().click(function () {
                bg.fadeOut(300);
                popup.hide();
                showFlash();
            });
        });
        return false;
    });
    // Р¤РѕСЂРјР° Р·Р°РєР°Р·Р°
    $(".button.order").click(function () {
        hideFlash();
        var msg = $(this).attr('rel');
        block.load('order/' + $(this).attr('id'), {}, function () {
            initOrderForm(block);
            block.find("textarea[name='message']").val(msg);
            bg.fadeIn(300);
            popup.css({'top': (getBodyScrollTop() + 50) + 'px'});
            popup.show();
            $(".CloseButton", popup).add(bg).unbind().click(function () {
                bg.fadeOut(300);
                popup.hide();
                showFlash();
            });
        });
    });
    // Р¤РѕСЂРјР° РѕС‚Р·С‹РІР°
    $(".button.write").click(function () {
        hideFlash();
        block.load('testimonial', {}, function () {
            initOrderForm(block);
            bg.fadeIn(300);
            popup.css({'top': (getBodyScrollTop() + 50) + 'px'});
            popup.show();
            $(".CloseButton", popup).add(bg).unbind().click(function () {
                bg.fadeOut(300);
                popup.hide();
                showFlash();
            });
        });
    });
    var hideFlash = function () {
        $("iframe,object,embed").not("#vk_groups iframe, #ok_group_widget iframe").hide();
    }
    var showFlash = function () {
        $("iframe,object,embed").not("#vk_groups iframe, #ok_group_widget iframe").show();
    }
    // Fancybox
    $("a.fancybox").fancybox({
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'speedIn': 600,
        'speedOut': 200,
        'overlayShow': false,
        'hideOnOverlayClick': true
    });

    // Cycle
    $(".cycle").cycle({
        fx: 'fade',
        pause: 1
    });
    // РџРѕРґСЃРІРµС‚РєР° РїСѓРЅРєС‚РѕРІ РјРµРЅСЋ
    $(".menu a,.menu2 a,.cats2 a").each(function (i, item) {
        var url = $(item).attr('href');
        var re = new RegExp(url + '$', 'i');
        if (re.test(location.href) || (url == './' && !location.href.replace("http://", "").split("/")[1])) {
            $(item).parents('li').addClass('active');
        }
    });
    // РЎРµСЂС‚РёС„РёРєР°С‚С‹
    var certblock = $(".cert");
    var certs = $(".items", certblock);
    $(".arrow.R", certblock).click(function () {
        $(".item:first", certs).appendTo(certs);
    });
    $(".arrow.L", certblock).click(function () {
        $(".item:last", certs).prependTo(certs);
    });
    // Р§РёС‚Р°С‚СЊ РґР°Р»РµРµ, РѕС‚Р·С‹РІС‹
    $(".testimonials .text>a.go-on").click(function () {
        $(this).parent().find(".bullshit").show();
        $(this).prev().remove();
        $(this).remove();
    });
    // РљРѕСЂР·РёРЅР°

    cart = new Cart('cart');
    var cartButton = $(".topbutton.cart");
    $(".button.cart").click(function () {


        if ($(this).data('price') !== undefined)
            price = $(this).data('price');
        else
            price = $(this).parents('.not.price-shares').find('span.num').html();


        FLOCKTORY('addToCart', $(this).attr('id').split(':')[0], price, 1);
        cart.add($(this).attr('id'), 1);
        var img = $(this).parents('div.product-item').find('img');

        //$(this).parent().parent().children('.product-image').children('a').children('img')


        if (img.length == 0) {
            img = $('section.item-page-tovar').find('img').first();	//img = $(this).parents('div.product-item').find('img');
        }


        var imgOffset = img.offset();
        var cartOffset = cartButton.offset();
        //alert("top"+cartOffset.top+"left"+cartOffset.left);
        img = img.clone().addClass('toCart').css({
            'top': imgOffset.top + 'px',
            'left': imgOffset.left + 'px',
            'width': '400px',
            'height': '400px'
        }).appendTo("body").animate({
            'top': (cartOffset.top + 5) + 'px',
            'left': (cartOffset.left + 10) + 'px',
            'width': '25px',
            'height': '25px'
        }, 600, function () {
            img.remove();
            cartButton.addClass('active').unbind('hover').hover(function () {
                $(this).removeClass('active');
            });
            cartButton.click();
        });
        console.log(img);
    });
    cartButton.click(function () {

        hideFlash();
        block.load('cart', {}, function () {
            initCart(block);
            bg.fadeIn(300);
            popup.css({'top': (getBodyScrollTop() + 50) + 'px'});
            popup.show();
            $(".CloseButton", popup).add(bg).unbind().click(function () {
                bg.fadeOut(300);
                popup.hide();
                showFlash();
            });
        });
    });

    // РџР°СЂР°РјРµС‚СЂС‹ С‚РѕРІР°СЂР°
    $(".param select").change(function () {

        var option = $("option:selected", this);
        var item = $(this).parents('.item-page-tovar-left');
        //var item = $(this).parents('.product-items');
        //var item = $(this).parents('.product-item');
        //var item = $(this).parents('.products-params-t');
        // console.log(item);

        var price = option.attr('rel');
        var oldprice = option.attr('rel2');
        if (price) {
            item.find(".currprice").show().find(".num").text(price);
        } else {
            item.find(".currprice").hide().find(".num").text(price);
        }
        if (oldprice) {
            item.find(".oldprice").show().find(".num").text(oldprice);
        } else {
            item.find(".oldprice").hide().find(".num").text(oldprice);
        }
        item.find(".param select").val($(this).val());
        item.find(".button.cart,.button.order").attr('id', $(this).val());
    });


    // Р¤РёР»СЊС‚СЂ
    var filterBlock = $(".filter");
    var filter = new Filter('filter', filterBlock);
    filterBlock.find("input").change(function (e) {
        var blockOffset = filterBlock.offset();
        var boxOffset = $(this).offset();
        $(".notice", filterBlock).show().animate({
            'top': $(this).offset().top + 'px'
        });
        filter.save();
    });
    if (filterBlock.length > 0) {
        var priceRange = $('.slider', filterBlock).slider({
            range: true,
            step: 100,
            min: $("#price_from").attr('rel'),
            max: $("#price_to").attr('rel'),
            values: [parseInt($("#price_from").val()), parseInt($("#price_to").val())],
            create: function (e, ui) {
                $(e.target).wrapInner('<div class="in"></div>');
            },
            slide: function (event, ui) {
                $("#price_from").val(ui.values[0]);
                $("#price_to").val(ui.values[1]);
            },
            change: function (event, ui) {
                $("#price_from").change();
            }
        });
        $(".reset", filterBlock).click(function () {
            $("input:checked", filterBlock).attr('checked', '');
            $("#price_from").val($("#price_from").attr('rel'));
            $("#price_to").val($("#price_to").attr('rel'));
            priceRange.slider("values", [parseInt($("#price_from").val()), parseInt($("#price_to").val())])
            filter.clear();
        });
        filterBlock.submit(function(){
            filter.submit();
        })

    }
    // Р’С‹СЂР°РІРЅРёРІР°РЅРёРµ РєР°С‚Р°Р»РѕРіР°
    var trioBrief, trioHeader, trioParam, Hbrief = 0, Hheader = 0, Hparam = 0;
    $(".main-content .product-items .product-item, .item-page .product-item").each(function (i, item) {

        //Hbrief = Math.max(Hbrief,$(".brief",item).height()+$(".oldprice",item).height());
        Hheader = Math.max(Hheader, $(".product-name", item).height());
        //Hparam = Math.max(Hparam,$(".param",item).height());
        if (i % 3 == 0) {
            //trioBrief = $(".brief",item);
            trioHeader = $(".product-name", item);
            //trioParam = $(".param",item);
        } else if (i % 3 == 1) {
            //trioBrief = trioBrief.add($(".brief",item));
            trioHeader = trioHeader.add($(".product-name", item));
            //trioParam = trioParam.add($(".param",item));
        } else if (i % 3 == 2) {
            //trioBrief = trioBrief.add($(".brief",item));
            trioHeader = trioHeader.add($(".product-name", item));
            //trioParam = trioParam.add($(".param",item));
            //trioBrief.each(function(j,brief){
            //  $(brief).height(Hbrief-6+($(".oldprice",$(brief).parent()).length>0 ? -16 : 0));
            //});
            trioHeader.each(function (j, header) {
                $(header).height(Hheader - 2);
            });
            //trioParam.each(function(j,param){
            //  $(param).height(Hparam-5);
            //  if (Hparam<1) {
            //      $(param).css("padding","0px");
            //  }
            //});
            //Hbrief = 0;
            Hheader = 0;
            //Hparam = 0;

        }
    });

    // РќРѕС‡РЅР°СЏ Р°РєС†РёСЏ
    /*var hours = new Date().getHours();
     if ((hours>=22 || hours<=8) && !$.cookie('night_discount')){
     setTimeout(function(){
     block.load('popup',{},function(){
     bg.fadeIn(300);
     popup.css({'top':(getBodyScrollTop()+100)+'px'});
     popup.show();
     $(".CloseButton",popup).add(bg).unbind().click(function(){
     $.cookie('night_discount', 1, {expires:7,path:'/'});
     bg.fadeOut(300);
     popup.hide();
     });
     $("input[type='submit']",popup).click(function(){
     $.cookie('night_discount', 1, {expires:180,path:'/'});
     return true;
     });
     });
     },5000);
     }*/

    // Р’СЃРїР»С‹РІР°СЋС‰РµРµ РѕРєРЅРѕ
    if ($("body").attr('rel') == 'popup' && !$.cookie('no_exit')) {
        var exitsplashmessage = $("body").attr('name');

        function addLoadEvent(func) {
            var oldonload = window.onload;
            if (typeof window.onload != 'function') {
                window.onload = func;
            } else {
                window.onload = function () {
                    if (oldonload) {
                        oldonload();
                    }
                    func();
                }
            }
        }

        function addClickEvent(a, i, func) {
            if (typeof a[i].onclick != 'function') {
                a[i].onclick = func;
            }
        }

        var PreventExitSplash = false;

        function DisplayExitSplash() {
            if (PreventExitSplash == false) {
                //$.cookie('no_exit', 1, {expires: 1,path: "/"});//СЃС‚Р°РІРёРј РєСѓРєРё
                //$(".button.call:eq(0)").click();
                return exitsplashmessage;
            }
        }

        var a = document.getElementsByTagName('A');
        for (var i = 0; i < a.length; i++) {
            if (a[i].target !== '_blank') {
                addClickEvent(a, i, function () {
                    PreventExitSplash = true;
                });
            } else {
                addClickEvent(a, i, function () {
                    PreventExitSplash = false;
                });
            }
        }
        disablelinksfunc = function () {
            var a = document.getElementsByTagName('A');
            for (var i = 0; i < a.length; i++) {
                if (a[i].target !== '_blank') {
                    addClickEvent(a, i, function () {
                        PreventExitSplash = true;
                    });
                } else {
                    addClickEvent(a, i, function () {
                        PreventExitSplash = false;
                    });
                }
            }
        }
        addLoadEvent(disablelinksfunc);
        disableformsfunc = function () {
            var f = document.getElementsByTagName('FORM');
            for (var i = 0; i < f.length; i++) {
                if (!f[i].onclick) {
                    f[i].onclick = function () {
                        PreventExitSplash = true;
                    }
                } else if (!f[i].onsubmit) {
                    f[i].onsubmit = function () {
                        PreventExitSplash = true;
                    }
                }
            }
        }
        addLoadEvent(disableformsfunc);
        window.onbeforeunload = DisplayExitSplash;
    }

    var img1 = new Image();
    img1.src = 'images/Popup1.png';
    var img2 = new Image();
    img2.src = 'images/Popup2.png';

    // Р’СЃРїР»С‹РІР°СЋС‰Р°СЏ РёРЅС„РѕСЂРјР°С†РёСЏ
    $(".popinfo").click(function () {
        hideFlash();
        block.load($(this).attr('href'), {}, function () {
            bg.fadeIn(300);
            popup.css({'top': (getBodyScrollTop() + 50) + 'px'});
            popup.show();
            $(".CloseButton", popup).add(bg).unbind().click(function () {
                bg.fadeOut(300);
                popup.hide();
                showFlash();
            });
        });
        return false;
    });
});
var bg, popup, cart, filter;

function Filter(name, selObj) {
    this.name = name;
    if (selObj) {
        var block = selObj;
    } else {
        var block = $(".filter");
    }
    var counter = $("#found_count", block);

    this._init = function () {
        var cookie = $.cookie(this.name);
        this.items = cookie ? $.parseJSON(cookie) : [];
        if (!this.items) {
            $.cookie(this.name, null);
        }
        //counter.text(this.count());
    }

    this.count = function () {
        $.post('filter/total', {}, function (data) {
            counter.text(data);
            if (data > 0) {
                counter.parent().find("a").show();
            } else {
                counter.parent().find("a").hide();
            }
        });
    }

    this.save = function () {
        var items = [];
        block.find("input:checked").each(function (i, item) {
            items[i] = $(item).val();
        });
        $.cookie(this.name, $.toJSON(items), {expires: 30, path: '/'});
        $.cookie(this.name + '_price_from', $("#price_from", block).val(), {expires: 30, path: '/'});
        $.cookie(this.name + '_price_to', $("#price_to", block).val(), {expires: 30, path: '/'});
        this.count();
    }

    this.clear = function () {
        this.items = [];
        $.cookie(this.name, null);
        $.cookie(this.name + '_price_from', null);
        $.cookie(this.name + '_price_to', null);
        counter.text(0);
    }

    this.submit = function () {
        url=block.attr('action');
        block.find('input:checked').each(function () {
            url+='/'+$(this).val();
        });
        url+='/price/'+ $("#price_from").val()+'/'+ $("#price_to").val();
        block.attr('action', url);

    }

    this._init();
}

function Cart(name) {
    this.name = name;
    var counter = $("#cartCounter");

    this._init = function () {
        var cookie = $.cookie(this.name);
        this.items = cookie ? $.parseJSON(cookie) : {};
        if (!this.items) {
            $.cookie(this.name, null);
        }
        counter.text(this.count());
    }

    this.count = function () {
        var i = 0;
        $.each(this.items, function (j, item) {
            i++;
        });
        return i;
    }

    this.add = function (val, count) {
        this.items[val] = this.items[val] ? parseInt(this.items[val]) + parseInt(count) : count;
        this._refresh();
    }

    this.edit = function (val, count) {
        this.items[val] = count;
        this._refresh();
    }

    this.del = function (val) {
        delete this.items[val];
        this._refresh();
    }

    this._refresh = function () {
        $.cookie(this.name, $.toJSON(this.items), {expires: 30, path: '/'});
        counter.text(this.count());
    }

    this.clear = function () {
        this.items = {};
        $.cookie(this.name, null, {expires: 30, path: '/'});
        counter.text(0);
    }

    this._init();
}

var initCart = function (block) {
    // РЎРѕС…СЂР°РЅРµРЅРёРµ
    $("form .Buttons .send", block).click(function () {
        $(this).unbind();
        $("form", block).submit(function () {
            $(this).ajaxSubmit({
                success: function (data) {
                    if (data == 'ok') {
                        $(".successHide", block).hide();
                        $(".successShow", block).show();
                    } else {
                        block.html(data);
                        initOrderForm(block);
                    }
                }
            });
            return false;
        }).submit();
        return false;
    });
    // РћС‚РјРµРЅР°
    $("form .Buttons .cancel", block).click(function () {
        bg.click();
        return false;
    });
    // РћС‡РёСЃС‚РёС‚СЊ
    $("form .Buttons .clear", block).click(function () {
        bg.click();
        cart.clear();
        return false;
    });
    // РЈРґР°Р»РёС‚СЊ
    $("form .button.delete", block).click(function () {

        var id;
        var value;

        if ($(this).parents('tr').find("input[name^='count']").val()) {
            value = $(this).parents('tr').find("input[name^='count']").val();
        } else {
            value = $(this).parent().prev().find("input[name^='count']").val();
        }

        if ($(this).parents("tr").attr('rel')) {
            id = $(this).parents("tr").attr('rel');
            cart.del(id);
        } else {
            id = $(this).parent().attr('rel');
            cart.del(id);
        }

        FLOCKTORY(
            'removeFromCart',
            id.split(':')[0],
            0,
            value
        );

        var cart_item = $('*[data-product-id="' + id + '"]');
        $(cart_item).remove();

        //$(this).parents("tr").remove();


        if (cart.count() == 0) {
            $("tr[rel='shipping']", block).remove();
        }
        $("#cartTotalPrice, #cartTotalPrice2").load('cart/total');
        return false;
    });


    // РљРѕР»-РІРѕ
    var flocktoryCount = -1;
    $("form input[name^='count'], .cart-product-count input[name^='count']", block).change(function () {

        var id = $(this).data('product-id');
        var price = $(this).data('product-price');

// =====================FLOCKTORY
        if (flocktoryCount < 0)
            flocktoryCount = this.defaultValue;

        dif = $(this).val() - flocktoryCount;
        if (dif < 0) {
            FLOCKTORYAct = 'removeFromCart';

        } else {
            FLOCKTORYAct = 'addToCart';
        }
        flocktoryCount = $(this).val();


        FLOCKTORY(
            FLOCKTORYAct,
            id.split(':')[0],
            price,
            Math.abs(dif)
        );


// =====================FLOCKTORY

        cart.edit(id, $(this).val());


        $("#cartTotalPrice, #cartTotalPrice2").load('cart/total', {}, function () {
            total = intval(+$("#cartTotalPrice").text());
            if (total > freeShipping && freeShipping) {
                $("tr[rel='shipping']", block).hide();
            } else {
                $("#cartTotalPrice, #cartTotalPrice2").text(total + shipping);
                $("tr[rel='shipping']", block).show();
            }
        });
    })
    ;
    // Free shipping check
    var total = intval($("#cartTotalPrice").text());
    var freeShipping = intval($("#freeShippingPrice").text());
    var shipping = intval($("#shippingPrice").text());
    if (total > freeShipping && freeShipping) {
        $("tr[rel='shipping']", block).hide();
    } else {
        $("#cartTotalPrice, #cartTotalPrice2").text(total + shipping);
        $("tr[rel='shipping']", block).show();
    }
    // РЎРјРµР¶РЅС‹Рµ С‚РѕРІР°СЂС‹
    $(".catalog .button.cart", block).click(function () {
        cart.add($(this).attr('id'), 1);
        $(".topbutton.cart").click();
    });
}
var initOrderForm = function (block) {
    // РЎРѕС…СЂР°РЅРµРЅРёРµ
    $("form .Buttons .send", block).click(function () {
        $(this).unbind();
        if ($(this).attr('rel')) {
            $("form", block).attr('action', $("form", block).attr('action') + '/' + $(this).attr('rel'));
        }
        $("form", block).submit(function () {
            $(this).ajaxSubmit({
                success: function (data) {
                    if (data == 'ok') {
                        //eval('dataLayer.push({'+ data+'});');
                        $(".successHide", block).hide();
                        $(".successShow", block).show();
                        cart.clear();
                    } else {
                        block.html(data);
                        initOrderForm(block);
                    }
                }
            });
            return false;
        }).submit();
        return false;
    });
    // РћС‚РјРµРЅР°
    $("form .Buttons .cancel", block).click(function () {
        $(".DarkBg").click();
        block.load($("form", block).attr('action'), {}, function (data) {
            block.html(data);
            initOrderForm(block);
        });


        //РџРѕРєР°Р·С‹РІР°РµРј РѕРєРЅРѕ РїРѕРґРїРёСЃРєРё
        var variant = $('html').data('variant');
        if ($.cookie('subscriptionOk') === null && variant === 'v1') {
            $.fancybox({type: 'inline', href: '#lidform_unisender'});   // РїРѕРєР°Р·С‹РІР°РµРј РѕРєРЅРѕ РїРѕРґРїРёСЃРєРё
            $.cookie('subscriptionShown', '1', {expires: 3600 * 24 * 365 * 5, path: '/'});
        }


        return false;
    });
    // РћРїР»Р°С‚Р°
    $("form .Buttons .pay", block).click(function () {
        //$(this).unbind();
        $("form", block).attr('action', $("form", block).attr('action') + '/pay');
        $("form .Buttons .send", block).click();
        return false;
    });
    // mask
    if (!$.browser.msie && !parseInt($.browser.version) < 7) {
        $('.phone_number', block).each(function (i, item) {
            var mask = $(item).attr('rel');
            if (mask) {
                $(item).mask(mask);
            }
        });
    }
}

function getBodyScrollTop() {
    return self.pageYOffset || (document.documentElement && document.documentElement.scrollTop) || (document.body && document.body.scrollTop);
}

function intval(mixed_var, base) {    // Get the integer value of a variable
    var tmp;
    if (typeof( mixed_var ) == 'string') {
        tmp = parseInt(mixed_var);
        if (isNaN(tmp)) {
            return 0;
        } else {
            return tmp;
        }
    } else if (typeof( mixed_var ) == 'number') {
        return Math.floor(mixed_var);
    } else {
        return 0;
    }
}

console.log('init2.js');
