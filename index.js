// JS for the tooltip which appears when a county is hovered over on the map
document.querySelectorAll("path").forEach(function (path) {
  path.addEventListener("mouseenter", function (e) {
    var tooltip = document.createElement("div");
    tooltip.textContent = e.target.getAttribute("data-title");
    tooltip.style.position = "fixed"; // Position tooltip relative to the viewport
    tooltip.id = "tooltip";
    document.body.appendChild(tooltip);
  });

  path.addEventListener("mousemove", function (e) {
    var tooltip = document.getElementById("tooltip");
    tooltip.style.left = e.clientX + 10 + "px"; // Position tooltip 10px to the right of the cursor
    tooltip.style.top = e.clientY + 10 + "px"; // Position tooltip 10px below the cursor
  });

  path.addEventListener("mouseleave", function () {
    var tooltip = document.getElementById("tooltip");
    document.body.removeChild(tooltip);
  });
});

const map = document.querySelector(".map");
window.addEventListener("scroll", function () {
  // Calculate the scale factor
  let scaleFactor = 1 - window.scrollY / window.innerHeight;

  // Limit the scale factor to a minimum value
  scaleFactor = Math.max(scaleFactor, 0);

  // Apply the scale transform to the map
  map.style.transform = `scale(${scaleFactor})`;
});

const mainMenu = document.querySelector(".mainMenu");
const closeMenu = document.querySelector(".closeMenu");
const openMenu = document.querySelector(".openMenu");

openMenu.addEventListener("click", () => {
  mainMenu.style.display = "flex";
  mainMenu.style.top = "0";
});

closeMenu.addEventListener("click", () => {
  mainMenu.style.top = "-150vh";
});

window.onload = function() {
  var searchInput = document.getElementById('search');
  
  // Set the placeholder text based on the window's width
  if (window.innerWidth <= 800) {
    searchInput.placeholder = "Search";
  } else {
    searchInput.placeholder = "Search Products, Categories or Location...";
  }
  
  var testDiv = document.createElement('div');
  
  testDiv.style.position = 'absolute';
  testDiv.style.visibility = 'hidden';
  testDiv.style.height = 'auto';
  testDiv.style.width = 'auto';
  testDiv.style.whiteSpace = 'nowrap';
  testDiv.innerHTML = searchInput.placeholder;
  
  document.body.appendChild(testDiv);
  
  searchInput.style.width = testDiv.clientWidth + 'px';
  
  document.body.removeChild(testDiv);
};





