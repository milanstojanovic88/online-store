/*
    Splash Screen Script
 */

document.onreadystatechange = function () {

    if(document.readyState == 'interactive') {
        var allElements = document.getElementsByTagName('*');

        for(var i = 0; i < allElements.length; i++) {
            setElement(allElements[i]);
        }
    }
};

var checkElement = function (ele) {
        var allElements = document.getElementsByTagName('*'),
            numberOfElements = allElements.length,
            incrementPerElement = 100/numberOfElements;

        if($(ele).on()) {
            var animationWidth = Number(document.getElementById('animationWidth').value),
                progressWidth = animationWidth + incrementPerElement;

            document.getElementById('animationWidth').value = progressWidth;

            var progressBar = document.querySelector('.splash-screen .progress-bar');

            $(progressBar).animate({
                width: progressWidth + '%'
            },{
                duration: 1,
                complete: function () {
                    if(progressBar.style.width == '100%' && document.readyState == 'complete') {
                        setTimeout(function () {
                            $('.progress').fadeOut(400, function () {
                                $('.continue-to-store').fadeIn(400);
                            });
                        }, 1000);
                    }
                }
            });
        }
    },

    setElement = function (element) {
        checkElement(element);
    };

$(document).ready(function () {

    $('.continue-to-store button').click(function (event) {
        event.preventDefault();

        $('.splash-screen').animate({
            width: '120%'
        },{
            duration: 200,
            complete: function () {
                $(this).animate({
                    right: '100%'
                },{
                    duration: 400,
                    complete: function () {
                        $(this).css('display', 'none');
                    }
                });
            }
        });
    });

});