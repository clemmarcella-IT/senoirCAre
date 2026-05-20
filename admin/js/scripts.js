/**
 * SENIOR-CARE: Admin Navigation Logic
 * Handled: Sidebar Toggling, Active Page Highlighting, and Mobile Overlay.
 */

// 1. GLOBAL TOGGLE FUNCTION
// This function is called when you click the hamburger button.
window.toggleSidebar = function() {
    if (window.innerWidth <= 768) {
        // MOBILE: Slide the menu in/out over the content
        document.body.classList.toggle('sidebar-mobile-open');
    } else {
        // DESKTOP: Shrink the menu to show only icons 
        document.body.classList.toggle('sidebar-collapsed');
    }
};

// 2. PAGE INITIALIZATION
window.addEventListener('DOMContentLoaded', event => {

    //ACTIVE LINK HIGHLIGHT
    // This finds the current filename 
    const currentPath = window.location.pathname.split("/").pop();
    const navLinks = document.querySelectorAll('#sidebar .nav-link');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        
        // If the button link matches the current page, add the 'active' class (Green/Lime highlight)
        if (href === currentPath || (currentPath === "" && href === "dashboard.php")) {
            link.classList.add('active');
        }
    });

    // --- MOBILE OVERLAY CLOSE ---
    // If the user is on a phone and taps the dark background, close the menu
    const overlay = document.getElementById('sidebar-overlay');
    if (overlay) {
        overlay.addEventListener('click', () => {
            document.body.classList.remove('sidebar-mobile-open');
        });
    }

    // If the user rotates their phone or resizes the window, reset the states
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            document.body.classList.remove('sidebar-mobile-open');
        }
    });

    // --- MODAL ACCESSIBILITY FOCUS FIX ---
    // Prevents "Blocked aria-hidden on an element because its descendant retained focus" console warnings
    // 1. Prepare modal when showing
    document.addEventListener('show.bs.modal', (event) => {
        if (event.target) {
            event.target.removeAttribute('aria-hidden');
            event.target.removeAttribute('inert');
        }
    });

    // 2. Clear focus and make inert immediately when hiding starts
    document.addEventListener('hide.bs.modal', (event) => {
        if (event.target) {
            event.target.setAttribute('inert', 'true');
            // Force blur if activeElement is inside the modal
            if (document.activeElement && event.target.contains(document.activeElement)) {
                if (typeof document.activeElement.blur === 'function') {
                    document.activeElement.blur();
                }
            }
        }
    });

    // 3. Restore accessibility attributes when fully closed
    document.addEventListener('hidden.bs.modal', (event) => {
        if (event.target) {
            event.target.setAttribute('aria-hidden', 'true');
        }
    });

});