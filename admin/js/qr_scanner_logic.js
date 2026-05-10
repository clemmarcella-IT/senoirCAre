function onScanSuccess(decodedText, decodedResult) {
    console.log("QR Code scanned successfully:", decodedText);
    const idInput = document.getElementById('scanned_id');
    const nameInput = document.getElementById('scanned_name');
    const submitBtn = document.getElementById('submitBtn');

    if (idInput) {
        idInput.value = decodedText; // Sets the OscaIDNo
        console.log("Set scanned_id to:", decodedText);
    }

    if (nameInput) {
        nameInput.value = 'Loading...';
        
        let fetchUrl = `query_fetch_senior.php?oscaID=${encodeURIComponent(decodedText.trim())}`;
        let duesId = idInput ? idInput.getAttribute('data-dues-id') : null;
        if (duesId) {
            fetchUrl += `&dues_id=${encodeURIComponent(duesId)}`;
        }

        fetch(fetchUrl)
            .then(response => response.text())
            .then(text => {
                var dataParts = text.split('|');
                if (dataParts[0] === "true") {
                    nameInput.value = dataParts[1];
                    if (submitBtn) submitBtn.disabled = false;
                } else if (dataParts[0] === "fully_paid") {
                    nameInput.value = dataParts[1] + ' (Fully Paid)';
                    if (submitBtn) submitBtn.disabled = true;
                    alert('This senior has already fully paid their required dues amount for this cycle.');
                } else {
                    nameInput.value = 'Senior not found';
                    if (submitBtn) submitBtn.disabled = true;
                    alert('Senior not found in the database. Please verify the QR code.');
                }
            })
            .catch(error => {
                console.error('Error fetching senior name:', error);
                nameInput.value = 'Error loading name';
                if (submitBtn) submitBtn.disabled = true;
            });
    } else if (submitBtn) {
        submitBtn.disabled = false;
        console.log("Enabled submit button");
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