<!DOCTYPE html>
<html>
<head>
    <title>QR Generator - SENIOR-CARE</title>
    <!-- Load the Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>
<body>

    <h3>Senior Citizen QR Generator</h3>
    
    <!-- Input for OscaID -->
    <input type="text" id="oscaInput" placeholder="Enter OscaIDNo.">
    <button onclick="generateQR()">Generate QR Code</button>

    <br><br>

    <!-- Where the QR Code will appear -->
    <div id="qrcode"></div>

    <script>
        // Initialize the QR object once
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            width: 150,
            height: 150
        });

        function generateQR() {
            var id = document.getElementById("oscaInput").value;
            
            if (id == "") {
                alert("Please enter an OscaID first!");
                return;
            }

            // Make the QR code based on the ID
            qrcode.makeCode(id);
        }
    </script>
</body>
</html>