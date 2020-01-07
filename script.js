console.log("hello world");

// var xmlhttp = new XMLHttpRequest();
// var url = "https://api.typeform.com/forms/hLICNX/responses ";
// xmlhttp.open("POST", url, true);
// var params = "";//"sid=" + xlv.sid + "&desc=" + layoutDesc;
// xmlhttp.setRequestHeader("authorization", "bearer: 8jojXgH2KzVyhP1orFfsoZX6YNT7kNi4z7f3KpEKF8NV");
// xmlhttp.onreadystatechange = function() { //Call a function when the state changes.
//     // if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
//     var response = xmlhttp.responseText;
//     console.log(response);
//     // }
// };
// xmlhttp.send(params);

var url = "responses.php";
d3.json(url, function(json) {
    console.log(json);
});
