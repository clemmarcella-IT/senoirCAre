// Toggle Kiosk Mode with Persistence
function toggleKiosk() {
    const isKiosk = document.body.classList.toggle('kiosk-mode');
    localStorage.setItem('kioskMode', isKiosk);
}

// Search UI
function showSuggestions() { document.getElementById('suggestionPalette').style.display = 'block'; }
function hideSuggestions() { 
    setTimeout(() => {
        const p = document.getElementById('suggestionPalette');
        if(p) p.style.display = 'none';
    }, 200); 
}

// --- TIP #5: ACCESSIBLE MOBILE MENU (INERT) ---
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('show');
    
    // If sidebar is hidden, make it "inert" so screen readers skip it
    if (sidebar.classList.contains('show')) {
        sidebar.removeAttribute('inert');
    } else {
        sidebar.setAttribute('inert', '');
    }
}

// Handle screen resizing logic for accessibility
const mediaQuery = window.matchMedia('(max-width: 768px)');
function handleScreenChange(e) {
    const sidebar = document.getElementById('sidebar');
    if (e.matches) {
        // We are on mobile: Hide sidebar by default and make inert
        sidebar.classList.remove('show');
        sidebar.setAttribute('inert', '');
    } else {
        // We are on desktop: Always show sidebar and remove inert
        sidebar.classList.remove('show');
        sidebar.removeAttribute('inert');
    }
}
mediaQuery.addEventListener('change', handleScreenChange);


// Initialize page on load
document.addEventListener("DOMContentLoaded", function() {
    // 1. Apply Kiosk Mode if it was previously turned on
    if (localStorage.getItem('kioskMode') === 'true') {
        document.body.classList.add('kiosk-mode');
    }

    // 2. Initialize Mobile Accessibility Setup
    handleScreenChange(mediaQuery);

    // 3. Highlight the correct Sidebar item based on URL
    const currentPath = window.location.pathname.split("/").pop();
    const navLinks = document.querySelectorAll('#sidebar .nav-link');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPath || (currentPath === "" && href === "dashboard.html")) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
});