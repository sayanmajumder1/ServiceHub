function toggleDropdown() {
    var submenu = document.getElementById("submenu");
    submenu.classList.toggle("show");
}

// Close submenu after clicking a submenu link
document.addEventListener("DOMContentLoaded", function() {
    var submenuLinks = document.querySelectorAll("#submenu a");

    submenuLinks.forEach(function(link) {
        link.addEventListener("click", function() {
            document.getElementById("submenu").classList.remove("show");
        });
    });
});
