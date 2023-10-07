const button = [];
const arrayButton = [];
document.querySelectorAll(".item").forEach(function (item, index) {
  if (index === 0) {
    item.querySelector(".text_icon").style.color = "red";
  }
  if (!item.querySelector("ul")) {
    button.push(item.querySelector(".text_icon").innerText);
  }
  const ul = item.querySelector("ul");
  if (item.querySelector("ul")) {
    ul.querySelectorAll("li").forEach((e) => {
      arrayButton.push(e.innerText);
    });
  }
  console.log(arrayButton, button);
  let isItemOn = false;
  item.addEventListener("click", function () {
    isItemOn = !isItemOn;
    item.getElementsByClassName("text_icon")[0].innerText;
    button.map((e) => {
      if (e === item.getElementsByClassName("text_icon")[0].innerText) {
        console.log(e);
        document.getElementById(`${e.toLocaleLowerCase()}`).style.display =
          "block";
        document
          .getElementsByName(`${e}`)[0]
          .getElementsByClassName("text_icon")[0].style.color = "red";
      } else if (
        item.getElementsByClassName("text_icon")[0].innerText !== "Components"
      ) {
        document
          .getElementsByName(`${e}`)[0]
          .getElementsByClassName("text_icon")[0].style.color = "#ffffff";
        document.getElementById(`${e.toLocaleLowerCase()}`).style.display =
          "none";
        arrayButton.map((ele) => {
          document.getElementsByName(`${e}`)[0].style.color = "black";
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
                document.getElementsByName(`${e}`)[0].style.color = "red";
              } else {
                document.getElementsByName(`${e}`)[0].style.color = "black";
                document.getElementById(
                  `${e.toLocaleLowerCase()}`
                ).style.display = "none";
              }
            });
            button.map((e) => {
              document
                .getElementsByName(`${e}`)[0]
                .getElementsByClassName("text_icon")[0].style.color = "#ffffff";
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
