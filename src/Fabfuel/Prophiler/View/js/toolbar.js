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

    document.getElementById('hideToolbar').addEventListener("click", function () {
        document.getElementById('toolbarMinimised').style.display = "inherit";
        document.getElementById('toolbarMaximised').style.display = "none";
        document.getElementById('prophiler').style.width = "200px";
    });
    document.getElementById('showToolbar').addEventListener("click", function () {
        document.getElementById('toolbarMaximised').style.display = "inherit";
        document.getElementById('toolbarMinimised').style.display = "none";
        document.getElementById('prophiler').style.width = "auto";
    });

    window.addEventListener("load", function () {

        var jsonTags = document.getElementsByTagName('json');

        for (var index = 0; index < jsonTags.length; index++) {
            var el = jsonTags[index];
            jsonTags[index].innerHTML = JSON.stringify(JSON.parse(el.innerHTML), null, '    ');
        }
    });

})(Prophiler);