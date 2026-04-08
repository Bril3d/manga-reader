import Sortable from "sortablejs";

const toggleBtn = document.querySelector("#toggle-button");
const navContainer = document.querySelector("#nav-container");
const navListsTitles = document.querySelectorAll("#nav-list-title");
const sideListItems = document.querySelectorAll("#side-list > li");

toggleBtn.addEventListener("click", (e) => {
  e.preventDefault();
  navContainer.classList.toggle("absolute");
  // navContainer.classList.toggle("w-80");
  navContainer.classList.toggle("hidden");
  navContainer.classList.toggle("animate__fadeInLeft");
});

document.addEventListener("click", (e) => {
  if (!e.target.closest("#nav-container") && !e.target.closest("#toggle-button")) {
    navContainer.classList.remove("absolute");
    // navContainer.classList.remove("w-80");
    navContainer.classList.add("hidden");
    navContainer.classList.remove("animate__fadeInLeft");
  }
});

sideListItems.forEach((el) => {
  const anchorElement = el.querySelector("a");
  const listItems = el.querySelector("div");

  anchorElement.addEventListener("click", function (e) {
    if (listItems) {
      e.preventDefault();
      listItems.classList.toggle("hidden");
      listItems.classList.toggle("flex");
    }
  });
});
