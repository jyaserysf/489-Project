<?php 

    try{
        require('Database/connection.php');
        if(isset($_POST['ID'])){
            //echo $_POST['ID'];
            $sql_currentSections="SELECT * FROM course_sections WHERE courseID=".$_POST['ID'];
            $currentSectionsrec=$db->query($sql_currentSections);
            $currentSections=$currentSectionsrec->fetch(PDO::FETCH_ASSOC);

            if ($currentSections !== false) {
                echo "<label>Section: </label>";
                do {
                    echo " <button class='section-button' data-section-id='". $currentSections['ID'] . "'>" . $currentSections['sectionNumber'] . " | " . $currentSections['days'] . "</button>";
                } while ($currentSections = $currentSectionsrec->fetch(PDO::FETCH_ASSOC));
            } else {
                echo "<label>Section: </label> <p>No section available</p>";
            }
            // if($currentSectionsrec->rowCount() >0){
            //     while($currentSections){
            //         echo "<option value='".$currentSections['ID']."'>".$currentSections['sectionNumber']." | ".$currentSections['days']."</option>";
            //     }
            // }else{
            //     echo "<option> No section available</option>";
            // }
        }
        
        


    } catch(PDOException $e){
        die($e->getMessage());
        }


?>