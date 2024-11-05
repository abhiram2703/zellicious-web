function openPopup(restaurant) {
  const restaurantNameElement = document.getElementById("restaurant-name");
  const menuItemsElement = document.getElementById("menu-items");
  
  restaurantNameElement.innerText = restaurant;

  // Clear previous menu items
  menuItemsElement.innerHTML = '';

  // Sample food items for demonstration
  const foodItems = {
    'Restaurant 1': [
      { name: 'Margherita Pizza', price: '12.99' },
      { name: 'Pepperoni Pizza', price: '13.99' }
    ],
    'Restaurant 2': [
      { name: 'Cheeseburger', price: '9.99' },
      { name: 'Double Burger', price: '11.99' }
    ],
    'Restaurant 3': [
      { name: 'California Roll', price: '10.99' },
      { name: 'Spicy Tuna Roll', price: '11.99' }
    ],
    'Restaurant 4': [
      { name: 'Pasta Primavera', price: '8.99' },
      { name: 'Fettuccine Alfredo', price: '10.99' }
    ]
  };

  const items = foodItems[restaurant];
  items.forEach(item => {
    const menuItem = document.createElement('div');
    menuItem.className = 'menu-item';
    
    const quantityContainer = document.createElement('div');
    quantityContainer.className = 'quantity';
    
    const minusButton = document.createElement('button');
    minusButton.innerText = '-';
    minusButton.onclick = () => updateQuantity(item.name, -1);
    
    const quantityInput = document.createElement('input');
    quantityInput.type = 'text';
    quantityInput.value = '0';
    quantityInput.id = item.name.replace(/\s+/g, '-').toLowerCase();
    quantityInput.readOnly = true;

    const plusButton = document.createElement('button');
    plusButton.innerText = '+';
    plusButton.onclick = () => updateQuantity(item.name, 1);

    quantityContainer.appendChild(minusButton);
    quantityContainer.appendChild(quantityInput);
    quantityContainer.appendChild(plusButton);

    menuItem.innerText = `${item.name} - $${item.price} `;
    menuItem.appendChild(quantityContainer);
    
    menuItemsElement.appendChild(menuItem);
  });

  document.getElementById("popup").style.display = "block";
}

function closePopup() {
  document.getElementById("popup").style.display = "none";
}

function updateQuantity(itemName, change) {
  const quantityInput = document.getElementById(itemName.replace(/\s+/g, '-').toLowerCase());
  let currentQuantity = parseInt(quantityInput.value);
  currentQuantity = Math.max(0, currentQuantity + change); // Prevent negative quantities
  quantityInput.value = currentQuantity;
}

// Close the popup when the user clicks outside of the popup
window.onclick = function(event) {
  if (event.target === document.getElementById("popup")) {
    closePopup();
  }
}

//Top categories redirect 
function redirectToFood(category) {
  // Redirects to food.html and can pass the category if needed
  window.location.href = 'foo.php?category=' + encodeURIComponent(category);
}
