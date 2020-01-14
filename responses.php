<?php

include 'token.php';

$fieldsUrl = 'https://api.typeform.com/forms/hLICNX';
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//curl_setopt($ch, CURLOPT_USERPWD, "username:$mcApiKey");
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_PORT, 443);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['authorization: bearer '.$token]);
curl_setopt($ch, CURLOPT_URL, $fieldsUrl);

$fields = json_decode(curl_exec($ch)) -> fields;
curl_close($ch);
if (!$fields) {
    echo 'Error geting fields: '.curl_error($ch);
}
$fieldsArr = [];
foreach ($fields as $field) {
    $fieldsArr[$field -> id] = $field;//->title;
}

$responsesUrl = 'https://api.typeform.com/forms/hLICNX/responses?page_size=1000&completed=true';

$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//curl_setopt($ch, CURLOPT_USERPWD, "username:$mcApiKey");
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_PORT, 443);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['authorization: bearer '.$token]);
curl_setopt($ch, CURLOPT_URL, $responsesUrl);

$items = json_decode(curl_exec($ch)) -> items;
curl_close($ch);
if (!$items) {
    echo 'Error gettting responses: '.curl_error($ch);
}


$questions = [
    //"XV8CdkrDbVt1"=>"*How your answers will get used*",
    //"AHUqhqk1tSGh"=>"How did you hear about ARCADE 2020?",
    "W689aci9J4DJ"=>"attending",//"Are you attending ARCADE 2020 in person or online?",
    //"XkRbJkrasxY7"=>"Do you live in the UK?",
    "ydszzg66inMl"=>"miles_travelled",//"How many miles have you travelled to get here?",
    //"tggOt3lqMDLL"=>"How do you rate ARCADE 2020 so far?",
    "YCiq7003TyY9"=>"play_often",//How often do you play video games, including games on your phone?",
    "ZRyB93qTfTMk"=>"play_online",//"Do you play online games?",
    "Pdx9z9W8I1YX"=>"online_gaming_social",//"How important is the social side of online video gaming to you?",
    "OO0fLMEUchkx"=>"years_playing",//"How many years have you been playing video games?",
    "OdWilO8GDZG0"=>"why_game",//"Why do you game?",
    "sPq1uGnlbxKK"=>"positive_or_negative",//"Do you think video gaming has a mostly positive or negative effect on your mental health and wellbeing?",
    // "V0pqKYh5JVVN"=>"Have you ever struggled with feelings of isolation, low mood or worries? ",
    "TkWCHPVKlNvz"=>"helpful",//"At times of difficulty in your life, have you ever found video gaming to be helpful?",
    "p4wXFoNP8HqB"=>"age",//"How old are you?",
    "oYovHqyYHmcz"=>"gender",//"What is your gender?",
];

// $questions = ["one", "two", "Attending", "MilesTravelled", "rateDS", "OftenPlay", "Online", "Social", "YearsPlaying", "Why", "Effect", "Mood", "Helpful", "Age", "Gender"];

function getAnswer($item, $fieldId, $fieldsArr)
{
    foreach ($item->answers as $answer) {
        if ($answer-> field -> id == $fieldId) {
            $type = $answer -> type;
            $out = $answer -> $type;

            $field = $fieldsArr[$fieldId];

            if ($type === 'choice') {
                // $out = $out -> label;
                $temp = -1;
                $choices = $field->properties->choices;
                $choiceCount = sizeof($choices);
                for ($c = 0; $c<$choiceCount;$c++){
                    if ($out->label == $choices[$c]->label){
                        $temp = $c;
                    }
                }
                $out = $temp;
            } else if ($type === 'choices') {
                $out = -1;// $out->labels;
            }
            return $out;
        }
    }
    return -1;//"n/a";
}

$results = [];



foreach ($items as $item) {
    $result = [];
    $ok = getAnswer($item, "XV8CdkrDbVt1", $fieldsArr);
   if ($ok == 0) {
        foreach ($questions as $key=>$value) {
            $result[$value] = getAnswer($item, $key, $fieldsArr);
            // for ($i=0; $i<16; $i++) {
        //     $answer = $item -> answers[$i];
        //     $type = $answer -> type;
        //     $out = $answer -> $type;
        //     if ($type === 'choice') {
        //         $out = $out -> label;
        //     }
        //     if ($type === 'choices') {
        //         $whyAnswers = $out;
        //     } else {
        //         $fieldId = $answer -> field -> id;
        //         $result[$fieldId] = $out;//
        //     }
        // }
        // foreach ($whyAnswers->labels as $whyAnswer){
        // 			$copiedArr = $result;
        // 			$copiedArr["Why"] = $whyAnswer;
        // 			$results[($item->landing_id).$whyAnswer] = $copiedArr;
        // }
        }
        $results[$item->landing_id] = $result;
    }
}

// echo json_encode($items);
//echo json_encode($fields);
$output = array(
  "data"=>array_values($results),
  "fields"=>$fields,
);
echo json_encode($output);
?>
