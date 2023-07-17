<?php

function MiladiToShamsi($date)
{
    return jdate($date)->format('Y/m/d');;
}




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
// az oonjaei ke momkene like va disslike ha ziad bashan tooye table joda zakhirash nakardam ke hajm ziadi az database gerfteh nashe
// va hamchenin tedad query ha kamtar beshe
// choon momkene be ezaye har comment 10 like va 10 disslike vojood dashte bashe ke dar in halat agar ma 20 comment baraye har news dashte
// bashim oon vaght 20*20 : 400 reaction baraye comment haye yeki az news ha sabt mishe !!!!  va it is divanegi
// ma inja ba ye foreach sade rooye ye json ke bar asas  key:ip va value =>{ 1:like , -1:disslike }  hamechizo easy hal mikonim :)
//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function checkIfValueExistsInJson($ip, $likeOrDisslike, $json)
{


    $newData = [];

    //in karbar ba in ip reaction nadade bood va be onvan reaction jadid sabt shod (in halate pishFarze)
    $status = 0;



    if (!is_null($json)) {
        $data = json_decode($json, true);



        foreach ($data as $key => $value) {

            if ($key == $ip) {
                if ($value != $likeOrDisslike) {
                    //in karbar ba in ip reaction dade bood vali meghdaresh fargh dasht ... pas meghdaresh avaz shod

                    if ($likeOrDisslike == 1) {
                        $status = 11;
                    } elseif ($likeOrDisslike == -1) {
                        $status = -11;
                    }

                    $newData[$ip] = $likeOrDisslike;

                } else {

                    //in karbar ba in ip reaction dade bood va meghdaresh hamooon bood ... pas ye jooraei nazaresho bardashte va ma dige tooye json zakhirash nemikonim
                    // masalan ghablan like karde va alan dobare zade rooye like ... pas tabiatan likesh bardashte mishe
                    // (hala harchi ke boode)

                    if ($likeOrDisslike == 1) {
                        $status = 111;
                    } elseif ($likeOrDisslike == -1) {
                        $status = -111;
                    }
                }
            } else {
                $newData[$ip] = $value;
            }
        }
    }


    if ($status == 0) {

        if ($likeOrDisslike == 1) {
            $status = 1;
        } elseif ($likeOrDisslike == -1) {
            $status = -1;
        }


        $newData[$ip] = $likeOrDisslike;


    }




    return ['status' => $status, 'json' => json_encode($newData)];
}
