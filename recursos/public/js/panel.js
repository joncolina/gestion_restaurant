function MenuLateral() {
    if (document.body.className == "sb-nav-fixed sb-sidenav-toggled") {
        document.body.className = "sb-nav-fixed";
    }
    else {
        document.body.className = "sb-nav-fixed sb-sidenav-toggled";
    }
}