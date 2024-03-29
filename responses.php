<?php

include 'token.php';

error_reporting(0);
ini_set('display_errors', 0);

// $formId = "hLICNX"; zDB7xx = 2020 // demo
$formId = "vow4w3Oc";//"T1GyCUox";//"zDB7xx";//

$fieldsUrl = 'https://api.typeform.com/forms/'.$formId;
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

$responsesUrl = 'https://api.typeform.com/forms/'.$formId.'/responses?page_size=1000&completed=true';

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
//if (!$items) {
//    echo 'Error gettting responses: '.curl_error($ch);
//}

/* //demo
$questions = [
    //"XV8CdkrDbVt1"=>"*How your answers will get used*",
    //"AHUqhqk1tSGh"=>"How did you hear about ARCADE 2020?",
    //"W689aci9J4DJ"=>"attending",//"Are you attending ARCADE 2020 in person or online?",
    //"XkRbJkrasxY7"=>"Do you live in the UK?",
    "ydszzg66inMl"=>"miles_travelled",//"How many miles have you travelled to get here?",
    //"tggOt3lqMDLL"=>"How do you rate ARCADE 2020 so far?",
    "YCiq7003TyY9"=>"plays_often",//How often do you play video games, including games on your phone?",
    "ZRyB93qTfTMk"=>"plays_online",//"Do you play online games?",
    "Pdx9z9W8I1YX"=>"social side important",//"How important is the social side of online video gaming to you?",
    "OO0fLMEUchkx"=>"years_playing",//"How many years have you been playing video games?",
  //  "OdWilO8GDZG0"=>"why_game",//"Why do you game?",
    "sPq1uGnlbxKK"=>"effect_on_wellbeing",//"Do you think video gaming has a mostly positive or negative effect on your mental health and wellbeing?",
    // "V0pqKYh5JVVN"=>"Have you ever struggled with feelings of isolation, low mood or worries? ",
    "TkWCHPVKlNvz"=>"is_helpful",//"At times of difficulty in your life, have you ever found video gaming to be helpful?",
    "p4wXFoNP8HqB"=>"age",//"How old are you?",
    "oYovHqyYHmcz"=>"gender",//"What is your gender?",
];
*/

//$questions = [
//    "pzeNF6mvgVnf"=>"miles_travelled",//"How many miles have you travelled to get here?",
//    "gCDzS7gBPMQ0"=>"plays_often",//How often do you play video games, including games on your phone?",
//    "BKodpgrlCaoW"=>"plays_online",//"Do you play online games?",
//    "SuajGYfkcSMp"=>"social side important",//"How important is the social side of online video gaming to you?",
//    "qzDDxayCgsgi"=>"years_playing",//"How many years have you been playing video games?",
//    "tW9OSrbYK9cG"=>"effect_on_wellbeing",//"Do you think video gaming has a mostly positive or negative effect on your mental health and wellbeing?",
//    "zihF61GxqVP5"=>"is_helpful",//"At times of difficulty in your life, have you ever found video gaming to be helpful?",
//    "GaSrdxtvUrfC"=>"age",//"How old are you?",
//    "skpiEAjjvzlW"=>"gender",//"What is your gender?",
//];

$questions = [
    "QCqCHvKQ0PFe"=>"miles_travelled",//"How many miles have you travelled to get here?",
    "6IoOaHSU4Qk8"=>"plays_often",//How often do you play video games, including games on your phone?",
    "f0i6RfigeCG4"=>"plays_online",//"Do you play online games?",
    "sKWJsUVm8E4f"=>"social side important",//"How important is the social side of online video gaming to you?",
    "UhPGbOKFpfai"=>"years_playing",//"How many years have you been playing video games?",
    "BhhRrqLKtYuC"=>"effect_on_wellbeing",//"Do you think video gaming has a mostly positive or negative effect on your mental health and wellbeing?",
    "oAu1xUqwXLZh"=>"is_helpful",//"At times of difficulty in your life, have you ever found video gaming to be helpful?",
    "qG02WbxlUVxN"=>"age",//"How old are you?",
    "lFt9dEyBQ73y"=>"gender",//"What is your gender?",
];

// $questions = ["one", "two", "Attending", "MilesTravelled", "rateDS", "OftenPlay", "Online", "Social", "YearsPlaying", "Why", "Effect", "Mood", "Helpful", "Age", "Gender"];

function getAnswer($item, $fieldId, $fieldsArr)
{
    foreach ($item->answers as $answer) {
        if ($answer-> field -> id == $fieldId) {
            $type = $answer -> type;
            $out = $answer -> $type;

            $field = $fieldsArr[$fieldId];
            if ($type === 'number') {
                $out = ((int)($out / 5)) * 5;
                if ($out > 80) {
                    $out = 80;
                }
                if ($out < 10) {
                    $out = 10;
                }
            } elseif ($type === 'choice') {
                //echo (string) $out ;
                //$out = $out->label;
                $temp = -1;
                $choices = $field->properties->choices;
                $choiceCount = sizeof($choices);
                for ($c = 0; $c<$choiceCount;$c++) {
                    if ($out->label == $choices[$c]->label) {
                        $temp = $c;
                    }
                }
                $out = $temp;
            } elseif ($type === 'choices') {
                $out = -1;// $out->labels;
            }
            return $out;
        }
    }
    return -1;//"n/a";
}

$results = [];


$id = 0;
foreach ($items as $item) {
    $result = [];
    //the id for how your answers used Q:
    $ok = getAnswer($item, "UTQiLMiXIk41", $fieldsArr); // watch out! - needs to change depending on formID
    //echo $ok;
    if ($ok == 1) {
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
        $result["id"] = $item->landing_id;
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
