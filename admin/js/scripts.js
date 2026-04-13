// --- YOUTUBE-STYLE SIDEBAR TOGGLE ---
function toggleSidebar() {
    if (window.innerWidth <= 768) {
        // MOBILE BEHAVIOR: Slide menu over content
        document.body.classList.toggle('sidebar-mobile-open');
        
        const sidebar = document.getElementById('sidebar');
        if (document.body.classList.contains('sidebar-mobile-open')) {
            sidebar.removeAttribute('inert');
        } else {
            sidebar.setAttribute('inert', '');
        }
    } else {
        // DESKTOP BEHAVIOR: Shrink to mini-sidebar
        document.body.classList.toggle('sidebar-collapsed');
    }
}

// --- KIOSK MODE PERSISTENCE ---
function toggleKiosk() {
    const isKiosk = document.body.classList.toggle('kiosk-mode');
    localStorage.setItem('kioskMode', isKiosk);
}

// --- RESPONSIVE CLEANUP ---
const mediaQuery = window.matchMedia('(max-width: 768px)');
function handleScreenChange(e) {
    const sidebar = document.getElementById('sidebar');
    if (e.matches) {
        // Switching to Mobile mode
        document.body.classList.remove('sidebar-collapsed');
        document.body.classList.remove('sidebar-mobile-open');
        sidebar.setAttribute('inert', '');
    } else {
        // Switching to Desktop mode
        document.body.classList.remove('sidebar-mobile-open');
        sidebar.removeAttribute('inert');
    }
}
mediaQuery.addEventListener('change', handleScreenChange);

// --- INITIALIZE DASHBOARD ---
document.addEventListener("DOMContentLoaded", function() {
    // 1. Kiosk Mode setup
    if (localStorage.getItem('kioskMode') === 'true') {
        document.body.classList.add('kiosk-mode');
    }

    // 2. Active Link Highlighting
    const currentPath = window.location.pathname.split("/").pop();
    const navLinks = document.querySelectorAll('#sidebar .nav-link');
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPath || (currentPath === "" && href === "dashboard.html")) {
            link.classList.add('active');
        }
    });

    // 3. CHARTS INITIALIZATION (Only runs if canvas elements exist)
    const forestDeep = '#1F4B2C';
    const accentMint = '#91EAAF';
    const limeHighlight = '#C3E956';
    const alertRed = '#dc3545';

    // Health Line Chart
    if(document.getElementById('healthLineChart')){
        new Chart(document.getElementById('healthLineChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Medical Alerts',
                    data: [12, 19, 3, 5, 2, 3],
                    borderColor: alertRed,
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            }
        });
    }

    // Assistance Bar Chart
    if(document.getElementById('assistanceBarChart')){
        new Chart(document.getElementById('assistanceBarChart'), {
            type: 'bar',
            data: {
                labels: ['Rice', 'Medicine', 'Cash Aid', 'Grocery'],
                datasets: [{
                    label: 'Units Distributed',
                    data: [450, 320, 150, 280],
                    backgroundColor: [forestDeep, accentMint, '#3498db', limeHighlight]
                }]
            }
        });
    }

    // Demographic Pie Chart
    if(document.getElementById('genderPieChart')){
        new Chart(document.getElementById('genderPieChart'), {
            type: 'pie',
            data: {
                labels: ['Female', 'Male'],
                datasets: [{
                    data: [720, 564],
                    backgroundColor: [limeHighlight, forestDeep]
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });
    }

    // Participation Horizontal Bar Chart
    if(document.getElementById('activitiesHBarChart')){
        new Chart(document.getElementById('activitiesHBarChart'), {
            type: 'bar',
            data: {
                labels: ['Zumba', 'Checkup', 'Bingo', 'Reading', 'Gardening'],
                datasets: [{
                    label: 'Attendees',
                    indexAxis: 'y',
                    data: [85, 120, 95, 45, 60],
                    backgroundColor: accentMint
                }]
            }
        });
    }
});