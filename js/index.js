window.onload = initCatalogPage;

function initCatalogPage() {

    var elonLink = document.getElementById("elon_button");
    elonLink.onclick = onElonClick;

    var teslaLink = document.getElementById("tesla_button");
    teslaLink.onclick = onTeslaClick;

    var spaseLink = document.getElementById("spase_button");
    spaseLink.onclick = onSpaseClick;

    var booringLink = document.getElementById("boring_button");
    booringLink.onclick = onBoringClick;

    var modal = document.getElementById("entrance_button");
    modal.onclick = showModal;

    var closeModal = document.getElementById("close_modal");
    closeModal.onclick = closeModalWin;

    var register = document.getElementById("reg_button");
    register.onclick = regUser;

    var login = document.getElementById("login_button");
    login.onclick = LogInUser;

    changeForm();
}

function regUser() {
    var login = document.getElementById("login").value;
    console.log(login);
    var password = document.getElementById("password").value;
    var data = {
        "login": login,
        "password": password
    };
    console.log(password);
    console.log(data);
    postRequest("../musk/saveUser.php", data, onLoginResponse);
}

function LogInUser() {
    var login = document.getElementById("login").value;
    console.log(login);
    var password = document.getElementById("password").value;
    var data = {
        "login": login,
        "password": password
    };
    console.log(password);
    console.log(data);
    postRequest("../musk/testreg.php", data, onLoginResponse);
}


function onElonClick() {
    var data = {"theme": "elon"};
    chengeBackground(data);
    postRequest("../musk/selectTheme.inc.php", data, onCatalogResponse);
}

function onTeslaClick() {
    var data = {"theme": "tesla"};
    chengeBackground(data);
    postRequest("../musk/selectTheme.inc.php", data, onCatalogResponse);
}

function onSpaseClick() {
    var data = {"theme": "spasex"};
    postRequest("../musk/selectTheme.inc.php", data, onCatalogResponse);
}

function onBoringClick() {
    var data = {"theme": "boring"};
    postRequest("../musk/selectTheme.inc.php", data, onCatalogResponse);


}

function onLoginResponse(response) {
    alert(response.inf);
}


function onCatalogResponse(response) {
    if (response) {
        var html = "";
        for (var i = 0; i < response.inf.length; ++i) {
            var inf = response.inf[i];
            html += "<div class=\"article span4\">" +
                "      <div class=\"article_wrapper\">" +
                "        <h3 class=\"article_title\">" + inf.title + "</h3>" +
                "        <img src=\"" + inf.img + " \" class=\"\">" +
                "        <p class=\"article_description\">" + inf.description + "</p>\n" +
                "      </div>" +
                "    <a href=\"javascript:void(0);\" class=\"button_more button\"  id=\"read\" value=\"" + inf.id + "\">Читать</a>" +

                "</div>"
        }
        document.getElementById("news_row").innerHTML = html;
        show();
        getValue();
    }
}

function onArticleResponse(article) {
    if (article) {
        var html = "";
        for (var i = 0; i < article.inf.length; ++i) {
            var inf = article.inf[i];

            html += "<div></div>" +
                "<div class=\"article_id\">" +
                "<h3 class=\"article_title\">" + inf.header + "</h3>" +
                "<div class=\"lead\">" + inf.lead + "</div>" +
                "<p>" + inf.text + "</p>" +
                "<a href=\" " + inf.link + "\" target=\"_blank\">ссылка на источник</a>" +
                " </div>" +
                "<div class='clear'></div>"
        }
        document.getElementById("news_row").innerHTML = html;

        show();
    }
}


function chengeBackground(data) {
    var a = {"theme": "tesla"};
    if (data == a) {
        console.log(1212);
    }

}

function show() {
    $('.row_block').animate({opacity: 1, marginTop: "200px", borderWidth: "10px"}, 500);
    setTimeout(function () {
        $('.article').fadeIn(500);
        $('.article').animate({opacity: 1}, 500);
        $('.article_id').animate({opacity: 1}, 500);
    }, 500);

}

function showModal() {
    $('.modal_wrapper').css("display", "block");
    $('.modal_login').css("display", "block");
    $('.base_block').animate({opacity: 1, height: "320px"}, 400);
    window.setTimeout(function () {
        $('.form_block').animate({opacity: 1, width: "400px"}, 200);
        window.setTimeout(function () {
            $('.form_block_wrapper').animate({opacity: 1}, 200)
        }, 200)
    }, 250);
}

function changeForm() {
    $('.reg').click(function () {
        $('.form_block_wrapper').fadeOut(300);
        $('.form_block_reg').fadeIn(250);

    });
    $('.log').click(function () {
        $('.form_block_wrapper').fadeIn(250);
        $('.form_block_reg').fadeOut(200);
    })
}

function closeModalWin() {
    $('.form_block').animate({opacity: 0, width: "0px"}, 300);
    $('.about').css('overflow-y', 'auto');
    window.setTimeout(function () {
        $('.base_block').animate({opacity: 0, height: "0px"}, 200);
        window.setTimeout(function () {
            $('.modal_wrapper').css("display", "none");
        }, 200);
    }, 400);

}

function getValue() {
    $(".about").on('click', "#read", function () {
        var id = $(this).attr("value");
        var data = {"id": id};
        postRequest("../musk/article.php", data, onArticleResponse);

    });
}


/*
function scrollToTop(){
    var to_top = document.getElementById('button_to_top');
    var position
    console.log(to_top);
    to_top.addEventListener('click', function(){
        var timer = 0;
        console.log("click");
        position = window.pageYOffset;
        console.log(position);
        scroll(timer);
    });
    function scroll(timer){
        if (position > 0){
            console.log('scroll');
            window.scrollTo(0, position);
            position = position - 25;
            timer = setTimeout(scroll, 5);
        }
        else{
            console.log('else');
            window.scrollTo(0,0);
        }
    }
}
*/
/*
function scrollWindow() {
    $('html, body').animate({
        scrollTop: $("#side_menu").offset().top
    }, 2000);
}
*/