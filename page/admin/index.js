document.querySelectorAll(".item").forEach(function (item) {
  let isItemOn = false;
  item.addEventListener("click", function () {
    isItemOn = !isItemOn;
    const button = ["Dashboard", "Utilities", "Table"];
    const arrayButton = ["Page1", "Page2"];
    item.getElementsByClassName("text_icon")[0].innerText;
    button.map((e) => {
      if (e === item.getElementsByClassName("text_icon")[0].innerText) {
        document.getElementById(`${e.toLocaleLowerCase()}`).style.display =
          "block";
      } else if (
        item.getElementsByClassName("text_icon")[0].innerText !== "Components"
      ) {
        document.getElementById(`${e.toLocaleLowerCase()}`).style.display =
          "none";
        arrayButton.map((ele) => {
          document.getElementById(`${ele.toLocaleLowerCase()}`).style.display =
            "none";
        });
      }
    });
    if (item.querySelector(".show_down")) {
      item
        .querySelector(".show_down")
        .querySelectorAll("li")
        .forEach((ele) => {
          ele.addEventListener("click", function () {
            arrayButton.map((e) => {
              if (e === ele.innerText) {
                document.getElementById(
                  `${e.toLocaleLowerCase()}`
                ).style.display = "block";
              } else {
                document.getElementById(
                  `${e.toLocaleLowerCase()}`
                ).style.display = "none";
              }
            });
            button.map((e) => {
              document.getElementById(
                `${e.toLocaleLowerCase()}`
              ).style.display = "none";
            });
          });
        });
    }
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
