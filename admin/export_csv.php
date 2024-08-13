<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
    exit;
}
else {
    // Set the headers to indicate that this is a CSV file and will be downloaded
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=applied_leaves.csv');

    // Open a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

    // Output the column headings
    fputcsv($output, array('Leave ID', 'Employee ID', 'Employee Name', 'Leave Type', 'Posting Date', 'Status'));

    // Fetching data from database
    $sql = "SELECT tblleaves.id as lid, 
                    tblemployees.FirstName, 
                    tblemployees.LastName, 
                    tblemployees.EmpId, 
                    tblemployees.id, 
                    tblleaves.LeaveType, 
                    tblleaves.PostingDate, 
                    tblleaves.Status 
            FROM tblleaves 
            JOIN tblemployees ON tblleaves.empid = tblemployees.id 
            ORDER BY lid DESC";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if($query->rowCount() > 0) {
        foreach($results as $result) {
            // Determine the status text
            $status = '';
            if($result->Status == 1) {
                $status = 'Approved';
            } elseif($result->Status == 2) {
                $status = 'Not Approved';
            } else {
                $status = 'Waiting for Approval';
            }

            // Add each row of data to the CSV
            fputcsv($output, array(
                $result->lid, 
                $result->EmpId, 
                $result->FirstName . ' ' . $result->LastName, 
                $result->LeaveType, 
                $result->PostingDate, 
                $status
            ));
        }
    }

    // Close the file pointer
    fclose($output);
    exit();
}
?>
