function buyBook(id) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        const response = JSON.parse(this.response);
        if (true == response.succes){
            window.location.href = window.location.origin;
        } else {
            alert(response.message);
        }
    }
    xhttp.open("GET", window.location.origin+"/api/purchase/"+id );
    xhttp.send();
}

function searchBooks(text)
{
    if ('' == text) {
        window.location.href = window.location.origin;
        return;
    }

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (xhttp.readyState === XMLHttpRequest.DONE) {
            replaceData(xhttp.responseText);
        };
    }
    xhttp.open("GET", window.location.origin+"/api/search/"+text);
    xhttp.send();
}

var delayTimer;
function doSearch(text) {
    if (delayTimer) {  
        clearTimeout(delayTimer);
    }
    delayTimer = setTimeout(function() {searchBooks(text)}, 1000);
}

function replaceData(responseText) {
    const res = JSON.parse(responseText);
    if (res.length > 0) {
        document.querySelectorAll('.lines').forEach(e => e.remove());
        for(let i = 0; i < res.length; i++) {
            let obj = res[i];

            let elem = document.createElement("div");
            elem.classList.add("row");
            elem.classList.add("lines");

            let titleDiv = document.createElement("div");
            titleDiv.classList.add("inline_block");
            titleDiv.classList.add("title");
            titleDiv.innerHTML = obj.title;

            let authorDiv = document.createElement("div");
            authorDiv.classList.add("inline_block");
            authorDiv.classList.add("authors");
            authorDiv.innerHTML = obj.authors;

            let popTotalDiv = document.createElement("div");
            popTotalDiv.classList.add("inline_block");
            popTotalDiv.classList.add("pop_total");
            popTotalDiv.innerHTML = obj.popularity_total;

            let popMonthDiv = document.createElement("div");
            popMonthDiv.classList.add("inline_block");
            popMonthDiv.classList.add("pop_month");
            popMonthDiv.innerHTML = obj.popularity;

            let buttonDiv = document.createElement("div");
            buttonDiv.classList.add("inline_block");
            buttonDiv.classList.add("button");

            let button = document.createElement("button");
            button.innerHTML = "Buy";
            button.onclick = function() { buyBook(obj.id); };
            buttonDiv.appendChild(button);

            elem.appendChild(titleDiv);
            elem.appendChild(authorDiv);
            elem.appendChild(popTotalDiv);
            elem.appendChild(popMonthDiv);
            elem.appendChild(buttonDiv);

            let rows = document.querySelectorAll(".row");
            let len = rows.length;
            let lastElement = len < 1 ? "" : rows[len-1];
            insertAfter(lastElement, elem);
        }
    }
}

function insertAfter(referenceNode, newNode) {
    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}