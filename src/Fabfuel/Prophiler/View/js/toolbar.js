/**
 * @author @marcotroisi <hello@marcotroisi.com>
 * @created 26.11.14
 */


var Prophiler = Prophiler || {};
(function(Prophiler) {

    Prophiler.slideToggleData = function(containerId) {
        var container = document.getElementById(containerId),
            classes = container.className.split(' '),
            newClasses = [];
        console.log(classes)
        classes.forEach(function (className) {
            if (className == 'closed') {
                newClasses.push('opened');
            } else if (className == 'opened') {
                newClasses.push('closed');
            } else {
                newClasses.push(className);
            }
        });
        container.className = newClasses.join(' ');
    };

    window.addEventListener("load", function () {

        var jsonTags = document.getElementsByTagName('json');

        for (var index = 0; index < jsonTags.length; index++) {
            var el = jsonTags[index];
            jsonTags[index].innerHTML = JSON.stringify(JSON.parse(el.innerHTML), null, '    ');
        }
    });

})(Prophiler);