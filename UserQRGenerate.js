/**
 * SENIOR-CARE: QR Generation Logic
 */
function renderProfileQR(id) {
    if(!id) return;
    new QRCode(document.getElementById("qrcode-target"), {
        text: id, 
        width: 150, 
        height: 150, 
        colorDark : "#1F4B2C",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });
}