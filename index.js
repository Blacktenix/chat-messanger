function poll() {
  if (toLogin != "") {
    fetch(`http://localhost:1234/message_poll.php?toLogin=${toLogin}`)
      .then((response) => response.json())
      .then((data) => {
        //document.getElementById("root").innerHTML = data.time
        let div = document.querySelector(".chat-output");
        div.innerHTML = "";
        for (let i = 0; i < data.length; i++) {
          let msg = data[i];
          let messageClass =
            msg["userFrom"] == login ? "my-message" : "their-message";
          console.log(msg["message"]);
          div.innerHTML +=
            `<div class='message ${messageClass}'><strong>` +
            msg["userFrom"] +
            `:</strong>` +
            msg["message"] +
            `</div>`;
        }
        setTimeout(poll, 1500); // повторять запрос каждую секунду
      });
  } else {
    setTimeout(poll, 1500); // повторять запрос каждую секунду
  }
}

let sendMessage = () => {
  let text = document.getElementById("text").value;
  let formData = new FormData();
  formData.append("text", text);
  document.getElementById("text").value = "";

  fetch(`http://localhost:1234/send-message.php?toLogin=${toLogin}`, {
    method: "POST",
    body: formData,
  });
};

let setToLogin = (newValue) => {
  if (toLogin != "")
    document.getElementById(toLogin).classList.remove("active");
  toLogin = newValue;
  document.getElementById(toLogin).classList.add("active");
  document.getElementById("text").value = "";
  document.querySelector(".chat-output").innerHTML = "";

  // опционально: меняет ссылку в браузере
  history.replaceState(null, "", "/index.php?toLogin=" + toLogin);
};

let deleteChat = () => {
  let formData = new FormData();
  formData.append("formAction", "delete_chat");
  formData.append("toLogin", toLogin);

  fetch(`http://localhost:1234/index.php`, {
    method: "POST",
    body: formData,
  }).then((_) => (window.location = "http://localhost:1234/index.php"));
};

poll();
