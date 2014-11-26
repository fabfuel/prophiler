/**
 * @author @marcotroisi <hello@marcotroisi.com>
 * @created 26.11.14
 */


var Prophiler = Prophiler || {};
(function(Prophiler) {

    Prophiler.slideToggleData = function(name) {
        var element = document.getElementById(name);
        if (element.style.display != 'inherit') {
            element.style.display = 'inherit';
            element.style.opacity = '1.0';
        } else {
            element.style.opacity = '0';
            element.style.display = 'none';
        }
    };

    window.addEventListener("load", function () {

        var jsonTags = document.getElementsByTagName('json');

        for (var index = 0; index < jsonTags.length; index++) {
            var el = jsonTags[index];
            jsonTags[index].innerHTML = JSON.stringify(JSON.parse(el.innerHTML), null, '    ');
        }
    });

})(Prophiler);