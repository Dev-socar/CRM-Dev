import { login } from "./login.js";
import {
  formLogin,
  formAgregarCliente,
  formAgregarUsuario,
  formEditarCliente,
  formEliminarCliente,
  formEditarUsuario,
  formEliminarUsuario,
  formPerfilUsuario,
  calendario,
} from "./selectores.js";
import { agregarCliente, editarCliente, eliminarCliente } from "./cliente.js";
import {
  agregarUsuario,
  editarUsuario,
  eliminarUsuario,
  editarPerfil,
} from "./usuario.js";
import { cargarCalendario } from "./calendario.js";


formLogin?.addEventListener("submit", login);
formAgregarCliente?.addEventListener("submit", agregarCliente);
formEditarCliente?.addEventListener("submit", editarCliente);
formEliminarCliente?.forEach((b) => {
  b.addEventListener("submit", eliminarCliente);
});

formAgregarUsuario?.addEventListener("submit", agregarUsuario);
formEditarUsuario?.addEventListener("submit", editarUsuario);
formEliminarUsuario?.forEach((b) => {
  b.addEventListener("submit", eliminarUsuario);
});

formPerfilUsuario?.addEventListener("submit", editarPerfil);

document.addEventListener("DOMContentLoaded", () => {
  if (calendario) {
    cargarCalendario(calendario);
  }
});
