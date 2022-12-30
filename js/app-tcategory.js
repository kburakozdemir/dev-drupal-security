// Ref: https://stackoverflow.com/questions/43008609/expanding-all-details-tags
// Toggle open all details elements, onload
// Regardless of their initial status
// document.body.querySelectorAll("details").forEach((e) => {
//   e.hasAttribute("open")
//     ? e.removeAttribute("open")
//     : e.setAttribute("open", true);
// });

document.getElementById("collapse_all").addEventListener("click", () => {
  document.body
    .querySelectorAll("details")
    .forEach((e) => (e.hasAttribute("open") ? e.removeAttribute("open") : ""));
});
