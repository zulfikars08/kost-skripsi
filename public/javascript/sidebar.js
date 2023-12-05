const shrink_btn = document.querySelector(".shrink-btn");
const sidebar = document.querySelector(".sidebar");
const sidebar_links = document.querySelectorAll(".sidebar-links a");
const active_tab = document.querySelector(".active-tab");
const shortcuts = document.querySelector(".sidebar-links h4");
const tooltip_elements = document.querySelectorAll(".tooltip-element");
const loadingOverlay = document.querySelector('.loading-overlay');

let activeIndex;

shrink_btn.addEventListener("click", () => {
  document.body.classList.toggle("shrink");
  sidebar.classList.toggle("shrink");
  active_tab.classList.toggle("shrink");
  shortcuts.classList.toggle("shrink");
  setTimeout(moveActiveTab, 400);

  shrink_btn.classList.add("hovered");

  setTimeout(() => {
    shrink_btn.classList.remove("hovered");
  }, 500);
});

function moveActiveTab() {
  let topPosition = activeIndex * 58 + 2.5;

  if (activeIndex > 5) {
    topPosition += shortcuts.clientHeight;
  }

  active_tab.style.top = `${topPosition}px`;
}

function setActiveMenuItem(index) {
  sidebar_links.forEach((sideLink) => sideLink.classList.remove("active"));
  sidebar_links[index].classList.add("active");

  activeIndex = index;

  moveActiveTab();

  // Trigger the tooltip hover effect for the clicked menu
  tooltip_elements[activeIndex].dispatchEvent(new Event("mouseover"));
}

function showTooltip() {
  let tooltip = this.parentNode.lastElementChild;
  let spans = tooltip.children;
  let tooltipIndex = this.dataset.tooltip;

  Array.from(spans).forEach((sp) => sp.classList.remove("show"));
  spans[tooltipIndex].classList.add("show");

  tooltip.style.top = `${(100 / (spans.length * 2)) * (tooltipIndex * 2 + 1)}%`;
}

tooltip_elements.forEach((elem) => {
  elem.addEventListener("mouseover", showTooltip);
});


sidebar_links.forEach((link) => link.addEventListener("click", changeLink));
