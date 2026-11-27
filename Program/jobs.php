<?php
include("DBConnection.php");
    if(isset($_GET["jobSearch"])){
        $jobSI=trim($_GET["jobSearch"] ?? "");//job search index(name)             
        $jobSL=trim($_GET["loc"] ?? "");//job search location
        $jobWS="%".$jobSI."%";//job word seach            
        $jobSearch=$conn->prepare("SELECT 
        title, description , posted_at, location, salary_range 
        FROM jobs WHERE location=? AND title like ?");
        $jobSearch->bind_param("ss",$jobSL,$jobWS);
        $jobSearch->execute();
        $jobsFound=$jobSearch->get_result();
    }
?>

<!-- Here Goes The Html -->


<!-- Here Ends The Html -->
<?php 
    if(isset($jobsFound)){
        if($jobsFound->num_rows == 0){ 
            echo "No Jobs Of Sort Right At The Moment Check Later"; 
        }else{
            while($row=$jobsFound->fetch_assoc()) {
                echo $row['title'];
            }
        }
    }
        
?>