<tr>
    <td class="text-center" scope="row"><?php echo $i + 1; ?></th>
    <td class="text-center"><?php echo $allUsers[$i]['name']; ?></td>
    <td class="text-center"><?php echo $allUsers[$i]['surname']; ?></td>
    <td class="text-center"><?php echo $allUsers[$i]['email']; ?></td>
    <td class="text-center">
        <?php
            if($allUsers[$i]['userType'] == 1){
                echo $authAndRegPWords['userType1'];
            }elseif($allUsers[$i]['userType'] == 2){
                echo $authAndRegPWords['userType2'];
            }
        ?>
    </td>
    <td class="text-center"><?php echo $allUsers[$i]['createDate']; ?></td>
    <td class="text-center">
        <?php
            for($j=0; $j<count($countries); $j++){
                if($countries[$j]['country_id'] == $data['country_id']){
                    if($countries[$j]['status'] == 1){
                        echo $countries[$j]['country_name_'.$language];
                    }
                } 
            } 
        ?>
    </td>
    <td class="text-center"><?php echo $data['purpose']; ?></td>
    <td class="text-center">
        <?php
            for($k=0; $k<count($faculties); $k++){
                if($faculties[$k]['faculty_id'] == $data['faculty_to_id']){
                    if($faculties[$k]['status'] == 1){
                        echo $faculties[$k]['faculty_name_'.$language];
                    }
                }
            }
        ?>
    </td>
    <td class="text-center"><?php echo $data['mobility_form']; ?></td>
    <td class="text-center">
        <?php 
            $from = $data['period_from'];
            $to = $data['period_to'];
            echo $applicationPWords['periodVar1'].' '.$from.' <br>'.$applicationPWords['periodVar2'].' '.$to; 
        ?>
    </td>
    <td class="text-center"><a class="btn btn-success" href="dataOfUser.php?id=<?php echo $id; ?>" style="width: 115px;"><?php echo $requestsPWOrds['button']; ?></a></td>
</tr>