const base_url = $('meta[name=base_url]').attr("content");
//chosen
var config = {
    '.chosen-select': {},
    '.chosen-select-deselect': {allow_single_deselect: true},
    '.chosen-select-no-single': {disable_search_threshold: 10},
    '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
    '.chosen-select-rtl': {rtl: true},
    '.chosen-select-width': {width: '95%'}
}
for (var selector in config) {
    $(selector).chosen(config[selector]);
}

//state & city select
$('.select_js').on('change', function () {
    var select_id = $(this).val();
    var select_type = $(this).attr('data-type');
    var select_reply = $(this).attr('data-reply');
    var select_name = $(this).attr('data-name');
    if (select_id == null || select_id == '') {
        $('.city_class').empty();
        $('.city_class').append('<option value="">انتخاب شهر</option>')
        Swal.fire({
            // title: "ناموفق",
            title: "Başarısız",
            text: "Lütfen bir " + select_name + " seçin",
            // text: "لطفا استان را انتخاب کنید",
            icon: "warning",
            timer: 6000,
            timerProgressBar: true,
        })
    } else {
        var url = base_url + "/city_ajax_js/" + select_type + "/" + select_id;
        $.get(url, function (data, status) {

            $('.' + select_reply).empty();
            $('.' + select_reply).append('<option value=""> Seçiniz</option>')
            $.each(data, function (key, value) {
                $('.' + select_reply).append('<option value="' + value.id + '">' + value.name + '</option>')
            })
            $('.' + select_reply).trigger('chosen:updated');
            if (select_reply == 'loc_id') {
                $('.loc_address').removeClass('d-none')
            }
            else {
                $('.loc_address').addClass('d-none')
            }
        })
    }
})

var swiper = new Swiper('.coustomer-slider', {
    slidesPerView: 2,
    spaceBetween: 10,
    loop: true,
    // init: false,
    autoplay: {
        delay: 4500,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.coustomer-pagination',
        clickable: true,
    },
    breakpoints: {
        640: {
            slidesPerView: 1,
            spaceBetween: 5,
        },
        768: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 20,
        },
    }
});
var swiper = new Swiper('.eco-slider', {
    lazy: true,
    slidesPerView: 2,
    loop: false,
    // init: false,
    autoplay: {
        delay: 450000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.eco-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next.slider_r1_1002',
        prevEl: '.swiper-button-prev.slider_r1_1002',
    },
    breakpoints: {

        540: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
    }
});
var swiper = new Swiper('.vip-slider', {
    lazy: true,
    slidesPerView: 2,
    loop: false,
    // init: false,
    autoplay: {
        delay: 450000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.vip-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next.slider_r1_1001',
        prevEl: '.swiper-button-prev.slider_r1_1001',
    },
    breakpoints: {

        540: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
    }
});
var swiper = new Swiper('.row1_slider_1', {
    lazy: true,
    slidesPerView: 2,
    loop: false,
    // init: false,
    navigation: {
        nextEl: '.swiper-button-next.slider_r1_1',
        prevEl: '.swiper-button-prev.slider_r1_1',
    },
    autoplay: {
        delay: 450000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.eco-pagination',
        clickable: true,
    },
    breakpoints: {

        540: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
    }
});
var swiper = new Swiper('.row1_slider_2', {
    lazy: true,
    slidesPerView: 2,
    loop: false,
    // init: false,
    navigation: {
        nextEl: '.swiper-button-next.slider_r1_2',
        prevEl: '.swiper-button-prev.slider_r1_2',
    },
    autoplay: {
        delay: 450000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.eco-pagination',
        clickable: true,
    },
    breakpoints: {

        540: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
    }
});
var swiper = new Swiper('.row1_slider_3', {
    lazy: true,
    slidesPerView: 2,
    loop: false,
    // init: false,
    navigation: {
        nextEl: '.swiper-button-next.slider_r1_3',
        prevEl: '.swiper-button-prev.slider_r1_3',
    },
    autoplay: {
        delay: 450000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.eco-pagination',
        clickable: true,
    },
    breakpoints: {
        490: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
    }
});
var swiper = new Swiper('.row1_slider_4', {
    lazy: true,
    slidesPerView: 2,
    loop: false,
    // init: false,
    navigation: {
        nextEl: '.swiper-button-next.slider_r1_4',
        prevEl: '.swiper-button-prev.slider_r1_4',
    },
    autoplay: {
        delay: 450000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.eco-pagination',
        clickable: true,
    },
    breakpoints: {

        540: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
    }
});
var swiper = new Swiper('.row1_slider_5', {
    lazy: true,
    slidesPerView: 2,
    loop: false,
    // init: false,
    navigation: {
        nextEl: '.swiper-button-next.slider_r1_5',
        prevEl: '.swiper-button-prev.slider_r1_5',
    },
    autoplay: {
        delay: 450000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.eco-pagination',
        clickable: true,
    },
    breakpoints: {
        490: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
    }
});
var swiper = new Swiper('.row1_slider_6', {
    lazy: true,
    slidesPerView: 2,
    loop: false,
    // init: false,
    navigation: {
        nextEl: '.swiper-button-next.slider_r1_6',
        prevEl: '.swiper-button-prev.slider_r1_6',
    },
    autoplay: {
        delay: 450000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.eco-pagination',
        clickable: true,
    },
    breakpoints: {

        540: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
    }
});
var swiper = new Swiper('.row1_slider_7', {
    lazy: true,
    slidesPerView: 2,
    loop: false,
    // init: false,
    navigation: {
        nextEl: '.swiper-button-next.slider_r1_7',
        prevEl: '.swiper-button-prev.slider_r1_7',
    },
    autoplay: {
        delay: 450000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.eco-pagination',
        clickable: true,
    },
    breakpoints: {
        490: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
    }
});
var swiper = new Swiper('.row1_slider_8', {
    lazy: true,
    slidesPerView: 2,
    loop: false,
    // init: false,
    navigation: {
        nextEl: '.swiper-button-next.slider_r1_8',
        prevEl: '.swiper-button-prev.slider_r1_8',
    },
    autoplay: {
        delay: 450000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.eco-pagination',
        clickable: true,
    },
    breakpoints: {

        540: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
    }
});
var swiper = new Swiper('.row1_slider_9', {
    lazy: true,
    slidesPerView: 1,
    loop: false,
    // init: false,
    navigation: {
        nextEl: '.swiper-button-next.slider_r1_9',
        prevEl: '.swiper-button-prev.slider_r1_9',
    },
    autoplay: {
        delay: 450000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.eco-pagination',
        clickable: true,
    },
    breakpoints: {
        490: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
    }
});
var swiper = new Swiper('.swiper-container-category', {
    effect: 'coverflow',
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: 'auto',
    loop: true,
    autoplay: {
        delay: 4700,
        disableOnInteraction: false,
    },
    coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: true,
    },
    pagination: {
        el: '.swiper-pagination',
    },
});


var swiper = new Swiper('.swiper-container_page_cat', {
    slidesPerView: 1,
    spaceBetween: 10,
    // init: false,
    // pagination: {
    //     el: '.swiper-pagination',
    //     clickable: true,
    // },
    autoplay: {
        delay: 4700,
        disableOnInteraction: false,
    },
    breakpoints: {
        640: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 15,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 10,
        },
        1200: {
            slidesPerView: 6,
            spaceBetween: 10,
        },
    }
});
var swiper = new Swiper(".row2_slider_1", {
    slidesPerView: 2,
    // slidesPerColumn: 2,
    spaceBetween: 10,
    breakpoints: {
        540: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        620: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 10,
        },
        1080: {
            arrow: false,
            spaceBetween: 10,
            slidesPerView: 4,
            slidesPerColumn: 2,

        }
    },
    // pagination: {
    //     el: ".swiper-pagination",
    //     clickable: true,
    // },

    navigation: {
        nextEl: '.swiper-button-next.slider_r2_1',
        prevEl: '.swiper-button-prev.slider_r2_1',
    },
});
var swiper = new Swiper(".row2_slider_2", {
    slidesPerView: 2,
    // slidesPerColumn: 2,
    spaceBetween: 10,
    breakpoints: {

        620: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 10,
        },
        1080: {
            arrow: false,
            spaceBetween: 10,
            slidesPerView: 4,
            slidesPerColumn: 2,

        }
    },
    // pagination: {
    //     el: ".swiper-pagination",
    //     clickable: true,
    // },

    navigation: {
        nextEl: '.swiper-button-next.slider_r2_2',
        prevEl: '.swiper-button-prev.slider_r2_2',
    },
});

var swiper = new Swiper(".row2_slider_3", {
    slidesPerView: 1,
    // slidesPerColumn: 2,
    spaceBetween: 10,
    breakpoints: {

        620: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 10,
        },
        1080: {
            arrow: false,
            spaceBetween: 10,
            slidesPerView: 4,
            slidesPerColumn: 2,

        }
    },
    // pagination: {
    //     el: ".swiper-pagination",
    //     clickable: true,
    // },

    navigation: {
        nextEl: '.swiper-button-next.slider_r2_3',
        prevEl: '.swiper-button-prev.slider_r2_3',
    },
});

var swiper = new Swiper(".row2_slider_4", {
    slidesPerView: 1,
    // slidesPerColumn: 2,
    spaceBetween: 10,
    breakpoints: {

        620: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 10,
        },
        1080: {
            arrow: false,
            spaceBetween: 10,
            slidesPerView: 4,
            slidesPerColumn: 2,

        }
    },
    // pagination: {
    //     el: ".swiper-pagination",
    //     clickable: true,
    // },

    navigation: {
        nextEl: '.swiper-button-next.slider_r2_4',
        prevEl: '.swiper-button-prev.slider_r2_4',
    },
});
var swiper = new Swiper(".row2_slider_5", {
    slidesPerView: 1,
    // slidesPerColumn: 2,
    spaceBetween: 10,
    breakpoints: {

        620: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 10,
        },
        1080: {
            arrow: false,
            spaceBetween: 10,
            slidesPerView: 4,
            slidesPerColumn: 2,

        }
    },
    // pagination: {
    //     el: ".swiper-pagination",
    //     clickable: true,
    // },

    navigation: {
        nextEl: '.swiper-button-next.slider_r2_5',
        prevEl: '.swiper-button-prev.slider_r2_5',
    },
});
var swiper = new Swiper(".row2_slider_6", {
    slidesPerView: 1,
    // slidesPerColumn: 2,
    spaceBetween: 10,
    breakpoints: {

        620: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 10,
        },
        1080: {
            arrow: false,
            spaceBetween: 10,
            slidesPerView: 4,
            slidesPerColumn: 2,

        }
    },
    // pagination: {
    //     el: ".swiper-pagination",
    //     clickable: true,
    // },

    navigation: {
        nextEl: '.swiper-button-next.slider_r2_6',
        prevEl: '.swiper-button-prev.slider_r2_6',
    },
});

var swiper = new Swiper(".row2_slider_7", {
    slidesPerView: 1,
    // slidesPerColumn: 2,
    spaceBetween: 10,
    breakpoints: {

        620: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 10,
        },
        1080: {
            arrow: false,
            spaceBetween: 10,
            slidesPerView: 4,
            slidesPerColumn: 2,

        }
    },
    // pagination: {
    //     el: ".swiper-pagination",
    //     clickable: true,
    // },

    navigation: {
        nextEl: '.swiper-button-next.slider_r2_7',
        prevEl: '.swiper-button-prev.slider_r2_7',
    },
});

var swiper = new Swiper(".row2_slider_8", {
    slidesPerView: 1,
    // slidesPerColumn: 2,
    spaceBetween: 10,
    breakpoints: {

        620: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 10,
        },
        1080: {
            arrow: false,
            spaceBetween: 10,
            slidesPerView: 4,
            slidesPerColumn: 2,

        }
    },
    // pagination: {
    //     el: ".swiper-pagination",
    //     clickable: true,
    // },

    navigation: {
        nextEl: '.swiper-button-next.slider_r2_8',
        prevEl: '.swiper-button-prev.slider_r2_8',
    },
});

var galleryThumbs = new Swiper('.gallery-thumbs', {
    // spaceBetween: 0,
    // slidesPerView: 4,
    // freeMode: true,
    // watchSlidesVisibility: true,
    // watchSlidesProgress: true,
    direction: "vertical",
    slidesPerView: 5,
    spaceBetween: 5,
    mousewheel: true,
    // pagination: {
    //     el: ".swiper-pagination",
    //     clickable: true
    // }
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

});


var galleryTop = new Swiper('.gallery-top', {
    spaceBetween: 10,
    // zoom: {
    //     maxRatio: 3,
    // },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    thumbs: {
        swiper: galleryThumbs
    }
});
//hover share product & blog page
$('.fa_hover_share').click(function () {
    if ($(this).hasClass('open')) {
        $(this).removeClass('open')
        $('.arrow_box').hide(200)
    }
    else {
        $('.arrow_box').show(200)
        $(this).addClass('open')
    }
})
//model select
$('.model_select').on('change', function () {
    var count_prev = 0;
    var slider_next = false;
    var model_id = $(this).val();
    var buy_url = $(this).find(':selected').attr('data-buy');
    var fav_url = $(this).find(':selected').attr('data-favorite');
    var key = $(this).find(':selected').attr('data-key');
    $('.item_count_show').text(1);
    $('.minus-item-show').addClass('btn-disabled');
    if (model_id == 0) {
        $('#model_p_g').click()
        Swal.fire({
            title: "Dikkat",
            text: " Lütfen modellerden birini seçin ",
            icon: "warning",
            timer: 6000,
            timerProgressBar: true,
        })
        //fav link
        $('#favorite_link').attr('href', fav_url)
        //buy link
        $('#buy_link').attr('href', buy_url)
        $('.basket-item-count-show').attr('data-url', buy_url)
        $('#price_1').hide(200);
        $('#price_2').hide(200);
        $('#div_discount').hide(200);
        $('.product-count-show').removeClass('d-flex')
        $('.product-count-show').addClass('d-none')
        $('#buy_link').addClass('btn-disabled')
        $('#model_text').hide(200)
    }
    else {
        var model_inventory = $(this).find(':selected').attr('data-inventory');
        var model_price = $(this).find(':selected').attr('data-price');
        var model_price_vip = $(this).find(':selected').attr('data-price-vip');
        var model_discount = $(this).find(':selected').attr('data-discount');
        var text = $(this).find(':selected').attr('data-text');
        if (text != '') {
            $('#model_text').show(200)
            $('#model_text1').text(text);

        }
        if (model_inventory > 0) {
            //fav link
            $('#favorite_link').attr('href', fav_url)
            //buy link
            $('#buy_link').attr('href', buy_url)
            $('.basket-item-count-show').attr('data-url', buy_url)
            $('#buy_link').removeClass('btn-invent')
            $('.product-count-show').removeClass('d-none')
            $('.product-count-show').addClass('d-flex')
            $('#buy_link').addClass('btn-success')
            $('#buy_link svg').show(100)
            $('#buy_link span').text('Sepete ekle')
            //price
            if (model_price_vip > 0) {
                $('#price_1').text(tl_convert(model_price));
                $('#price_2').text(tl_convert(model_price_vip));
                $('#discount').text(model_discount);
                $('#price_1').show(200);
                $('#price_2').show(200);
                $('#div_discount').show(200);
                $('#buy_link').removeClass('btn-disabled')
            }
            else {
                $('#price_1').hide(200);
                $('#div_discount').hide(200);
                $('#price_2').text(model_price);
                $('#buy_link').removeClass('btn-disabled')
            }
        }
        else {
            //fav link
            $('#favorite_link').attr('href', fav_url)
            $('#buy_link').attr('href', 'javascript:void(0)')
            $('.basket-item-count-show').attr('data-url', 'javascript:void(0)')
            $('#buy_link').addClass('btn-invent')
            $('#buy_link').removeClass('btn-success')
            $('#buy_link svg').hide(100)
            $('#buy_link span').text('222')
            $('.product-count-show').removeClass('d-flex')
            $('.product-count-show').addClass('d-none')
            //price
            if (model_price_vip > 0) {
                $('#price_1').text(tl_convert(model_price));
                $('#price_2').text(tl_convert(model_price_vip));
                $('#discount').text(model_discount + '333');
                $('#price_1').show(200);
                $('#price_2').show(200);
                $('#div_discount').show(200);
                $('#buy_link').removeClass('btn-disabled')
            }
            else {
                $('#price_1').hide(200);
                $('#div_discount').hide(200);
                $('#price_2').text(model_price);
                $('#buy_link').removeClass('btn-disabled')
            }
        }
        // $('.num_price_js').text(function (index, value)
        // {
        //     return value.replace(/\D/g, "").replace(/\B(?=(\d{2})+(?!\d))/g, ".");
        // });
        $(".num_price_js").text(function (e, n) {
            var lent = n.length;
            var lir = n.substr(0, lent - 2);
            var lir1 = lir.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            if (n.substr(-2) > 0) {
                var res1 = '.' + n.substr(-2);
            }
            else {
                var res1 = '';
            }
            var res = lir1 + res1;
            return res;
        })
    }
})
//del basket
$('.del_basket').click(function () {
    var url = $(this).attr('data-url');
    var title = $(this).attr('data-title');
    var model = $(this).attr('data-model');
    var titr = title + ' ' + model;
    Swal.fire({
        // title: title ,
        text: 'Bu ürünü sileceğinizden eminsiniz',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    })
        .then((result) => {
            if (result.isConfirmed) {
                location.href = url;
            }
        })
})
//off code
$('.off_code_a').click(function () {
    var off_code = $('.off_code_input').val();
    var post = $(this).attr('data-post');
    var total = $(this).attr('data-total')

    if (off_code == null || off_code == '') {
        Swal.fire({
            title: "Ù†Ø§Ù…ÙˆÙÙ‚",
            text: "Ø§Ø¨ØªØ¯Ø§ Ú©Ø¯ ØªØ®ÙÛŒÙ Ø±Ø§ ÙˆØ§Ø±Ø¯ Ú©Ù†ÛŒØ¯",
            icon: "warning",
            timer: 6000,
            timerProgressBar: true,
        })
    } else {
        var url = base_url + "/off_checked/" + off_code + "/" + total;
        $.get(url, function (data, status) {
            if (data == 0) {
                $('.off_code_input').val('')
                $('#off_code_form').val('')
                $('.discont_set_yes').hide(200)
                Swal.fire({
                    title: "Ù†Ø§Ù…ÙˆÙÙ‚",
                    text: "Ú©Ø¯ ØªØ®ÙÛŒÙ Ø§Ø´ØªØ¨Ø§Ù‡ Ù…ÛŒ Ø¨Ø§Ø´Ø¯",
                    icon: "warning",
                    timer: 6000,
                    timerProgressBar: true,
                })
            }
            else if (data == 'no') {
                $('.off_code_input').val('')
                $('#off_code_form').val('')
                $('.discont_set_yes').hide(200)
                Swal.fire({
                    title: "Ù†Ø§Ù…ÙˆÙÙ‚",
                    text: "Ú©Ø¯ ØªØ®ÙÛŒÙ Ø¨Ø±Ø§ÛŒ Ù‡Ø± Ø´Ø®Øµ ÛŒÚ©Ø¨Ø§Ø± Ù…ØµØ±Ù Ù…ÛŒ Ø¨Ø§Ø´Ø¯ØŒ Ùˆ Ø´Ù…Ø§ Ø§Ø² Ø§ÛŒÙ† Ú©Ø¯ Ø§Ø³ØªÙØ§Ø¯Ù‡ Ú©Ø±Ø¯Ù‡ Ø§ÛŒØ¯",
                    icon: "warning",
                    timer: 6000,
                    timerProgressBar: true,
                })
            }
            else {
                $('.discont_val').text(parseInt(total) - parseInt(data))
                $('.discount_sum').text(parseInt(data) + parseInt(post))
                $(".discount_sum").text(function (e, n) {
                    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                })
                $(".discont_val").text(function (e, n) {
                    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                })
                $('#off_code_form').val(off_code)
                $('.discont_set_yes').show(200)
                Swal.fire({
                    title: "Ù…ÙˆÙÙ‚",
                    text: "Ú©Ø¯ ØªØ®ÙÛŒÙ Ø§Ø¹Ù…Ø§Ù„ Ø´Ø¯",
                    icon: "success",
                    timer: 6000,
                    timerProgressBar: true,
                })
            }
        });
    }

})

// count product show page
$('.basket-item-count-show').click(function () {
    var type = $(this).attr('data-type');
    var buy_url = $(this).attr('data-url');
    var num = $('.item_count_show').text();
    var num_new = parseInt(num);
    if (type == 'plus') {
        var num_new = parseInt(num) + 1;
    }
    else if (type == 'minus') {
        if (parseInt(num_new) > 1) {
            var num_new = parseInt(num) - 1;
        }
    }
    if (num_new > 1) {
        $('.minus-item-show').removeClass('btn-disabled');
    }
    else {
        $('.minus-item-show').addClass('btn-disabled');
    }
    $('.item_count_show').text(num_new);
    $('#buy_link').attr('href', buy_url + '?num=' + num_new)
})


var swiper = new Swiper('.cat_slid', {
    slidesPerView: 1,
    spaceBetween: 10,
    // init: false,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    autoplay: {
        delay: 4500,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        640: {
            slidesPerView: 2,
            spaceBetween: 5,
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 5,
        },
        1024: {
            slidesPerView: 6,
            spaceBetween: 5,
        },
    }
});
var swiper = new Swiper(".cat_page_g_s", {
    spaceBetween: 30,
    effect: "fade",
    autoplay: {
        delay: 4500,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});
var swiper = new Swiper(".cat_page_g_s1", {
    spaceBetween: 30,
    effect: "fade",
    autoplay: {
        delay: 5500,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});

function set_lir(n) {
    var lent = n.length;
    var lir = n.substr(0, lent - 2);
    var lir1 = lir.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    if (n.substr(-2) > 0) {
        var res1 = '.' + n.substr(-2);
    }
    else {
        var res1 = '';
    }
    var res = lir1 + res1;
    return res;
}

//send basket new address
$('.user_new').click(function () {
    if ($('.send_order_new').hasClass('opacity_new')) {
        $(this).text('Adresime')
        $('.send_order_new').removeClass('opacity_new')
        $('.address_send_val').val('yes')
        $('.req_new_address').prop('required', true)
    }
    else {
        $(this).text('Başka bir adrese gönder')
        $('.send_order_new').addClass('opacity_new')
        $('.address_send_val').val('no')
        $('.req_new_address').prop('required', false)
    }

});

function openNav() {
    document.getElementById("mySidenav1").style.width = "100%";
    document.getElementById("mySidenav").style.width = "250px";

}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("mySidenav1").style.width = "0";

}

function tl_convert(n) {
    var lent = n.length;
    var lir = n.substr(0, lent - 2);
    var lir1 = lir.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    if (n.substr(-2) > 0) {
        var res1 = '.' + n.substr(-2);
    }
    else {
        var res1 = '';
    }
    var res = lir1 + res1;
    return res;
}

function autocomplete(inp, inp2, inp3, arr) {
    var currentFocus;
    inp.addEventListener("input", function (e) {
        var a, b, i, val = this.value;
        closeAllLists();
        if (!val) {
            return !1
        }
        currentFocus = -1;
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        this.parentNode.appendChild(a);
        for (i = 0; i < arr.length; i++) {
            var pos = arr[i][0].toUpperCase().indexOf(val.toUpperCase());
            if (pos > -1) {
                b = document.createElement("DIV");
                b.innerHTML = arr[i][0].substr(0, pos);
                b.innerHTML += "<strong>" + arr[i][0].substr(pos, val.length) + "</strong>" + "<strong class='float-start'>" + arr[i][1] + "</strong>";
                b.innerHTML += arr[i][0].substr(pos + val.length);
                b.innerHTML += "<input type='hidden' value='" + arr[i][0] + "'>" +
                    "<input type='hidden' value='" + arr[i][1] + "'>" +
                    "<input type='hidden' value='" + arr[i][2] + "'>";
                b.addEventListener("click", function (e) {
                    // console.log(this.getElementsByTagName("input")[1])
                    inp.value = this.getElementsByTagName("input")[2].value;
                    inp2.value = this.getElementsByTagName("input")[1].value;
                    sender("sdsd");
                    closeAllLists();
                    // if ($(window).width() >= 992) {
                    //     $('#frm_get').submit()
                    // }
                    // if ($(window).width() < 992) {
                    //     $('#frm_get1').submit()
                    // }
                });
                a.appendChild(b)
            }
        }
    });
    inp.addEventListener("keydown", function (e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            currentFocus++;
            addActive(x)
        } else if (e.keyCode == 38) {
            currentFocus--;
            addActive(x)
        } else if (e.keyCode == 13) {
            // e.preventDefault();
            // if (currentFocus > -1) {
            //     if (x) x[currentFocus].click()
            // }
            if ($(window).width() >= 992) {
                $('form#frm_get1').submit();
            }
            else {
                $('form#frm_get2').submit();
            }
        }
    });

    function addActive(x) {
        if (!x) return !1;
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        x[currentFocus].classList.add("autocomplete-active")
    }

    function removeActive(x) {
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active")
        }
    }

    function closeAllLists(elmnt) {
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i])
            }
        }
    }

    document.addEventListener("click", function (e) {
        closeAllLists(e.target)
    })
}

function sender(a) {
    if ($(window).width() >= 992) {
        document.getElementById("frm_get1").submit()
    }
    else {
        document.getElementById("frm_get2").submit()
    }
}

$(window).scroll(function () {
    var $heightScrolled = $(window).scrollTop();
    var $defaultHeight = 200;
    if ($heightScrolled < $defaultHeight) {
        $('#mobil_menu').removeClass("mobil_menu_fix");
    }
    else {
        $('#mobil_menu').addClass("mobil_menu_fix")

    }

});

$('.closenav_address').click(function () {
    $('#mySidenav_address').removeClass('open_nav_address')
    $('.bg_all_nav_open').removeClass('d-block')
    $('body').removeAttr('style');
})
$('.closenav_address2').click(function () {
    $('#mySidenav_address').removeClass('open_nav_address')
    $('.bg_all_nav_open').removeClass('d-block')
    $('body').removeAttr('style');
})
$('.opennav_address').click(function () {
    $('#mySidenav_address').addClass('open_nav_address')
    $('.bg_all_nav_open').addClass('d-block')
    document.body.style.overflow = "hidden";
})
$('.address_item_1VcxP').click(function () {
    var select_item = $(this).attr('data-key');
    var count = $(this).attr('data-count')
    for (var i = 1; i <= count; i++) {
        $('#item_' + i).removeClass('selected_B7Hp0')
        $('#checked_' + i).hide()
    }
    $('#item_' + select_item).addClass('selected_B7Hp0');
    $('#checked_' + select_item).show()
    $('#address_val').val($(this).attr('data-val'));
});
$('.sender_').click(function () {
    var val = $('#address_val').val()

    if (val == '') {
        Swal.fire({
            title: "çok dikkat",
            text: "Lütfen gönderinin gönderileceği adresi seçin",
            icon: "warning",
            timer: 6000,
            timerProgressBar: true,
        })

    }
    else {
        $('#address_form').submit()
    }
});
//reng slider
document.documentElement.classList.add('js');

addEventListener('input', e => {
    let _t = e.target,
        _p = _t.parentNode;
    _p.style.setProperty(`--${_t.id}`, +_t.value)
}, false);
//reng slider
$('.prev_box').click(function () {
    var id=$(this).attr('data-val');
    $('#prev_'+id).click();
});
$('.next_box').click(function () {
    var id=$(this).attr('data-val');
    $('#next_'+id).click();
});
$('#filter_1').click(function () {
    if($("#f_filter").hasClass("box_f_filter_open"))
    {
        $("#f_filter").removeClass('box_f_filter_open')
        $("#filter_1").removeClass('filter_set')
    }else
    {
        $("#f_filter").addClass('box_f_filter_open')
        $("#filter_1").addClass('filter_set')

    }

})
$(".btn_down").click( function () {
    $('#down').click();
});
$(".btn_up").click( function () {
    $('#up').click();
});


var swiper = new Swiper(".model_slider", {
    slidesPerView: 1,
    spaceBetween: 10,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        640: {
            slidesPerView: 2,
            spaceBetween: 8,
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 8,
        },
        1024: {
            slidesPerView: 6,
            spaceBetween: 11,
        },
    },
});
var swiper = new Swiper(".other_slider", {
    slidesPerView: 1,
    spaceBetween: 10,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        640: {
            slidesPerView: 2,
            spaceBetween: 8,
        },
        768: {
            slidesPerView: 43,
            spaceBetween: 8,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
    },
});