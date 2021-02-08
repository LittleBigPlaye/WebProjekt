/**
 * This script is used to display content, that is hidden, if javascript is disabled 
 */

document.addEventListener('DOMContentLoaded', function () {
    var jsRelevantBlocks = document.getElementsByClassName('jsRelevant');
    Array.prototype.forEach.call(jsRelevantBlocks, function (jsRelevant, index) {
        jsRelevant.style.display = 'block';
    });
});