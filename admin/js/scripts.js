/**
 * SENIOR-CARE: Admin Navigation Logic
 * Controls the sidebar, mobile menu, and active page highlighting.
 */

// 1. GLOBAL TOGGLE FUNCTION
// Exposed to window for inline onclick handlers
window.toggleSidebar = function() {
    console.log('toggleSidebar called, window.innerWidth:', window.innerWidth);
    console.log('body classes before:', document.body.classList);

    if (window.innerWidth <= 768) {
        // MOBILE: Slide menu over the content
        document.body.classList.toggle('sidebar-mobile-open');
        console.log('Mobile toggle applied');
    } else {
        // DESKTOP: Shrink menu to icons (YouTube Style)
        document.body.classList.toggle('sidebar-collapsed');
        console.log('Desktop toggle applied');
    }

    console.log('body classes after:', document.body.classList);
};

// 2. DOM CONTENT LOADED LOGIC
window.addEventListener('DOMContentLoaded', event => {

    // --- ACTIVE LINK HIGHLIGHT ---
    // Finds the current page name (e.g., health.php)
    const currentPath = window.location.pathname.split("/").pop();
    const navLinks = document.querySelectorAll('#sidebar .nav-link');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        
        // If the link matches the page, add the green highlight (active class)
        if (href === currentPath || (currentPath === "" && href === "dashboard.php")) {
            link.classList.add('active');
        }
    });

    // --- MOBILE OVERLAY CLOSE ---
    // Closes the menu if the user taps the dark background on a phone
    const overlay = document.getElementById('sidebar-overlay');
    if (overlay) {
        overlay.addEventListener('click', () => {
            document.body.classList.remove('sidebar-mobile-open');
        });
    }

});