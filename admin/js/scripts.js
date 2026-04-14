// 1. Function to Open/Close the menu
function toggleSidebar() {
    if (window.innerWidth <= 768) {
        // If small screen, slide it over
        document.body.classList.toggle('sidebar-mobile-open');
    } else {
        // If big screen, just shrink it
        document.body.classList.toggle('sidebar-collapsed');
    }
}

// 2. Highlight the button of the page we are currently on
document.addEventListener("DOMContentLoaded", function() {
    // Find the name of the current file (e.g. dashboard.php)
    const currentPath = window.location.pathname.split("/").pop();
    
    // Find all links in the sidebar
    const navLinks = document.querySelectorAll('#sidebar .nav-link');
    
    navLinks.forEach(link => {
        // If the link points to the current file, make it green/active
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });
});