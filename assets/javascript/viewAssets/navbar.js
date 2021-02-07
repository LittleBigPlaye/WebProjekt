/**
 * This script is used to collapse uncollapsed submenus of the menu bar
 * @author Robin Beck
 */

document.addEventListener('DOMContentLoaded', function () {
    var checkboxes = document.getElementsByClassName('subNavToggle');

    Array.prototype.forEach.call(checkboxes, function (checkbox, index) {
        checkbox.addEventListener('change', function () {
            if (this.checked) {
                showSubNavigation(index);
            }
        });
    });

    function showSubNavigation(targetNavigation) {
        var checkboxes = document.getElementsByClassName('subNavToggle');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = (i == targetNavigation);
        }
    }
});