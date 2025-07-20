const form = document.getElementById("diuForm");
const submitBtn = form.querySelector("button");

form.addEventListener("submit", function(event) {
  event.preventDefault();  

  const email = document.getElementById("email").value.trim();
  const id = document.getElementById("studentId").value.trim();
  const name = document.getElementById("name").value.trim();
  const message = document.getElementById("message");

  const emailRegex = /^[a-zA-Z0-9._%+-]+@diu\.edu\.bd$/;
  const idRegex = /^\d{3}-\d{2}-\d{4}$/;
  const nameRegex = /^[A-Za-z\s]+$/;

  // Remove dancing first
  submitBtn.classList.remove("dance");

  if (!emailRegex.test(email)) {
    message.textContent = "❌ Invalid email. Must end with @diu.edu.bd";
    message.style.color = "red";
    submitBtn.classList.add("dance");
  } else if (!idRegex.test(id)) {
    message.textContent = "❌ Invalid ID. Format must be xxx-xx-xxxx";
    message.style.color = "red";
    submitBtn.classList.add("dance");
  } else if (!nameRegex.test(name)) {
    message.textContent = "❌ Name must contain only alphabets";
    message.style.color = "red";
    submitBtn.classList.add("dance");
  } else {
    message.textContent = "✅ Submitted Successfully!";
    message.style.color = "green";
    submitBtn.classList.remove("dance");

    // Optional: form.reset();
  }
});

// Theme toggle
const modeToggle = document.getElementById("modeToggle");
const body = document.body;

modeToggle.addEventListener("change", () => {
  body.classList.toggle("dark");
});
