<?php
require_once 'dbconnection.php';

if (isset($_GET['student_id'])) {
    $student_id = (int)$_GET['student_id']; 

    // Use a prepared statement to prevent SQL injection
    $stmt = $data->prepare("SELECT username, phone, email FROM users WHERE id = ? AND usertype='student'");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $student = $result->fetch_assoc();

        // Set headers for CSV download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="student_' . $student_id . '.csv"');

        // Open output stream
        $output = fopen('php://output', 'w');

        // Output the header row
        fputcsv($output, array('Username', 'Phone', 'Email'));

        // Output the student data
        fputcsv($output, $student);

        fclose($output);
        exit(); 
    } else {
        // Handle case where student is not found
        echo "Student not found.";
    }
} else {
    // Handle case where student_id is not provided
    echo "Invalid request.";
}
?>
