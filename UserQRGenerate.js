// Confirmation Popup
function initiateProfiling() {
    const form = document.getElementById('seniorForm');
    if(!form.checkValidity()) { form.reportValidity(); return; }

    Swal.fire({
        title: 'Confirm Enrollment?',
        text: "Ensure all 3 Signatures and 3 Thumbmarks are uploaded correctly.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#1F4B2C',
        confirmButtonText: 'Yes, Submit'
    }).then((result) => { if (result.isConfirmed) form.submit(); });
}

// Approach 1 QR
function renderProfileQR(oscaID) {
    if(!oscaID) return;
    new QRCode(document.getElementById("qrcode-target"), {
        text: oscaID, width: 150, height: 150, colorDark : "#1F4B2C"
    });
}

// Dynamic Age Calculation
function calculateAge() {
    const bday = new Date(document.getElementById('bdayInput').value);
    const today = new Date();
    let age = today.getFullYear() - bday.getFullYear();
    const m = today.getMonth() - bday.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < bday.getDate())) { age--; }
    document.getElementById('ageDisplay').innerText = "Derived Age: " + (isNaN(age) ? "--" : age);
}