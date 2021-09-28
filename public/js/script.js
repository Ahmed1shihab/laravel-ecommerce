// Add/remove open class from mobile burger

const burger = document.getElementById("burger");

burger.addEventListener("click", () => {
    burger.classList.toggle("open");
    document.getElementById("mobile-stuff").classList.toggle("open");
});

// const addToCart = document.getElementById("add-to-cart");

// addToCart.addEventListener("submit", function (e) {
//     e.preventDefault;
// });
