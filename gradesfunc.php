<?php 
    try{
        require('Database/connection.php');
    }
    catch(PDOException $e){
        die($e->getMessage());
        }

         $gradesW=["A"=>4.0,"A-"=>3.67,"B+"=>3.33,"B"=>3.0,"B-"=>2.67,"C+"=>2.33,"C"=>2.0,"C-"=>1.67,"D+"=>1.33,"D-"=>1.0,"F"=>0.0,];

        function selectGrade(){
            global $gradesW;
            foreach($gradesW as $grade=>$weight){
                echo '<option value="'.$weight.'">'.$grade.' </option>';
            }
        }

        //selectGrade();

        




?>