<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student') {
    header('Location: login.php');
    exit;
}

include('db.php');

// Handle form submission
if (isset($_POST['submit_complaint'])) {
    $pc_number = $_POST['pc_number'];
    $room_number = $_POST['room_number'];
    $components = explode(',', $_POST['components']); // This will be an array of selected components
    $description = $_POST['description'];
    $student_id = $_SESSION['user_id'];

    // Convert components array into a comma-separated string
    $components_str = implode(',', $components);

    // Insert complaint into database
    $stmt = $conn->prepare("INSERT INTO complaints (pc_number, room_number, components, description, student_id, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param('ssssi', $pc_number, $room_number, $components_str, $description, $student_id);
    $stmt->execute();

    $_SESSION['message'] = "Complaint added successfully!";
    header('Location: student_dashboard.php');
    exit;
}
?>

<?php include('templates/header.php'); ?>

<h2>Add a Complaint</h2>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert success-alert">
        <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<form method="POST" action="add_complaint.php" class="complaint-form">
    <!-- PC Number Field -->
    <label for="pc_number">PC Number:</label>
    <input type="text" id="pc_number" name="pc_number" placeholder="Enter PC Number" required>

    <!-- Room Number Field -->
    <label for="room_number">LAB Number:</label>
    <input type="text" id="room_number" name="room_number" placeholder="Enter Room Number" required>

    <!-- Fault Components Dropdown -->
    <label for="components">Fault Components:</label>
    <select id="components" onchange="addComponent()">
        <option value="" disabled selected>Select a component</option>
        <option value="Mouse">Mouse</option>
        <option value="Keyboard">Keyboard</option>
        <option value="Monitor">Monitor</option>
        <option value="CPU">CPU</option>
        <option value="RAM">RAM</option>
        <option value="Hard Drive">Hard Drive</option>
        <!-- Add more components as needed -->
    </select>

    <!-- Selected Components Box -->
    <div id="selectedComponentsBox" class="component-box">
        <h4>Selected Components:</h4>
        <div id="selectedComponentsList" class="component-list"></div>
    </div>

    <!-- Hidden field to store selected components -->
    <input type="hidden" name="components" id="componentsInput" value="">

    <label for="description">Description:</label>
    <textarea id="description" name="description" placeholder="Enter detailed description"></textarea>

    <button type="submit" name="submit_complaint">Submit Complaint</button>
</form>

<script>
// List to hold selected components
let selectedComponents = [];

function addComponent() {
    const componentDropdown = document.getElementById('components');
    const selectedValue = componentDropdown.value;
    
    // Add selected component to the list
    if (selectedValue && !selectedComponents.includes(selectedValue)) {
        selectedComponents.push(selectedValue);
        
        // Update UI
        updateSelectedComponentsUI();
        
        // Disable selected option in dropdown
        componentDropdown.querySelector(`option[value="${selectedValue}"]`).disabled = true;
    }
}

function updateSelectedComponentsUI() {
    const componentsList = document.getElementById('selectedComponentsList');
    componentsList.innerHTML = ''; // Clear the list

    // Display each selected component with a remove button
    selectedComponents.forEach((component, index) => {
        const componentDiv = document.createElement('div');
        componentDiv.className = 'component-item';
        componentDiv.innerHTML = `${component} <button type="button" onclick="removeComponent(${index})" class="remove-btn">x</button>`;
        componentsList.appendChild(componentDiv);
    });

    // Update hidden input field to store selected components
    document.getElementById('componentsInput').value = selectedComponents.join(',');
}

function removeComponent(index) {
    const removedComponent = selectedComponents.splice(index, 1)[0];
    
    // Re-enable the removed option in dropdown
    document.getElementById('components').querySelector(`option[value="${removedComponent}"]`).disabled = false;
    
    // Update UI
    updateSelectedComponentsUI();
}
</script>

<?php include('templates/footer.php'); ?>

<style>
/* Styling for the form and component box */
.complaint-form {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    border-radius: 10px;
}

.complaint-form label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

.complaint-form input, .complaint-form textarea, .complaint-form select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
}

.complaint-form button {
    background-color: #28a745;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.complaint-form button:hover {
    background-color: #218838;
}

.component-box {
    background-color: #fff;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.component-box h4 {
    margin-bottom: 10px;
}

.component-list {
    display: flex;
    flex-wrap: wrap;
}

.component-item {
    background-color: #007bff;
    color: #fff;
    padding: 5px 10px;
    border-radius: 20px;
    margin-right: 10px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
}

.component-item .remove-btn {
    background-color: transparent;
    color: #fff;
    border: none;
    margin-left: 10px;
    font-size: 16px;
    cursor: pointer;
}

.component-item .remove-btn:hover {
    color: #ffc107;
}
</style>
