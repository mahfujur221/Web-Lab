let terms = parseInt(prompt("Enter the number of terms:"));
let fibonacci = [];

for (let i = 0; i < terms; i++) {
  if (i === 0) {
    fibonacci.push(0);
  } else if (i === 1) {
    fibonacci.push(1);
  } else {
    fibonacci.push(fibonacci[i - 1] + fibonacci[i - 2]);
  }
}

console.log("Fibonacci Series:");
console.log(fibonacci.join(", "));
