document.querySelectorAll(".item").forEach(function (item) {
  let isItemOn = false;

  item.addEventListener("click", function () {
    isItemOn = !isItemOn;
    if (item.querySelector(".show_down") && isItemOn) {
      const icon = item.getElementsByClassName("icon")[1];
      const showDown = item.querySelector(".show_down");
      icon.src = "../../images/admin/chevron_down.png";
      showDown.style.display = "block";
    } else if (item.querySelector(".show_down")) {
      const icon = item.getElementsByClassName("icon")[1];
      const showDown = item.querySelector(".show_down");
      icon.src = "../../images/admin/chevron_right.png";
      showDown.style.display = "none";
    }
  });
});
