window.onload = function() {
    getOrders();

    var form = document.querySelector(".filterForm");
    var resetButton = document.querySelector("#cleanFilter");
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const formTarget= event.target;
        var formElements  = formTarget.elements;
        // let errorBlock = document.querySelector(".error-block");
        // errorBlock.innerHTML = "";
        var flexCheckDefault = formElements.flexCheckDefault.checked;
        getOrders(true,flexCheckDefault);
        form.classList.add("active");

    });

    resetButton.addEventListener('click', function (event){
        event.preventDefault();
        getOrders();
        form.classList.remove("active");
    });

};


function updateTable(response){
    let tableBlock = document.querySelector(".table-order");
    let tableHtml = "";
    console.log(typeof response)
    console.log(response)
    console.log(response !== undefined)
    if(response !== undefined){
    let errorBlock = document.querySelector(".error-block");
    let errorHtml = "";
    errorBlock.innerHTML = errorHtml;
    response.forEach(function (item,index,response) {
        tableHtml += "<tr><td>"+item["ID"]+"</td><td>"+item["PRICE"]+"</td><td>"+item["PAYED"]+"</td></tr>";
    })
    }else{
        tableHtml += "<tr><td></td><td></td><td></td></tr>";
    }
    tableBlock.innerHTML = tableHtml;
}

function showError(response) {
    let errorBlock = document.querySelector(".error-block");
    let errorHtml = "";
    response.forEach(function (item,index,response){
        errorHtml += " <div class='error' style='color: red'>"+ item +"</div>";
    })
    errorBlock.innerHTML = errorHtml;
}
function getOrders(useFilter = null, payed = null){
    const xhr = new XMLHttpRequest();

    var formData = JSON.stringify({
        useFilter:useFilter,
        payed:payed,
    });

    xhr.open("POST", "/nik_test/api/",);
    xhr.responseType = 'json';
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        var response;
        if(xhr.readyState == 4){
            switch (xhr.status){
                case 200:
                    response = xhr.response;
                    console.log(response)
                    updateTable(response);
                    break;
                case 400:
                    response = xhr.response;
                    updateTable();
                    showError(response);
                    break;
            }
        }else{
            return;
        }
    };
    xhr.send(formData);
}