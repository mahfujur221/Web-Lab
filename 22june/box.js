const container = document.getElementById("container");

for (let i = 1; i <= 10; i++) {
  const box = document.createElement("div");
  box.className = "box";
  box.textContent = "This box is " + i;

  if (i % 2 === 0) {
    box.style.backgroundColor = "aqua";
    box.style.color = "black";
  } else {
    box.style.backgroundColor = "orange";
  }

  container.appendChild(box);
}
