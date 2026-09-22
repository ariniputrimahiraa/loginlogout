document.addEventListener("DOMContentLoaded", function () {
  var password = document.getElementById("password");
  var toggle = document.getElementById("togglePassword");

  var form = document.getElementById("loginForm");
  var button = document.getElementById("loginButton");

  var email = document.getElementById("email");

  var errorAlert = document.querySelector(".alert-error");

  /* =========================
       INITIAL ANIMATION
    ========================= */

  var card = document.querySelector(".login-card");

  if (card) {
    setTimeout(function () {
      card.className += " login-card-show";
    }, 100);
  }

  /* =========================
       AUTO FOCUS EMAIL
    ========================= */

  if (email) {
    setTimeout(function () {
      email.focus();
    }, 450);
  }

  /* =========================
       SHOW / HIDE PASSWORD
    ========================= */

  if (toggle && password) {
    toggle.onclick = function () {
      if (password.type == "password") {
        password.type = "text";

        toggle.innerHTML = "Sembunyikan";

        toggle.className = "toggle-password active";
      } else {
        password.type = "password";

        toggle.innerHTML = "Lihat";

        toggle.className = "toggle-password";
      }
    };
  }

  /* =========================
       INPUT FOCUS EFFECT
    ========================= */

  var inputs = document.querySelectorAll(".input-wrapper input");

  var i;

  for (i = 0; i < inputs.length; i++) {
    inputs[i].onfocus = function () {
      var wrapper = this.parentNode;

      wrapper.className += " input-focus";
    };

    inputs[i].onblur = function () {
      var wrapper = this.parentNode;

      wrapper.className = wrapper.className.replace(" input-focus", "");
    };
  }

  /* =========================
       FORM SUBMIT
    ========================= */

  if (form && button) {
    form.onsubmit = function () {
      if (email.value == "" || password.value == "") {
        return false;
      }

      button.disabled = true;

      button.className += " loading";

      return true;
    };
  }

  /* =========================
       ERROR ANIMATION
    ========================= */

  if (errorAlert && card) {
    card.className += " login-error";

    setTimeout(function () {
      card.className = card.className.replace(" login-error", "");
    }, 600);
  }

  /* =========================
       PASSWORD ENTER
    ========================= */

  if (password) {
    password.onkeypress = function (event) {
      event = event || window.event;

      if (event.keyCode == 13) {
        if (form) {
          form.submit();
        }
      }
    };
  }
});

function confirmLogout() {
  return confirm("Apakah Anda yakin ingin logout?");
}
