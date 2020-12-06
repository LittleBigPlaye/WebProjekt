function showNavBar() {
    var navBar = document.getElementById("myTopNavigation");
    if (navBar.className === "topNavigation") {
        navBar.className += " responsive";
    } else {
        navBar.className = "topNavigation";
    }
}