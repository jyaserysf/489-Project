<?php 

    try{
        require('Database/connection.php');
        if(isset($_POST['ID'])){
            //echo $_POST['ID'];
            $semesterInfo="SELECT* from semester";
                $semester =$db->query($semesterInfo);
                $sem=$semester->fetch();
  
            $sql_currentSections="SELECT * FROM course_sections WHERE courseID=".$_POST['ID'];
            $currentSectionsrec=$db->query($sql_currentSections);
            $currentSections=$currentSectionsrec->fetch(PDO::FETCH_ASSOC);

            if ($currentSections !== false) {
                echo "<label>Section: </label>";
                do {
                    
                    echo " <button  class='section-button'  data-section-id='". $currentSections['ID'] . "'>" . $currentSections['sectionNumber'] . " | " . $currentSections['days'] . "</button>
                    
                    ";
                } while ($currentSections = $currentSectionsrec->fetch(PDO::FETCH_ASSOC));
            } else {
                echo "<label>Section: </label> No section available";
            }
            
        }
        
        


    } catch(PDOException $e){
        die($e->getMessage());
        }


?>