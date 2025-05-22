document.getElementById("applyForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const data = {
    name: document.getElementById("name").value,
    email: document.getElementById("email").value,
    password: document.getElementById("password").value,
    chapter: document.getElementById("chapter").value
  };
  fetch("backend/apply.php", {
    method: "POST",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify(data)
  })
  .then(res => res.json())
  .then(res => {
    document.getElementById("applyMessage").textContent = res.message;
  });
});

document.getElementById("loginForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const data = {
    email: document.getElementById("loginEmail").value,
    password: document.getElementById("loginPassword").value
  };
  fetch("backend/login.php", {
    method: "POST",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify(data)
  })
  .then(res => res.json())
  .then(res => {
    document.getElementById("loginMessage").textContent = res.message;
    if (res.success) window.location.href = "profile.html";
  });
});
