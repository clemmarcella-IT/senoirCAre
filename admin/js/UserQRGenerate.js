/**
 * SENIOR-CARE: QR Generation Logic (Standardized)
 */
function renderProfileQR(id) {
    if(!id) return;
    const target = document.getElementById("qrcode-target");
    if(!target) return;

    new QRCode(target, {
        text: id, 
        width: 200,           // High resolution internal size
        height: 200,          // High resolution internal size
        colorDark : "#1F4B2C", // Forest Green
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });
}