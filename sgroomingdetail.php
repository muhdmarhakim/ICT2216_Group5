<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "head.inc.php"; ?>
</head>
<body>
    <!-- Topbar Start -->
    <?php include "topbar.inc.php"; ?>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <?php include "adminnav.php"; ?>
    <!-- Navbar End -->

    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-3">
            <div class="row">
                <div class="col text-center mb-4">
                    <h1>Grooming Bookings Details for Today</h1>
                </div>
            </div>

            <?php
            // Include your database configuration file here if not already included
            include "db_connect.php";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Get today's date
            $today = date('Y-m-d');

            // Query to fetch grooming bookings for today
            $sql = "SELECT b.ID, b.DropOffDate, b.PickUpDate, b.Food, b.Remarks, b.TotalPrice, b.Paid, b.Status, s.ServiceName, p.Name AS PetName
                    FROM Booking b
                    JOIN Service s ON b.ServiceID = s.ID
                    JOIN Pet p ON b.PetID = p.ID
                    WHERE s.ID BETWEEN 3 AND 11
                    AND DATE(b.DropOffDate) = '$today'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    echo '<div class="row mb-4">';
                    echo '<div class="col-lg-6 offset-lg-3">';
                    echo '<div class="card shadow">';
                    echo '<div class="card-header py-3">';
                    echo '<h6 class="m-0 font-weight-bold text-primary">' . htmlspecialchars($row['PetName']) . '</h6>';
                    echo '</div>';
                    echo '<div class="card-body">';
                    echo '<p><strong>Service:</strong> ' . htmlspecialchars($row['ServiceName']) . '</p>';
                    echo '<p><strong>Drop-off Date:</strong> ' . htmlspecialchars($row['DropOffDate']) . '</p>';
                    echo '<p><strong>Pick-up Date:</strong> ' . htmlspecialchars($row['PickUpDate']) . '</p>';
                    echo '<p><strong>Food:</strong> ' . ($row['Food'] ? 'Yes' : 'No') . '</p>';
                    echo '<p><strong>Remarks:</strong> ' . htmlspecialchars($row['Remarks']) . '</p>';
                    echo '<p><strong>Total Price:</strong> $' . htmlspecialchars($row['TotalPrice']) . '</p>';
                    echo '<p><strong>Paid:</strong> ' . ($row['Paid'] ? 'Yes' : 'No') . '</p>';

                    // Display different buttons based on booking status
                    if ($row['Status'] != 'Rejected') {
                        echo '<div class="mb-3">'; // Adding margin bottom
                        echo '<a href="seditbooking.php?id=' . htmlspecialchars($row['ID']) . '" class="btn btn-primary mr-2">Edit Booking</a>';
                        echo '</div>';
                        
                        // Add form for rejecting booking
                        echo '<form action="srejectbooking.php" method="post" class="mb-3">';
                        echo '<input type="hidden" name="booking_id" value="' . htmlspecialchars($row['ID']) . '">';

                        // Properly formatted reason input box
                        echo '<div class="form-group">';
                        echo '<input type="text" name="reason" placeholder="Enter rejection reason" required class="form-control">';
                        echo '</div>';

                        echo '<button type="submit" class="btn btn-danger">Reject Booking</button>';
                        echo '</form>';
                    } else {
                        echo '<p class="text-danger">Booking Rejected</p>';
                    }

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="row">';
                echo '<div class="col">';
                echo '<div class="alert alert-info">No grooming bookings found for today.</div>';
                echo '</div>';
                echo '</div>';
            }

            $conn->close();
            ?>
        </div>
    </section>

    <!-- Footer Start -->
    <?php include "footer.inc.php"; ?>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="lib/select2/js/select2.full.min.js"></script>
    <script src="lib/sweetalert/sweetalert.min.js"></script>
    <script src="lib/jquery-steps/jquery.steps.min.js"></script>
    <script src="lib/parsleyjs/parsley.min.js"></script>
    <script src="lib/Chart.js/Chart.min.js"></script>
    <script src="js/main.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Custom JavaScript can be added here
    </script>
</body>
</html>