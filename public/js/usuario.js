import { validarFormulario } from "./helpers/validarFormulario.js";
import { toast } from "./notificacion.js";

const getFormElements = () => {
  const elements = {
    nombre: document.querySelector("#nombre"),
    email: document.querySelector("#email"),
    telefono: document.querySelector("#telefono"),
    password: document.querySelector("#password"),
  };

  const idElement = document.querySelector("#id");
  if (idElement) {
    elements.id = idElement;
  }

  return elements;
};

const errorMessages = {
  nombre: "El Nombre es Obligatorio",
  email: "El Email es Obligatorio",
  telefono: "El Telefono es Obligatorio",
  password: "El Password es Obligatorio",
};

const agregarUsuario = (e) => {
  e.preventDefault();
  const formElements = getFormElements();
  const formData = {};
  for (let key in formElements) {
    formData[key] = formElements[key].value;
  }

  const validado = validarFormulario(formElements, errorMessages);
  if (!validado) return;

  sendAgregarUsuario(formData);
};

const sendAgregarUsuario = async (formData) => {
  const datos = new FormData();
  Object.keys(formData).forEach((key) => {
    datos.append(key, formData[key]);
  });

  const url = "/dashboard/empleados/agregar";

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
    toast("Empleado Agregado Correctamente");

    //redireccionamos si se agrego correctamente
    setTimeout(() => {
      window.location.href = "/dashboard/empleados";
    }, 3500);
  } catch (error) {
    console.error("Error:", error);
    toast(error.message, "error");
  }
};

const editarUsuario = async (e) => {
  e.preventDefault();
  const formElements = getFormElements();
  const formData = {};
  for (let key in formElements) {
    formData[key] = formElements[key].value;
  }

  const validado = validarFormulario(formElements, errorMessages, false);
  if (!validado) return;

  sendEditarUsuario(formData);
};

const sendEditarUsuario = async (formData) => {
  const datos = new FormData();
  Object.keys(formData).forEach((key) => {
    datos.append(key, formData[key]);
  });

  const url = "/dashboard/empleados/editar";

  try {
    const response = await fetch(url, {
      method: "POST",
      body: datos,
    });

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.error || "Error desconocido");
    }

    const result = await response.json();
    toast("Cliente Editado Correctamente");

    setTimeout(() => {
      window.location.href = "/dashboard/empleados";
    }, 3500);
  } catch (error) {
    console.error("Error:", error);
    toast(error.message, "error");
  }
};

const eliminarUsuario = async (e) => {
  e.preventDefault();
  const id = e.target.children[0].value;
  const formData = new FormData();
  formData.append("id", id);
  const url = "/dashboard/empleados/eliminar";

  const resultado = await Swal.fire({
    title: "Estas Seguro?",
    text: "Se Eliminara este Empleado de Manera Permanente",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Si, Eliminar",
  });

  if (resultado.isConfirmed) {
    try {
      const response = await fetch(url, {
        method: "POST",
        body: formData,
      });
      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.error);
      }
      const data = await response.json();
      toast("Empleado Eliminado Correctamente");
      setTimeout(() => {
        window.location.href = "/dashboard/empleados";
      }, 3000);
    } catch (error) {
      console.error("Error:", error);
      toast(error.message, "error");
    }
  }
};

const editarPerfil = (e) => {
  e.preventDefault();
  const formElements = getFormElements();
  const formData = {};
  for (let key in formElements) {
    formData[key] = formElements[key].value;
  }

  const validado = validarFormulario(formElements, errorMessages, false);
  if (!validado) return;

  sendEditarPerfil(formData);
};

const sendEditarPerfil = async (formData) => {
  const datos = new FormData();
  Object.keys(formData).forEach((key) => {
    datos.append(key, formData[key]);
  });

  const url = "/dashboard/ajustes";

  try {
    const response = await fetch(url, {
      method: "POST",
      body: datos,
    });

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.error);
    }

    const result = await response.json();
    toast("Perfil Actualizado");

    setTimeout(() => {
      window.location.href = "/dashboard/panel";
    }, 3500);
  } catch (error) {
    console.error("Error:", error);
    toast(error.message, "error");
  }
};

export { agregarUsuario, editarUsuario, eliminarUsuario, editarPerfil };
