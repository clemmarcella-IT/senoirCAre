function onScanSuccess(decodedText, decodedResult) {
    console.log("QR Code scanned successfully:", decodedText);
    const idInput = document.getElementById('scanned_id');
    const submitBtn = document.getElementById('submitBtn');

    if(idInput) {
        idInput.value = decodedText; // Sets the OscaIDNo
        console.log("Set scanned_id to:", decodedText);
        if(submitBtn) {
            submitBtn.disabled = false;
            console.log("Enabled submit button");
            // Automatically submit if you want faster check-ins:
            // document.getElementById('attendanceForm').submit();
        } else {
            console.log("Submit button not found");
        }
    } else {
        console.log("scanned_id input not found");
    }
}

function onScanError(errorMessage) {
    console.log("QR Scan error:", errorMessage);
}

function startScanner() {
    console.log("Starting QR scanner...");
    console.log("Html5QrcodeScanner available:", typeof Html5QrcodeScanner);

    if (typeof Html5QrcodeScanner === 'undefined') {
        console.error("Html5QrcodeScanner is not loaded. Check the script tag.");
        alert("QR Scanner library not loaded. Please check your internet connection and refresh the page.");
        return;
    }

    try {
        var html5QrcodeScanner = new Html5QrcodeScanner("reader", {
            fps: 10,
            qrbox: 250
        });
        html5QrcodeScanner.render(onScanSuccess, onScanError);
        console.log("Scanner rendered successfully");
    } catch (error) {
        console.error("Error creating scanner:", error);
        alert("Error initializing QR scanner: " + error.message);
    }
}