<?php

function disp_subs($id_person, $first_name, $last_name, $email, $membership_status, $sub_date, $end_sub, $id_membership, &$id) {
    echo "
    <tr class=\"row-selected\">
        <td>".$id_person."</td>
        <td>".$first_name."</td>
        <td>".$last_name."</td>
        <td>".$email."</td>
        <td>".$membership_status."</td>
        <td>".$sub_date."</td>
        <td>".$end_sub."</td>
        <td>".$id_membership."</td>
    </tr>
    ";
    $id++;
}