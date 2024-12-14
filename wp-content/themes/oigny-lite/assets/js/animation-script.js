"use strict";

document.addEventListener("DOMContentLoaded", function () {
    function playAnimation(element, frame = false) {
        if (frame) {
            element.style.visibility = 'visible';
            element.style.opacity = '1';
            element.style.transform = 'none';
        }
        if (element.getBoundingClientRect().top > 0 && element.getBoundingClientRect().top <= (window.innerHeight * 0.75)) {
            element.classList.add('oigny-lite-animate-init');            
        }
    }

    function prepareAnimation(doc, frame = false) {
        var elements = doc.getElementsByClassName('oigny-lite-animate');

        for (let element of elements) {
            if ( frame ) {
                playAnimation(element, true);
            } else {
                window.addEventListener('load', function () {
                    playAnimation(element);
                });
                window.addEventListener('scroll', function () {
                    playAnimation(element);
                });
            }
        }
    }

    prepareAnimation(document);

    setTimeout(function() {
        var iframe = document.getElementsByClassName('edit-site-visual-editor__editor-canvas');
        var innerDoc = iframe.length > 0 ? iframe[0].contentDocument || iframe[0].contentWindow.document : null;
        innerDoc ? prepareAnimation(innerDoc, true) : null;
    }, 3000);
});