document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("userLoginForm")?.addEventListener("submit", (e) => {
    e.preventDefault();
    alert("User Login Form Submitted!");
  });

  document.getElementById("userRegisterForm")?.addEventListener("submit", (e) => {
    e.preventDefault();
    alert("User Registration Form Submitted!");
  });

  document.getElementById("restaurantLoginForm")?.addEventListener("submit", (e) => {
    e.preventDefault();
    alert("Restaurant Login Form Submitted!");
  });
});
