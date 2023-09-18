document.addEventListener('DOMContentLoaded', function() {
    var currentUrl = window.location.href;
    var navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    for (var i = 0; i < navLinks.length; i++) {
        if (currentUrl.indexOf(navLinks[i].getAttribute('href')) !== -1) {
            navLinks[i].classList.add('active');
            break;
        }
    }
});