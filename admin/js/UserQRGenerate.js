/**
 * SENIOR-CARE: QR Generation Logic
 */
function renderProfileQR(id) {
    if(!id) return;
    const target = document.getElementById("qrcode-target");
    if(!target) return;

    new QRCode(target, {
        text: id, 
        width: 200,           
        height: 200,        
        colorDark : "#1F4B2C", 
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });
}