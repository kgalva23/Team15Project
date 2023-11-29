document.addEventListener('DOMContentLoaded', function() {
    var addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var itemId = this.getAttribute('data-item-id');
            addToCart(itemId);
        });
    });
});

function addToCart(itemId) {
    var cart = getShoppingCart();
    cart.push(itemId);
    setShoppingCart(cart);
}

function getShoppingCart() {
    var cart = getCookie('shopping_cart');
    if (cart) {
        return JSON.parse(cart);
    } else {
        return [];
    }
}

function setShoppingCart(cart) {
    setCookie('shopping_cart', JSON.stringify(cart), 7); // Expires in 7 days
}

function setCookie(name, value, daysToLive) {
    var date = new Date();
    date.setTime(date.getTime() + (daysToLive*24*60*60*1000));
    var expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}