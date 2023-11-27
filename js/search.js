document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('searchItems');
    if (searchInput) {
        searchInput.addEventListener('input', performSearch);
    }
});

function performSearch() {
    var searchTerm = document.getElementById('searchItems').value.toLowerCase();
    var filteredItems = items.filter(function(item) {
        return item.Name.toLowerCase().includes(searchTerm);
    });
    displayItems(filteredItems);
}

function displayItems(itemsToDisplay) {
    var container = document.getElementById('itemContainer');
    container.innerHTML = ''; 

    itemsToDisplay.forEach(function(item) {
        var itemDiv = document.createElement('div');
        itemDiv.className = 'col-md-6 mb-4';
        itemDiv.innerHTML = `
            <div class="card card-flex">
                <img src="${item.ImagePath}" class="card-img-left">
                <div class="card-body">
                    <h5 class="card-title">${item.Name}</h5>
                    <p class="card-text">${item.Description}</p>
                    <p class="card-text">Company: ${item.Company}</p>
                    <p class="card-text">Price: $${Number(item.Price).toFixed(2)}</p>
                    <button class="btn btn-success">Add to Cart</button>
                </div>
            </div>
        `;
        container.appendChild(itemDiv);
    });
}
