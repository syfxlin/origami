jQuery(document).ready(function ($) {
    "use strict";
    var origami = {};

    // 滑动到文章部分
    origami.scroll_content = function() {
        $('#featured-down').on('click', function(e) {
            $('html,body').animate({
                scrollTop: $('#featured-show')[0].offsetTop - 79
            }, 500);
            e.preventDefault();
        });
    };

    // 页首滑动改变样式
    origami.scroll_change = function() {
        var fea_top = $('#featured-show')[0].offsetTop;
        $(window).scroll(function() {
            if($(document).scrollTop() >= fea_top - 82) {
                $('#site-header').addClass('fixed-header-0');
                $('.menu-item-has-children').css('color','#111');
                $('#site-title').hide();
                $('#site-logo').fadeIn();
                $('#mobile-nav-icon').find('span').css('background-color','#757575');
            } else {
                $('#site-header').removeClass('fixed-header-0');
                $('.menu-item-has-children').css('color','#fff');
                $('#site-logo').hide();
                $('#site-title').fadeIn();
                $('#mobile-nav-icon').find('span').css('background-color','#fff');
            }
        });
    };

    // 菜单显示和隐藏
    origami.mobile_nav_menu = function () {
        var media_queries = {
			tablet: window.matchMedia('(min-width:768px) and (max-width: 991px)'),
			mobile: window.matchMedia('(max-width:767px)')
		}
        function isSmall() { return media_queries.mobile.matches; }
		function isMedium() { return media_queries.tablet.matches; }
		function isXLarge() { return (!media_queries.tablet.matches && !media_queries.mobile.matches); }

        $('#mobile-nav-button').click(function (e) {
            e.preventDefault();

            $('#mobile-nav-button').toggleClass('active');

            $('#site-header-inner,#header-nav,#main-content,footer').toggleClass('menu-active');

        });
        $('#header-nav #nav-ul > .menu-item-has-children > a,#header-nav #nav-ul > ul > .page_item_has_children > a').append('<span class="sub-drop-icon fa fa-angle-down"></span>');
        $('#header-nav .sub-menu > .menu-item-has-children > a,#header-nav .children > .page_item_has_children > a').append('<span class="sub-drop-icon sub-second-drop fa fa-angle-down"></span>');
        $('.sub-drop-icon').on('click', function (e) {
            e.preventDefault();
            if (!isXLarge()) {
                $(this).closest('.menu-item,.page_item').find('> .sub-menu, > .children').slideToggle(250).toggleClass('opened');
                $(this).toggleClass('fa fa-angle-down fa fa-angle-up');
            }

        });
        $('#main-content,footer').on('click', function () {
            if ($('#mobile-nav-button').hasClass('active')) {
                $('#site-header-inner,#header-nav,#main-content,footer').removeClass('menu-active');
                $('#mobile-nav-button').removeClass('active');
            }
        });
    };

    // 函数调用
    origami.mobile_nav_menu();
    origami.scroll_content();
    if($('body').attr('class').indexOf('home') != -1) {
        origami.scroll_change();
    }
    if($('#origami-theme-info').length <= 0) {
        $('#footer-copyright').append('<br><span id="origami-theme-info">Theme - Origami By <a href="https://www.ixk.me">Otstar Lin</a></span>');
    }
});

// onload完成后执行
window.onload = function() {
    // title切换
    var OriginTitile = document.title;
    var titleTime;
    document.addEventListener('visibilitychange', function () {
        if (document.hidden) {
            document.title = '(つェ⊂)我藏好了哦~ ' + OriginTitile;
            clearTimeout(titleTime);
        } else {
            document.title = '(*´∇｀*) 被你发现啦~ ' + OriginTitile;
            titleTime = setTimeout(function () {
                document.title = OriginTitile;
            }, 2000);
        }
    });

    jQuery(document).ready(function ($) {
        var origami = {};
        origami.scroll_top = function () {
            $(window).scroll(function () {
                if ($(document).scrollTop() > 50) {
                    $('#scroll-top').fadeIn(500);
                } else {
                    $('#scroll-top').fadeOut(500);
                }
            });
            $('#scroll-top').on('click', function (e) {
                $('html,body').animate({
                    scrollTop: 0
                }, 500);
                e.preventDefault();
            });
        };
        // 代码块新窗口打开
        origami.code_window = function() {
            $('.toolbar').append('<div class="toolbar-item"><span class="code-window">全屏</span></div>');
            $('.code-window').click(function(){
                var code_window=window.open();
                var code = $(this).parent().parent().parent().html();
                code_window.document.write('<html><head>');
                code_window.document.write('<link rel="stylesheet" id="prism-style-css" href="' + location.protocol + '//' + location.host + '/wp-content/themes/Origami/css/prism.css" type="text/css" media="all"><script type="text/javascript" src="' + location.protocol + '//' + location.host + '/wp-content/themes/Origami/js/prism.js"></script>');
                code_window.document.write('<style>body{margin:0px;background: #272822;}</style></head><body>');
                code_window.document.write('<div id="test" style="background:#272822;width:100%;height:100%;"><div class="code-toolbar">'+ code +'</div></div>');
                code_window.document.write('</body></html>');
            });
        };
        // Ajax读取评论
        origami.ajax_comment_load = function() {
            if($('#comment_post_ID').length > 0) {
                window.the_post_id = $('#comment_post_ID').attr('value');
            }
            window.max_page_index = $('#comment_page_index').text();
            function hideComment(){
                $('#comment_list').hide();
                $('#loading_comments').slideDown();
            }
            function loadComment(out) {
                $('#comment_list').html($(out).fadeIn(500));
                $('#comment_list').fadeIn();
                $('#comment_page_index').hide();
                $('#loading_comments').slideUp('fast');
                $('html,body').animate({scrollTop: $('#comment_list').offset().top - 200}, 500);
            }
            window.get_the_page_commment = function() {
                if(max_page_index != 0) {
                    $.ajax({
                        type: "GET",
                        url: location.href,
                        data:{
                            "action":"comments",
                            "post_id":the_post_id,
                            "page_index":$('#comment_page_index').text()
                        },
                        dataType: "html",
                        success: function(out){
                            $('#comment_list').html($(out).fadeIn(500));
                            $('#comment_page_index').hide();
                            $('#reload_comments').hide();
                            if(max_page_index > 1 && max_page_index != '') {
                                $('#comment_prev').fadeIn();
                                $('#comment_num_nav').fadeIn();
                            }
                        },
                        error: function() {
                            $('#reload_comments').fadeIn();
                        }
                    });
                }
            };

            // 评论翻页
            window.get_other_page_comment = function(page_index) {
                $.ajax({
                    type: "GET",
                    url: location.href,
                    data:{
                        "action": "comments",
                        "post_id": the_post_id,
                        "page_index": page_index
                    },
                    beforeSend: hideComment(),
                    dataType: "html",
                    success: function(out) {
                        loadComment(out);
                        $('#comment_next').fadeIn();
                        $('#comment_prev').fadeIn();
                        if($('#comment_page_index').text() == 1) {
                            $('#comment_prev').hide();
                        }
                        if($('#comment_page_index').text() == max_page_index) {
                            $('#comment_next').hide();
                        }
                    }
                });
            };

            function comment_index_button() {
                for(var i = max_page_index; i > 0 ; i--) {
                    $('#comment_num_nav_select').prepend('<option value="' + i + '">第' + i + '页</option>');
                }
                // 触发设置
                $('#comment_prev').click(function() {
                    get_other_page_comment($('#comment_page_index').text() - 1);
                });
                $('#comment_next').click(function() {
                    get_other_page_comment((parseInt($('#comment_page_index').text()) + 1).toString());
                });
                $('#comment_num_nav_select').change(function() {
                    get_other_page_comment($('option:selected').attr('value'));
                });
            }

            get_the_page_commment();
            comment_index_button();
        };
        // 文章图片缩放
        origami.img_maxbox = function() {
            $('.page-content img').click(function() {
                $(this).before('<div class="page-content-img-background"><div class="page-content-img-max"><img class="page-content-img" src="' + $(this).attr('src') + '"></div></div>');
                $('.page-content-img-background').fadeIn();

                $('.page-content-img-max').click(function() {
                    $('.page-content-img-background').fadeOut('normoal',function() {
                        $('.page-content-img-background').remove();
                    });
                });
            });
        };
        // 实时搜索
        origami.real_time_search = function() {
            $('#header-search').click(function() {
                $('#search-section').fadeIn('normal', function() {
                    $('#search-form').focus();
                });
                $('#search-form').bind("input propertychange",function() {
                    var $this = $(this);
                    var delay = 250;

                    clearTimeout($this.data('timer'));
                    $this.data('timer', setTimeout(function(){
                        $this.removeData('timer');
                        if($('#search-form').val() == "") {
                            $('#search-content').empty();
                            $('#search-content').hide();
                        } else {
                            $.ajax({
                                type: "GET",
                                url: location.protocol + '//' + location.host + '/',
                                data:{
                                    "action": "real_time_search",
                                    "search": $('#search-form').val()
                                },
                                beforeSend: function() {
                                    $('#search-content').empty();
                                    $('#search-content').hide();
                                },
                                dataType: "html",
                                success: function(out) {
                                    $('#search-content').append(out);
                                    $('#search-content').fadeIn('fast');
                                }
                            });
                        }
                    }, delay));
                });

                $('#search-section-close').click(function() {
                    $('#search-section').fadeOut();
                });
            });
        };
        // 生成阅读转移二维码
        origami.reading_transfer = function() {
            var url = encodeURI(location.href);
            var select = true;
            $('#qrcode').click(function() {
                if(select) {
                    $('#qrcode-img').empty();
                    new QRCode(document.getElementById("qrcode-img"), {
                        text: url + "?index=" + ($(document).scrollTop() - $('.blog-post-content').offset().top) / $('.blog-post-content').height(),
                        width: 180,
                        height: 180,
                        colorDark : "#000000",
                        colorLight : "#ffffff",
                        correctLevel : QRCode.CorrectLevel.L
                    });
                    $('#qrcode-img').fadeIn(500);
                    select = false;
                } else {
                    $('#qrcode-img').fadeOut(500);
                    select = true;
                }
            });
        };
        // 点击显示文章目录
        origami.post_index = function() {
            var select = true;
            if($(window).width() > 991) {
                $('#toc-button').click(function(e) {
                    if(e.target.className == "fa fa-indent fa-2x") {
                        if(select) {
                            $('.toc').addClass('toc-show');
                            $('.toc').css('box-shadow','none');
                            select = false;
                        } else {
                            $('.toc').removeClass('toc-show');
                            $('.toc').css('box-shadow','0 0 20px #B6DFE9');
                            select = true;
                        }
                    }
                });
            }
        };
        // 当访问的设备有记录阅读位置时就跳转
        origami.set_position = function() {
            var url = location.search;
            if(url.indexOf('?index') != -1) {
                var str = url.substr(1);
                var strs = str.split("=");
                var index_temp = strs[1];
                window.index = $('.blog-post-content').offset().top + ($('.blog-post-content').height() * index_temp);
                $("html,body").animate({scrollTop:index},500);
                $("#if-to-start").fadeIn(300);
            }
        };
        window.to_start = function() {
            $("html,body").animate({scrollTop:0},500);
            $("#if-to-start").fadeOut(300);
        };
        window.no_to_start = function() {
            $("#if-to-start").fadeOut(300);
        };
        // 时光轴特效
        origami.timeline_ami = function () {
            var $element = $('.timeline-each-event, .timeline-title');
            var $window = $(window);
            $window.on('scroll resize', check_for_fade);
            $window.trigger('scroll');

            function check_for_fade() {
                var window_height = $window.height();
                var space;
                $.each($element, function (event) {
                    var $element = $(this);
                    var element_height = $element.outerHeight();
                    var element_offset = $element.offset().top;
                    space = window_height - (element_height + element_offset - $(window).scrollTop());
                    if (space < 60) {
                        $element.addClass("non-focus");
                    } else {
                        $element.removeClass("non-focus");
                    }

                });
            }
        };
        // 执行代码
        origami.scroll_top();
        origami.img_maxbox();
        origami.real_time_search();
        origami.ajax_comment_load();
        origami.code_window();
        origami.timeline_ami();
        origami.reading_transfer();
        origami.set_position();
        origami.post_index();
        origami.fix_a_hover = function() {
            $('body').append('<style>a{transition: color 0.5s;}</style>');
        };
        origami.fix_a_hover();
    });

    function origami_new_owo() {
        try {
            if(is_owo == true) {
                new OwO({
                    logo: 'OωO表情',
                    container: document.getElementsByClassName('OwO')[0],
                    target: document.getElementsByClassName('comment-text')[0],
                    api: location.protocol + '//' + location.host + '/wp-content/themes/Origami/js/OwO.json',
                    position: 'down',
                    width: '100%',
                    maxHeight: '250px'
                });
            }
        } catch (e) {}
    }

    // 执行原生js函数
    origami_new_owo();
    lazyload();
};