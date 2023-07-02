function checkinput(inp) {
    text = inp.value;

    
    if (! inp.checkValidity() && text.length > 0 ) { inp.setAttribute("correct","false"); }
    else { inp.setAttribute("correct","Null"); }
    
    if (text.length > 0 ) { inp.setAttribute("empty","false"); }
    else { inp.setAttribute("empty","true"); }

   
}

function serverFetch(value,response_handler,error_handler = error => {console.error(">>"+String(error));}) {

    var url = "serveur.php";

    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(value)
    })

        .then(response => response.text())
        // .then(data=>{console.log('respnse json => '+String(data)) ;return data}) // FOR DEBUGGING
        .then(data =>response_handler(JSON.parse(data)))
        .catch(error_handler);


}
