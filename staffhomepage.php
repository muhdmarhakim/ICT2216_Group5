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

    <style>
        .dashboard {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin: 50px auto;
            width: 80%;
        }
        .dashboard-box {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            cursor: pointer;
        }
        .dashboard-box h2 {
            font-size: 1.5em;
        }
        .dashboard-box p {
            font-size: 1.2em;
        }
    </style>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "SSDDB";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize counts
    $boardingCount = 0;
    $daycareCount = 0;
    $groomingCount = 0;
    $totalCount = 0;

    // Fetch service counts
    $sql = "SELECT s.ID, s.ServiceName, COUNT(b.ID) as Count 
            FROM Service s 
            LEFT JOIN Booking b ON s.ID = b.ServiceID AND DATE(b.DropOffDate) = CURDATE() 
            GROUP BY s.ID, s.ServiceName";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            switch ($row['ServiceName']) {
                case 'Boarding':
                    $boardingCount = $row['Count'];
                    break;
                case 'Daycare':
                    $daycareCount = $row['Count'];
                    break;
                default:
                    if (strpos($row['ServiceName'], 'Groom') !== false || strpos($row['ServiceName'], 'Shower') !== false) {
                        $groomingCount += $row['Count'];
                    }
                    break;
            }
            $totalCount += $row['Count'];
        }
    }

    $conn->close();
    ?>

    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-3">
            <div class="row">
                <div class="col text-center mb-4">
                    <h1>Staff Dashboard</h1>
                </div>
            </div>

            <main>
                <div class="dashboard">
                    <a href="sbookingdetails.php?serviceId=1" class="dashboard-box">
                        <h2>Boarding</h2>
                        <p><?php echo $boardingCount; ?> bookings</p>
                    </a>
                    <a href="sbookingdetails.php?serviceId=2" class="dashboard-box">
                        <h2>Daycare</h2>
                        <p><?php echo $daycareCount; ?> bookings</p>
                    </a>
                    <a href="sgroomingdetail.php?serviceId=3" class="dashboard-box">
                        <h2>Grooming</h2>
                        <p><?php echo $groomingCount; ?> bookings</p>
                    </a>
                    <a href="sbookingdetails.php?serviceId=0" class="dashboard-box">
                        <h2>Total Services</h2>
                        <p><?php echo $totalCount; ?> bookings</p>
                    </a>
                </div>
            </main>

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
        </div>
    </section>
</body>
</html>