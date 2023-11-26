document.addEventListener('DOMContentLoaded', function() {
    var sortSelect = document.getElementById('sortSelect');
    if (sortSelect) {
        sortSelect.addEventListener('change', applyFilters);
    }
});

function applyFilters() {
    var sortValue = document.getElementById('sortSelect').value;
    var sortedItems;

    if (sortValue === 'price_low_high') {
        sortedItems = items.sort((a, b) => parseFloat(a.Price) - parseFloat(b.Price));
    } else if (sortValue === 'price_high_low') {
        sortedItems = items.sort((a, b) => parseFloat(b.Price) - parseFloat(a.Price));
    } else {
        sortedItems = items;
    }
    displayItems(sortedItems); 
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