<?php require_once('includes/session.php'); 

// 1. Create New Event Logic
if(isset($_POST['create_event'])) {
    $eventName = mysqli_real_escape_string($conn, $_POST['event_name']);
    $eventDate = mysqli_real_escape_string($conn, $_POST['event_date']);
    $eventTime = mysqli_real_escape_string($conn, $_POST['event_time']);
    mysqli_query($conn, "INSERT INTO events (EventName, eventDate, EventTime) VALUES ('$eventName', '$eventDate', '$eventTime')");
    header("Location: events.php");
    exit;
}

// 2. Scan QR Attendance Logic (Duplication Constraint)
if(isset($_POST['scanned_id']) && isset($_POST['event_id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['scanned_id']);
    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $timeIn = date('H:i:s');

    // Check if ID exists
    $checkUser = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo='$id'");
    if(mysqli_num_rows($checkUser) == 0) {
        echo "<script>alert('Error: Unregistered QR Code.'); window.location='events.php';</script>";
        exit;
    }

    // DUPLICATION CONSTRAINT CHECK (Cannot mark attendance twice for the same event)
    $checkDup = mysqli_query($conn, "SELECT * FROM attendance WHERE OscaIDNo='$id' AND EventID='$event_id'");
    if(mysqli_num_rows($checkDup) > 0) {
        echo "<script>alert('Duplicate: Senior $id is already marked for this event.'); window.location='events.php';</script>";
    } else {
        mysqli_query($conn, "INSERT INTO attendance (OscaIDNo, EventID, EventAttendanceStatus, attendanceTimeIn) 
                             VALUES ('$id', '$event_id', '$status', '$timeIn')");
        echo "<script>alert('Success: Marked $status for $id.'); window.location='events.php';</script>";
    }
    exit;
}

// 3. Delete Attendance Log
if(isset($_GET['del_att'])) {
    mysqli_query($conn, "DELETE FROM attendance WHERE AttendanceID='".$_GET['del_att']."'");
    header("Location: events.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Events & Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <h2 class="text-success fw-bold"><i class="fa fa-calendar-check me-2"></i> Events & Attendance</h2>
        
        <div class="row mt-4">
            <!-- CREATE EVENT SECTION -->
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-dark text-white fw-bold">1. Create New Event</div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="small text-muted fw-bold">Event Name</label>
                                <input type="text" name="event_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="small text-muted fw-bold">Event Date</label>
                                <input type="date" name="event_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="small text-muted fw-bold">Event Time</label>
                                <input type="time" name="event_time" class="form-control" required>
                            </div>
                            <button type="submit" name="create_event" class="btn btn-dark w-100">Create Event</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- SCAN ATTENDANCE SECTION -->
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white fw-bold">2. Scan QR for Event Attendance</div>
                    <div class="card-body row">
                        <div class="col-md-5 border-end text-center">
                            <div id="reader" style="width: 100%; margin: 0 auto;"></div>
                        </div>
                        <div class="col-md-7 ps-4">
                            <form method="POST" id="qrForm">
                                <div class="mb-3">
                                    <label class="small text-muted fw-bold">Select Active Event</label>
                                    <select name="event_id" class="form-select border-success" required>
                                        <option value="" disabled selected>-- Choose Event --</option>
                                        <?php
                                        // Fetch upcoming/recent events
                                        $evQ = mysqli_query($conn, "SELECT * FROM events ORDER BY eventDate DESC");
                                        while($ev = mysqli_fetch_assoc($evQ)) {
                                            echo "<option value='".$ev['EventID']."'>".$ev['EventName']." (".date("M d", strtotime($ev['eventDate'])).")</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="small text-muted fw-bold">Scanned OscaIDNo.</label>
                                    <input type="text" name="scanned_id" id="scanned_id" class="form-control text-primary fw-bold" readonly required>
                                </div>
                                <div class="mb-4">
                                    <label class="small text-muted fw-bold">Attendance Status</label>
                                    <select name="status" class="form-select">
                                        <option value="present">Present</option>
                                        <option value="absent">Absent</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success w-100" id="submitBtn" disabled>Mark Attendance</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Row -->

        <!-- RECENT ATTENDANCE TABLE -->
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">Recent Attendance Logs</div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr><th>Log ID</th><th>Event Name</th><th>OscaIDNo.</th><th>Time In</th><th>Status</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        // JOIN attendance table with events table to get EventName
                        $q = mysqli_query($conn, "
                            SELECT a.*, e.EventName 
                            FROM attendance a 
                            JOIN events e ON a.EventID = e.EventID 
                            ORDER BY a.AttendanceID DESC LIMIT 50
                        ");
                        while($row = mysqli_fetch_assoc($q)): ?>
                        <tr>
                            <td><?php echo $row['AttendanceID']; ?></td>
                            <td class="fw-bold"><?php echo $row['EventName']; ?></td>
                            <td><span class="badge bg-primary fs-6"><?php echo $row['OscaIDNo']; ?></span></td>
                            <td><?php echo date("h:i A", strtotime($row['attendanceTimeIn'])); ?></td>
                            <td>
                                <?php if($row['EventAttendanceStatus'] == 'present'): ?>
                                    <span class="badge bg-success">Present</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Absent</span>
                                <?php endif; ?>
                            </td>
                            <td><a href="events.php?del_att=<?php echo $row['AttendanceID']; ?>" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></a></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>

    </main>

    <!-- QR Scanner Logic -->
    <script src="js/scripts.js"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById('scanned_id').value = decodedText;
            document.getElementById('submitBtn').disabled = false; 
        }
        var html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess);
    </script>
</body>
</html>