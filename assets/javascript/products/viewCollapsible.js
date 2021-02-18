/**
 * This script is used to control the collapsible for the product view
 * @author Robin Beck
 */
document.addEventListener('DOMContentLoaded', function() {
    var collapsibleToggle = document.getElementById('collapsibleToggle');
    var collapsible = document.getElementById('collapsible');


    var minHeight = '150px';
    if (collapsible) {
        collapsible.style.maxHeight = minHeight;
        collapsible.style.paddingBottom = '100px';
    }

    var collapsibleFadeout = document.getElementById('collapsibleFadeout');
    if (collapsibleFadeout) {
        collapsibleFadeout.style.display = 'block';
    }


    if (collapsibleToggle) {
        var collapsibleToggleLabel = collapsibleToggle.parentElement;
    }

    if (collapsibleToggle && collapsible) {
        collapsibleToggle.addEventListener('click', function() {

            if (collapsible.style.maxHeight != minHeight) {
                if (collapsibleToggleLabel) {
                    collapsibleToggleLabel.style.transform = 'rotate(0)';
                }
                collapsible.style.maxHeight = minHeight;
            } else {
                if (collapsibleToggleLabel) {
                    collapsibleToggleLabel.style.transform = 'rotate(180deg)';
                }
                collapsible.style.maxHeight = collapsible.scrollHeight + 'px';
            }
        });
    }
});