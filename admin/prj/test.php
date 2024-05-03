<?php


$pages_json = file_get_contents('../inc/luna_pages/pages_2.json');
$pages_data = json_decode($pages_json, true);

array_push($pages_data[1],8);
print_r($pages_data);
exit;





$array = [1, 3, 5, 8];

// Valore da cercare e rimuovere
$valore_da_rimuovere = 5;

// Trova l'indice del valore nel tuo array
$indice = array_search($valore_da_rimuovere, $array);

// Se l'indice esiste, rimuovi l'elemento dall'array
if ($indice !== false) {
    unset($array[$indice]);
}

// Stampa l'array aggiornato
print_r($array);

exit;


$exclude = array('..', '.');
foreach (scandir("../../product") as $row) {

  $item=pathinfo($row);
  if(!in_array($item['basename'],$exclude)){
    $folder = $item['basename'];

    rename("../../product/$folder","../../product/".$folder."_old");
    echo "<br>" ;
  }

}

exit;


  require "inc/header.php" ;


  // calcolo differenza date
  $today = date("Y-m-d");
  $date1 = new DateTime($today);
  $end = date("Y-m-d",strtotime("+10 days"));
  $date2 = new DateTime($end);

  $res = $date1->diff($date2);
  echo $res->days ;
  exit;


  if(($end - $today)  ) 
  {
    echo "Ok" ;
  }
  else
  {
    echo "Ko" ;
  }



  exit;

$ch = curl_init('https://giornatecardiologichetorinesi.it/quiz/script.php');
// $ch = curl_init('http://boots.local/salomon/quiz/script.php');

for($i=1; $i<501; $i++)
{
  if($i==1)
  {
    $ts1=1691655222910;
    $ts2=1691655222921;
    $ts3=1691655222934;
  }
  // set post fields
  
  $post = 
  [
    'id' => $i,
    1 => $ts1+$i,
    2 => $ts2+$i,
    3 => $ts3+$i
  ];
  print_r($post);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  
  // execute!
  $response = curl_exec($ch);
  // close the connection, release resources used
  curl_close($ch);
  
  // do anything you want with your response
  var_dump($response);
}

exit;






  $time = time();

  // print_r($time);

  echo "<br>";

  // get the day from epoch
  $day = date('Y-m-d 00:00:00',$time);
  
  print_r($day);
  exit;




?>

<script src="assets/extensions/jquery/jquery.min.js"></script>
<script>

// sessionStorage.clear();

// INSERIMENTO NEL SESSIONSTORAGE
// // const userArray = ['user_id','relation_id',1(domanda),0(boolean),timestamp_inizio,timestamp_fine];

let id = 1 ;
let start = Date.now();
let userArray = ['user','relation',1,0,start];
sessionStorage.setItem(id, JSON.stringify(userArray));
let id1 = 2 ;
userArray = ['user1','relation1',1,0];
sessionStorage.setItem(id1, JSON.stringify(userArray));
let id2 = 3 ;
userArray = ['user2','relation2',1,0];
sessionStorage.setItem(id2, JSON.stringify(userArray));
let id3 = 4 ;
userArray = ['user3','relation3',1,0];
sessionStorage.setItem(id3, JSON.stringify(userArray));


// GET ALL DATA FROM SESSIONSTORAGE
var obj = Object.keys(sessionStorage).reduce(function(obj, key) {
   obj[key] = sessionStorage.getItem(key);
   return obj
}, {});

console.log(obj)

// POST DATA TO PHP MNG PAGE

$.post("script.php", { total: obj });

// LOCALSTORAGE

// recupero l'id dalla sessione
// var session = "<?=$_SESSION['account_id']?>";

// // INSERIMENTO NEL LOCALSTORAGE
// // localStorage.setItem('quiz_(indice domanda)', JSON.stringify(userArray));

// // GET E PARSE KEY (STRINGA >> JSON)
// // prova = JSON.parse(localStorage.getItem('user'));
// // console.log("prova")


// // ITERATE ALL LOCALSTORAGE KEYS
// for (var i = 0; i < localStorage.length; i++) {

//   // set iteration key name
//   var key = localStorage.key(i);

//   // get the keys which includes 'quiz'
//   if(key.includes('quiz')){

//     // get e parse del valore della chiave ciclata
//     var value = JSON.parse(localStorage.getItem(key));

//     // prendo l'indice 0 (l'utente nel caso sopra)
//     console.log(value[0])
    
//     }

// // SVUOTA LOCALSTORAGE (A INIZIO QUIZ)
// // localStorage.clear();

// }
</script>
<?php

$test = 'a:1:{i:0;a:1:{s:5:"chair";a:2:{i:0;s:1:"2";i:1;s:1:"1";}}}';
$test_st = unserialize($test);
print_r($test_st);


exit;

?>
In JavaScript, you can read and modify JSON files using various techniques. Here's an example of how you can accomplish this:

To read a JSON file:

javascript
Copy code
const fs = require('fs');

// Read the JSON file
fs.readFile('data.json', 'utf8', (err, data) => {
  if (err) {
    console.error(err);
    return;
  }

  // Parse the JSON data
  const jsonData = JSON.parse(data);

  // Access and manipulate the data as needed
  console.log(jsonData);
});
To modify a JSON file:

javascript
Copy code
const fs = require('fs');

// Read the JSON file
fs.readFile('data.json', 'utf8', (err, data) => {
  if (err) {
    console.error(err);
    return;
  }

  // Parse the JSON data
  const jsonData = JSON.parse(data);

  // Modify the data
  jsonData.property = 'new value';

  // Convert the modified data back to JSON string
  const updatedData = JSON.stringify(jsonData);

  // Write the updated JSON data back to the file
  fs.writeFile('data.json', updatedData, 'utf8', (err) => {
    if (err) {
      console.error(err);
      return;
    }
    console.log('JSON file has been updated.');
  });
});
Make sure to replace 'data.json' with the actual path to your JSON file. The fs module in Node.js is used in these examples, assuming 
you are working in a Node.js environment. If you are running JavaScript in a web browser, the process may differ slightly as 
browsers have security restrictions on directly accessing the file system. In the browser, you typically use AJAX requests to 
load and modify JSON data from a server.

------------------
AJAX Requests:
------------------

If you have a server-side component or an API endpoint that can handle file operations, 
you can use AJAX (Asynchronous JavaScript and XML) requests to send and receive JSON data. 
You can make requests to your server, and the server can handle the file read and write 
operations. Here's an example using the Fetch API:
javascript
Copy code
<script>
// Read JSON data from the server
fetch('data.json')
  .then(response => response.json())
  .then(jsonData => {
    // Access and manipulate the data
    console.log(jsonData);
  })
  .catch(error => {
    console.error(error);
  });

// Modify JSON data and send it to the server
const modifiedData = { key: 'new value' };

fetch('saveData', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify(modifiedData)
})
  .then(response => {
    if (response.ok) {
      console.log('JSON data has been saved.');
    } else {
      console.error('Failed to save JSON data.');
    }
  })
  .catch(error => {
    console.error(error);
  });
</script>
In the above example, data.json is the file you want to read, and 'saveData' is the 
endpoint or URL where you would send the modified JSON data for saving on the server-side.
Remember that the server-side component or API you are using should be responsible for 
handling file operations and persisting the changes to the JSON file.