function onScanSuccess(decodedText, decodedResult) {
    const idInput = document.getElementById('scanned_id');
    const submitBtn = document.getElementById('submitBtn');
    
    if(idInput) {
        idInput.value = decodedText; // Sets the OscaIDNo
        if(submitBtn) {
            submitBtn.disabled = false;
            // Automatically submit if you want faster check-ins:
            // document.getElementById('attendanceForm').submit();
        }
    }
}

function startScanner() {
    var html5QrcodeScanner = new Html5QrcodeScanner("reader", { 
        fps: 10, 
        qrbox: 250 
    });
    html5QrcodeScanner.render(onScanSuccess);
}