// Add/remove open class from mobile burger

const burger = document.getElementById("burger");

burger.addEventListener("click", () => {
    burger.classList.toggle("open");
    document.getElementById("mobile-stuff").classList.toggle("open");
});
