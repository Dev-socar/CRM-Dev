import { toast } from "./notificacion.js";
const inputEmail = document.querySelector("#email");
const inputPassword = document.querySelector("#password");

const login = (e) => {
  e.preventDefault();

  const email = inputEmail.value;
  const password = inputPassword.value;
  if (email.trim() === "" && password.trim() === "") {
    return toast("Ambos Campos son Obligatorios", "error");
  }
  if (email.trim() === "") {
    return toast("Email Obligatorio", "error");
  }
  if (password.trim() === "") {
    return toast("Password Obligatorio", "error");
  }

  sendLogin(password, email);
};

const sendLogin = async (password, email) => {
  const datos = new FormData();
  datos.append("email", email);
  datos.append("password", password);
  const url = "/login";
  try {
    const response = await fetch(url, {
      method: "POST",
      body: datos,
    });
    if (!response.ok) {
      // Lanza un error si la respuesta no es exitosa
      const errorData = await response.json();
      throw new Error(errorData.error);
    }
    const result = await response.json();
    if (result.response === "ok") {
      window.location.href = "/dashboard/panel";
      return;
    }
  } catch (error) {   
    toast(error.message, "error");
  }
};

export { login };
