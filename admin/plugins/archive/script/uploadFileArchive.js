// Declare global variables for easy access 
const uploadForm = document.querySelector('.upload-form');
const filesInput = uploadForm.querySelector('#formFile');
const filesOperation = uploadForm.querySelector('#operation');
console.log("operation") ;
console.log(filesOperation);

var finalUrl = "index.php?p=allArchive&msg=fileSucc" ;

if(filesOperation=="edit"){
    finalUrl = "index.php?p=allArchive&msg=fileEditSucc" ;
}


// Attach submit event handler to form
uploadForm.onsubmit = event => {
    event.preventDefault();

    // Make sure files are selected
    if(filesOperation=="add"){        
        if (!filesInput.files.length) {
            uploadForm.querySelector('.result').innerHTML = 'Please select a file!';
        }
    } 
    
    // Create the form object
    let uploadFormDate = new FormData(uploadForm);
    // Initiate the AJAX request
    let request = new XMLHttpRequest();
    // Ensure the request method is POST
    request.open('POST', uploadForm.action);
    // Attach the progress event handler to the AJAX request
    console.log(request);
    request.upload.addEventListener('progress', event => {
        // Add the current progress to the button
        uploadForm.querySelector('button').innerHTML = 'Uploading... ' + '(' + ((event.loaded/event.total)*100).toFixed(2) + '%)';
        // Update the progress bar
        uploadForm.querySelector('.progress').style.background = 'linear-gradient(to right, #25b350, #25b350 ' + Math.round((event.loaded/event.total)*100) + '%, #e6e8ec ' + Math.round((event.loaded/event.total)*100) + '%)';
        // Disable the submit button
        uploadForm.querySelector('button').disabled = true;
    });
    // The following code will execute when the request is complete
    request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
            console.log('ok');
            // Output the response message
            // uploadForm.querySelector('.result').innerHTML = request.responseText;
            location.href=(finalUrl);
        }
    };
    // Execute request
    request.send(uploadFormDate);

};