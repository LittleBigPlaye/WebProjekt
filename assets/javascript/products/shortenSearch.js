/**
 * Used to shorten the search string, if it is too long
 */

document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('search');
    var btnSearch = document.getElementById('searchSubmit');

    if (btnSearch) {
        btnSearch.addEventListener('click', function(event) {

            if (searchInput.value.length > 200) {
                searchInput.value = searchInput.value.substr(0, 200);
            }
        })
    }
});