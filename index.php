<?php include('templates/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Management System</title>
    <link rel="stylesheet" href="css/styles1.css">
</head>
<body>
    <header>
        <h1>Computer Lab Complaint Management System</h1>

    </header>

    <section class="hero">
        <div class="hero-content">
            <h2>Report Issues in the Computer Lab</h2>
            <p>Facing a problem with the equipment or systems? Let us know so we can fix it!</p>
            <a href="register.php" class="btn">Submit a Complaint</a>
        </div>
    </section>

    <section class="info">
        <div class="container">
            <h2>How It Works</h2>
            <p>Submit your complaints about any issues with the lab computers or equipment. Our team will address them as soon as possible.</p>
            <div class="grid">
                <div class="card">
                    <h3>Step 1: Submit</h3>
                    <p>Fill out the form with the details of the issue you're facing.</p>
                </div>
                <div class="card">
                    <h3>Step 2: Review</h3>
                    <p>Our technical team will review the complaint and identify the problem.</p>
                </div>
                <div class="card">
                    <h3>Step 3: Resolve</h3>
                    <p>We will work on fixing the issue and notify you once it is resolved.</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2024  LAB Complaint Management System LKCTC - Computer Lab</p>
    </footer>
</body>
</html>

<?php include('templates/footer.php'); ?>
