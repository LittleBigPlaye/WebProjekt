document.addEventListener('DOMContentLoaded', function() {
    var collapsibleToggle = document.getElementById('collapsibleToggle');
    var collapsible = document.getElementById('collapsible');

    var minHeight = '150px';
    if (collapsible) {
        collapsible.style.maxHeight = minHeight;
    }

    if (collapsibleToggle && collapsible) {
        collapsibleToggle.addEventListener('click', function() {
            // alert(collapsible.style.maxHeight);
            if (collapsible.style.maxHeight != minHeight) {
                collapsible.style.maxHeight = minHeight;
            } else {
                collapsible.style.maxHeight = collapsible.scrollHeight + 'px';
            }
        });
    }
});