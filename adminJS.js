// Handle button clicks
document.addEventListener('click', function(e){
    if(e.target && e.target.classList.contains('add')){
        let bookID = e.target.getAttribute('data-id');
        updateQuantity(bookID, 1);
    }
    else if(e.target && e.target.classList.contains('remove')){
        let bookID = e.target.getAttribute('data-id');
        updateQuantity(bookID, -1);
    }
    else if(e.target && e.target.classList.contains('delete')){
        let bookID = e.target.getAttribute('data-id');
        deleteBook(bookID);
    }
});

// Send request to update book quantity
function updateQuantity(bookID, quantity){
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'updateBook.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function(){
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let response = xhr.responseText;
            if(response === 'success'){
                // Update quantity on the page
                let quantityElem = document.querySelector('td[data-id="'+bookID+'"] + td');
                let currentQuantity = parseInt(quantityElem.innerText);
                quantityElem.innerText = currentQuantity + quantity;
            }
            else{
                alert('Failed to update book quantity!');
            }
        }
    };
    xhr.send('bookID='+bookID+'&quantity='+quantity);
}

// Send request to delete book
function deleteBook(bookID){
    if(confirm('Are you sure you want to delete this book?')){
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'deleteBook.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function(){
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
                let response = xhr.responseText;
                if(response === 'success'){
                    // Remove book row from the page
                    let bookRow = document.querySelector('tr[data-id="'+bookID+'"]');
                    bookRow.parentNode.removeChild(bookRow);
                }
                else{
                    alert('Failed to delete book!');
                }
            }
        };
        xhr.send('bookID='+bookID);
    }
}
