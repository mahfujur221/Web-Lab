
const greeting = document.getElementById('greeting');
const date = document.getElementById('date');

const now = new Date();
const hour = now.getHours();
let greet = "Hello!";
if (hour < 12) greet = "Good Morning, Chef!";
else if (hour < 18) greet = "Good Afternoon, Chef!";
else greet = "Good Evening, Chef!";

greeting.textContent = greet;
date.textContent = now.toDateString();


function toggleInstructions(btn) {
  const steps = btn.nextElementSibling;
  if (steps.style.display === "none") {
    steps.style.display = "block";
    btn.textContent = "Hide Steps";
  } else {
    steps.style.display = "none";
    btn.textContent = "Show Steps";
  }
}


const tips = [
  "Always taste your food as you cook.",
  "Let your meat rest after cooking.",
  "Use sharp knives for better control.",
  "Clean as you go to save time.",
  "Use fresh ingredients for best flavor."
];

document.getElementById('tipBtn').onclick = () => {
  const tip = tips[Math.floor(Math.random() * tips.length)];
  const box = document.getElementById('tipBox');
  box.style.backgroundColor = `hsl(${Math.random() * 360}, 70%, 90%)`;
  box.textContent = tip;
};


const form = document.getElementById('mealForm');
const tableBody = document.querySelector('#mealTable tbody');

form.onsubmit = function (e) {
  e.preventDefault();
  const mealName = document.getElementById('mealName').value.trim();
  const day = document.getElementById('day').value;
  const types = [...document.querySelectorAll('input[name="type"]:checked')].map(i => i.value);
  const errorBox = document.getElementById('error');
  errorBox.textContent = '';

  if (mealName.length < 3) {
    errorBox.textContent = "Meal name must be at least 3 characters.";
    return;
  }
  if (!day) {
    errorBox.textContent = "Please select a day.";
    return;
  }
  if (types.length === 0) {
    errorBox.textContent = "Select at least one meal type.";
    return;
  }

  const dayRow = [...tableBody.children].find(row => row.firstChild.textContent === day);
  if (dayRow) {
    const meals = dayRow.children[1].textContent.split(", ");
    if (meals.length >= 3) {
      errorBox.textContent = "This day already has 3 meals.";
      return;
    }
    meals.push(`${mealName} (${types.join(", ")})`);
    dayRow.children[1].textContent = meals.join(", ");
  } else {
    const row = tableBody.insertRow();
    row.insertCell().textContent = day;
    row.insertCell().textContent = `${mealName} (${types.join(", ")})`;
  }

  form.reset();
};
